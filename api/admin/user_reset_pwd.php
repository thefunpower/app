<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';   


//系统.员工.重置密码
access('system.user.reset_pwd');

$id = $input['id'];

$res = db_get_one("user","*",['id'=>$id]);
if($res){
	$pwd   = mt_rand(100000,999999); 
	$id = db_update('user',[ 
	    'pwd'       =>  md5($pwd),
	    'updated_at' => now(),
	    'need_change'=> $pwd,
	],['id'=>$id]);
	json_success(['msg'=>'重置密码成功']);
}

json_error(['msg'=>'重置密码失败']);