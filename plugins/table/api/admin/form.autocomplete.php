<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__.'/../../../../boot/app.php';   

$table = $input['table']; 
$acl = $input['_acl'];
if($acl){
  $acl = aes_decode($acl);
  $acl = trim(substr($acl,0,strpos($acl,':'))); 
  $acl = '|'.$acl;
}
if(!if_access_or('system.table.admin|'."table.".$table.".admin".$acl)){
  json_error(['msg'=>lang('Access Deny')]);
};
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
