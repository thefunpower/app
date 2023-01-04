<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';    

//系统.员工.修改员工资料
access('system.user.update'); 

$vali    = validate([
    'user'   => '员工姓名',
    'email'  => '邮件',
    'gender'  => '性别', 
    'birthday'  => '生日', 
    'job'  => '岗位', 
],$input,[
    'required' => [
        ['user'],
        ['email'],
        ['gender'], 
        ['birthday'], 
        ['job'], 
    ],
    'email'=>[
        ['email'], 
    ], 
]);
if($vali){
    json($vali);
}   


$data  = g();
$id    = $data['id'];
$pwd   = $data['pwd']; 
$group_id  = $data['group_id'];  
$find  = get_user_where(['id'=>$id,'tag'=>'admin']); 
if(!$find){
	json(['code'=>250,'msg'=>'用户不存在','type'=>'error']);
}
$update = $input;
unset($update['id']);
$update['updated_at'] = now();
$update['group_id']   = $group_id; 
if($pwd){
    $update['pwd'] = md5($pwd); 
}  
$update = db_allow("user",$update);
$update['health_control'] = $input['health_control']?:-1;
unset($update['acl']); 
db_update('user',$update,['id'=>$id]);
//用户保存信息hook 
do_action("admin.user.do_action",$id);  
json(['code'=>0,'msg'=>'更新成功'.$pwd,'type'=>'success']);