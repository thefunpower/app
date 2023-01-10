<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/

include __DIR__.'/../../boot/app.php';  

//系统.员工.绑定部门
access('system.user.bind_group');

$id         = g('id');
$group_id   = g('group_id');  
$find  = db_get_one("user","*",['id'=>$id,'tag'=>'admin']);
if(!$id || !$group_id){
    json(['code'=>250,'msg'=>'未选择用户组','type'=>'error']);
}
if(!$find){
    json(['code'=>250,'msg'=>'用户不存在','type'=>'error']);
}
db_update('user',[  
    'group_id' => $group_id
],['id'=>$id]);
json(['code'=>0,'msg'=>'绑定用户组成功'.$pwd,'type'=>'success']);
