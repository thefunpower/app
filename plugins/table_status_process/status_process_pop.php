<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
if(!defined("PATH")){exit();}
?>

<el-dialog
  title="审核"
  :visible.sync="is_status_process"
  width="500px" 
  :close-on-click-modal="false"  
  :close-on-press-escape="false" 
  top="20px"
  >
  <p></p>
  <div  v-for="v in status_process_his">
      <span :style="'color:'+v.color" >[{{v.status}}]</span> 
        {{v.body}}<br>
      <p style="text-align: right;">审核员：{{v.user}} <br>审核时间：{{v.time}}</p>
      <hr v-if="v.is_end==1 || v.color=='red'">
  </div> 
  <p></p>
  <div v-if="active_status_success == 1"> 
      
  </div>
  <div v-else-if="active_status_success == 2">
    <div style="width: 80%;margin: auto;">
      <el-steps  :active="active_status_process" finish-status="success">
    	  <el-step :title="v.title" v-for="(v,k) in status_process_top"></el-step> 
      </el-steps>
    </div>
    
    <el-form v-if="status_process_can_change" ref="form" :model="form" label-width="180px">
    	  <el-form-item label="通过或拒绝"> 
  	    <el-radio v-model="status_process_form.status" label="1">通过</el-radio>
    		<el-radio v-model="status_process_form.status" label="2">拒绝</el-radio>
  	  </el-form-item>
  	  <el-form-item label="审核说明">
  	    <el-input v-model="status_process_form.body" type="textarea"></el-input>
  	  </el-form-item>
  	  <el-form-item label="">
  	    <el-button :disabled="status_process_dis?true:false" @click="status_process_save" type="primary">确认</el-button>
  	  </el-form-item> 
    </el-form>
  </div>
</el-dialog>