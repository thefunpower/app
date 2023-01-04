<?php

/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/

include __DIR__ . '/../../../../boot/app.php';


//系统.审核流程.审核员
access("yy.table_status_process.staff");
$user_id = get_admin_id();
$nid = $input['nid'];
$name = $input['name'];
$data = $input['data'];
$status = $data['status'];
$body = $data['body'];
if($name && $status){
	$res = db_get_one($name,'*',['id'=>$nid]);
	if(!in_array($res['status_process'], ['wait','process','finish','finish_error'])){
		json_error(['msg'=>'未提交审核']);
	}
	$arr = get_table_status_process_next($name,$nid,$user_id);
	$next_user_id = $arr['next_user_id'];
	if(!$arr['user_id'] || $arr['user_id'] != $user_id){
		json_error(['msg'=>'没有审核权限']);
	}
	$step = $arr['step']; 
	db_insert("table_status_process",[
		'nid'=>$nid,
		'name'=>$name,
		'status'=>$status,
		'user_id'=>$user_id,
		'next_user_id'=>$next_user_id,
		'body'=>$body,
		'step'=>$step,
		'created_at'=>now(),
	]);
	if($status == 2){ 
		db_action(function()use($nid,$name){
			db_update("table_status_process",[
				'is_del'=>1,
			],[
				'nid'=>$nid,
				'name'=>$name,
			]);
			db_update($name,[
				'status_process'=>'finish_error',
				'status'=>-1
			],['id'=>$nid]);
		}); 
	}else{ 
		if(get_table_status_process_step($name,$nid) == 100){
			db_update($name,[
				'status_process'=>'finish',
				'status'=>1
			],['id'=>$nid]);
		}else{
			db_update($name,[
				'status_process'=>'process',
				'status'=>1
			],['id'=>$nid]);			
		}
	}
	json_success(['msg'=>'操作成功']);
}else{
	json_error(['msg'=>'请选择审核通过或拒绝']);
}

