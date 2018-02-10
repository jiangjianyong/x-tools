iptables -F
iptables -X
iptables -Z

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

#允许vpn访问samba服务
iptables -A INPUT -s 192.168.0.0/24 -p tcp --dport 137 -j ACCEPT
iptables -A INPUT -s 192.168.0.0/24 -p tcp --dport 138 -j ACCEPT
iptables -A INPUT -s 192.168.0.0/24 -p tcp --dport 445 -j ACCEPT

#允许访问的外网端口
iptables -A INPUT -p tcp --dport 80 -j ACCEPT
iptables -A INPUT -p tcp --dport 22 -j ACCEPT
iptables -A INPUT -p icmp -j ACCEPT 


#允许访问vpn server
iptables -A INPUT -p tcp --dport 1723 -j ACCEPT

#允许访问测试用代理
iptables -A INPUT -p tcp --dport 7000:8000 -j ACCEPT

#禁止其他未允许的规则访问
iptables -A INPUT -j REJECT
iptables -A FORWARD -j REJECT
