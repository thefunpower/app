<?php   
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
global $config; 
$config['title'] = "权限";
include __DIR__.'/../boot/app.php';  
//include __DIR__.'/header.php';
check_admin_login();
misc('jquery,vue,node,bs5,element,css');  
$auth  = new \AuthClass;
$lists = $auth->load();  
$id    = g('id');
$group = db_get_one('user_group','*',['id'=>$id]); 
$acl = $group['acl'];
?>

<div id="app" v-cloak style="margin:0;padding: 0;padding: 20px;"> 
    <div class="mt10">  
    	 	<!-- <h3>部门：<?= $group['name']?></h3> -->
	    	<table class="table table-striped table-bordered">
	  
			  <tbody>
			  	<?php 
				  $i = 0;
				  foreach($lists as $kk=>$volist){ 
				  $i++;  
				?>  
			  	<?php 
				  	$j = 0;
				  	foreach($volist as $k=>$v2){ 
				  	$j++;
				?>  
			    <tr>
			      <th style="width:200px;"> 
					<label class="checkbox  hand" >
				  			<input  type="checkbox" rel="a_<?=$i?>"  style="display: none;"  class="all top ml20"><?= lang($k)?>
				  	</label>  
				  </th>
			      <th class="next_1">
			      <?php  
			    	foreach($v2 as $v1){
			    		if($v1 && is_array($v1)){
			      ?>
			      <label class="checkbox" style="margin-right: 20px;"  
						      		title="<?= lang($v1['action'])?>">
			      	 <input type="checkbox"  class="next_2"  
						  <?php if($acl && in_array($v1['action'],$acl)){?>checked<?php }?>
						  rel="acl_name"  name="acl[]" value="<?= $v1['action']?>">
						  <?= lang($v1['label'])?> 
				   </label> 
			      <?php }}?> 
			      </th>
			    </tr>
			    <?php }?>  
			    <?php }?>  
			  </tbody>
			</table>
			<el-button type="primary" @click="save"><?=lang('保存')?></el-button>
    </div>          
</div> 
<style type="text/css"> 
.hover_show_top .next_tree{display:none;} 
.hover_show_top:hover .next_tree { 
 	display:block;
}
.hover_show_top .next_tree:hover{  
   display:block; 
 } 
</style>
<script type="text/javascript"> 
	$(function() { 
		//初始化加载选中状态
		init_check_status();
		function init_check_status(){
			//第二层判断
			$("input.next_1").each(function() {
				 var top = $(this);
				 var i = 0;
				 var k = 0;
				 var j = 0;
				 $(this).parent().next(".next_2").find('input').each(function(){
					let ch = $(this).prop('checked');
					i++;
					if(ch === true){
						j++;
					}else{
						k++;
					} 
				}); 
				if(i == j){ 
					top.prop('indeterminate',false);
					top.prop('checked',true);
				}else if(j > 0 ){
					//半选 
					top.prop('indeterminate',true);
				}else{
					top.prop('indeterminate',false);
					top.prop('checked',false);
				}
			});
			//第一层
			$("input.top").each(function() {
				 var top = $(this);
				 var i = 0;
				 var k = 0;
				 var j = 0; 
				 $(this).parent().parent().parent().find('input.next_2').each(function(){
					let ch = $(this).prop('checked');
					i++;
					console.log("ch:"+ch);
					if(ch === true){
						j++;
					}else{
						k++;
					} 
				});
				console.log(">>> " + i+' '+j+' '+k);
				if(i>0 && i == j){ 
					top.prop('indeterminate',false);
					top.prop('checked',true);
				}else if(j > 0 ){
					//半选 
					top.prop('indeterminate',true);
				}else{
					top.prop('indeterminate',false);
					top.prop('checked',false);
				}
			});
		}


		//实现半选
		$("input.next_2").click(function(){
			let ch = $(this).prop('checked'); 
			let input = $(this).parent()
						.parent(".next_2:last");  
			let flag = 0; 
			let i = 0;
			let j = 0;
			let k = 0;
			input.find('input').each(function(){
				i++;
				let ch = $(this).prop('checked'); 
				if(ch){
					j++;
				}else{
					k++;
				}
			});			 
			let top = input.parent().find(".next_1:last"); 
			if(i == j){ 
				top.prop('indeterminate',false);
				top.prop('checked',true);
			}else if(j > 0 ){
				//半选
				top.prop('indeterminate',true);
			}else{
				top.prop('indeterminate',false);
				top.prop('checked',false);
			}
			init_check_status();
		});

		//实现全选、全不选
		$(".top").click(function(){
			let ch = $(this).prop('checked'); 
			let input = $(this).parent()
					.parent()
					.next('.next_1:first')
					.find("input");
			if(ch){
				input.each(function(){
					$(this).prop('indeterminate',false);
					$(this).prop('checked',true);
				});
			}else{
				input.each(function(){
					$(this).prop('indeterminate',false);
					$(this).prop('checked',false);
				});
			}
		});

		$(".next_1").click(function(){
			let ch = $(this).prop('checked'); 
			let input = $(this).parent() 
					.next('.next_2:first')
					.find("input");
			if(ch){
				input.each(function(){
					$(this).prop('indeterminate',false);
					$(this).prop('checked',true);
				});
			}else{
				input.each(function(){
					$(this).prop('indeterminate',false);
					$(this).prop('checked',false);
				});
			}
			init_check_status();
		});  
 
	}); 
    var _this;
    var app = new Vue({
        el:"#app",
        data:{
            form:{
            	id:"<?= $id?>"
            },
            active:"<?= $id?>",
            h:"",             
        },
        created(){
            _this = this;  
            this.h = window.innerHeight-100;
        },
        methods:{
        	click(e){
        		let i = e.name; 
        		this.form.id = i; 
        	},
            save(){
            	let val = [];
            	let name = "input[rel='acl_name']"; 
        		$(name).each(function(){ 
        			if($(this).prop("checked")){
        				val.push($(this).val());
        			}
        		}); 
        		this.form.acl = val;
        		ajax("/api/admin/auth.php",this.form,function(res){
        			if(res.code == 0){
        				_this.$message({
				          message: res.msg,
				          type: 'success'
				        });
        			}
        		}); 
            },
            
        }
    });
</script>
<style type="text/css">
    .rows{  
    	margin-right: 10px;
    	    border-radius: 5px;
		    border: 1px solid #eee;
		    padding: 5px;
		    margin-bottom: 10px;
	}
    .table_f1{
    	min-width: 120px;
    }
</style>

<?php include __DIR__.'/footer.php';?>