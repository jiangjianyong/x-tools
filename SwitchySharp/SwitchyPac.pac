function regExpMatch(url, pattern) {    try { return new RegExp(pattern).test(url); } catch(ex) { return false; }    }
    function FindProxyForURL(url, host) {
	if (shExpMatch(url, "*community.weimi.me*")) return 'PROXY 127.0.0.1:80';
	if (shExpMatch(url, "*shequ.dev.weimi.me*")) return 'PROXY 10.221.149.246:80';
	if (shExpMatch(url, "*star.weimi.me*")) return 'PROXY 127.0.0.1:80';
	if (shExpMatch(url, "*wiki.hiwemeet.com*")) return 'PROXY 183.136.160.215:80';
	return 'DIRECT';
}