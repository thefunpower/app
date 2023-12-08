<?php
 
if(!file_exists(__DIR__.'/vendor/autoload.php')){
  echo "composer未安装，请执行以下命令<br><br>";
  echo "composer install";
  exit();
} 
require __DIR__ . '/boot/boot.php';  
