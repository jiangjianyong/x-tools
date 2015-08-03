#!/bin/bash

read name

if [ $name == 'jiang']
then
  echo "$name jianyong"
else
  echo "$name, Hello World!"
fi

case "$name" in
  0) echo "$name 0000000";;
  jiang) echo "$name jianyong;";;
esac;

# 遍历数组
for v in {1..4}
do
  echo "$v is ok!"
done;

# 传统的for循环
for ((a=1; a<=3; a++))
do
  echo "$a is ok!"
done;



