<?php
//版本号
define('VERSION', "2.1.0");
//线上可以关闭PHP错误提示
define('DEBUG', true);
define("ADMIN_DIR_NAME", 'admin');
define("ADMIN_COOKIE_NAME", 'user_id'); 
define('PATH', realpath(__DIR__ . '/../').'/');
define('SYS_PATH', PATH . '/vendor/thefunpower/core/');
/**
 * error_log() 函数，记录具体错误
 */
ini_set('log_errors', 'On');
ini_set('error_log', PATH . '/data/phplog.log');
/**
 * 错误提示 
 */
if (DEBUG) {
  ini_set('display_errors', 'on');
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
} else {
  ini_set('display_errors', 'off');
  error_reporting(0);
}
include PATH . '/vendor/autoload.php'; 
include PATH . '/config.ini.php'; 
/**
* 启动数据库连接
*/
$medoo_db_config = $config;
include SYS_PATH.'/../db_medoo/boot.php';
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
//autoload_theme('front');
//auto_include_router(); 
include SYS_PATH . '/app.php';
include __DIR__ . '/helper.php';
include __DIR__ . '/router.php';
//开始
do_action('init');
$input  = g();
$router->set404(function() {   
    auto_load_app_router(['app','']);
});
$router->run();

