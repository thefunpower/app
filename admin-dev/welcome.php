<?php  
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/ 
global $config; 
$config['title'] = "控制台";
include __DIR__.'/../boot/app.php';   
include __DIR__.'/header.php';
misc('jquery,vue,node,css,element');
check_admin_login();
?>
<div id="app">
   <?php 
   $_page = "";
   do_action('admin.index|admin.welcome',$_page); 
   echo $_page;
   ?>
</div>
<?php include __DIR__.'/footer.php';?>