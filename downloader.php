<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md . $ID20221128 
*/
/**
 * 下载
 * /downloader.php?name=文件名&local_url=本地地址
 */
error_reporting(0);
$name = addslashes($_GET['name']);
$file = __DIR__.'/'.addslashes($_GET['local_url']);
if(!file_exists($file)){exit();}
header("Cache-Control: no-cache, must-revalidate");
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' .$name);
header('Content-length:'.filesize( $file));
readfile($file);