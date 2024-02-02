<?php 
include PATH.'/theme/default/header.php';
?>

{{welcome}}


<?php 
$vue->data("welcome","");
$vue->created(['load()']);
$vue->method('load()',"
this.welcome = 'welcome ';
");

?>

<?php 
include PATH.'/theme/default/footer.php';
?>
