<?php

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
  echo "composer未安装，请执行以下命令<br><br>";
  echo "composer install";
  exit();
}
if (is_dir(__DIR__ . '/../install')) {
  if (!file_exists(__DIR__ . '/../data/lock')) {
    header("Location:/install");
    exit();
  }
}
require __DIR__ . '/app.php';
require __DIR__ . '/router.php';
autoload_theme('front');
auto_include_router(); 
$router->run();
