<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__ . '/../../boot/app.php';
/**
 * 返回时区，当时时间
 * /api/v1_time_now.php
 */
$time = date('Y-m-d H:i:s');
json_success(['time' => $time]);
