<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../../boot/app.php';     

//系统.常用功能.全站配置
access('system.config');

$all = g();

foreach($all as $k=>$v){   
    set_config($k,$v);
}
json_success(['msg'=>'保存配置成功']);
