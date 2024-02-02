<?php
global $acl_config;

/**
 * 函数加载
 * 加载每个应用下的helper.php文件
 */
$load = ['core','app','modules'];
foreach($load as $package) {
    $all = glob(PATH . '/' . $package . '/*/helper.php');
    foreach($all as $v) {
        include $v;
    }
    $all = glob(PATH . '/' . $package . '/*/acl.php');
    foreach($all as $v) {
        include $v;
    }
}

/**
 * 加载ACL权限文件
 */
if($acl_config) {
    foreach($acl_config as $k => $v) {
        foreach($v as $k1 => $v1) {
            url_acl_add($k . $k1, $v1);
            url_acl_add_auth($k, $k . $k1);
        }
    }
}