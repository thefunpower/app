<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
/**
 * PC网站会员上传文件
 */
include __DIR__ . '/../../boot/app.php'; 
$user = user_center_check_login();
$user_id = $user['id'];
$uploader = new \lib\Upload;
$uploader->user_id = $user_id;
$_POST['return_arr'] = 1;
$ret = $uploader->one();
unset($ret['local_path']);
$ret['code'] = 0;
json($ret);
