<el-form-item label="<?=$label?>"    
    <?php if($v['required']){?>required <?php }?> <?=$options_element?> >
    <el-upload  
          action="/api/admin/upload.php"
          :before-upload="<?=$upload_before[$field]['method']?>"  
           accept="<?= lib\Mime::get($upload_success[$field]['mime'])?>"  
          :on-success="<?=$upload_success[$field]['method']?>" 
          :show-file-list="false"
          <?php if($v['multiple']){?> multiple <?php }?>
          >
          <span class="link hand">上传</span> 
    </el-upload>
    <div style="display: flex;"> 
      <?php if($v['sortable'] && $v['multiple']){?>
      <draggable  
        v-if="form.<?=$field?>" style="display: flex;flex-wrap: wrap;" 
        v-model="form.<?=$field?>" 
        @start="drag=true" @end="drag=false"> 
      <?php }?>
        <?php if($v['multiple']){
            //多文件显示
          ?>
          <div style="margin-right:5px;position: relative;" 
              v-for="(v,k) in form.<?=$field?>">
             <div style="position: relative;">
              <?php if($v['show_type'] == 'image'){?>
                  <img  :src="v"  style="width:90px;height: 90px;">
                  <span @click="<?=$upload_remove[$field]['method']?>(k)" 
                class="remove_link hand" style="position:absolute;top:0;right: 0;">删除</span>
              <?php }else{?> 
                {{v}}  
                <span @click="<?=$upload_remove[$field]['method']?>(k)" 
                class="remove_link hand">删除</span>
              <?php }?>
            </div> 
          </div>
        <?php }else{
            //单个文件显示
          ?>
            <div style="position: relative;" v-if="form.<?=$field?>">
              <?php if($v['show_type'] == 'image'){?>
                  <img  :src="form.<?=$field?>"  style="width:90px;height: 90px;">
                  <span @click="<?=$upload_remove[$field]['method']?>(0)" 
                    class="remove_link hand" style="position:absolute;top:0;right: 0;">删除</span>
                  <?php }else{?> 
                    <span class="link hand" v-if="get_ext(form.<?=$field?>) == 'pdf'" @click="open_pdf(form.<?=$field?>)">
                      {{form.<?=$field?>}}  
                    </span>
                    <span v-else>{{form.<?=$field?>}} </span>
                    

                    <span @click="<?=$upload_remove[$field]['method']?>(0)" 
                    class="remove_link hand">删除</span>
                  <?php }?>
            </div> 
        <?php }?>
      <?php if($v['sortable'] && $v['multiple']){?>
        </draggable>
      <?php }?>
    </div>  
</el-form-item>