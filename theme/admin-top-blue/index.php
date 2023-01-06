<?php 
global $node_config; 
$node_config['title'] = "控制台"; 
include __DIR__.'/header.php';

?>
<title>控制台</title>
<div class="container" id="app" style="margin:auto;">
   

   <?php 
   $_page = "";
   do_action('admin.index',$_page); 
   echo $_page;
   ?>
   

 
<?php 
include __DIR__.'/footer.php';
?>