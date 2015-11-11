
###源码中扩展文件安装(如pcntl扩展)
```
wget http://cn2.php.net/distributions/php-5.5.7.tar.gz
tar zxvf php-5.5.7.tar.gz
cd php-5.5.7

cd ext/pcntl
/usr/bin/phpize
./configure --with-php-config=bin/php-config   #（ps:请正确的指定php-config的目录）
make && make install
```

###php_oci 安装
```
# 安装oci必须先安装oracle-instantclient, 去官网下载相应版本的客户端的rpm包, 直接安装即可
rpm -Uvh oracle-instantclient11.2-basic-11.2.0.3.0-1.x86_64.rpm 
rpm -Uvh oracle-instantclient11.2-devel-11.2.0.3.0-1.x86_64.rpm 

#第一个 RPM 将 Oracle 库放在 /usr/lib/oracle/11.2/client64/lib 中，第二个 RPM 在/usr/include/oracle/11.2/client64 中创建头。

pecl install oci8
```

###源码安装
```
tar zxvf memcached.tar.gz
cd memcached
phpize
./configure --with-php-config=bin/php-config 
make && make install
```

###修改PHP配置文件, 加入相应扩展
```
extension=memcache.so
extension=pcntl.so
extension=oci8.so
```

###常见问题
###### TODO 通过源码安装pdo_oci时会出现一些问题
* configure: error: Unsupported Oracle version! 12.1
* 将pdo_oci的版本由 PDO_OCI-1.0 换成 PDO_OCI-1.0RC2
