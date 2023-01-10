<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';    

$user  = g('user');
$pwd   = g('pwd');  
$find  = db_get_one("user");
if(!$user || !$pwd){
    json(['code'=>250,'msg'=>'用户名密码不能为空','type'=>'error']);
}
check_form_token();
check_reffer();
if(!$find){
    db_insert('user',[
        'user'  => 'admin',
        'pwd'   => md5('admin'),
        'tag'   => 'admin',
        'created_at'=> now()
    ]);
}
$find = get_user_where(['user'=>$user,'tag'=>'admin']); 
//登录页面hook
do_action("admin.login.before",$find); 

if($find && $find['pwd'] == md5($pwd)){
    //登录成功
    do_action("admin.login.success",$find); 

    cookie(ADMIN_COOKIE_NAME,$find['id']);
    cookie('user_name',$find['user']);
    json(['code'=>0,'msg'=>'登录成功','type'=>'success']);
}else{
    //登录失败
    do_action("admin.login.error",$find); 
    json(['code'=>250,'msg'=>'登录失败','type'=>'error']);    
}  