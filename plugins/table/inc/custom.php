<el-form-item label="<?=$label?>"    
    <?php if($v['required']){?>required <?php }?> <?=$options_element?> > 
    <?php 
      $callable = $v['callable'];
      if($callable){
          if(is_callable($callable)){
            $callable();  
          }else{
            echo $callable;
          } 
      } 
    ?> 
</el-form-item>