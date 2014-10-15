#!/bin/sh
ssh $1 "cd `dirname $2`;sudo tar czvf - `basename $2`" > $3-`date -d "-1 days" "+%Y-%m-%d"`.tgz
