<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/


add_action("admin.menu", function (&$menus) { 
  admin_yy_menu($menus); 
  $menus['yy']['children'][] = [ 
    'label' => '短信',
    'url' => 'plugins/sms/smsadmin.php',
    'acl' => "yy.sms"
  ]; 
}); 

/**
 * 发送短信
 */
function send_sms($phone, $str)
{
  return plugins\sms\SMS::send($phone, $str);
}
 
add_action('config.vue.data', function (&$str) {

  $all = get_config([
    'sms_user',
    'sms_pwd',
    'sms_ip',
    'sms_sign',
  ]);
  foreach ($all as $k => $v) {
    $str .= "this.\$set(this.form,'" . $k . "','" . $v . "')\n";
  }
});
add_action("config.form", function () {
?>
<el-tab-pane label="短信" > 
 
  <el-form-item label="用户名" required="true">
    <el-input v-model="form.sms_user" ></el-input>
  </el-form-item>
  <el-form-item label="密码" required="true">
    <el-input v-model="form.sms_pwd"  ></el-input>
  </el-form-item>
  <el-form-item label="IP" required="true">
    <el-input v-model="form.sms_ip" ></el-input>
  </el-form-item>
  <el-form-item label="签名" required="true">
    <el-input v-model="form.sms_sign" ></el-input>
  </el-form-item>
</el-tab-pane>
<?php

});
/**
 * 发送短信
 *
 * @param string $phone
 * @param string $txt
 * @return void
 */
function sms_send($phone, $txt,$use_verify_code = false)
{
  if($use_verify_code){
      $cache_id = 'sms:' . $phone;
      $code = cache($cache_id);
      if (!$code) {
        $code  = mt_rand(1000, 9999);
      }
      cache($cache_id, $code, 300);
  }
  return plugins\notice\core\sms\Sms::send($phone, $txt);
} 
/**
 * 验证手机号+验证码是否正确
 */
function verify_sms_code($phone,$code)
{
  $cache_id = 'sms:' . $phone;
  $cache_code = cache($cache_id);   
  if ($cache_code != $code) {
    json_error(['msg' => '验证码错误']);
  } 
  cache_delete($cache_id); 
  return true;
}
