<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__.'/../../../../boot/app.php'; 
 
$table = $input['table']; 
if(!if_access_or('system.table.edit|'."table.".$table.".edit")){
  json_error(['msg'=>lang('Access Deny')]);
}; 
$where['ORDER'] = ['sort' => 'DESC', 'pid' => "ASC"];
$all = db_get($table, "*", $where);
foreach ($all as $v) { 
  $list[] = $v;
} 
$list =  array_to_tree(
  $list,
  'id',
  $pid = 'pid',
  $child = 'children',
  $root = 0,
  $id
);
$list =  array_values($list);
json_success(['data'=>$list]);