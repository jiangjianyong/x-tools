#HappyDays

###代码部署须知
```
	/*忽略文件权限改变*/
	git config core.filemode=false
	
	/*将临时文件的权限改为777*/
	sudo chmod -R 777 apps/temp/
	sudo chmod -R 777 apps/public/temp/
	
	/*初始化第三方库*/
	composer install
	
	/*配置文件变动*/
```


###框架介绍
> 使用Flight框架, 引入Smarty模板引擎, 其他库请参考composer.json文件
