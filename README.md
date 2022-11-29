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
 

## php.ini
 
~~~
max_input_vars = 5000
~~~
 