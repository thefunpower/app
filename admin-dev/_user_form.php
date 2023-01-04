<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
if(!defined("PATH")) exit();
?>
<el-form-item label="<?=lang('员工姓名')?>" required="true">
    <el-input v-model="form.user" >
    </el-input>
</el-form-item>
<el-form-item label="<?=lang('电子邮箱')?>" required="true">
    <el-input v-model="form.email" >
    </el-input>
</el-form-item>
<el-form-item label="<?=lang('手机号')?>" required="true">
    <el-input v-model="form.phone" >
    </el-input>
</el-form-item>
<!-- 

<el-form-item label="<?=lang('性别')?>" required="true">
    <el-radio v-model="form.gender" label="1"><?=lang('男')?></el-radio>
    <el-radio v-model="form.gender" label="2"><?=lang('女')?></el-radio>
</el-form-item>

<el-form-item label="<?=lang('生日')?>" required="true">
    <el-input v-model="form.birthday"  min="1900-01-01" max="<?=date("Y-m-d")?>" format="yyyy-MM-dd" value-format="yyyy-MM-dd"  type="date" size="medium" >
    </el-input>
</el-form-item>

<el-form-item label="<?=lang('岗位')?>" required="true">
    <el-input v-model="form.job" size="medium" >
    </el-input>
</el-form-item>

<el-form-item label="<?=lang('纳入健康管理')?>"  >
    <el-radio v-model="form.health_control" label="1"><?=lang('是')?></el-radio>
    <el-radio v-model="form.health_control" label="-1"><?=lang('否')?></el-radio>
</el-form-item> 
  -->
<el-form-item label="<?=lang('选择部门')?>">
	<el-select v-model="form.group_name" class="yc_input" ref="group_id">
		<el-option style="height: auto;width:100%;" :value="node">
			<el-tree class="filter-tree" @node-click="select_click" :data="options" default-expand-all ref="tree">
			</el-tree>
		</el-option>
	</el-select>
</el-form-item>