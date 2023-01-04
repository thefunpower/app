<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__ . '/../../boot/app.php';
//上传文件
$res     = api();
$uploader = new \lib\Upload;
$uploader->user_id = $res['user_id'] ?: 0;
$_POST['return_arr'] = 1;
$ret = $uploader->one();
unset($ret['local_path']);
$ret['code'] = 0;
json($ret);
