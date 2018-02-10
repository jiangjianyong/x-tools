mysqldump -h $1 -u $2 -p$3 $4 | gzip > ~/backup/$4/$4-`date -d "-1 days" "+%Y-%m-%d"`.gz
