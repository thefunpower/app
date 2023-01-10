<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/

include __DIR__.'/../../boot/app.php';    
//系统.员工.列表 
access('system.user.index');
$where = [
    'ORDER'=>[
        'id'=>'DESC'
    ]
];
$where['tag'] = 'admin';

$wq = $input['wq'];
if($wq){
	$whereOr['user[~]'] = $wq;
	$whereOr['email[~]'] = $wq;
	$where['OR'] = $whereOr;
}

$status = $input['status']?:1;
$where['status'] = $status;

$gender = $input['gender'];
if($gender){
	$where['gender'] = $gender;
}

$health_control = $input['health_control'];
if($health_control){
	$where['health_control'] = $health_control;
}





$data = db_pager("user","*",$where); 
$arr = [
	1=>'男',
	2=>'女',
];
foreach($data['data'] as &$v){
    $v = get_user($v['id']); 
    unset($v['pwd']);
    $v['gender_txt'] = $arr[$v['gender']];
}
json($data);