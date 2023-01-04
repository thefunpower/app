<?php  
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
include __DIR__.'/../../boot/app.php';  
admin_header();
?>  
<div id="app" style="margin: 20px;">

<?php 
 
$status = [
      ['label'=>'显示','value'=>'1'], 
      ['label'=>'不显示','value'=>'-1'], 
];
$table_config = [
  //是店铺发布的内容
  'shop_admin'=>false,
  //批量操作
  'selection'=>[
      'field'=>'status',
      'value'=>[
        ['label'=>'选择操作','value'=>''],
        ['label'=>'显示','value'=>'-1'], 
        ['label'=>'不显示','value'=>'1'],
      ]
  ],
  //在搜索前添加HTML
  'before_search_bar'=>'',
  //在搜索后添加HTML
  'after_search_bar'=>'',
  //在搜索行添加HTML
  'search_bar'=>'',
  //在页尾添加HTML
  'footer'=>'',
  //表格高度,innerHeight-{height}
  'height'=>'180',
  //字段显示
  'column'=>[ 
       ['field'=>'title','label'=>'分类名'],
       [
        'field'=>'status','label'=>'状态','width'=>'100', 'sortable'=>true,
        'template'=>"
          <span v-if='scope.row.status == 1' class='green' >
              显示
          </span>
          <span v-if='scope.row.status == -1' style='color:red;' >
              不显示
          </span>
         ",
       ],   
       ['field'=>'created_at','label'=>'发布时间','width'=>'180'],
      
  ], 
  /**
   * 关联定义
   * 第一个shop参数是查寻出来后赋值给谁，也是field可以使用shop.shop_name的原因
   * value中第一个参数是表名，表中id为主键；第二个参数是主表中关联字段
   */
  'relation'=>[  
       
  ],
  //查寻SQL，对应搜索功能字段
  'sql'=>[
    'table'=>'article_type',
    'select'=>'*', 
    'where'=> [ 
        'ORDER'=>['sort'=>'DESC','id'=>'DESC' ],
        'title(~)'=>'$title', 
        'status'=>'$status', 
    ],
  ], 
  //搜索功能,要与sql中的where一一匹配
  //关联搜索需要配合relation定义
  'filter'=>[  
      [
        'label'=>'分类名',
        //搜索字段
        'field'=>'title',
        //字段类型
        'element'=>'text', 
        //placeholder
        'placeholder'=>'分类名', 
      ],
      [
        'label'=>'状态',
        //搜索字段
        'field'=>'status',
        //字段类型
        'element'=>'select',
        'value'=> $status,
        //placeholder
        'placeholder'=>'状态', 
      ],
      
  ],
  //操作,edit remove是固定的两个操作
  'action'=>[
      //编辑操作，编辑是固定的edit方法
      'edit'=>'编辑', 
      //删除操作,删除是固定的remove方法
      'remove'=>'删除', 
  ], 
  
   
  //HTML属性
  "html_option"=>[
      //表单弹出方式 drawer或dialog，默认dialog . drawer方式测试中
      //'form_pop'=>'drawer',
      /**
       * 弹出的表单,默认80%
       */
      //弹出的表单是否全屏
      //'edit_dialog_fullscreen'=>true,
      //弹出的表单宽度，优先级低于edit_dialog_fullscreen
      'edit_dialog_width'=>'500px',


  ],
  //表单中存在需要保存到其他表的字段 
  //表单设置
  'form'=>[  
        [
          'label'=>'分类名',
          'field'=>'title',
          'element'=>'input',
          'required'=>true,
          //表单验证规则 
          //参考 https://www.yuque.com/sunkangchina/juhe/validate
          'validate'=>[  
              //'email'=> ['title'], 
              'lengthMin' => [
                  ['title', 2]
              ]
          ], 
          // vue_options 功能可以实现某个字段为某个值时显示的功能
          // 'vue_options'=>[
          //   "v-if=\"form.printer_drive=='gx'\"",
          // ],
          
          //焦点进入自动选中
          'focus'=>true,
        ],  
        [
          'label'=>'排序',
          'field'=>'sort',
          'element'=>'input',
        ], 
        [
          'label'=>'状态',
          'field'=>'status', 
          'element'=>'radio',
          'default'=>1, 
          //支持搜索
          'filterable'=>false,
          //是否多选，多选时field必须是json字段类型
          'multiple'=>false,
          'value'=>$status,
        ],
  ],

];
?> 
<?php 
/**
 * 通过配置生成表格需要的PHP代码，包含$vue对象
 */
table_maker($table_config,function(&$vue){
   
}); 
?>

<?php 
//最后一步输出VUEJS，少这个是不行的
table_maker_js(); 
?>
</div> 

<?php admin_footer()?>