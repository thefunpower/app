<el-form-item label="<?=$label?>"   
  <?php if($v['required']){?>required <?php }?> <?=$options_element?> >
  <el-input 
  <?php if($v['focus']){?>
    @focus="focus($event)" 
  <?php }?> 
  class="table_input" v-model="form.<?=$field?>"></el-input>
</el-form-item> 