<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
global $config;

include __DIR__ . '/../../boot/app.php';
$config['title'] = lang("全站配置");
admin_header();
check_admin_login();
access('system.config');
$vue = new Vue;
$vue->opt = [
	'is_editor' => false,
	'is_page'  => false,
	'is_reset' => false,
	'is_add'   => false,
	'is_edit'  => false,

];
$vue->data("top", "");
$vue->data("form", "js:{}");
$vue->created(["start()"]);
do_action("config.vue.data", $str_data);
$vue->method("start()", "js:
	" . $str_data . "
	this.top = window.innerHeight/2 - 100;
"); 

$right_menu = [];
do_action("config.right_menu", $right_menu);

$vue->method("config_save()", "js:{
	 ajax('/plugins/config/api/config_save.php',this.form,function(res){
	 	_this.\$message({
          message: res.msg,
          type: res.type
        });  
        " . $save_str . "
	 });
}");
$vue->data("activeName","a");
//配置vuejs
do_action("config.vue", $vue);
$js  = $vue->run();
$mime = \lib\Mime::load();
$tool = [];
do_action("config.tool",$tool);
?>

<div id="app" v-cloak>
	<div class="main_body">
		<el-form label-width="180px" label-position="left">
			<div class="config" style="width:800px;margin: auto;">
				<el-tabs v-model="activeName" type="border-card" tab-position="top" >
					<el-tab-pane label="<?=lang('通用')?>" name="a">  
						<?php if($tool){?>
					    <h3><?=lang('功能开关')?><small style="color:brown;margin-left: 10px;"><?=lang('功能有变动时保存提示成功后，请刷新页面')?>！</small></h3><hr>
					    <?php foreach($tool as $k=>$v){?>
					    <el-form-item label="<?=$k?>"> 
					      <?php foreach($v as $k1=>$v1){
					        $active = "1";
					        $inactive = "0";
					        $activetext = '';
					        $inactivetext = '';
					        $title = '';
					        if(is_array($v1)){
					          $active = $v1['active']?:"1";
					          $inactive = $v1['inactive']?:"0";
					          $title = $v1['title'];
					          $activetext = $v1['activetext'];
					          $inactivetext = $v1['inactivetext'];
					          $v1 = $v1['label'];
					        }
					        ?>
					        <?php if(!$activetext){?>
					          <?=$v1?>
					        <?php }?>
					        <el-switch title="<?=$title?>"
					          active-text="<?=$activetext?>"
					          inactive-text="<?=$inactivetext?>" 
					          active-value="<?=$active?>"
					          inactive-value="<?=$inactive?>"
					          v-model="form.<?=$k1?>"
					          active-color="#13ce66"
					          inactive-color="#ff4949">
					        </el-switch>
					      <?php }?>
					    </el-form-item> 
					    <?php }}?>
					    <el-divider content-position="center"><?=lang('上传')?></el-divider>
					    <h3><?=lang('上传')?></h3><hr>
					    <el-form-item label="<?=lang('文件类型')?>"> 
					      <el-select v-model="form.upload_mime"   filterable  multiple placeholder="<?=lang('请选择')?>">
					        <?php foreach($mime as $k=>$v){?>
					        <el-option key="<?=$k?>" label="<?=$k?>" value="<?=$k?>"></el-option>
					        <?php }?>
					      </el-select> 
					    </el-form-item> 
					    <el-form-item label="<?=lang('文件大小')?>（M）">
					      <el-input   v-model="form.upload_size"    >					         
					      </el-input> 
					    </el-form-item>  
					  
					    <el-form-item label="<?=lang('备案号')?>">
					      <el-input   v-model="form.beianhao"    ></el-input> 
					    </el-form-item> 
					    <el-form-item label="<?=lang('腾讯地图')?>">
					      <el-input   v-model="form.tx_map_key"    ></el-input>
					      https://lbs.qq.com/dev/console/key/setting
					    </el-form-item> 
					 
					    <h3><?=lang('邮件')?></h3>
					    <hr>
					    <el-form-item label="<?=lang('帐号')?>" required="true">
					      <el-input   v-model="form.mail_from"    ></el-input>
					    </el-form-item> 
					    <el-form-item label="<?=lang('密码')?>"  required="true">
					      <el-input   v-model="form.mail_pwd" type="password"    ></el-input>
					    </el-form-item>  
					    <el-form-item label="SMTP" required="true">
					      <el-input   v-model="form.mail_smtp"    ></el-input>
					    </el-form-item>  
					    <el-form-item label="<?=lang('端口')?>" required="true">
					      <el-input   v-model="form.mail_port"    ></el-input>
					    </el-form-item>  
					    <?php do_action('config.form.first')?>
					  </el-tab-pane> 
					<?php
					//配置form
					do_action("config.form");
					?> 
				     
				  </el-tabs> 
				  <div class="mt10"> 
					<el-button type="primary" style="width: 100px;"  @click="config_save"><?=lang('保存')?></el-button> 
				  </div>
			</div>
			
		</el-form> 
	</div>
</div>

<script type="text/javascript">
	<?= $js ?>
	<?php
	//配置JS
	do_action("config.js");
	?>
</script>
<style type="text/css">
	.config input,.config textarea,.config select{
		width: 500px;
	}
</style>
<?php
admin_footer();
?>