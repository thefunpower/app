<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__ . '/../../boot/app.php';
/**
 * 上传裁剪后文件
 * /api/v1_crop.php
 */
$api = api();
$user_id = $api['user_id'];

$uploader = new \lib\Upload;
$uploader->user_id = $user_id;
$f  = $_FILES['file'];
$type = $f['type'];
if ($f['error'] != 0) {
    json(['code' => 250, 'msg' => 'upload error']);
}
$ext  = substr($type, strrpos($type, '/') + 1);
$tmp  = $f['tmp_name'];
$path = 'uploads/crop/' . date('Y-m') . "/";
$dest = PATH . $path;
if (!is_dir($dest)) {
    mkdir($dest, 0777, true);
}
$ext = $ext ?: 'jpg';
$name = uniqid(true) . "." . $ext;
$dest = $dest . $name;
if (!move_uploaded_file($tmp, $dest)) {
    json(['code' => 0, 'msg' => 'move file failed']);
}
$data['code'] = 0;
$data['status'] = 200;
$data['data']  = static_url() . $path . $name;
json($data);
