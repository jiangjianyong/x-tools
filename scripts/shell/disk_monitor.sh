#!/bin/bash
#monitor available disk space
#监控主机的磁盘空间，当使用空间超过90％就通过发mail来发警告
SPACE='df | sed -n '/ \ / $ / p' | gawk '{print $5}' | sed  's/%//'
if [ $SPACE -ge 90 ]
then
691620025@qq.com
fi