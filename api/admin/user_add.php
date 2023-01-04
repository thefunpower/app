<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';   
//系统.员工.添加
access('system.user.add'); 
$vali    = validate([
    'user'   => '员工姓名',
    'email'  => '邮件',
    'gender'  => '性别', 
    'birthday'  => '生日', 
    'job'  => '岗位', 
],$input,[
    'required' => [
        ['user'],
        ['email'],
        ['gender'], 
        ['birthday'], 
        ['job'], 
    ],
    'email'=>[
        ['email'], 
    ], 
]);
if($vali){
    json($vali);
}  

$data  = g();
$user  = $data['user'];
$pwd   = mt_rand(100000,999999);  

$group_id   = $data['group_id'];  
$find  = db_get_one("user","*",['user'=>$user]);
if(!$user || !$pwd){
    json_error(['msg'=>'用户名密码必填']);
}
if($find){
	json_error(['msg'=>'用户已存在']);
}
$data = db_allow("user",$input); 
$data['pwd'] = md5($pwd);
$data['tag'] = 'admin';
$data['created_at'] = now();
$data['need_change'] = $pwd;
$data['group_id'] = $group_id;
$data['status'] = 1;
$data['health_control'] = $input['health_control']?:-1;
$id = db_insert('user',$data);

//用户保存信息hook 
do_action("admin.user.do_action",$id); 

json_success(['msg'=>'添加用户成功']);