#!/bin/sh
#systemstat.sh
#Mike.Xu
#系统状况监控
path=/tmp/systemstat
mkdir -p $path
IP=`ifconfig eth0 | grep "inet addr" | awk '{print $2}' |   awk 'BEGIN{FS=":"} {print $2}'`;
echo "Current IP $IP"

top -n 2| grep "Cpu" >>$path/cpu.txt
free -m | grep "Mem" >> $path/mem.txt
df -k | grep "sda1" >> $path/drive_sda1.txt
#df -k | grep sda2 >> $path/drive_sda2.txt
df -k | grep "/mnt/storage_0" >> $path/mnt_storage_0.txt
df -k | grep "/mnt/storage_pic" >> $path/mnt_storage_pic.txt
time=`date +%m"."%d" "%k":"%M`
connect=`netstat -na | grep "$IP:80" | wc -l`
echo "$time  $connect" >> $path/connect_count.txt

