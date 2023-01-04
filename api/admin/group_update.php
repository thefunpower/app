<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';    

//系统.部门.修改
access('system.group.update');
//修改部门
$data   = g();
$id     = $data['id'];
$name   = $data['name'];  
$pid    = $data['pid'];   
$find  = db_get_one("user_group","*",['id'=>$id]);
if(!$id || !$name){
    json(['code'=>250,'msg'=>'部门名必填','type'=>'error']);
}
if(!$find){
	json(['code'=>250,'msg'=>'不存在的部门','type'=>'error']);
}
db_update('user_group',[ 
    'name'     => $name, 
    'pid'      => $pid,
],['id'=>$id]);
json(['code'=>0,'msg'=>'更新部门成功','type'=>'success']);