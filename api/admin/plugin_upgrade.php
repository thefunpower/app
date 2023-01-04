<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';   
//系统.常用功能.插件升级
access('system.plugin.upgrade');

$name = $input['name'];
$version = $input['version'];
$new_version = $input['new_version'];

if(!$name || !$new_version || !$new_version){
	json_error(['msg'=>'操作异常']);
}

$res = db_get_one("plugin","*",['name'=>$name]);


//加载升级包
$dir = PATH.'plugins/'.$name.'/upgrade/*.sql';
$fs = glob($dir);
if($fs){
	$new_fs = [];
	foreach($fs as $sql){
		$filename = get_name($sql);
		if($filename > $version && $filename <= $new_version){
			$new_fs[] = $sql;
		} 
	} 
	if($new_fs){
		foreach($new_fs as $sql){ 
		    $data = file_get_contents($sql);
		    if($data){
		    	db_query($data);	
		    }		    
		}
	} 
} 
db_update("plugin",['version'=>$new_version],['name'=>$name]);
json_success(['msg'=>'升级完成']);
