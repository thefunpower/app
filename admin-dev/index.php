<?php  
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
if(isset($_GET['a'])){
    $a = $_GET['a'];
    if($a){ 
        $file = __DIR__.'/../plugins/'.$a.'.php'; 
        if(file_exists($file)){
            include $file;
            exit;
        } else {
            $file = __DIR__.'/'.$a.'.php'; 
            if(file_exists($file)){
                include $file;
                exit;
            }
        }
    }
}


include __DIR__ . '/../boot/app.php';  
if (!is_logined()) {
    jump(ADMIN_DIR_NAME.'/login.php');
} 
use lib\Menu; 
$menu  = Menu::get(); 
$title = $_GET['title'];
$url   = $_GET['url'];  
if($config['theme_admin']){  
    include PATH.'theme/'.$config['theme_admin'].'/index.php';
    return;
}else{
    echo "未配置theme_admin";
}
?> 