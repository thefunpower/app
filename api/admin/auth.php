<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';    

//系统.部门.配置权限
access('system.group.auth');

$id  = g('id');
$acl = g('acl');  
db_update('user_group',['acl'=>$acl],['id'=>$id]); 
json(['code'=>0,'msg'=>'保存权限成功','type'=>'success']);