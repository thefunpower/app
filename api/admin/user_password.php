<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';   
check_admin_login();
//修改自己的密码
$id    = cookie(ADMIN_COOKIE_NAME);
$pwd   = $input['pwd'];  
$pwd1   = $input['pwd1'];  
$pwd2   = $input['pwd2'];  

$data    = g();  
$vali    = validate([
    'pwd'   => '原密码',
    'pwd1'  => '新密码',
    'pwd2'  => '重复新密码', 
],$input,[
    'required' => [
        ['pwd'],
        ['pwd1'],
        ['pwd2'], 
    ],
    'equals'=>[
        ['pwd1','pwd2'], 
    ],
    'lengthMin'=>[
    	['pwd1',6]
    ]
]);
if($vali){
    json($vali);
}   
if($pwd1 == $pwd){
	json_error(['msg'=>'原密码与新密码相同，无需更新密码']);
}
$find  = db_get_one("user","*",['id'=>$id]);
if(!$find){
	json_error(['msg'=>'系统异常，如有疑问请联系管理员']);
}
if(md5($pwd) != $find['pwd']){
	json_error(['msg'=>'原密码错误']);	
}

if(!$pwd){
    json_error(['msg'=>'密码不能为空']);
}
if(!$find){
	json_error(['msg'=>'用户不存在']);
}
db_update('user',['pwd'=>md5($pwd1),'need_change'=>''],['id'=>$id]);
json_success(['msg'=>'修改密码成功，新密码为'.$pwd1."请记牢，下次登录请使用新密码。"]);