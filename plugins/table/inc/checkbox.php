<el-form-item label="<?=$label?>"    
  <?php if($v['required']){?>required <?php }?> <?=$options_element?> > 
  <?php 
    if($v['value'] && is_array($v['value'])){
  ?>
  <el-checkbox-group  v-model="form.<?=$field?>" >  
    <?php 
      foreach($v['value'] as $kk=>$vv){?>
        <el-checkbox border
          label="<?=$vv['value']?>"         
          ><?=$vv['label']?></el-checkbox>
    <?php }?>
    </el-checkbox-group>
  <?php }?>
</el-form-item>