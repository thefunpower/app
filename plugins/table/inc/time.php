<el-form-item label="<?=$label?>"    
  <?php if($v['required']){?>required <?php }?> <?=$options_element?>  >  
  <el-time-select v-model="form.<?=$field?>" 
    value-format="HH:mm:ss"  ref="<?=$field?>"   
    <?php if($v['options']){?>
      picker-options=<?=json_encode($v['options'])?>
    <?php }?>
    > 
  </el-time-select> 
</el-form-item>