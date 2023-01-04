<el-form-item label="<?=$label?>"   
   <?php if($v['required']){?>required <?php }?> <?=$options_element?> >
    <?=$editor[$field];?>
</el-form-item>  