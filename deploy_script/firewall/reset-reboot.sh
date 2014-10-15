iptables-save > /etc/firewall.conf
echo '#!/bin/sh' > /etc/network/if-up.d/iptables 
echo "iptables-restore < /etc/firewall.conf" >> /etc/network/if-up.d/iptables 
chmod +x /etc/network/if-up.d/iptables 

