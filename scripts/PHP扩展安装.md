
###源码中扩展文件安装(如pcntl扩展)
```
cd ext/pcntl
/usr/bin/phpize
./configure --with-php-config=bin/php-config   #（ps:请正确的指定php-config的目录）
make && make install
```

###pecl安装
```
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

###常见问题
###### TODO 通过源码安装pdo_oci时会出现一些问题
* configure: error: Unsupported Oracle version! 12.1
* 将pdo_oci的版本由 PDO_OCI-1.0 换成 PDO_OCI-1.0RC2
