<?php 

$router->get('/',function(){     
	do_action("index");
}); 

$router->get('/demo',function(){     
	include __DIR__.'/theme/default/demo.php';
}); 

$router->get('/city/(.*)',function($city){     
	echo $city;
}); 