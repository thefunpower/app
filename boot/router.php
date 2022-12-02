<?php 
if(!defined('VERSION')){die();} 
global $router;    

$router->get("/",function()
{
	echo 'welcome';
	exit;
});