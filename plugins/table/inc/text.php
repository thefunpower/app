<el-form-item label="<?=$label?>"    
      <?php if($v['required']){?>required <?php }?> <?=$options_element?> > 
    <el-input class="table_input"  
      <?php if($v['focus']){?>
        @focus="focus($event)" 
      <?php }?>    
      v-model="form.<?=$field?>" 
      type="textarea"    style="width: 100%;"
      <?php if($v['rows']){?> :rows="<?=$v['rows']?>" <?php }?>    
    ></el-input>
</el-form-item>