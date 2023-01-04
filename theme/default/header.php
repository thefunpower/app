<!doctype html>
<html lang="zh-CN">
  <head>
    <!-- 必须的 meta 标签 -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript">
      var host = "<?=substr(host(),0,-1)?>";
    </script>
    <?php 
    misc('jquery,vue,element,node');
    do_action('front.head');
    ?> 
    <title><?=$title?></title>
  </head>
  <body>
    
  <?php do_action('front.header');?>
     
  