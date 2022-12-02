<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms . $ID20221128 
*/

//版本号
define('VERSION', "2.1.0");
//线上可以关闭PHP错误提示
define('DEBUG', true);
define("ADMIN_DIR_NAME", 'admin-dev');
define("ADMIN_COOKIE_NAME", 'user_id'); 
//定义一些路径常量一般不用修改
define('PATH', __DIR__ . '/../');
define('SYS_PATH', PATH . '/vendor/thefunpower/core/'); 
/**
 * 错误提示 
 */
if (DEBUG) {
  ini_set('display_errors', 'on');
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
} else {
  ini_set('display_errors', 'off');
  error_reporting(0);
  /**
   * error_log() 函数，记录具体错误
   */
  ini_set('log_errors', 'On');
  ini_set('error_log', PATH . '/data/phplog.log');
}
include PATH . '/vendor/autoload.php';
/**
 * 路由
 * https://github.com/bramus/router
 * 
location / {
  if (!-e $request_filename){
    rewrite ^(.*)$ /index.php last;
  }
}
 */
global $router;
$router = new \Bramus\Router\Router();
include SYS_PATH . '/app.php';
include __DIR__ . '/helper.php';
//开始
do_action('init');
$input  = g();
