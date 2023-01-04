<el-form-item label="<?=$label?>"    
      <?php if($v['required']){?>required <?php }?>   <?=$options_element?> style="position: relative;">   
	<span class="hand link" @click="push_tag('<?=$field?>')" 
		 >添加</span>
	<div v-for="(v,index) in form.<?=$field?>">
		<el-input v-model="form.<?=$field?>[index]" style="width:200px;" class="mb10" ></el-input> 
		<span @click="del_tag('<?=$field?>',index)" class="hand link">删除</span>
	</div> 
</el-form-item>  
<?php 
$vue->data_form($field,"js:['']");
$vue->method("push_tag(field)","js: 
	this.form[field].push('');
");
$vue->method("del_tag(field,index)","js: 
	this.form[field].splice(index,1);
");
?>