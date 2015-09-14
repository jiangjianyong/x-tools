###PHP OCI Driver for Oracle

######安装Oracle Instant Client
```
mkdir -p /opt/oracle
cd /opt/oracle

/* 在oracle官网下载相应的文件
  @http://www.oracle.com/technetwork/database/features/instant-client/index-097480.html
  @Basic instantclient-basic-linux.x64-12.1.0.2.0.zip
  @SDK   instantclient-sdk-linux.x64-12.1.0.2.0.zip
*/
unzip basic.zip
unzip sdk.zip

ln -s instantclient_12_1 instantclient
cd /opt/oracle/instantclient
ln -s libclntsh.so.12.1 libclntsh.so
ln -s libocci.so.12.1 libocci.so

chcon -t textrel_shlib_t /opt/oracle/instantclient/*.so
execstack -c /opt/oracle/instantclient/*.so.*
setsebool -P httpd_execmem 1

echo /opt/oracle/instantclient > /etc/ld.so.conf.d/oracle-instantclient

pecl install oci8

instantclient,/opt/oracle/instantclient

chcon system_u:object_r:textrel_shlib_t:s0 /usr/lib/php/modules/oci8.so
chmod +x /usr/lib/php/modules/oci8.so
echo extension=oci8.so > /etc/php.d/oci8.ini
apachectl restart


mkdir -p /tmp/pear/download/
cd /tmp/pear/download/
pecl download pdo_oci
tar xvf PDO_OCI-1.0.tgz
cd PDO_OCI-1.0
Edit the config.m4 file…

Add these lines:
    elif test -f $PDO_OCI_DIR/lib/libclntsh.$SHLIB_SUFFIX_NAME.11.1; then
      PDO_OCI_VERSION=11.1    
above these lines:

    elif test -f $PDO_OCI_DIR/lib/libclntsh.$SHLIB_SUFFIX_NAME.10.1; then
      PDO_OCI_VERSION=10.1    
Also add these lines:

      11.1)
        PHP_ADD_LIBRARY(clntsh, 1, PDO_OCI_SHARED_LIBADD)
        ;;
above these lines:

      *)
        AC_MSG_ERROR(Unsupported Oracle version! $PDO_OCI_VERSION)
        ;;
If you are using PHP 5.4 or newer, you may also need to run this command:

sed -i -e 's/function_entry pdo_oci_functions/zend_function_entry pdo_oci_functions/' pdo_oci.c
Now build everything:

phpize
mkdir -p /opt/oracle/instantclient/lib/oracle/11.1
ln -s /opt/oracle/instantclient/sdk /opt/oracle/instantclient/lib/oracle/11.1/client
ln -s /opt/oracle/instantclient /opt/oracle/instantclient/lib/oracle/11.1/client/lib
./configure --with-pdo-oci=instantclient,/opt/oracle/instantclient,11.1
make
make install

```


######推荐地址(https://vufind.org/wiki/installing_the_php_oci_driver_for_oracle)
