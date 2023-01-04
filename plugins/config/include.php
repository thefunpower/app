<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/ 


 
function admin_dev_menu(&$menus){
  if(!$menus['dev']){
      $menus['dev'] = [
            'icon' => '',
            'label' => '开发者',
            'level' => 2000,
            'acl' => "dev."
     ]; 
   }
}

function admin_yy_menu(&$menus){
  if(!$menus['yy']){
      $menus['yy'] = [
        'icon' => '',
        'label' => '运营',
        'level' => 35,
        'acl' => "yy."
      ]; 
  } 
}

 add_action("admin.menu", function (&$menus) {
  $menus['system']['children'][] = [
    'icon' => 'far fa-circle',
    'label' => '全站配置',
    'level'=>30,
    'url' => 'plugins/config/config.php',
    'acl' => "system.config"
  ]; 

  admin_yy_menu($menus);
});



add_action('config.vue.data',function(&$str){

  $all = get_config([ 
    'mail_from',
    'mail_pwd',
    'mail_smtp',
    'mail_port', 
    'tx_map_key', 
    'upload_size',
    'beianhao',
  ]);  
  $upload_mime = get_config('upload_mime'); 
  if($upload_mime){
    $str .="this.\$set(this.form,'upload_mime',".json_encode($upload_mime).");\n";
  }
  foreach($all as $k=>$v){
    $str .= "this.\$set(this.form,'".$k."','".$v."')\n";  
  }  
  $tool = [];
  do_action("config.tool",$tool);
  $get_config_key = [];
  foreach($tool as $k=>$v){
      foreach($v as $k1=>$v1){
        $get_config_key[] = $k1;
      }
  }
  if($get_config_key){
    $cc = get_config($get_config_key);
  } 
  foreach($cc as $k=>$v){
    $str .= "this.\$set(this.form,'".$k."','".$v."')\n";  
  }  


});

 


add_action("config.form",function(){ 
  $mime = \lib\Mime::load();
  $tool = [];
  do_action("config.tool",$tool);

  ?> 
  
<?php 

});


add_action("upload.mime", function($mime)
{
    $upload_mime = get_config('upload_mime');
    if($upload_mime){
      foreach($upload_mime as $v){
          $m = lib\Mime::get($v);
          if(is_string($m)){
            $arr = explode(',',$m);
          }else{
            $arr = $m;
          } 
          foreach($arr as $vv){
            $new_mime[] = $vv;
          } 
      } 
      if(!in_array($mime,$new_mime)){
        json_error(['msg'=>"上传文件类型错误".$mime]); 
      }
    }else{
        json_error(['msg'=>"请在系统->全站配置 通用中配置上传信息"]); 
    }
});


add_action("upload.size", function($size)
{
    $upload_size = get_config('upload_size');
    if($upload_size){
      if($size > $upload_size *1024*1024){
        json_error(['msg'=>"上传文件过大,最大允许".$upload_size."MB"]); 
      }
    }else{
      json_error(['msg'=>"请在系统->全站配置 通用中配置上传信息"]); 
    }
});