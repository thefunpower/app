<el-form-item label="<?=$label?>"    
  <?php if($v['required']){?>required <?php }?> <?=$options_element?> >  
  <el-date-picker v-model="form.<?=$field?>"   ref="<?=$field?>"   type="datetime"   align="center"   :picker-options="pickerOptions"   
    value-format="yyyy-MM-dd HH:mm:ss"
   placeholder="<?=$v['placeholder']?>"
    > 
  </el-date-picker> 
</el-form-item>