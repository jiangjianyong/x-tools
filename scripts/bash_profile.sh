#!/bin/bash

wc_ps1=`grep "PS1" ~/.bashrc -rw | wc -l`
bashrc_path=~/.bashrc
counter=0

if [ $wc_ps1 -ge 1 ]; 
then
    echo "终端着色代码已存在"
else
    echo "结果的样式:"
    echo "  1. [/data/webservice] (master) 1387h50m  "
    echo "  2. [jianyong:/data/webservice -> master] "
    echo "请输入样式的序号: "

    read profile_value

    echo "你输入的序号是$profile_value"

    counter=$((++counter))
    case $profile_value in 
        (1)
            cat ./template/bashrc/from_web >> $bashrc_path ;;
        (2)
            cat ./template/bashrc/from_jianbo >> $bashrc_path ;;
        *)
            counter=$((--counter))
            echo '无对应的样式';;
    esac;

fi

echo "共{$counter}个改动"
if [ $counter -ge 1 ]; then
    echo "是否重新编译.bashrc [y是, 任意键继续] "
    read source_bashrc

    if [ $source_bashrc == y ];
    then
        source $bashrc_path
        echo "{$bashrc_path} 编译完成"
    fi
else
    echo "{$bashrc_path} 未改变"
fi


echo "脚本执行完毕"






