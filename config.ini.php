<?php
//服务器域名 
$config['host']    = 'http://'.$_SERVER['HTTP_HOST'].'/';
//数据库配置 
// Mysql IP
$config['db_host'] = '193.112.45.178';
//数据库名
$config['db_name'] = 'o2o';
//数据库登录用户名
$config['db_user'] = 'o2o';
//数据库登录密码
$config['db_pwd']  = 'MP3cBSczeFeaXSPE'; 
//数据库端口号
$config['db_port'] = 3306; 
$config['db_dsn']  = "mysql:dbname={$config['db_name']};host={$config['db_host']};port={$config['db_port']}";

//CDN
$config['cdn_url'] = [
	//'https://域名/',
];
//缓存  file 或 redis
$config['cache_drive']  = 'file';
//文件缓存前缀
$config['cache_prefix'] = $_SERVER['HTTP_HOST']; 
//COOKIE 配置
$config['cookie_prefix'] = '';
$config['cookie_path']   = '/';
$config['cookie_domain'] = '';
//redis配置
$config['redis'] = [
	'host'=>'193.112.45.178',
	'port'=>'6379',
	'auth'=>'111111', 
];
//sony_flake 生成订单号
$config['sony_flake'] = [
    //数据中心ID
	'center_id'=>0,
	//机器ID
	'work_id'=>0,
	'from_date'=>'2022-10-27',
];
//AES加密解密 aes_encode(data) aes_decode(data)
$config['aes_key'] = '301570';
$config['aes_iv']  = md5(36525535); 
//前台主题
$config['front_theme'] = 'default'; 
//后台主题
$config['theme_admin'] = 'admin-material'; 
//时区
$config['timezone'] = 'PRC'; 
//JWT
$config['jwt_key'] = 'depponPmcGateway';
//防篡改签名
$config['sign_secret']='TheCoreFun2022';
