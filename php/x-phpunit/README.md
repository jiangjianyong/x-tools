# 项目集成phpunit

#安装PHPUnit
`wget https://phar.phpunit.de/phpunit.phar`

`chmod +x phpunit.phar`

`mv phpunit.phar /usr/local/bin/phpunit`

`sudo mv phpunit.phar /usr/local/bin/phpunit`

`phpunit --version`

#使用说明
代码中的phpunit.xml的配置
  > 引入phpunit_bootstrap.php

  > 执行class/Test/*.class.php
  
避免在每个测试文件中都引入相同的头文件.

需要在phpunit_bootstrap.php中将TestCase.class.php include, 否则会报错(TestCase类不存在).

在含有phpunit.xml文件的目录下, 执行phpunit, 将会按照phpunit.xml配置执行测试.



#文档
https://phpunit.de/manual/4.6/zh_cn/index.html
