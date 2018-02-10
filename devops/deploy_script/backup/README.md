千人掌数据备份
===============================


先按照备份说明修改配置
再添加定时任务


定时任务
----------------------------
修改 `crontab.qrz_backup` 中/data 路径到当前脚本文件夹，然后复制到cron中
	
	cp crontab.qrz_backup /etc/cron.d/qrz_backup


备份说明
----------------------------

###备份mysql数据库

`backup_data.sh`

修改mysql和服务器配置

通过ssh执行mysqldump，然后下载到备份服务器,按日期保存在data/data-(date).sql.gz , gzip压缩文件

解压: gzip -d file


###备份静态文件

`backup_files.sh`

修改服务器配置和备份文件路径

压缩文件，下载到备份服务器，按日期保存

解压: tar zxvf file


###清理过期备份

`cleanup.sh`

清理10天前的数据


