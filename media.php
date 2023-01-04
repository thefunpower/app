<?php
/**
ng重写规则

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

*/
if (!isset($_GET['sign'])) {
    //exit('sign error');
} 
$imagePath = __DIR__.'/uploads/'; 
$image     = trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/'); 
$fullPath  = $imagePath . $image; 
$mime      = getimagesize($fullPath)['mime']; 
header("Content-Type: $mime");  
header("X-Accel-Redirect: /uploads/$image");