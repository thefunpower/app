<?php  
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__.'/../../boot/app.php'; 
admin_header();
access("yy.table_status_process.admin"); 
?>  
<div id="app" style="margin: 20px;">

<?php  
$table_config = [
  //HTML属性
  "html_option"=>[
      //表单弹出方式 drawer或dialog，默认dialog . drawer方式测试中
      //'form_pop'=>'drawer',  
     'edit_dialog_width'=>'400px', 
  ],
   
  //表格高度,innerHeight-{height}
  'height'=>'220',
  //字段显示
  'column'=>[ 
       ['field'=>'title','label'=>'审核名称'], 
       ['field'=>'name','label'=>'数据表'],  
  ], 
  /**
   * 关联定义
   * 第一个shop参数是查寻出来后赋值给谁，也是field可以使用shop.title的原因
   * value中第一个参数是表名，表中id为主键；第二个参数是主表中关联字段
   */
  'relation'=>[
     // 'shop'=>['table_demo_shop','shop_id']
  ],
  //查寻SQL，对应搜索功能字段
  'sql'=>[
    'table'=>'table_status_process_set',
    'select'=>'*',
    //where查寻遵循db类，仅把value值以 $字段 形式，以便请求替换成真实的数据
    //唯一区别[]改为(),因为请求时[]被理解为数组
    'where'=> [ 
        'ORDER'=>['id'=>'DESC'],
        'title(~)'=>'$title', 
    ],
  ], 
  //搜索功能,要与sql中的where一一匹配
  'filter'=>[ 
      [
        'label'=>'名称', 
        'field'=>'title',
        //字段类型
        'element'=>'input', 
        'placeholder'=>'输入审核名称搜索',  
      ],  
  ],
  //操作
  'action'=>[ 
      'set'=>'配置',  
  ], 
  //表单验证规则 
  'validate'=>[
    
  ],
  //表单设置
  'form'=>[

  ],

];
?> 
<?php 
//通过配置生成表格
table_maker($table_config,function(&$vue){ 
  $all = db_get("user",'*',['tag'=>'admin','status'=>1]);
  $user = [];
  foreach($all as $v){
    $user[] = [
      'label'=>$v['user'],
      'value'=>$v['id'],
    ];
  }
  $vue->data("users","js:".json_encode($user));
  $vue->data("max",0);
  $vue->data("show_set",false);
  $vue->method("set()","js:
    ajax('/plugins/table_status_process/api/admin/get.php',{
      nid:this.row.id, 
    },function(res){
      _this.app_lists = res.arr;
      _this.form_app = res.data;
    });

    this.show_set = true;
  "); 
  $vue->data("form_app","js:
  {
      title: [],
      user_id: []
  }");
  $vue->data("app_lists","js:[0,1]"); 
  $vue->method("add_app_lists(i)","js:
    i = ++i;
    this.app_lists.push(i);
    console.log(this.app_lists)
    this.get_app_lists();
  ");

  $vue->method("get_app_lists()","js:
    for (let i in this.app_lists) {
        let data = this.app_lists[i];
        if (parseInt(data) > 0) {
            this.max_product = data;
        } else {
            this.max_product = 0;
        }
    }
  ");
  $vue->method("del_app_lists(j)","js: 
      if (this.app_lists.length == 1) {
          return false;
      }
      for (let i in this.app_lists) {
          let data = this.app_lists[i];
          if (j == data) {
              this.app_lists.splice(i, 1);
              this.app_lists.name[i] = '';
              this.app_lists.user_id[i] = '';
          }
      }
      this.get_app_lists(); 
  "); 
  $vue->data("disabled",false);
  $vue->method("save_set()","js:
      this.disabled = true;
      ajax('/plugins/table_status_process/api/admin/save.php',{
        nid:this.row.id,
        data:this.form_app
      },function(res){
        _this.disabled = false;
        _this.show_set = false;
        ".vue_message()."
      });
  ");
  $vue->method("end(e)","js: 
    let oldIndex = e.oldIndex;
    let newIndex = e.newIndex;  
    const a_title = this.form_app['title'][oldIndex];
    const a_user_id = this.form_app['user_id'][oldIndex];
    const b_title = this.form_app['title'][newIndex];  
    const b_user_id = this.form_app['user_id'][newIndex];  
    this.form_app['title'][oldIndex] = b_title;
    this.form_app['user_id'][oldIndex] = b_user_id;
    this.form_app['title'][newIndex] = a_title;
    this.form_app['user_id'][newIndex] = a_user_id; 
     
  ");
}); 
?>

<el-dialog
  title="配置审核流程"
  :visible.sync="show_set"
  width="800px" >
  <draggable :list="app_lists" @start="dragging = true" @end="end">
      <div class="form-item-small nested-2 mb10" v-for="i in app_lists">
          审核标题：
          <el-input size="medium" v-model="form_app.title[i]" class="name" style="width:150px;" 
            placeholder="请输入审核标题"></el-input>
          审核人员：
          <el-select size="medium" v-model="form_app.user_id[i]" class="user_id" placeholder="请选择审核人员">
              <el-option v-for="item in users" :key="item.value" :label="item.label" :value="item.value">
              </el-option>
          </el-select>
          <el-button size="medium" v-if="i == max" class="" type="text" @click="add_app_lists(i)">
              添加
          </el-button>
          <el-button size="medium" class="del_btn" type="text" @click="del_app_lists(i)">
              删除
          </el-button>
      </div> 
  </draggable>
  <div class="save_button_end">
    <el-button type="primary" :disabled="disabled" @click="save_set">保存配置</el-button>
  </div>
</el-dialog>

<?php 
//最后一步输出VUEJS，少这个是不行的
table_maker_js(); 
?>
</div>
<?php 
admin_footer();
?>

