<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';    

//系统.部门.添加
access('system.group.add');
//添加部门 
$name   = g('name');  
$find   = db_get_one("user_group","*",['name'=>$name]);
if(!$name){
    json(['code'=>250,'msg'=>'部门名必填','type'=>'error']);
}
if($find){
	json(['code'=>250,'msg'=>'部门已存在','type'=>'error']);
}
db_insert('user_group',[ 
    'name'   => $name,
    'status' => 1
],['id'=>$id]);
json(['code'=>0,'msg'=>'添加部门成功','type'=>'success']);