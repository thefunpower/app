<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__ . '/../../boot/app.php';
$sign    = g('sign');
$user_id = g('user_id');
if (!$user_id || !$sign) {
    json_error(['msg' => '参数错误']);
}
$res     = get_author($sign, true);
if ($res['user_id'] != $user_id) {
    json_error(['msg' => '参数错误']);
}
json_success(['msg' => '登录成功']);
