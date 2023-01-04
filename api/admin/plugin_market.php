<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php'; 
use Alchemy\Zippy\Zippy;
//系统.常用功能.插件
access('system.plugin');
$type = g('type')?:'list';
if($type == 'download'){
   $url  = g('url');
   $data = file_get_contents($url);
   $dir  = PATH.'/uploads/tmp_plugins/';
   if(!is_dir($dir)){
    mkdir($dir,0777,true);
   }
   $file = $dir . time().'.zip';
   file_put_contents($file,$data);
   $zippy   = Zippy::load();
   $archive = $zippy->open($file);
   $archive->extract(PATH.'/plugins');
   unlink($file);
   json_success(['msg'=>'安装成功']);
}

if($type == 'list'){
    $opts = array(   
      'http'=>array(   
        'method'=>"GET",   
        'timeout'=>1,//单位秒  
       )   
    );    
    $url = "http://m.qihetaiji.com/plugins/market/index.php";
    $data = json_decode(file_get_contents($url , false, stream_context_create($opts)),true);  
    $all  = local_plugin();  
    foreach($data as &$v){
      $v['is_install'] = false;  
      if($all[$v['name']]){
          $v['is_install'] = true;
      } 
    }
    json_success(['data'=>$data]);
}


