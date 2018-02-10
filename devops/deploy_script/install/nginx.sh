echo "deb http://packages.dotdeb.org squeeze all" >> /etc/apt/sources.list
wget http://www.dotdeb.org/dotdeb.gpg
cat dotdeb.gpg | sudo apt-key add -
apt-get update
apt-get install nginx
apt-get install php5-cli php5-suhosin php5-fpm php5-cgi php5-mysql
apt-get install php5-apc php5-curl php5-imagick php5-memcache php5-redis
/etc/init.d/php5-fpm restart
/etc/init.d/nginx restart


