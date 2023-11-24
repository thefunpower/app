<?php  

//数据库IP
$config['host']    = 'http://127.0.0.1:3000';
$config['db_host'] = '127.0.0.1';
//数据库名
$config['db_name'] = 'ec';
//数据库登录用户名
$config['db_user'] = 'root';
//数据库登录密码
$config['db_pwd']  = '111111'; 
//数据库端口号
$config['db_port'] = 3306; 


//COOKIE 配置
$config['cookie_prefix'] = '';
$config['cookie_path']   = '/';
$config['cookie_domain'] = '';


//AES加密解密 aes_encode(data) aes_decode(data)
$config['aes_key'] = 'test';
$config['aes_iv']  = md5('app');



//邮件发送 YCEHKDTNJUZXXYNL
$config['mail_from']  = '';
$config['mail_pwd']   = '';
$config['mail_smtp']  = 'smtp.163.com';
$config['mail_port']  = '465';

//前台主题
$config['front_theme'] = 'default'; 
//后台主题
$config['theme_admin'] = 'admin_typecho'; 
//时区
$config['timezone'] = 'PRC';


///////////////////////////////////////////////////////////////
// 连接数据库 
$dsn = "mysql:dbname=".$config['db_name'].";host=".$config['db_host'].";port=".$config['db_port'];
$user= $config['db_user'];
$pwd = $config['db_pwd'];
///////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////
// 邮件
$config['mail_dsn']   = 'smtp://'.$config['mail_from'].':'.$config['mail_pwd'].'@'.$config['mail_smtp'].':'.$config['mail_port'];
///////////////////////////////////////////////////////////////


