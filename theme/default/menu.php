<?php
$info = glob(PATH.'/app/*/info.php');
global $menu;

foreach($info as $v){
   include $v;
}

 