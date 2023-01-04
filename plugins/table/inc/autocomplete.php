<el-form-item label="<?=$label?>"    
      <?php if($v['required']){?>required <?php }?> <?=$options_element?> > 
    <el-autocomplete class="table_input"  
      <?php if($v['focus']){?>
        @focus="focus($event)" 
      <?php }?>    
      v-model="form.<?=$v['element_field']?>"
      :fetch-suggestions="autocomplete_suggestions<?=$field?>"
      placeholder="<?=$v['placeholder']?>"
      @select="autocomplete_select<?=$field?>($event)"
    ></el-autocomplete>
</el-form-item>