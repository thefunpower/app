<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';    

//系统.员工.配置权限
access('system.user.auth');

$id  = g('id');
$acl = g('acl'); 
$acl = $acl?:[];
db_update('user',['acl'=>$acl],['id'=>$id]); 
json_success(['msg'=>'保存权限成功']);