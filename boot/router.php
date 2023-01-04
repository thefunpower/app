<?php 
if(!defined('VERSION')){die();} 
global $router;    
/**
* 路由
* https://github.com/bramus/router
*/
$router->get('/',function(){     
	do_action("index");
}); 