<?php

define('VERSION', "2.1.0");
if(!defined('DEBUG')) {
    define('DEBUG', true);
}
if(!defined('IS_CLI')) {
    define('IS_CLI', false);
}
define("ADMIN_DIR_NAME", 'admin');
define("ADMIN_COOKIE_NAME", 'user_id');
define('PATH', realpath(__DIR__ . '/../') . '/');
define('SYS_PATH', PATH . '/vendor/thefunpower/core/');
ini_set('log_errors', 'On');
ini_set('error_log', PATH . '/data/phplog.log');
if (DEBUG) {
    ini_set('display_errors', 'on');
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
} else {
    ini_set('display_errors', 'off');
    error_reporting(0);
}
include PATH . '/vendor/autoload.php';
include PATH . '/config.ini.php';
$medoo_db_config = $config;
include SYS_PATH . '/../db_medoo/boot.php';
include SYS_PATH . '/app.php';
include __DIR__ . '/helper.php';
if(IS_CLI) {
    return;
}
do_action('init');
$input  = g();
include __DIR__ . '/router.php';
return IRoute::do(function () {
    //路由存在

}, function () {
    //路由不存在
    include PATH . '/404.php';
    if(is_local()) {
        pr(IRoute::$err);
    }
});
