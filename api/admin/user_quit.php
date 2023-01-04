<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';   


//系统.员工.办理离职
access('system.user.quit');

$id = $input['id'];
if($id == 1){
	json_error(['msg'=>'初始员工已禁用该功能']);
}
$res = db_get_one("user","*",['id'=>$id]);
if($res){
	if($res['status'] == 1){
		$status = -1;
		$msg = '员工离职成功';
	}else{
		$status = 1;
		$msg = "恢复员工在职成功";
	}
	$id = db_update('user',[ 
	    'status'     =>  $status,
	    'updated_at' => now(), 
	],['id'=>$id]);
	json_success(['msg'=>$msg]);
}

json_error(['msg'=>'操作异常，如有疑问请联系管理员']);