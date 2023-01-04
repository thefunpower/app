<el-form-item label="<?=$label?>"    
    <?php if($v['required']){?>required <?php }?> <?=$options_element?> > 
    <el-color-picker v-model="form.<?=$field?>"></el-color-picker>
</el-form-item>