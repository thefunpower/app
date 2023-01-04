<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__.'/../../../../boot/app.php';    
$user_id = logined_user_id();
if(!$user_id){
  json_error([]);
}
$key = $input['key'];
$val = $input['val'];

if($key && strpos($key,':table_per_page_')!==false){
  if($val > 0){
    cache($key,$val,time()+86400*365*10);
  }
}

json_success([]);