<?php 
global $menu;
$menu[] = [ 
    'title' => '员工及组织架构',
    'icon' => 'el-icon-user',
    'menu' => [
        '员工' => '/sys/user/index',
        '组织架构' => '/sys/group/index',
    ] 
];
$menu[] = [
    'title' => '系统',
    'icon' => 'el-icon-menu',
    'menu' => [
        '操作记录' => '/sys/log/index',
    ]
];
 