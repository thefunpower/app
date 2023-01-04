<el-form-item label="<?=$label?>"    
  <?php if($v['required']){?>required <?php }?> <?=$options_element?> >  
  <el-input 
    <?php if($v['focus']){?>
      @focus="focus($event)" 
    <?php }?>   
     class="table_input" type="number" v-model="form.<?=$field?>" 
    <?php if($v['min'] && is_numeric($v['min'])){?>
      :min="<?=$v['min']?>" 
    <?php }?>
    <?php if($v['max'] && is_numeric($v['max'])){?>
      :max="<?=$v['max']?>" 
    <?php }?> 
    label="<?=$label?>"> 
    </el-input-number> 
</el-form-item>