<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms . $ID20221128 
*/
if (file_exists(__DIR__ . '/../data/lock')) {
  echo json_encode(['code' => 250, 'msg' => '锁定安装']);
  exit();
} 
include __DIR__ . '/../boot/app.php';
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>安装</title>
<?php misc('jquery,vue,node,bs5,layui');?>
<script src="/misc/js/common.js"></script>
</head>


<body>
  <form class="layui-form" method="post" action="" style="background: #fff;    padding: 20px;
    border-radius: 10px;margin:auto;margin-top: 60px;width: 600px;">

    <h2>安装系统</h2>
    <div class="mb-3">
      <label class="form-label">当前域名</label>
      <input type="text" name="host_url" class="form-control" value="http://<?= $_SERVER['HTTP_HOST'] ?>/" placeholder="当前域名">
    </div>

    <h4>数据库信息：</h2>

      <div class="mb-3">
        <label class="form-label">主机地址</label>
        <input type="text" name="host" class="form-control" value="127.0.0.1" placeholder="主机地址">
      </div>
      <div class="mb-3">
        <label class="form-label">数据库名称</label>
        <input type="text" name="dbname" autofocus class="form-control" value="" placeholder="数据库名称">
      </div>
      <div class="mb-3">
        <label class="form-label">数据库帐号</label>
        <input type="text" name="user" class="form-control" value="" placeholder="数据库帐号">
      </div>
      <div class="mb-3">
        <label class="form-label">数据库密码</label>
        <input type="text" name="pwd" class="form-control" value="" placeholder="数据库名称">
      </div>


      <h4>
        管理员帐号：
        </h2>
        <div class="mb-3">
          <label class="form-label">用户名</label>
          <input type="text" name="admin_user" value="admin" class="form-control" value="" placeholder="用户名">
        </div>
        <div class="mb-3">
          <label class="form-label">密码</label>
          <input type="text" name="admin_pwd" value="admin" class="form-control" value="" placeholder="密码">
        </div>


        <div class="layui-form-item"> 
            <button type="button" class="btn btn-primary" lay-submit lay-filter="form">确认安装</button> 
        </div>
  </form> 
  <div id="license" style="display: none;">
    <?php  
    $Parsedown = new Parsedown(); 
    echo $Parsedown->text(file_get_contents(__DIR__."/license.php")); 
    ?>
  </div>
  <script>
    $(function(){
      layer.open({
        area:['100%','100%'],
        closeBtn:false,
        title:"软件使用协议",
        content:$('#license').html(),
        btn: ['我同意并安装', '我拒绝停止安装'],
        yes: function(index, layero){
          layer.closeAll();
        },
        btn2: function(index, layero){
          alert('您已拒绝安装,请关闭当前页面！');
          setTimeout(function(){
            window.close();
          },3000); 
          return false;
        }
      });  
    });  
    var form = layui.form;
    //监听提交
    form.on('submit(form)', function(data) {
      ajax("/install/do_install.php", data.field, function(res) {
        let msg = res.msg;
        if (res.code != 0) {
          msg = "<span style='color:red;'>" + msg + "</span>";
        }
        layer.open({
          title: '提示信息',
          content: msg,
          closeBtn: false,
          yes: function(index, layero) {
            layer.close(index);
            if (res.code == 0) {
              window.location.href = "/<?=ADMIN_DIR_NAME?>";
            }
          }
        });
      });
      return false;
    });
  </script> 
  <style type="text/css">
    body {
      background: #eee;
    }

    h4 {
      margin-bottom: 10px;
      font-weight: bold;
    }
   .layui-layer-btn1{
    background: red !important;
    color: #fff !important;
   }
  </style>
</body>

</html>