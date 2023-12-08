<?php  
global $router;

use ExpressTemplate\Zto;  

$router->get('/',function(){
	 view('index');
});
  