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
$name = $input['name'];
$nid = $input['nid'];
$arr = get_table_status_process_code($name,true);
$active_status_process = get_table_status_process_step($name,$nid);
$his = get_table_status_process_his($name,$nid);
$status_process = db_get_one($name,'status_process',['id'=>$nid]);

if($active_status_process == 100 || $status_process=='finish'){ 
	$ret = [
		'his'=>$his,
		'his_last'=>count($his),
		'success'=>1
	];
}else{
	$ret = [
		'his'=>$his,
		'his_last'=>count($his),
		'data'=>$arr,
		'active_status_process'=>$active_status_process,
		'success'=>2
	];
}
$ret['can_change'] = true;
if(!get_table_status_process_next($name,$nid,$user_id,true)){
	$ret['can_change'] = false;
}
json_success($ret);

