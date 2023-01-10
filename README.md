## 开发手册

https://thefunpower.netlify.qihetaiji.com/guide/

## 配置重写

~~~
location / {
  if (!-e $request_filename){
    rewrite ^(.*)$ /index.php last;
  }
}
location ~.*\.sql {
  deny all;
}
location ^~ /uploads {
    internal; 
} 
location ~* \.(png|jpg|jpeg|gif|pdf|mp4|docx|doc|xls|xlsx|webp|webm)$ { 
    if (!-f $request_filename) {
        rewrite ^/.*$ /media.php;
    } 
    if ( -f $request_filename ) {
        expires 1d;
    }
}
~~~

## composer安装
线上
~~~
composer install
~~~

本地
~~~
composer install  --ignore-platform-req
~~~

## 服务器依赖

~~~
yum install ImageMagick ImageMagick-devel 
yum install ghostscript
~~~

## php.ini
 
~~~
max_input_vars = 5000
~~~
 

## 开发代码保持最新

~~~
composer config -g --unset repos.packagist
composer update thefunpower/core --ignore-platform-reqs
~~~