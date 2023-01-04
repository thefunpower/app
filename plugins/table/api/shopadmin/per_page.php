<?php 
/*
  Copyright (c) 2021-2050 FatPlug, All rights reserved.
  This file is part of the FatPlug Framework (http://fatplug.cn).
  This is not free software.
  you can redistribute it and/or modify it under the
  terms of the License after purchased commercial license. 
  mail: sunkangchina@163.com
  web: http://fatplug.cn
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