#允许本地回环接口(即运行本机访问本机)
iptables -A INPUT -s 127.0.0.1 -d 127.0.0.1 -j ACCEPT
# 允许已建立的或相关连的通行
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT
#允许所有本机向外的访问
iptables -A OUTPUT -j ACCEPT
# 允许内网访问任何端口
#iptables -A INPUT -s 192.168.1.0/24 -j ACCEPT
iptables -A INPUT -s dev -j ACCEPT
iptables -A INPUT -s online-1 -j ACCEPT
#禁止其他未允许的规则访问
iptables -A INPUT -j REJECT
iptables -A FORWARD -j REJECT
