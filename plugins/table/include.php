<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/ 

/**
 * 
 * 用PHP生成表格
 * 支持搜索、排序、操作（编辑、删除）
 * 其他操作请用$vue对象及html实现 
 * 
 * 表中必须要有 id title status 三个字段，没有这三个字段请不要使用此类。
 * 字段不要用Mysql存在的字段关键字，如varchar date time 等  
 * 
 * misc('vue,element,jquery,node,layui,echarts,pure,wangEditor,sortable');
 *  以下CSS已经定义好
 * .table_select_search{ width: 160px; }
 * .table_input_search{ width: 200px; }
 * .table_input{width: 100%;}
 * .el-dialog__body{padding-top: 0px;}
 * 
 */
class Table{
  /**
   * vue
   */
  public static $vue;
  /**
   * 生成TABLE
   * 
   * sql参数
   * 
   
   'sql'=>[
      'table'=>'table_demo',
      'select'=>'*',
      'where'=> [ 
          'ORDER'=>['id'=>'DESC'],
          'title[~]'=>'$title',
          'tips[~]'=>'$tips',
      ],
   ], 

   * 
   */
  public static function make($arr = [],$call = null){ 
    //用户必须是登录的
    $user_id = logined_user_id();
    if(!$user_id){
      return;
    }
    //记住分页选中的每页数量 
    $per_page_key = $user_id.":table_per_page_".md5($_SERVER['REQUEST_URI']); 
    $per_page = cache($per_page_key)?:20;
    // page_loaded
    $page_loaded = '';
    //批量搜索
    $selection = $arr['selection']; 
    $selection_value = $selection['value']; 
    $selection_field = $selection['field'];  
    //column_call
    $column_call = $arr['column_call'];
    $acl = $arr['acl'];
    //在搜索处添加元素
    $before_search_bar = $arr['before_search_bar'];  
    $after_search_bar = $arr['after_search_bar']; 
    $footer = $arr['footer']; 
    $search_bar = $arr['search_bar']; 
    //全局option
    $html_option = $arr['html_option']; 
    $is_drawer = false;
    if($html_option['form_pop'] == 'drawer'){
        $is_drawer = true;
    } 
    //form_layout
    $form_layout = $arr['form_layout']; 
    //form_tab_layout
    $form_tab_layout = $arr['form_tab_layout'];
    //form_tab
    $form_tab = $arr['form_tab'];
    //表格高度
    $height = $arr['height']; 
    //搜索关联表，不是join sql，是分开来执行的SQL
    $relation = $arr['relation']; 
    //是否使用编辑器
    $use_editor = $arr['use_editor'];
    $form = $arr['form'];
    //搜索
    $filter = $arr['filter'];
    //显示字段
    $column = $arr['column'];
    //操作
    $action = $arr['action'];
    //SQL
    $sql = $arr['sql'];
    //主表
    $table = $sql['table'];
    //SELECT字段，必须
    $select = $sql['select'];
    //条件
    $where = $sql['where']; 
    //显示table TREE
    $tree = $arr['tree']; 
    $tree_pid = $arr['tree_pid'];  
    //列表URL
    $page_url = "/plugins/table/api/admin/table.php"; 
    //编辑URL
    $edit_url = "/plugins/table/api/admin/table_edit.php"; 
    //删除UURL
    $delete_url = "/plugins/table/api/admin/table_del.php";   
    if($tree){
      $page_url = "/plugins/table/api/admin/table_tree.php"; 
    }
    /**
    * 判断是否是店铺
    */
    if($arr['shop_admin']){
      //列表URL
      $page_url = "/plugins/table/api/shopadmin/table.php"; 
      //编辑URL
      $edit_url = "/plugins/table/api/shopadmin/table_edit.php"; 
      //删除UURL
      $delete_url = "/plugins/table/api/shopadmin/table_del.php";   
      if($tree){
        $page_url = "/plugins/table/api/shopadmin/table_tree.php"; 
      }
    } 

    $edit_url = $edit_url."?table=".$table;
    $delete_url = $delete_url."?table=".$table;
    //表单验证
    $validate = [];
    $validate_field = [];
    $validate_rule = [];
    foreach($form as $k=>$v){
        if($v['required']){
            $validate_field[$v['field']] = $v['label'];
            $validate_rule['required'][] = [$v['field']];
        }
        if($v['validate']){
            $validate_field[$v['field']] = $v['label'];
            foreach($v['validate'] as $kk=>$vv){
              $validate_rule[$kk][] = $vv;
            }
        }
    }
    $validate = ['field'=>$validate_field]+$validate_rule;  
    //列表字段格式,一般用于el-元素，如radio
    $_format = [];
    $vue = new Vue;  
    $vue->opt = [ 
        'is_editor'  => true,
        'is_page'  => true,
        'is_reset' => true,
        'is_add'   => true,
        'is_edit'  => true,  
    ];   
    if($action['remove']){
      $vue->edit_url  = $edit_url;      
    } 
    if($action['remove']){
        $vue->method("del(id)","js:{
           ajax('".$delete_url."',{id:id},function(res){
            _this.\$message({
                  message: res.msg,
                  type: res.type
                });
                layer.closeAll();
            _this.load_page();
           });
        }");
    }   
    //操作统一对row赋值
    $vue->method("command(e,row)","js:{ 
         this.row = row;e(); 
    }"); 
    //编辑操作
    $vue->method("edit()","js:{ 
         let row  = JSON.parse(JSON.stringify(this.row));
         this.update(row);
    }"); 
    //删除操作
    $vue->method("remove()","js:{ 
        layer.confirm('删除删除【'+this.row.title+'】？', {
            title:'操作提示',
            btn: ['确认', '取消']  
        }, function(index, layero){
             _this.del(_this.row.id);
        }, function(index){
            
        });
    }"); 
    //编辑时修改form参数
    $save_auto_string = ""; 
    if($validate){
      $save_auto_string .= "this.form._validate = ".json_encode($validate).";\n"; 
    } 
    //查寻时修改where条件
    $where_string = '';
    if($relation){
      $where_string .= "this.where._relation = ".json_encode($relation).";\n"; 
    }
    $vue->data("save_auto_loading",false);
    $vue->method("save_auto()","js:
      ".$save_auto_string."
      this.save_auto_loading = true;
      this.form._relation = this.where._relation;
      ajax('".$edit_url."',this.form,function(res){
          _this.\$message({type:res.type,message:res.msg});
          if(res.code == 0){
            _this.is_show = false;
            _this.load_page();
          }
          _this.save_auto_loading = false;
      });
    "); 
    //排序相关
    $vue->data("orderby_field","js:{}");
    $vue->data("is_new_orderby",false); 
    $vue->method("sortChange(r)","js: 
      let sort = 'DESC';
      if(r.order == 'ascending'){
        sort = 'ASC';
      } 
      this.orderby_field[r.prop] = sort; 
      this.is_new_orderby  = true;
      this.load_page(); 
    "); 
    /**
     * 处理各种字段  
    */
    $address_cascader = false;
    $editor = [];
    $upload_before = [];
    $upload_success = [];
    $upload_remove = [];
    $autocomplete = []; 
    $form_data_var = '';
    $default_val = [];
    foreach($form as $k=>$v){
      $field = $v['field'];
      $default = $v['default'];
      if($default){
        $default_val[$field] = $default;
      }
      $element = $v['element'];
      $element_field = $v['element_field'];
      if(strpos($element,'.') !== FALSE){
          $arr = explode('.',$element);
          $vue->data_form($arr[0],'js:{}'); 
      }
      if(strpos($element_field,'.') !== FALSE){
          $arr = explode('.',$element_field);
          $vue->data_form($arr[0],'js:{}'); 
      }
      //处理编辑器字段
      if($element == 'editor' && $field){
          $editor[$field] = $vue->editor($field);
          //启用编辑器
          $use_editor = true;
      }else if($element == 'upload'){
          //处理上传字段
          $upload_success[$field] = [
              'field'=>$field,
              'method'=>"upload_success_".$field,
              'multiple'=>$v['multiple'],
              'mime'=>$v['mime'], 
          ];
          $upload_before[$field] = [
              'field'=>$field,
              'method'=>"upload_before_".$field,
              'multiple'=>$v['multiple'],
              'mime'=>$v['mime'],
              'size'=>$v['size'],
          ];
          $upload_remove[$field] = [
              'field'=>$field,
              'method'=>"upload_remove_".$field,
              'multiple'=>$v['multiple'],
              'mime'=>$v['mime'],
          ];
      }else if($element == 'radio'){
          //radio字段返回的值必须是string类型，如果是int没办法选中
          $_format[$field] = 'string';
      }else if($element == 'checkbox'){  
          $vue->data_form($field,'js:[]');
      }else if($element == 'address'){  
          $address_cascader = true;
      }else if($element == 'autocomplete'){  
          $autocomplete[$field] = $v; 
      } 
    } 
    //处理autocomplete
    if($autocomplete){
        foreach($autocomplete as $k=>$v){
            $vue->method("autocomplete_suggestions".$k."(queryString, cb)","js: 
              let query = ".json_encode($v['sql']).";
              query.queryString = queryString; 
              ajax('/plugins/table/api/admin/form.autocomplete.php',query,function(res){
                  cb(res);
              });
            ");
            $vue->method("autocomplete_select".$k."(item)","js: 
                this.form.".$k." = item.id;
                this.form.".$v['element_field']." = item.value; 
                this.\$forceUpdate();
            ");
        } 
    } 
    /**
     * 上传处理开始
     * 生成上传文件需要的vue方法
     */
    //上传显示loading效果
    $vue->data("full_loading",false);
    if($upload_before){
        foreach($upload_before as $k=>$v){
            $upload_size = $v['size']?:5;
            $vue->method($v['method']."(file)","js:
                const isMaxSize = file.size / 1024 / 1024 < ".$upload_size.";
                if (!isMaxSize) {
                    this.\$message.error('上传图片大小不能超过 ".$upload_size."MB!');
                    return false
                }
                this.full_loading = this.\$loading({
                  lock: true,
                  text: '上传文件中',
                  spinner: 'el-icon-loading',
                  background: 'rgba(0, 0, 0, 0.7)'
                });
                return true;
            ");
        }
    }
    if($upload_success){
        foreach($upload_success as $k=>$v){
          $field = $v['field'];
          $multiple = $v['multiple'];
          $string = '';
          if($multiple){
              $string = "_this.form.".$field.".push(res.data);"; 
          }else{
              $string = "_this.form.".$field." = res.data;"; 
          }
          $vue->method($v['method']."(res,f,files)","js:
              _this.full_loading.close();
              if(!_this.form.".$field."){
                _this.form.".$field."   = []; 
              }  
              ".$string."      
              _this.\$forceUpdate();   
          ");
        }
    }
    if($upload_remove){
        foreach($upload_remove as $k=>$v){
            $field = $v['field'];
            $multiple = $v['multiple'];
            $string = '';
            if($multiple){
                $string = "_this.form.".$field.".splice(k,1);"; 
            }else{
                $string = "_this.form.".$field." = '';"; 
            }
            $vue->method($v['method']."(k)","js: 
                ".$string." 
                _this.\$forceUpdate();   
            ");
        }
    }
    //上传处理结束     
    //不使用load()加载数据
    $vue->load_name = "load_page";
    $where_json = json_encode($where?:[]);
    $where_string .= "
      this.where.table='$table';
      this.where.select='$select';
      this.where.where=$where_json;
    "; 
    if($filter){
      foreach($filter as $v){
        if(strpos($v['field'],'.')!==false){
          $arr = explode('.',$v['field']);
          $where_string.=" 
          if(!this.where.".$arr[0]."){
            this.\$set(this.where,'".$arr[0]."',{});  
          }          
          \n";
        }
      }
    }  
    $vue->data('where',"js:{per_page:".$per_page."}");  
    $vue->data('per_page',$per_page);  
    $vue->watch("where:","js:
        {
          handler(newValue, oldValue) { 
            console.log(_this.where.per_page)
            console.log(newValue.per_page)
            if(_this.per_page != newValue.per_page){ 
                ajax('/plugins/table/api/admin/per_page.php',{
                  key:'".$per_page_key."',
                  val: newValue.per_page
                },function(res){}); 
                _this.per_page = newValue.per_page; 
            } 
          },
          deep: true
        }
    ");
    if($tree){
      if(!$tree_pid){
        $tree_pid = 'pid';
      }
      $vue->data("table_tree_options","js:[]"); 
      $page_loaded.="
      let dd = JSON.parse(JSON.stringify(res.data));
      dd.unshift({title:'无父级',id:0});
      _this.table_tree_options".$tree_pid." = dd;\n"; 
    }
    if($column_call){ 
      $where_string.=" this.where._column_call = '".$column_call."';";
    }
    if($acl){ 
      $where_string.=" this.where._acl = '".aes_encode($acl.":".time())."';";
    }
    $vue->method("load_page()","js:
      ".$where_string." 
      if(this.is_new_orderby){
        this.where.where.ORDER = this.orderby_field;
      }  
      this.loading = true;
      this.where._format = ".json_encode($_format)."; 
      ajax('".$page_url."',this.where,function(res){
          _this.page   = res.current_page;
          _this.total  = res.total;
          _this.lists  = res.data;
          ".$page_loaded."
          _this.res  = res;
          if(_this.loading){ 
             _this.loading = false; 
          }
      });
    "); 

    $vue->data("height","");
    $vue->created(["init()"]);
    $init_string = '';
    //innerWidth
    $vue->data("innerWidth","");
    $init_string .= " 
        this.innerWidth = window.innerWidth;
        window.onresize = () => {
          return (() => {  
            _this.innerWidth = window.innerWidth;
          })();
        };
    ";
    if($height){ 
        $init_string .= "
            this.height = window.innerHeight - ".$height.";
            this.innerWidth = window.innerWidth;
            window.onresize = () => {
              return (() => { 
                _this.height = window.innerHeight - ".$height."; 
                _this.innerWidth = window.innerWidth;
              })();
            };
        ";
    }
    $actived_plugin = has_actived_plugin();
    //处理地址字段，依赖user_address插件
    if($address_cascader){ 
      if(!$actived_plugin['user_address']){
        exit('插件user_address必须，请先启用该插件');
      }
      $vue->data("address_cascader","js:[]"); 
      $vue->method("_address_cascader()", "js:    
          if(_this.address_cascader && Object.keys(_this.address_cascader).length > 0){
              console.log('无需加载address');
          }else{
            ajax('/plugins/user_address/api/v1/city.php',{type:'element-ui'},function(res){
               _this.address_cascader = res.data;
               //loading.close();
            });
          } 
      ");; 
    }  
    $vue->method("init()","js: ".$init_string."");
    //处理FORM TAB
    $vue->data("activeTab",'mytab0');
    $default_val_vue = '';
    if($default_val){
        foreach($default_val as $k=>$v){
          $default_val_vue.="if(!this.form.id) {this.\$set(this.form,'".$k."','".$v."');}";
        }
    }
    $vue->method("closedDialog()","js:
      this.activeTab = 'mytab0'; 
    ");
    $vue->method("focus(event)","js:
      event.currentTarget.select();
    ");
    //执行外部调用vue
    if($call){
      $call($vue);
    }
    //不管用不用日期，把参数先初始化下
    $vue->addDateTimeSelect();
    //打开PDF文件
    $vue->data("pdf_url","");
    $vue->method("open_pdf(file)","js: 
       this.pdf_url = file; 
       setTimeout(function(){
        $('.table_pdf_class').show();
      },800);
    ");
    $vue->method("get_ext(file)","js:
      return get_ext(file);
    ");
    if($selection){
      $vue->data("selection","js:{}");
      $vue->data("selection_value","js:".json_encode($selection_value));
      $vue->method("do_selection()","js:
          this.loading = true;
          let v    = this.multipleSelection;
          let ids  = [];
          let flag = 0;
          for(i in v){
             if(v[i].id){
              flag = 1;
             }
             ids.push(v[i].id);
          }
          if(flag == 0){
            layer.msg('请先选择');
            return false;
          } 
          ajax('".$edit_url."', {
            id:ids,
            table:'".$table."',
            update:{".$selection_field.":this.selection.".$selection_field."}
          }, function(res) {
            _this.\$message({
              message:res.msg,
              type:res.type,
            });
           _this.load_page();
         }); 
      ");
      $vue->data("multipleSelection", "js:{}");
      $vue->method("handleSelectionChange(val)", "js:{
            this.multipleSelection = val;
      }");
      $vue->data("selectiont_len", "js:0");
      $vue->watch("multipleSelection(val)", "js:{
        this.selectiont_len = val.length;
      }");
    } 
    $vue->method("reset_page()","js:
      this.where = {
        per_page: this.per_page
      };
      this.load_page();
    "); 
    $opt = ['data'=>$arr,'vue'=>$vue];
    do_action("table.vue",$opt);
    self::$vue = $opt['vue'];
    block_clean(); 
   ?>
   <?= $before_search_bar?>
   <div class="flex table_flex"> 
      <?php if($action['edit']){?>
        <el-button type="primary" plain   @click="show()">添加</el-button> 
      <?php }?>
      <div class='table_plugin_pdf_pop' v-if="pdf_url">
        <span @click="pdf_url=''" style="display:none;" class="table_pdf_class close link hand">关闭预览</span>
        <iframe ref="iframe" class="table_pdf_class iframe" v-if="pdf_url" 
        :src="pdf_url" ></iframe>
      </div> 
      <?php if($filter){?>
        <?php 
        foreach ($filter as $v) {
        $label = $v['label'];
        $key = $v['field'];
        $element = $v['element'];
        $placeholder = $v['placeholder'];
        ?>
          <?php if($element == 'input'){?>
          <el-input class="table_input_search"  v-model="where.<?=$key?>"  @keyup.enter.native="reload"  placeholder="<?=$placeholder?>"> </el-input>
          <?php }?>

          <?php if($element == 'select'){
              if($v['value'] && is_array($v['value'])){ 
              ?>
              <el-select class="table_select_search" v-model="where.<?=$key?>" 
               @change="reload"  placeholder="请选择<?=$v['label']?>">
                <?php foreach($v['value'] as $kk=>$vv){?>
                  <el-option label="<?=$vv['label']?>" value="<?=$vv['value']?>"> </el-option>
                <?php }?>
              </el-select>
              <?php }?>
          <?php }?>

        <?php }?>
        <el-button @click="reload()" :disabled="loading?true:false" type="primary" plain >搜索</el-button>
        <?= $search_bar?>
        <el-button @click="reset_page()"  :disabled="loading?true:false" type="success" plain >重置</el-button>
      <?php }?>      
    </div>  
    
    <?php if($selection){?>
    <div class="mt10" v-if="selectiont_len > 0">
        批量操作：
        <el-select 
          v-model="selection.<?=$selection_field?>" 
          placeholder="操作"  > 
            <el-option  v-for="(v,k) in selection_value" :key="k" :label="v.label" :value="v.value"> 
          </el-option>
        </el-select>
        <el-button type="primary" @click="do_selection"  :disabled="loading?true:false">确认</el-button>
    </div> 
    <?php }?>
    
    <?= $after_search_bar?>
        <el-table 
        <?php if($tree){?> 
          :default-expand-all="true"  
          row-key="title" 
          :tree-props="{children: 'children', hasChildren: 'hasChildren'}"
        <?php }?> 
          <?php if($selection){?> 
            @selection-change="handleSelectionChange" 
          <?php }?> 
          <?php if($height){?> 
            :height="height"
          <?php }?>
            v-loading="loading" border @sort-change="sortChange"
            :data="lists"
            style="width: 100%;margin-top: 10px;"> 
            <?php if($selection){?>
              <el-table-column type="selection" width="50">
              </el-table-column>
            <?php }?>
            <el-table-column type="index" label="序号" :index="indexMethod" width="60"></el-table-column>
            <?php foreach($column as $v){?>
            <el-table-column 
            <?php if(strpos($v['field'],'.') === false){ 
              ?>
              prop="<?=$v['field']?>"
            <?php }?>
              label="<?=$v['label']?>"
              <?php if($v['sortable']){?>
                sortable="custom" 
              <?php }?>
              <?php if($v['width']){?>
                  width="<?=$v['width']?>"
              <?php }?>
              width="">
              <?php if(strpos($v['field'],'.') !== false){
              $field_arr = explode('.', $v['field']) ;
              $field_1 = $field_arr[0];
              $field_2 = $field_arr[1];
              ?>
              <template slot-scope="scope" > 
                  <div v-if="scope.row.<?=$field_1?>"> 
                    {{scope.row.<?=$v['field']?>}}
                  </div>
              </template>
              <?php }?>

              <?php 
              /*scope.row*/
              if($v['template']){?>
                <template slot-scope="scope" > 
                     <?=$v['template']?>
                </template>
              <?php }?>

            </el-table-column>  
            <?php }?>
            <?php if($action){?>
            <el-table-column 
              prop="comment"
              label="操作"
              width="108">
              <template slot-scope="scope">  
                <el-dropdown @command="command($event,scope.row)">
                  <span class="el-dropdown-link">
                    选择操作<i class="el-icon-arrow-down el-icon--right"></i>
                  </span>
                  <el-dropdown-menu slot="dropdown">   
                    <?php foreach($action as $k=>$v){
                      if(!is_array($v)){
                      ?>
                      <el-dropdown-item :command="<?=$k?>"><?=$v?></el-dropdown-item>  
                    <?php }else{
                      $_action_label = $v['label'];
                      $_action_click = $v['click'];
                      unset($v['label'],$v['click']);
                      if($_action_click){$k=$_action_click;}
                      ?>
                       <el-dropdown-item 
                       <?php foreach($v as $kk=>$vv){?><?=$kk?>="<?=$vv?>"<?php }?>
                       :command="<?=$k?>"><?=$_action_label?></el-dropdown-item>  
                    <?php }?>
                    <?php }?>
                  </el-dropdown-menu>
                </el-dropdown>  
              </template>  
            </el-table-column>
            <?php }?>  
          </el-table>   
          <p style="margin-top: 10px;"> 
              <el-pagination background     
                @size-change="page_size_change"
                @current-change="page_change"
                :current-page="page" 
                :page-sizes="<?= json_encode(page_size_array()) ?>"   
                :page-size="where.per_page"
                layout="total, sizes, prev, pager, next, jumper"
                :total="total">
              </el-pagination> 
          </p>  
          <?php if($form){?>  
                  <?php  
                  foreach($form as $v){
                    $label = $v['label'];
                    $element = $v['element'];
                    $field = $v['field'];
                    block_start($field);
                    //元素options
                    $vue_options = $v['vue_options']; 
                    $options_element = '';
                    if($vue_options){
                      $options_element = implode(' "', $vue_options);
                    }
                  ?> 
                    <?php if($field && $element ){ 
                      $element_file = __DIR__.'/inc/'.$element.'.php';
                      if(file_exists($element_file)){
                        include $element_file;
                      }
                    ?>  
                    <?php block_end(); }?> 
                  <?php }?> 
                  
              <?php 
              $blocks = $compareBlocks = get_block();  
              ?>  
              <?php 
              //处理form_tab  
              if($form_tab){ 
                block_start('__tabs');
                foreach($form_tab as $k=>$v){
                  foreach($v as $vv){
                      unset($compareBlocks[$vv]);
                  }
                }
                foreach($form_tab as $k=>$v){
                  if($first){break;}
                  $first = $k;
                } 
                foreach($compareBlocks as $k=>$v){ 
                    //如果表单字段未配置到对应的TAB但又启用了TAB功能，没配置的字段统一添加到第一个TAB里面
                    $form_tab[$first][] = $k; 
                }

              ?>
              <el-tabs type="border-card"  v-model="activeTab" > 
                  <?php 
                  $i = 0; 
                  $form_tab_rebuild = [];
                  foreach($form_tab as $k=>$v){
                    $form_tab_rebuild[$k][0]['span'] = 24;
                    $form_tab_rebuild[$k][0]['field'] = $v;
                  }
                  $form_tab_diff = [];
                  if($form_tab_layout){
                    foreach($form_tab_layout as $k=>$v){
                        $form_tab_rebuild[$k] = $v;
                        foreach($v as $vv){
                          if(!$form_tab_diff[$k]){
                              $form_tab_diff[$k] = array_diff($form_tab[$k],$vv['field']);  
                          }else{
                            $form_tab_diff[$k] = array_diff($form_tab_diff[$k],$vv['field']);  
                          }
                          
                        } 
                    }
                  }
                  if($form_tab_diff){
                    foreach($form_tab_diff as $k=>$v){
                        $form_tab_rebuild[$k][0]['field'] = array_merge($form_tab_rebuild[$k][0]['field'],$v);
                    }
                  }  
                  foreach($form_tab_rebuild as $k=>$vv){  
                    ?>
                    <el-tab-pane label="<?=$k?>" name="mytab<?=$i?>">
                      <el-form label-position="left" label-width="180px"> 
                        <el-row>
                          <?php 
                          $form_layout_i = 0;
                          foreach($vv as $v){?>
                             <el-col :span="<?=$v['span']?>" <?php if($form_layout_i>0){?>style="padding-left: 20px;" <?php }?>>
                                <?php foreach($v['field'] as $vv2){
                                    echo $blocks[$vv2]; 
                                }?>
                            </el-col>
                          <?php $form_layout_i++;}?>
                        </el-row> 
                      </el-form>
                    </el-tab-pane> 
                  <?php $i++;}?> 
              </el-tabs>
            <?php block_end();}?>
            <?php 
            $form_dialog_opened = '';
            if($address_cascader){
              $form_dialog_opened = 'this._address_cascader();';
              $vue->editor_timeout = 1000;
            }
            if($use_editor){
              $form_dialog_opened.="this.weditor();";
            }
            if($default_val_vue){
              $form_dialog_opened .=$default_val_vue;
            }
            if($form_dialog_opened){
              $vue->method("form_dialog_opened()","js:
                 ".$form_dialog_opened."
              ");
            }
            ?> 
            <?php if($is_drawer){?>
            <el-drawer :title="form.id > 0?form.title:'添加'"   
              custom-class="table_drawer"
              :visible.sync="is_show"
              direction="rtl"  
              @closed="closedDialog"
              <?php if($form_dialog_opened){?>
                @opened="form_dialog_opened"
              <?php }?>
              :close-on-click-modal="false"  
              :close-on-press-escape="true"
              > 
            <?php }else{?>
            <el-dialog  
              :top="innerWidth>640?'20px':'0px'" 
              @closed="closedDialog"
              <?php if($form_dialog_opened){?>
                @opened="form_dialog_opened"
              <?php }?>
              :title="form.id > 0?form.title:'添加'"  
              :visible.sync="is_show" 
              :close-on-click-modal="false" 
              :show-close="true"
              :close-on-press-escape="true" 
              <?php  
              if($html_option['edit_dialog_fullscreen']){?>
                fullscreen="true"
              <?php }elseif($html_option['edit_dialog_width']){ 
              ?>
                :width="innerWidth<=640?'100%':'<?=$html_option['edit_dialog_width']?>'"
              <?php }else{?>
                :width="innerWidth<=640?'100%':'80%'" 
              <?php }?> 
              >  
            <?php }?>
                <?php 
                 if($form_tab){ 
                   echo get_block('__tabs'); 
                   include __DIR__.'/inc/save_btn.php';
                 }else {
                ?>

             <el-form label-position="left" label-width="180px">
                 <?php 
                  //处理form_layout 
                  if($form_layout){
                  ?>
                  <el-row>
                    <?php 
                    $form_layout_i = 0;
                    foreach($form_layout as $vv){
                      if(!$vv['span'] || !$vv['field']){
                        exit('form_layout配置错误');
                      }
                      ?>
                      <el-col :span="<?=$vv['span']?>" 
                        <?php if($form_layout_i>0){?>
                          style="padding-left: 20px;" 
                        <?php }?>> 
                          <?php foreach($vv['field'] as $vv2){
                              echo $blocks[$vv2];
                              unset($blocks[$vv2]);
                          }?>
                      </el-col>
                    <?php $form_layout_i++;}?>
                  </el-row>
                  <?php 
                      foreach($blocks as $block){
                        echo $block;
                      }
                  ?> 
                  <?php }else{?> 
                      <?php 
                          foreach($blocks as $block){
                            echo $block;
                          }
                      ?> 
                  <?php }?>
                  <?php include __DIR__.'/inc/save_btn.php';?> 
                <?php 
                 } 
               ?>   
            <?php if($is_drawer){?>
              </el-drawer>
            <?php }else{?>
              </el-dialog>
            <?php }?>
          <?php } ?>

          <?php do_action("table.html",$opt);?>
          <?= $footer?>
      <?php    
  } 


  public static function js(){
      $vue = self::$vue;
      ?>
      <script> 
        var E = window.wangEditor;  
        var editor;
          Vue.component('vuedraggable', window.vuedraggable);
      </script>
      <script type="text/javascript">
        <?= $vue->run()?>
      </script>

      <?php 
  }
}
/**
 * 通过配置生成表格
 */
function table_maker($table_config,$call){
    Table::make($table_config,$call);
}




/**
 * 接口显示列表
 */
function table_builder_list($input,$ret_array = false){
  //检查签名
  //signature_checker(); 
  $column_call = $input['_column_call'];
  $_format = $input['_format'];
  $table  = $input['table']; 
  $select = $input['select']?:"*";
  $where  = $input['where']?:[]; 
  $relation = $input['_relation'];   
  //每页显示
  $_REQUEST['per_page'] = $input['pre_page'];
  //处理关联字段 
  $relation_where = []; 
  foreach ($relation as $relation_table=>$v) { 
      $arr = $input[$relation_table];
      if($arr){
          $relation_where['LIMIT'] = 500;
          foreach ($arr as $kk => $vv) {
             $relation_where[$kk."[~]"] = $vv;
          }  
          $in = db_get($v[0],'id',$relation_where); 
          if(!$in){
            $in = [-1];
          }
          $where[$v[1]] = $in;
      }
  }
  //排序 
  $ORDER_FIELD = $where['ORDER_FIELD'];
  $ORDER_VALUE = $where['ORDER_VALUE'];
  unset($where['ORDER_FIELD'],$where['ORDER_VALUE']);
  if($ORDER_FIELD && $ORDER_VALUE){
    unset($where['ORDER']); 
    $where['ORDER'][$ORDER_FIELD] = $ORDER_VALUE;    
  }
  $where_key = ['ORDER','GROUP','OR','AND','MATCH','HAVING']; 
  $new_where = [];
  foreach($where as $k=>$v){
    $k = str_replace("(","[",$k);
    $k = str_replace(")","]",$k);
    $new_where[$k] = $v;
  }
  $where = $new_where;
  foreach($where as $k=>$v){ 
      if(is_string($k) && (strpos($k,'AND') !== FALSE || strpos($k,'AND') !== FALSE)){
        $where_new[$k] = $v;
        continue;
      }
      if(!in_array($k, $where_key)){  
        if(is_string($v)){ 
          $a = substr($v,0,1);
          $field = substr($v,1);
          if($a == '$' && $input[$field]){
              $where[$k] = $input[$field];
          }else{
            unset($where[$k]);
          }
        }
      }  
  }   
  if(!$table){
    json_error([]);
  }   
  //店铺
  global $shop_admin_active;
  if($shop_admin_active){
    $where['shop_id'] = get_shop_admin_id();
  }
  //分页
  $all = db_pager($table,$select,$where); 
  $static_row = []; 
  foreach($all['data'] as &$v){
      if($column_call){
        $v = $column_call($v['id']);
        continue;
      }
      //处理关联
      if($relation){
        foreach($relation as $kk=>$vv){
            $a = $vv[0]; //关联表 表名 
            $b = $vv[1]; //主表字段,当get=all时就是关联表的字段
            $met = $vv['get']?:'one'; 
            $static_key = $a.$b.$v['id'];
            if($a && $b){ 
              $pk = $vv['pk']?:'id';
              if($met == 'one'){
                  if($v[$b]){ 
                      if($static_row[$static_key]){
                          $v[$kk] = $static_row[$static_key];
                      }else{ 
                          $v[$kk] = db_get_one($a,'*',[$pk=>$v[$b]]);  
                          $static_row[$static_key] = $v[$kk];
                      }  
                  }
              }else if($met == 'all'){
                if($static_row[$static_key]){
                    $v[$kk] = $static_row[$static_key];
                }else{  
                  $v[$kk] = db_get($a,'*',[$b=>$v[$pk]]); 
                  $static_row[$static_key] = $v[$kk];
                }
              } 
              if(!$v[$kk]){
                  $v[$kk] = [];
              } 
            }
        }
      } 
      //处理json
      foreach ($v as $kk=>$vv) {
        if($_format && $_format[$kk]){
            if($_format[$kk] == 'string'){
              $v[$kk] = (string)$vv;
            }
        }
      }
  }
  $all['where'] = $where;
  if($ret_array){
    return $all;
  }
  json($all); 
}
/**
 * 保存数据
 */
function table_builder_edit($input){
  if($input['id'] > 0){
     $input['updated_at'] = now();
  }else{
    $input['created_at'] = now();
    $input['updated_at'] = now();
  }
  
  
  $relation = $input['_relation'];
  $table  = g('table');
  $id = $input['id']; 
  if(!$table){
    json_error(['msg'=>'参数异常']);
  } 
  /**
   * 批量更新 
   */
  if(is_array($id)){
    $update = $input['update'];
    foreach($update as $k=>$v){
      if(!$v){
        unset($update[$k]);
      }
    }
    if($update){
      db_update($table,$update,['id'=>$id]);
      json_success(['msg'=>'更新成功']);
    }else{
      json_success(['msg'=>'操作异常']);
    }
  }
  /**
   * 正常更新某表字段值
   */
  $table_fields = get_table_field_json($table);
  $one  = [];
  if($id){
    $one = db_get_one($table,'*',['id'=>$id]);
  }
  foreach($table_fields as $k=>$v){
    if($k){
        if(!$input[$k] && !$one[$k]){
          $input[$k] = [];
        }
    }
  } 
  //表单验证
  $validate = $input['_validate'];
  unset($input['_relation']);
  if($validate){
      $field = $validate['field'];
      unset($validate['field']);
      if($field && $validate ){ 
          if($vali = validate($field,$input,$validate)){
              json($vali);
          } 
      } 
  } 
  //店铺
  global $shop_admin_active;
  if($shop_admin_active){
    $input['shop_id'] = get_shop_admin_id();
  }
  //过滤数据
  $data = db_allow($table,$input); 
  if($id > 0 ){ 
    db_update($table,$data,['id'=>$id]); 
    //保存到关联表
    $input['id'] = $id;
    table_builder_edit_relation($relation,$input);
    json_success(['msg'=>'更新成功']);
  }else{
    $id = db_insert($table,$data);
    //保存到关联表
    $input['id'] = $id;
    table_builder_edit_relation($relation,$input);
    json_success(['msg'=>'添加成功']);
  }

}
/**
* 通过关联设置保存到关联表
*/
function table_builder_edit_relation($relation,$input){
  $save = [];
  $save_nid_field = [];
  foreach($relation as  $v){
    $k = $v[0];
    if($v['form_field']){
      $vv = $v['form_field'];
      if(is_array($v)){
        $save[$k] = $vv;
      }else{
        $save[$k] = [$vv];
      }      
      $save_nid_field[$k] = $v[1];
    }
  } 
  if($save){
      foreach($save as $table=>$field){
          $nid = $input['id'];
          $nid_field =  $save_nid_field[$table];
          foreach($field as $f){
            $data = $input[$f];  
            if(is_array($data)) {
              db_del($table,[$nid_field=>$nid]);
              foreach($data as $vv){
                $vv[$nid_field] = $nid;
                db_insert($table,$vv);
              }
            } 
          }
      }
  }
  
}

/**
 * 删除操作
 */
function table_builder_del($input){
  $table  = g('table');
  $id = $input['id'];
  $where = ['id'=>$id];
  //店铺
  global $shop_admin_active;
  if($shop_admin_active){
    $where['shop_id'] = get_shop_admin_id();
  }
  if($table && $id){
    db_update($table,['status'=>-1],$where);
    json_success(['msg'=>'操作成功']);
  }else{
    json_error(['msg'=>'操作异常']);
  }

}

/**
 * TABLE输出JS
 */
function table_maker_js(){
  Table::js();
}

/**
* 获取table数据 
*/
function get_table_by_slug($slug){
  $res = db_get_one("table",'*',['slug'=>$slug,'status'=>1]);
  return $res;
}
/**
* 店铺ID
*/
function get_shop_admin_id(){
    $shop_admin_id = cookie('shop_admin_id');
    $res = api(false);
    if($res['shop_admin_id']){
      $shop_admin_id = $res['shop_admin_id'];
    }
    return $shop_admin_id;
}
/**
* 判断店铺是否登录 
*/
function shop_admin_is_login()
{
   if(!get_shop_admin_id()){
     json_error(['msg'=>'非店铺信息']);    
   }
   global $shop_admin_active;
   $shop_admin_active = true;
}