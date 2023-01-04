<el-form-item label="<?=$label?>"    
  <?php if($v['required']){?>required <?php }?> <?=$options_element?> > 
  <el-select class="table_input" 
  <?php if($v['filterable']){?> filterable <?php }?> 
  <?php if($v['multiple']){?> multiple <?php }?>  
  v-model="form.<?=$field?>" placeholder="请选择">
    <?php 
    if($v['value'] && is_array($v['value'])){
    foreach($v['value'] as $kk=>$vv){?>
      <el-option label="<?=$vv['label']?>" value="<?=$vv['value']?>"></el-option>
    <?php }}?>
  </el-select>
</el-form-item>