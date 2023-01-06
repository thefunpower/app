<?php global $title,$config;?>
<!doctype html>
<html lang="zh-CN">
  <head>
    <!-- 必须的 meta 标签 -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript">
      var host = "<?=substr(host(),0,-1)?>";
    </script>
    <?php misc('vue,element,jquery,node,layui,echarts,bs5,wangEditor,sortable'); ?>   
    <link href="/theme/admin-top-blue/<?= $config['admin_css']?:'theme_darkly'?>.css" rel="stylesheet">
    <link href="/theme/admin-top-blue/app.css" rel="stylesheet">
    <link href="/misc/css/admin.css" rel="stylesheet">

    <title><?= $title?:"运营平台"?></title>
  </head>
  <body> 
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid container">
    <img src="/misc/img/logo.png" style="height: 30px; margin-right: 5px;">
    <a class="navbar-brand" href="/<?=ADMIN_DIR_NAME?>">运营后台</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="/"> 
          </a>
        </li> 
         
      </ul> 
        <ul class="navbar-nav right"> 
          <?php if(cookie('user_name')){?> 
          <?php  
          $menu  = lib\Menu::get(); 
          $i=0;foreach ($menu as $v) { 
          $i++;
          ?> 
          <?php if(!$v['children']){?>
            <li class="nav-item">
              <a class="nav-link" href="<?= create_url($v['url'])?>"><?= lang($v['label']) ?> </a>
            </li>
          <?php }else{?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= lang($v['label']) ?></a>
            <?php 
            if($v['children']){
            ?>
            <div class="dropdown-menu">
              <?php  
                foreach ($v['children'] as $v1) {
                $url = $v1["url"];
                if ($url) {
                    $url = host() . $url;
                }
              ?> 
              <a class="dropdown-item" href="<?= $url ?>"><?= lang($v1['label']) ?></a> 
              <?php }?>
            </div>
            <?php }?>
          </li>
          <?php }}?> 
            <li class="nav-item">
              <a class="nav-link active" href="/<?=ADMIN_DIR_NAME?>/user_password.php"  > 
                修改密码
              </a>
            </li>
          

            <li class="nav-item">
              <a class="nav-link active" href="/<?=ADMIN_DIR_NAME?>/logout.php" onclick="return confirm('确认退出系统？');"> 
                退出
              </a>
            </li>
          <?php }?> 
        </ul> 
    </div>
  </div>
</nav>  