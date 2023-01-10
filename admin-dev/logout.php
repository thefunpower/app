<?php  
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/ 
include __DIR__.'/../boot/app.php';  
remove_cookie(ADMIN_COOKIE_NAME); 
jump(ADMIN_DIR_NAME.'/login.php');
?>