<?php 
//form.<?=$field
$markdown_ele = "markdown_ele_".mt_rand(1,99999);
?>
<el-form-item label="<?=$label?>"   
  <?php if($v['required']){?>required <?php }?> <?=$options_element?> >
  <textarea id="<?=$markdown_ele?>"></textarea>
  <vue-markdown>{{form.<?=$field?>}}</vue-markdown>
</el-form-item> 
 