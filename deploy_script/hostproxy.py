#!/bin/sh -
"exec" "python" "-O" "$0" "$@"

__doc__ = """Tiny HTTP Proxy.

This module implements GET, HEAD, POST, PUT and DELETE methods
on BaseHTTPServer, and behaves as an HTTP proxy.  The CONNECT
method is also implemented experimentally, but has not been
tested yet.

Any help will be greatly appreciated.		SUZUKI Hisao
"""

__version__ = "0.2.1"

import BaseHTTPServer, select, socket, SocketServer, urlparse, sys, logging

class ProxyHandler (BaseHTTPServer.BaseHTTPRequestHandler):
    __base = BaseHTTPServer.BaseHTTPRequestHandler
    __base_handle = __base.handle

    server_version = "TinyHTTPProxy/" + __version__
    rbufsize = 0                        # self.rfile Be unbuffered

    def handle(self):
        (ip, port) =  self.client_address
        if hasattr(self, 'allowed_clients') and ip not in self.allowed_clients:
            self.raw_requestline = self.rfile.readline()
            if self.parse_request(): self.send_error(403)
        else:
            self.ip = ip
            self.__base_handle()

    def _connect_to(self, netloc, soc):
        i = netloc.find(':')
        if i >= 0:
            key = netloc
            host_port_bak = netloc[:i], int(netloc[i+1:])
        else:
            key = netloc + ':80'
            host_port_bak = netloc, 80
        if key not in self.hostmap:
            host_port = host_port_bak
        else:
            host_port = self.hostmap[key]
        logging.debug("%s -> %s:%d" % ((netloc,) + host_port))
        try: soc.connect(host_port)
        except socket.error, arg:
            try: msg = arg[1]
            except: msg = arg
            self.send_error(404, msg)
            return 0
        return 1

    def do_CONNECT(self):
        soc = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        try:
            if self._connect_to(self.path, soc):
                self.log_request(200)
                self.wfile.write(self.protocol_version +
                                 " 200 Connection established\r\n")
                self.wfile.write("Proxy-agent: %s\r\n" % self.version_string())
                self.wfile.write("\r\n")
                self._read_write(soc, 300)
        finally:
            soc.close()
            self.connection.close()

    def do_GET(self):
        (scm, netloc, path, params, query, fragment) = urlparse.urlparse(
            self.path, 'http')
        if scm != 'http' or fragment or not netloc:
            self.send_error(400, "bad url %s" % self.path)
            return
        soc = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        try:
            if self._connect_to(netloc, soc):
                self.log_request()
                soc.send("%s %s %s\r\n" % (
                    self.command,
                    urlparse.urlunparse(('', '', path, params, query, '')),
                    self.request_version))
                self.headers['Connection'] = 'close'
                self.headers['X-Forwarded-For'] = self.ip
                self.headers['Cache-Control'] = 'no-cache, must-revalidate'
                del self.headers['Proxy-Connection']
                for key_val in self.headers.items():
                    soc.send("%s: %s\r\n" % key_val)
                soc.send("\r\n")
                self._read_write(soc)
        finally:
            soc.close()
            self.connection.close()

    def _read_write(self, soc, max_idling=20):
        iw = [self.connection, soc]
        ow = []
        count = 0
        while 1:
            count += 1
            (ins, _, exs) = select.select(iw, ow, iw, 3)
            if exs: break
            if ins:
                for i in ins:
                    if i is soc:
                        out = self.connection
                    else:
                        out = soc
                    data = i.recv(8192)
                    if data:
                        out.send(data)
                        count = 0
            else:
                print "\t" "idle", count
            if count == max_idling: break

    do_HEAD = do_GET
    do_POST = do_GET
    do_PUT  = do_GET
    do_DELETE=do_GET

class ThreadingHTTPServer (SocketServer.ThreadingMixIn,
                           BaseHTTPServer.HTTPServer): pass

if __name__ == '__main__':
    logging.basicConfig(level=logging.DEBUG,
            format='%(asctime)s %(levelname)-8s %(message)s',
            datefmt='%Y-%m-%d %H:%M:%S'
            )

    from sys import argv
    if argv[1:] and argv[1] in ('-h', '--help'):
        print argv[0], "port(default 8000) conffile(default hostmap.conf)"
    else:
        if argv[2:]:
            conffile = argv[2]
            del argv[2:]
        else:
            conffile = 'hostmap.conf'

        try:
            f = open(conffile)
        except:
            print conffile
            print "Fail to open conffile"
            sys.exit()

        hostmap = {}
        for line in f:
            line = line.strip()
            if line.startswith('#') or len(line) == 0:
                continue
            fields = line.split()

            hostport_from = fields[0]
            i = hostport_from.find(':')
            if i == -1:
                hostport_from += ':80'

            hostport_to = fields[1]
            i = hostport_to.find(':')
            if i == -1:
                hostport_to += ':80'

            host_port_to = hostport_to.split(':')

            hostmap[hostport_from] = host_port_to[0], int(host_port_to[1])
            print("%s -> %s:%s" % ((hostport_from,) + hostmap[hostport_from]))
        ProxyHandler.hostmap = hostmap

        BaseHTTPServer.test(ProxyHandler, ThreadingHTTPServer)
