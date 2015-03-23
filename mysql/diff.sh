#!/bin/bash

baseTmpFile='tmp/base.mysql.log'
targetTmpFile='tmp/target.mysql.log'

base_conf='127.0.0.1:3306:root:123456:dbname'
target_conf='127.0.0.1:3306:root:123456:dbname2'

# mysqldump -> tmp file
echo $base_conf > $baseTmpFile;
echo $target_conf > $targetTmpFile;

vimdiff $baseTmpFile $targetTmpFile;

rm $baseTmpFile && rm $targetTmpFile;