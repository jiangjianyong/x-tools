<?php
//核心文件
session_start();
error_reporting(~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);//报告错有错误 上线的时候需要关闭
ini_set('precision', 16);  //这只浮点型精度
ini_set('date.timezone', 'PRC');

///定义文件夹
define('ROOT_PATH', dirname(__FILE__));
define('CLASS_PATH', ROOT_PATH.'/class');

//自动类加载
function classAutoload($strClassName)
{
	$strClassName = str_replace('_', '/', $strClassName);
	$libClassPath = LIB_PATH.'/'.$strClassName.'.class.php';
	$localClassPath = CLASS_PATH.'/'.$strClassName.'.class.php';
	if(file_exists($libClassPath)){
		require_once $libClassPath;
	} else if(file_exists($localClassPath)){
		require_once $localClassPath;
	}
}

spl_autoload_register('classAutoload');