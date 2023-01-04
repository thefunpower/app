<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__ . '/../../boot/app.php';
$res = api();
$user_id  = $res['user_id'];
$data = get_user($user_id);
if (!$data['id']) {
    json_error(['msg' => '用户不存在']);
}  
if(!$data['avatar_url']){
    $openid = $input['openid'];
    $from = $input['from'];
    $open = get_login_by_openid($openid,$from);
    $data['avatar_url'] = $open['avatar_url'];
}
unset($data['pwd']);
json_success(['data' => $data]);
