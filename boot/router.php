<?php


IRoute::get('/', 'app\web\controller\site@index'); 
/**
 * 仅用于本地开发测试路由使用。
 */
if(is_local() && file_exists(__DIR__ . '/test_router.php')) {
    include __DIR__ . '/test_router.php';
}
