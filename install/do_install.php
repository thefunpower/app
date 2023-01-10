<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md . $ID20221128 
*/
if (file_exists(__DIR__ . '/../data/lock')) {
	echo json_encode(['code' => 250, 'msg' => '锁定安装']);
	exit();
}
$data = $_POST;

$host   = $data['host'];
$dbname = $data['dbname'];
$user   = $data['user'];
$pwd    = $data['pwd'];
$admin_user  = $data['admin_user'];
$admin_pwd   = $data['admin_pwd'];
$host_url    = $data['host_url'];

if (!$admin_user || !$admin_pwd) {
	echo json_encode(['code' => 250, 'msg' => '管理员帐号信息必填']);
	exit();
}


include __DIR__ . '/../vendor/catfan/medoo/src/Medoo.php';
$dsn = "mysql:dbname=$dbname;host=$host;port=3306";
//连接数据库  
try {
	$pdo = new PDO($dsn, $user, $pwd);
	$db = new Medoo\Medoo([
		'pdo'     => $pdo,
		'type'    => 'mysql',
		'option'  => [
			PDO::ATTR_CASE => PDO::CASE_NATURAL
		],
		'command' => [
			'SET SQL_MODE=ANSI_QUOTES'
		],
		'error' => PDO::ERRMODE_WARNING
	]);
} catch (Exception $e) {
	echo json_encode(['code' => 250, 'msg' => '数据库连接失败']);
	exit();
}

$sql = "SHOW TABLES LIKE '%user%';";
$all = $db->query($sql)->fetchAll();
if (count($all) > 0 && $db->count('user') > 0) {
	echo json_encode(['code' => 250, 'msg' => '禁止安装']);
	exit();
}

$config_file = __DIR__ . '/../config.ini.php';
if (file_exists($config_file)) {
	if (!is_writable($config_file)) {
		echo json_encode(['code' => 250, 'msg' => 'config.ini.php不可写']);
		exit;
	}
}

$str = "<?php
//服务器域名
// 'http://'.\$_SERVER['HTTP_HOST'].'/';
\$config['host']    = '" . $host_url . "';
//数据库配置 
// Mysql IP
\$config['db_host'] = '" . $host . "';
//数据库名
\$config['db_name'] = '" . $dbname . "';
//数据库登录用户名
\$config['db_user'] = '" . $user . "';
//数据库登录密码
\$config['db_pwd']  = '" . $pwd . "'; 
//数据库端口号
\$config['db_port'] = 3306; 
\$config['db_dsn']  = \"mysql:dbname={\$config['db_name']};host={\$config['db_host']};port={\$config['db_port']}\";\n
//CDN
\$config['cdn_url'] = [
	//'https://域名/',
];
//缓存  file 或 redis
\$config['cache_drive']  = 'file';
//文件缓存前缀
\$config['cache_prefix'] = \$_SERVER['HTTP_HOST']; 
//COOKIE 配置
\$config['cookie_prefix'] = '';
\$config['cookie_path']   = '/';
\$config['cookie_domain'] = '';
//redis配置
\$config['redis'] = [
	'host'=>'',
	'port'=>'',
	'auth'=>'', 
];
//sony_flake 生成订单号
\$config['sony_flake'] = [
    //数据中心ID
	'center_id'=>0,
	//机器ID
	'work_id'=>0,
	'from_date'=>'2022-10-27',
];
//AES加密解密 aes_encode(data) aes_decode(data)
\$config['aes_key'] = '" . mt_rand(100000, 999999) . "';
\$config['aes_iv']  = md5(" . mt_rand(10000000, 99999999) . "); 
//前台主题
\$config['front_theme'] = 'default'; 
//后台主题 admin-material  admin-top-blue
\$config['theme_admin'] = 'admin-top-blue';
//admin-top-blue时可配置sandstone  theme_darkly
\$config['admin_css'] = 'sandstone'; 
//时区
\$config['timezone'] = 'PRC'; 
//JWT
\$config['jwt_key'] = 'depponPmcGateway';
//防篡改签名
\$config['sign_secret']='TheCoreFun2022';
";

file_put_contents($config_file, $str);

$all = glob(__DIR__ . '/sql/*.sql');
foreach ($all as $file_name) {
	$fp =  fopen($file_name, "r");
	while ($sql = get_next_sql()) {
		$sql = trim($sql);
		if ($sql) {
			$db->query($sql);
		}
	}
	fclose($fp);
}
if ($db->count('user') < 1) {
	$db->insert('user', [
		'tag' => 'admin',
		'user' => $admin_user,
		'pwd' => md5($admin_pwd),
		'status'=>1,
	]);
}

@file_put_contents(__DIR__ . '/../data/lock', date('Y-m-d H:i:s'));

echo json_encode(['code' => 0, 'msg' => '安装完成']);
exit();

//从文件中逐条取sql
function get_next_sql()
{
	global $fp;
	$sql = "";
	while ($line = @fgets($fp, 40960)) {
		$line = trim($line);
		$line = str_replace("////", "//", $line);
		$line = str_replace("/", "'", $line);
		$line = str_replace("//r//n", "chr(13).chr(10)", $line);
		$line = stripcslashes($line);
		if (strlen($line) > 1) {
			if ($line[0] == '-' && $line[1] == "-") {
				continue;
			}
		}
		$sql .= $line . chr(13) . chr(10);
		if (strlen($line) > 0) {
			if ($line[strlen($line) - 1] == ";") {
				break;
			}
		}
	}
	return $sql;
}
