<?php 
include __DIR__.'/app.php';
$json = g('json');
$arr = json_decode($json,true);
if(!is_array($arr)){
	exit;
}
$json = json_encode($arr,JSON_UNESCAPED_UNICODE);
misc('jquery3,json-viewer');
?>
<div id='json-renderer'></div>
<script type="text/javascript">
	$('#json-renderer').jsonViewer(<?=$json?>);  
</script>

