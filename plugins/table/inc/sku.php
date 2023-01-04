<el-form-item label="<?=$label?>"    
      <?php if($v['required']){?>required <?php }?>  <?=$options_element?>  >  
	<!-- 主规格名，不需要<el-input  v-model="main_spec" style="width: 300px;" ></el-input>   -->
	<table class="padding-table" style="width:100%;" class=" pure-table pure-table-bordered">
	    <thead>
	      <tr>
	        <th>规格 <span @click="push_spec('<?=$field?>')" class="hand link">添加</span></th>
	        <th >价格</th>
	        <th >库存</th> 
	        <th style="width:50px;">状态</th> 
	        <th style="width:50px;">操作</th> 
	      </tr>
	    </thead>
	    <tbody>
	        <tr v-for="(v,index) in form.<?=$field?>">
	          <td> 
	          	<el-input  v-model="form.<?=$field?>[index].spec_name"></el-input>
	          </td>
	          <td><el-input  v-model="form.<?=$field?>[index].price"></el-input></td>
	          <td>
	          	<el-input  v-model="form.<?=$field?>[index].stock" style="width: 100px;"></el-input> 
	          </td> 
	          <td>
		          <el-switch
					  v-model="form.<?=$field?>[index].status"
					  active-value="1"
					  inactive-value="-1"
					  active-color="#13ce66"
					  inactive-color="#ff4949">
					</el-switch>
			   </td> 	
			   <td>
			   	<span @click="del_spec('<?=$field?>',index)" class="hand link">删除</span>
			   </td>
	        </tr>
	             
	    </tbody>
	</table>
</el-form-item> 
<?php 
$vue->data_form($field,"js:[
	{spec_name:'',price:'',stock:'',status:'1'},
	{spec_name:'',price:'',stock:'',status:'1'}
]");
$vue->method("push_spec(field)","js: 
	this.form[field].push({spec_name:'',price:'',stock:'',status:'1'});
");
$vue->method("del_spec(field,index)","js: 
	this.form[field].splice(index,1);
");
?>