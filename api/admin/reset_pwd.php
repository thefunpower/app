<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';    
api_is_admin();
$data = g();
$user_id = cookie(ADMIN_COOKIE_NAME);
if($user_id){
    if(!$data['new_pwd']){
        json_error(['msg'=>'新密码不能为空']);
    }
    if(!$data['new_pwd_repeat']){
        json_error(['msg'=>'重复新密码不能为空']);
    }
    if($data['new_pwd'] != $data['new_pwd_repeat']){
        json_error(['msg'=>'两次输入的密码不同']);
    }
    db_update("user",['pwd'=>md5($data['new_pwd'])]);
    set_user_meta($user_id,[
        'is_reset_pwd' => 1,
    ]);
    json_success(['msg'=>'修改密码成功,请牢记新密码'.$data['new_pwd']]);
}