<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__ . '/../../boot/app.php';
// 更新用户信息，{nickname:} 
$res = api();
$user_id  = $res['user_id'];
$meta = g('meta');
if (!$meta) {
    json_error(['msg' => '请正确填写内容']);
}

set_user_meta($user_id, $meta);
json_success(['msg' => '操作成功']);
