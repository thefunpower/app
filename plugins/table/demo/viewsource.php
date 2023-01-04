<?php include __DIR__.'/../../../boot/app.php'; 
misc('jquery,hljs');
$viewsource = $_GET['viewsource'];
if($viewsource == 'viewsource'){exit();}
$file = __DIR__.'/'.$viewsource.'.php';
if(file_exists($file)){
    highlight_file($file);
?> 
<?php }?>

<script type="text/javascript">
 hljs.highlightAll();
</script>