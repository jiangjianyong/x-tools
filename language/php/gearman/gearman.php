<?php
/** 守护进程
yum install -y gearmand.x86_64
/bin/gearman
/bin/gearadmin

/sbin/gearmand -d
*/

/** PHP扩展
yum -y install libgearman

yum install libgearman-devel

wget http://pecl.php.net/get/gearman-1.1.2.tgz

tar -zxvf gearman-1.1.2.tgz

cd gearman-1.1.2

/data/apps/php/bin/phpize

./configure --prefix=/data/apps/phpgearman --with-php-config=/data/apps/php/bin/php-config

make&& make install

vim /data/apps/php/etc/php.ini
extension=gearman.so
*/

/**worker***/
try{
    $worker= new GearmanWorker();
    $worker->addServer('127.0.0.1');
    $worker->addFunction("reverse", "my_reverse_function");
    while ($worker->work());
}catch (Exception $e){
    var_dump($e->getMessage());
}

function my_reverse_function($job)
{
    return strrev($job->workload());
}

/**client***/
try{
    $client= new GearmanClient();
    $client->addServer('127.0.0.1');
    print $client->do("reverse", "Hello World!");
}catch (Exception $e){
    var_dump($e->getMessage());
}

?>
