<el-form-item label="<?=$label?>"    
      <?php if($v['required']){?>required <?php }?> <?=$options_element?> > 
  <el-cascader class="table_input"  
      v-model="form.<?=$field?>"  
      :options="address_cascader" ></el-cascader>  
  <el-input class="table_input mt10" v-model="form.<?=$field?>_detail"  placeholder="详细地址"  <?php if($v['focus']){?>
       @focus="focus($event)" 
  <?php }?> ></el-input> 
</el-form-item>