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

#对文件处理
for o in a.py a.sh
do
  cat $o
done

# 对命令处理
for o in $(ls)
do
  echo $o
done

# 遍历目录
function dir(){
  if test -d $1
  then
    for f in $(ls $1/*)
    do
      if test -f $f
      then
        echo $f
      fi
      
      dir "$f"
    done
  fi
}

dir "./"



# 数组
array=(1 2 3 4)

length=$(#array[@])
for((i=0; i<$length; i++))
do
  echo ${array[$i]}
done;






