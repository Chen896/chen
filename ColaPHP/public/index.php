<?php

//显示所有错误
error_reporting(E_ALL);
ini_set('display_errors', 'on');
//时区设置
date_default_timezone_set('Asia/Shanghai');

//当前路径[php>=5.3]
// define('APP_ROOT', str_replace(array('\\','public'), array('/',''), __DIR__));
define('APP_ROOT', realpath(__DIR__ . '/../').'/' );

define('APP_PATH', APP_ROOT.'app/');
define('FRAME_PATH', APP_ROOT.'Cola/');   #框架路径

define('B_CONFIG', APP_PATH.'common/config.inc.php');
define('B_PUBLIC', APP_ROOT.'Cola/');     #静态文件


#---------------------------------------------------------------------------------
# 设置默认值[pathinfo路由]
if(!isset( $_SERVER['PATH_INFO'] )) $_SERVER['PATH_INFO'] = '/home/index/index';
$tmp = explode('/', trim($_SERVER['PATH_INFO'], '/'));

define('B_MODULE', $tmp[0]);                   #模块名称
define('B_APP', $_SERVER["SCRIPT_NAME"].'/');  #当前应用URL
define('B_URL', B_APP.$tmp[0].'/'.$tmp[1]);    #当前模块URL
#---------------------------------------------------------------------------------
// var_dump(A_URL, M_URL, $_SERVER);


require '../Cola/Cola.php';
//创建框架对象
$cola = Cola::getInstance();
//分发
$cola->boot(B_CONFIG)->dispatch();
