<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';   
//系统.常用功能.插件
access('system.plugin');
$type = g('type')?:'list';
if($type == 'install'){
   $id  = g('id');
   $status = install_plugin_auto($id); 
   if($status == 1){ 
        $msg = "安装插件".$one['name']."成功！";
   }else{  
        $msg = "卸载插件".$one['name']."成功！";   
   }  
   json_success(['msg'=>$msg,'status'=>$status]);
}

if($type == 'list'){ 
    $data = load_plugin_to_db();
    json(['data'=>$data]);

}

