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
$all = db_get("table_status_process_set_detail","*",[
	'ORDER'=>['id'=>"ASC"],
	'nid'=>$nid
]);
$i = 0;
$list = [];
$arr = [];
foreach($all as $v){
	$list['title'][$i] = $v['title'];
	$list['user_id'][$i] = $v['user_id'];
	$arr[] = $i;
	$i++; 
}
if(!$list){
	$list = [
		'title'=>[],
		'user_id'=>[],
	];
	$arr = [0];
}
json_success(['data'=>$list,'arr'=>$arr]);