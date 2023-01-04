<el-form-item label="<?=$label?>"    
  <?php if($v['required']){?>required <?php }?> <?=$options_element?> >  
  <el-date-picker v-model="form.<?=$field?>"   ref="<?=$field?>"   type="date"
   placeholder="<?=$v['placeholder']?>"
   value-format="yyyy-MM-dd"
    > 
  </el-date-picker> 
</el-form-item>