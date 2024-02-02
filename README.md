#  APP

1.把`config.ini.dist.php` 改为`config.ini.php`

2.修改其中的参数

3.配置Nginx重写
 
## 重写

~~~
location ~.*\.(sql|pem|md|php) {
  deny all;
}  
location ^~ /theme/ {
    location ~* \.php$ {
        deny all;
    }
}
location / {
    if (!-e $request_filename){
        rewrite ^(.*)$ /index.php last;
    }  
}
location /uploads/ {
    try_files $uri /image_cache/index.php/$uri;
}
~~~
 

### SQL 

~~~
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COMMENT='配置';
~~~
