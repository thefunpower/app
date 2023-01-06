<?php 

add_action("admin.header",function(){
include __DIR__.'/header.php';
});

add_action("admin.footer",function(){
include __DIR__.'/footer.php';
});