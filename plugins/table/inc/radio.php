<el-form-item label="<?=$label?>"    
  <?php if($v['required']){?>required <?php }?> <?=$options_element?> > 
  <?php 
    if($v['value'] && is_array($v['value'])){
    foreach($v['value'] as $kk=>$vv){?>
      <el-radio v-model="form.<?=$field?>" label="<?=$vv['value']?>"><?=$vv['label']?></el-radio>
  <?php }}?>
</el-form-item>