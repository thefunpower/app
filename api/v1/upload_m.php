<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__ . '/../../boot/app.php';
//批量上传文件
$res     = api();
$uploader = new \lib\Upload;
$uploader->user_id = $res['user_id'] ?: 0;
$_POST['return_arr'] = 1;
$list = [];
foreach ($_FILES as $k => $v) {
    $_POST['file_key'] = $k;
    $ret = $uploader->one();
    $list[] = $ret;
}
json_success(['data' => $list]);
