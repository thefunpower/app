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
  $acl = '|'.$acl.".del";
}
if(!if_access_or('system.table.admin|'."table.".$table.".admin".$acl)){
  json_error(['msg'=>lang('Access Deny')]);
};
table_builder_del($input);
