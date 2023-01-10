<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
//判断是后台帐号登录的，没登录跳转到登录页面
check_admin_login('/'.ADMIN_COOKIE_NAME);
do_action("admin.header",$html);
echo $html;
?>  