<?php

/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/

include __DIR__ . '/../../../../boot/app.php';

//系统.审核流程.配置
access("yy.table_status_process.admin");

$nid = $input['nid'];
$data = $input['data'];

if($nid && $data){
	db_del("table_status_process_set_detail",['nid'=>$nid]);
	foreach($data['title'] as $k=>$v){
		$user_id = $data['user_id'][$k]; 
		db_insert("table_status_process_set_detail",[
			'title'=>$v,
			'user_id'=>$user_id,
			'nid'=>$nid,
		]);
	}
	json_success(['msg'=>'操作成功']);
}
