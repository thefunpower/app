<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__ . '/../../boot/app.php'; 
/**
*  由openid判断与user_id是不是一样的
*  有可能不一样，比如帐号被删除了
*/
$api = api();
$user_id = $api['user_id']; 
$openid  = $input['openid'];
$from  = $input['from']; 
if($user_id && $openid && $from){
	$res = db_get_one("login","*",[
		'openid'=>$openid,
		'type'=>$from,
	]);
	if(!$res){
		json_error(['user_id'=>0]);
	}
	if($res['user_id'] != $user_id){
		json_error(['user_id'=>$res['user_id']]);
	}
}
json_success(['msg'=>'帐号正常']);