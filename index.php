<?php
 
if(!file_exists(__DIR__.'/vendor/autoload.php')){
  echo "composer未安装，请执行以下命令<br><br>";
  echo "composer install";
  exit();
} 
require __DIR__ . '/boot/boot.php';  
global $router;
$router = new \Bramus\Router\Router(); 
require __DIR__ . '/boot/router.php'; 
autoload_theme('front');
auto_include_router();
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
$router->set404(function() { 
    header('HTTP/1.1 404 Not Found');
    include __DIR__.'/404.php';
}); 
$router->set404('(/.*)api(/.*)?', function() {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: application/json'); 
    $jsonArray = array();
    $jsonArray['code'] = "250"; 
    $jsonArray['msg'] = "未知路由"; 
    echo json_encode($jsonArray);
});
$router->run(); 

