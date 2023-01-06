<?php 
global $config,$title;
?>
<!DOCTYPE html>
<html lang="en">
  <head> 
<?php 
check_admin_login();
use lib\Menu; 
$menu  = Menu::get(); 
?><meta name="viewport" content="width=device-width,initial-scale=1"> 
  <script type="text/javascript">
      <?php 
      $secret = get_config('sign_secret')?:'TheCoreFun2022';
      ?>
      var signature_key = "<?=$secret?>"; 
      var host = "<?=substr(host(),0,-1)?>";
  </script>
    <?php misc('vue,element,jquery,node,layui,echarts,bs5,wangEditor,sortable'); ?>  
  <link rel="stylesheet" href="/node_modules/@mdi/font/css/materialdesignicons.min.css"> 
  <link rel="stylesheet" href="/theme/admin-material/assets/vendors/css/vendor.bundle.base.css"> 
  
  <link rel="stylesheet" href="<?=cdn()?>theme/admin-material/assets/css/demo/style.css">
  <link href="<?=cdn()?>misc/css/admin.css" rel="stylesheet">
  <script charset="utf-8" src="https://map.qq.com/api/gljs?v=1.exp&key=<?=get_config('tx_map_key')?>"></script>  
<style type="text/css">
  #app{ 
    margin-top: 0px  !important;
    margin-left: 40px  !important;
  }
  .el-upload-list{display: none;}
  p { 
    margin-top: 0.5rem; 
  }
  html, body{
    background-color: #fefdf8 !important;
    background-image: url(/misc/img/bg.png);
    color: #354A57;
  }
  .mdc-drawer + .mdc-drawer-app-content .mdc-top-app-bar{
    background-color: #fefdf8 !important;
    background-image: url(/misc/img/bg.png);
    color: #354A57;
  }

</style>
<?php do_action("admin.common.header");?>
    <title><?= $title?:"运营平台"?></title>
  </head>
  <body>
<?php 
do_action('admin.common.header');
?>
 <div class="body-wrapper"> 
    <?php if(!g('iframe_no_menu')){?>
    <aside class="mdc-drawer mdc-drawer--dismissible mdc-drawer--open">
      <div class="mdc-drawer__header">
        <a href="<?=host().ADMIN_DIR_NAME?>" class="brand-logo" style="font-size: 20px;">
          <img src="<?=host()?>misc/img/logo.png" style="width: 35px;">
          <?=lang('运营平台')?>
        </a>
      </div>
      <div class="mdc-drawer__content">
        <!-- <div class="user-info">
          <p class="name"></p>
          <p class="email"></p>
        </div> -->
        <div class="mdc-list-group">
          <nav class="mdc-list mdc-drawer-menu">
            
            <?php include __DIR__.'/menu.php';?>
             
          </nav>
        </div>
        <div class="profile-actions"> 
          <a href="/<?=ADMIN_DIR_NAME?>/user_password.php"><?=lang('修改密码')?></a>
          <span class="divider"></span>
          <a href="/<?=ADMIN_DIR_NAME?>/logout.php" onclick="return confirm('<?=lang('确认退出？')?>');"><?=lang('退出')?></a>
        </div>
         
      </div>
    </aside>
    <?php }?>

    <!-- partial -->
    <div class="main-wrapper mdc-drawer-app-content"> 
      <?php if(!g('iframe_no_menu')){?>
        <header class="mdc-top-app-bar">
          <div class="mdc-top-app-bar__row">
            <div class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
              <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button sidebar-toggler">menu</button>
             <span><?=$config['title']?></span>
            </div>
            <?=lang('已登录')?>：（<?=cookie('user_name')?>） <?=lang('版本')?>：V<?=VERSION?>
          </div>
        </header> 
      <?php }?>
      <div id="main-page">
        <?php if(g('iframe_no_menu')){?>
          <p></p>
        <?php }?>
      <?php 
        do_action('admin.common.content');
      ?>

   

    