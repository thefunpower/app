<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/

include __DIR__.'/../../boot/app.php';   

check_admin_login();

$id   = g('id');
$list = user_group_tree($id);
$list = array_merge([
    [
        'id' => 0,
        'label' => '移动到顶级'
    ]
], $list); 

$form   = db_get_one("user_group","*",['id'=>$id]);
$parent = [];
$pid    = $form['pid'];
if ($pid) {
    $parent = db_get_one("user_group","*",['id'=>$pid]);
}
json_success([
    'data'   => $list,
    'parent' => $parent,
    'form'   => $form
]);
