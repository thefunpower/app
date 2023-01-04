<?php 
global $node_config; 
$node_config['title'] = "控制台"; 
include __DIR__.'/header.php';

?>
<title>控制台</title>
<div id="app"> 
   

   <?php 
   $_page = "";
   do_action('admin.index',$_page); 
   echo $_page;
   ?>
   
</div>
 
<?php 
include __DIR__.'/footer.php';
?>