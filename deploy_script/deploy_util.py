#!/usr/bin/env python
import os
import sys

def yes_no(message,defaultAnswer):
    message += "(yes/no) (default:%s) "%defaultAnswer
    sys.stdout.write(message)
    answer = sys.stdin.readline().strip()
    if len(answer)==0:
        answer = defaultAnswer
    if answer != "yes":
        exit()

def get_reponame():
    repodir = os.popen("git rev-parse --git-dir|sed 's/\\.git//g' ").read().strip()
    if len(repodir)==0:
        repodir="."

    os.chdir(repodir)
    repodir = os.getcwd()
    reponame = os.path.basename(repodir)
    return reponame

def get_host_list(online_conf):
    hostlist = []
    f = open(online_conf)
    for x in f:
        x = x.strip()
        if x.startswith("#"):
            continue
        parts = x.split(":")
        host = parts[0]
        directory = parts[1]
        hostlist.append((host,directory))
    f.close()
    return hostlist

def color_print(message):
    print '\033[01;31m' + message + '\033[0m'

