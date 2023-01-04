<el-form-item label="<?=$label?>"    
      <?php if($v['required']){?>required <?php }?> <?=$options_element?> >
	<table class="padding-table" style="width:100%;" class=" pure-table pure-table-bordered">
	    <thead>
	      <tr>
	        <th style="width:180px;">属性名 <span @click="push_attr('<?=$field?>')" class="hand link">添加</span></th>
	        <th >属性值</th> 
	        <th style="width:50px;">操作</th> 
	      </tr>
	    </thead>
	    <tbody>
	        <tr v-for="(v,index) in form.<?=$field?>">
	          <td> 
	          	<el-input  placeholder="<?=$v['placeholder1']?:'属性名如：温度'?>" v-model="form.<?=$field?>[index].name" ></el-input>
	          </td>
	          <td><el-input  placeholder="<?=$v['placeholder2']?:'多值用,、或空格分隔如：标准冰、少冰、去冰、温、热'?>" v-model="form.<?=$field?>[index].values"></el-input></td> 
			   <td>
			   	<span @click="del_attr('<?=$field?>',index)" class="hand link">删除</span>
			   </td>
	        </tr>
	             
	    </tbody>
	</table>
</el-form-item>
<?php 
$vue->data_form($field,"js:[
	{name:'',values:''},
	{name:'',values:''},
]");
$vue->method("push_attr(field)","js: 
	this.form[field].push({name:'',values:''});
");
$vue->method("del_attr(field,index)","js: 
	this.form[field].splice(index,1);
");
?>