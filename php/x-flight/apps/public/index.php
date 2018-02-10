<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED & ~E_STRICT);
session_start();

require dirname(dirname(dirname(__FILE__))) . '/vendor/autoload.php';

define('APPS_PATH', dirname(dirname(__FILE__)));
define('TEMP_PATH', APPS_PATH . '/temp' );
define('CONF_PATH', APPS_PATH . '/conf' );
define('VIEWS_PATH', APPS_PATH . '/views' );
define('PLUGINS_PATH', APPS_PATH . '/plugins' );

// config
// Flight::register('db', 'PDO', array('mysql:host=www.jiangjianyong.cn;dbname=happy_days','root','pass'));
Flight::register('view', 'Smarty', array(), function($smarty){
    $smarty->setTemplateDir(VIEWS_PATH);
    $smarty->setConfigDir(CONF_PATH);
    $smarty->setCompileDir(TEMP_PATH . '/runtime/templates_c/');
    $smarty->setCacheDir(TEMP_PATH . '/runtime/cache/');
    $smarty->addPluginsDir(PLUGINS_PATH . '/views');
});

Flight::set('flight.log_errors', true);

// map
/**
AppID(应用ID)wxe35b746417e44c20
AppSecret(应用密钥)dd5a5838ab842d0be3d2a51a1798b9cb 隐藏 重置
 */
Flight::map('config', function($item = null){
     return 100;
});



Flight::route('/', function(){
	Flight::view()->assign('name', 'Bob');
	Flight::view()->display('index.html');
});

Flight::start();