<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
 
include __DIR__.'/../../boot/app.php';    

//系统.部门.查看
access('system.group.view');
json_success(['data'=>user_group_tree()]);