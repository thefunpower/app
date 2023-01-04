<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/  
include __DIR__.'/../boot/app.php'; 
?><!doctype html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <title><?=lang('登录')?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript">
      var host = "<?=substr(host(),0,-1)?>";
    </script>
<?php 
misc('jquery,vue,node,element,bs5'); 
$vue = new Vue;  
$vue->opt = [
  'is_editor'=> false,
    'is_page'  => false,
    'is_reset' => false,
    'is_add'   => false,
    'is_edit'  => false, 
    
];
$jump_url = host().ADMIN_DIR_NAME;
if($_GET['url']){
    $jump_url = $_GET['url'];
}
$vue->method("login()","js:
this.form.form_token = '".create_form_token()."';
ajax('/api/admin/login.php',this.form,function(res){
    _this.\$message({
      showClose: true,
      message: res.msg,
      type: res.type
    }); 
    if(res.code == 0){
        window.location.href = '".$jump_url."';
    }
});
return false;
");
//登录vuejs
do_action("admin.login.vue",$vue);
$js  = $vue->run();
?>   
<style type="text/css"> 
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      } 
      html,
      body {
        height: 80%;
      }

      body {
        display: flex;
        align-items: center;
        padding-top: 100px;  
      }

      .form-signin {
        width: 100%;
        max-width: 400px;
        padding: 15px;
        margin: auto;
        text-align: left;
      }

      .form-signin .checkbox {
        font-weight: 400;
      }

      .form-signin .form-floating:focus-within {
        z-index: 2;
      }

      .form-signin input[type="text"] { 
        margin-bottom: 2px;
        
      }

      .form-signin input[type="password"] { 
        margin-bottom: 2px; 
      } 
</style>
<link href="/misc/css/login.css" rel="stylesheet">
<script type="text/javascript" src="/misc/js/jquery.particleground.min.js"></script>
<script type="text/javascript">
  $(function(){
    $('.full-page').particleground({
        dotColor:'#5cbdaa',
        lineColor:'#5cbdaa'
    });
  });
</script> 
</head>
<body class="full-page">
<div id="app" class="text-center " style="width: 100%;margin-top: 100px;position: absolute; top: 50px;" >

  <main class="form-signin">
    <el-card class="box-card">
       <h3 style="text-align:center;margin-bottom: 10px;"><?=lang('运营后台')?></h3>
       <el-form label-position="left" >
          <el-form-item label="<?=lang('帐号')?>" required>
            <el-input type="text" v-model="form.user"  @keyup.enter.native="login" placeholder="<?=lang('请输入帐号')?>"></el-input>
          </el-form-item>
          <el-form-item label="<?=lang('密码')?>" required>
             <el-input type="password" v-model="form.pwd" @keyup.enter.native="login"  placeholder="<?=lang('请输入密码')?>"></el-input>
          </el-form-item>
          <?php 
            //登录表单
            do_action('admin.login.form');
          ?> 
          <div >
            <el-button style="width: 100%;" type="primary"   @click="login"><?=lang('登录')?></el-button> 
          </div>
    </el-form>
    </el-card>
  </main>

</div>

<script type="text/javascript">
    <?=$js?>
    <?php do_action("admin.login.footer.js");?> 
</script>
<?php do_action("admin.login.footer");?>
</body>
</html>