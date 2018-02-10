#!/bin/bash

echo "==: 配置用户信息 :=="

echo "请输入您的姓名:"
read gname

echo "请输入您的邮箱"
read gemail

echo "姓名：$gname, 邮箱：$gemail"
echo "    git config --global user.name $gname"
echo "    git config --global user.email $gemail"

echo "确认请输入y， 其他键继续"
read check_userinfo

if [ -n $check_userinfo ] && [ $check_userinfo == y ]; then
    if [ -n $gname ]; then
        git config --global user.name $gname 
    fi;

    if [ -n $gemail ]; then 
        git config --global user.email $gemail 
    fi;
fi;

echo "是否忽略文件权限变化, 是:y, 否:其他键"
read filemode

if [ $filemode == y ]; then
    git config --global core.filemode false
    echo "请在项目目录下执行 git config core.filemode false"
fi;

echo "编辑器的配置"
    git config --global diff.tool vimdiff
    git config --global diff.prompt No

echo "配置Git着色"
    git config --global color.ui true
    git config --global color.status auto
    git config --global color.diff auto
    git config --global color.branch auto

echo "当前Git配置文件"
    git config --list --global

echo "执行完毕"
