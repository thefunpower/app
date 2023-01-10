<?php  
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware
    LICENSE: https://github.com/thefunpower/core/blob/main/LICENSE.md 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
global $config; 

include __DIR__.'/../boot/app.php';    
$config['title'] = lang("修改密码");
include __DIR__.'/header.php';  
check_admin_login(); 
misc('jquery,vue,node,element,css');   
?>

<div id="app" v-cloak> 
    <div class="main_body"> 
    	<el-card class="box-card" style="width: 500px;margin: auto;">
	    	<h3><?=lang('修改密码')?></h3> 
			<el-form label-position="top" label-width="80px">
			  <el-form-item label="<?=lang('员工姓名')?>">
			    <el-input v-model="form.user" disabled></el-input>
			  </el-form-item>
			  <el-form-item label="<?=lang('原密码')?>" required>
			    <el-input v-model="form.pwd" type="password"></el-input>
			  </el-form-item>
			  <el-form-item label="<?=lang('新密码')?>" required>
			    <el-input v-model="form.pwd1" type="password"></el-input>
			  </el-form-item>
			  <el-form-item label="<?=lang('重复新密码')?>" required>
			    <el-input v-model="form.pwd2" type="password"></el-input>
			  </el-form-item>
			  <el-form-item label="" class="mt10">
			    <el-button type="primary"  @click="save"><?=lang('修改密码')?></el-button> 
			  </el-form-item>
			</el-form>
		</el-card> 
    </div> 
            
</div> 

<script type="text/javascript">
    var _this;
    var app = new Vue({
        el:"#app",
        data:{
            form:{
            	user:"<?= cookie('user_name')?>"
            }, 
        },
        created(){
            _this = this; 
        },
        methods:{
        	 
            save(){ 
        		ajax("/api/admin/user_password.php",this.form,function(res){ 
        				_this.$message({
				          message: res.msg,
				          type: res.type
				        }); 
        		}); 
            }
            
        }
    });
</script> 

<?php include __DIR__.'/footer.php';?>