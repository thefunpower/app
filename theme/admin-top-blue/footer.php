  <div style="position: fixed;bottom: 10px;right: 30px;"> 
   PowerBy: <a href="https://thefunpower.netlify.qihetaiji.com/guide/" 
      target="_blank">TheFunpower <?=get_version()?> </a>
  </div> 
<?php 
  do_action('admin.common.page.footer');
?>  
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