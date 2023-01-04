

<?php 
  do_action('admin.common.page.footer');
?>
</div>
</div>
</div> 
<script src="/theme/admin-material/assets/vendors/js/vendor.bundle.base.js"></script>  
<script src="/theme/admin-material/assets/js/misc.js"></script>  
<?php 
//JSON输出后或页面渲染后
do_action("end");
?>

<?php 
  do_action('admin.common.footer');
?>
<?php 
if(function_exists('message_sub_html')){
  message_sub_html('self','notice');  
}
?>
</body>
</html> 