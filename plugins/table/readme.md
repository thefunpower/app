数据库表中
id title status  created_at updated_at

如有 shop_id 说明是店铺，需要在cookie或api中有 shop_admin_id

~~~
依赖JS
<script type="text/javascript">
  <?php 
  //签名防止用户篡改，必须要定义。
  $secret = get_config('sign_secret')?:'TheCoreFun2022';
  ?>
  var signature_key = "<?=$secret?>";
</script>  
<?php misc('vue,element,jquery,node,layui,echarts,pure,wangEditor,sortable'); ?>  
~~~
