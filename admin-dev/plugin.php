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
$config['title'] = lang("插件");
include __DIR__.'/header.php';
check_admin_login();
misc('jquery,vue,node,element,css');   
$auth  = new \AuthClass;
$lists = $auth->load(); 
?>

<div id="app" v-cloak> 
    <div class="main_body">   
  			<el-table  v-loading="loading" border class="mt10" 
	    	    :height="height" 
		      :data="lists"
		      style="width: 100%"> 
		      <el-table-column type="index" label="<?=lang('序号')?>" :index="indexMethod" width="60"></el-table-column>
		      <el-table-column 
		        prop="title"
		        label="<?=lang('插件名')?>"
		        width="">
		        <template slot-scope="scope"> 
		        	<span v-if="scope.row.can_upgrade" style="color:green;font-weight: bold;" @click="upgrade(scope.row.name,scope.row.version,scope.row.new_version)">
		        		{{scope.row.title}}【<?=lang('可升级')?>】
		        	</span>
		        	<span v-else>{{scope.row.title}}</span>
		        </template>

		      </el-table-column> 

		      <el-table-column 
		        prop="name"
		        label="<?=lang('标识')?>"
		        width="300">
		        <template slot-scope="scope"> 
		        	<span v-if="scope.row.can_upgrade" style="color:green;font-weight: bold;">
		        		{{scope.row.name}} 
		        	</span>
		        	<span v-else>{{scope.row.name}}</span>
		        </template>
		      </el-table-column> 

		      <el-table-column 
		        prop="version"
		        label="<?=lang('版本')?>"
		        width="180">
		        <template slot-scope="scope"> 
		        	<span v-if="scope.row.can_upgrade"  class="red" @click="upgrade(scope.row.name,scope.row.version,scope.row.new_version)">
		        		{{scope.row.version}} -> {{scope.row.new_version}}
		        	</span>
		        	<span v-else>{{scope.row.version}}</span>
		        </template>
		      </el-table-column>  

		      <el-table-column 
		        prop="data.desc"
		        label="<?=lang('描述')?>"
		        width="">
		        <template slot-scope="scope"> 
		        	<span class="hand" v-if="scope.row.data" @click="show(scope.row.data.body)" v-html="scope.row.data.desc"> </span>
		        </template>
		      </el-table-column>  
		      <el-table-column  label="<?=lang('操作')?>" width="130">
		      	<template slot-scope="scope"> 
		      		<el-button v-if="scope.row.status == 1" type="text"  class="blue"
		      		@click="install(scope.row.name)"><?=lang('禁用')?></el-button> 
		      		<el-button class="red" v-else type="text"  @click="install(scope.row.name)"><?=lang('启用')?></el-button> 
		      	</template>
		      </el-table-column>  
		    </el-table> 
    </div>

</div> 

<script type="text/javascript">
    var _this;
    var app = new Vue({
        el:"#app",
        data:{
        	mlists:[],
        	lists: [], 
	        page:1,
	        total:0,
	        where:{
	        	per_page:20,
	        },
            form:{ 
            }, 
            is_show_update:false,
        	is_show_add:false,  
        	is_show_auth:false,
        	iframe_url:"",
        	height:"",
        	upgrade_form:{},
        	loading:true,
        },
        created(){
            _this = this; 
            this.load();
            this.load_market(); 
            this.fn();
            if (window.addEventListener) {
                window.addEventListener("resize", function() {
                  app.fn();
                });
            } else if (window.attachEvent) {
                window.attachEvent("onresize", function() {
                  app.fn();
                });
            } 
        },
        methods:{
        	upgrade(name,version,new_version){
        		this.update_form = {
        			name:name,
        			version:version,
        			new_version:new_version,
        		};
        		layer.confirm('升级', {
        		  title:"升级提醒", 
        		  content:'确认'+name+"从"+version+"升级到"+new_version+"?"+"<br>升级可能存在风险，请谨慎操作",
				  btn: ['我已了解风险并确认升级','取消'] 
				}, function(){
				   layer.closeAll();
				   ajax("/api/admin/plugin_upgrade.php",_this.update_form,function(res) { 
			           _this.$message({
				          message: res.msg,
				          type: res.type
				        }); 
			           if(res.code == 0){
			           	 _this.load(); 
			           }
			        });
				}, function(){
				   
				});
        	},
        	fn(){
        		this.height = window.innerHeight - 100;
        	},
        	doc(name,title){
        		layer.open({
				  type: 2, 
				  title:title,
				  content: '/admin/doc.php?name='+name,
				  area:['100%','100%']
				}); 
        	},
        	install(id){
        		ajax("/api/admin/plugin.php",{
        			type:'install',
        			id: id
        		},function(res) { 
		           _this.$message({
			          message: res.msg,
			          type: res.type
			        }); 
		           if(res.code == 0){
		           		_this.load(); 
		           }
		        });
        	},
        	download(url){
        		ajax("/api/admin/plugin_market.php",{
        			type:'download',
        			url: url
        		},function(res) { 
		           _this.$message({
			          message: res.msg,
			          type: res.type
			        }); 
		           if(res.code == 0){
		           		_this.load();
		           		_this.load_market();
		           }
		        });
        	},
        	page_size_change(val) { 
        	  this.where.page     = 1;
	          this.where.per_page = val;
	          this.load();
	        },
	        page_change(val) { 
	          this.where.page = val;
	          this.load();
	        },
	        load(){
	          let that = this; 
	          ajax("/api/admin/plugin.php",this.where,function(res) { 
	            that.page   = res.current_page;
	            that.total  = res.total;
	            that.lists  = res.data;
	            that.loading = false;
	          });
	        },   
	        load_market(){
	          let that = this; 
	           
	        },   
        	update(row){
        		this.is_show_update = true;
        		this.form = {
        			id:row.id,
        			user:row.user,
        		};
        	},
            save(){ 
            	let url = "/api/admin/plugin_add.php"; 
        		ajax(url,this.form,function(res){ 
        				_this.$message({
				          message: res.msg,
				          type: res.type
				        }); 
				        if(res.code == 0){
				        	_this.form = {}; 
				        	_this.load();
				        }
        		}); 
            },
            show(msg){
            	layer.open({
				  title: '内容'
				  ,content: msg
				});   
            }
            
        }
    });
</script> 

<?php include __DIR__.'/footer.php';?>