#/bin/bash
nginxLog="/usr/local/nginx/logs/access.log"
logBakFile="/usr/local/nginx/logs/"$(date "+%F")/"bak_"$(date "+%H-%M-%S")".log"

if [ ! -d ${logBakFile%/*} ]
then
    mkdir -p ${logBakFile%/*}
fi

mv $nginxLog $logBakFile 2>&1 >/dev/null
kill -USR1 `cat /usr/local/nginx/logs/nginx.pid`
