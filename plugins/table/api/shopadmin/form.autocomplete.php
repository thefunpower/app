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

$table = $input['table']; 
shop_admin_is_login();
$select = $input['select']?:"*";
$where = $input['where'];
$label = $input['label'];
$value = $input['value'];
$queryString = $input['queryString'];

foreach($where as $k=>$v){
    if(!$v){
      if(strpos($k,'(') !== false){
        unset($where[$k]);
        $k = str_replace('(', '[', $k);
        $k = str_replace(')', ']', $k);
      }
      if($queryString){
        $where[$k] = $queryString;  
      }else{
        unset($where[$k]);
      } 
    }
}  
$all = db_get($table,$select,$where); 
$list = [];
foreach($all as $v){
    $list[] = [
      'id'=>$v['id'],
      'value'=>$v[$label],
    ];
}
json($list);
