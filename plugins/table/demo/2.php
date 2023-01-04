<?php 
/**
 * 演示TABLE功能 
 * 这个功能太复杂，多看代码吧！！！
 * 字段不要用Mysql存在的字段关键字，如varchar date time 等
 * 
 * /plugins/table/demo/1.php
 */
include __DIR__.'/../../../boot/app.php'; 
admin_header();
?>  
<div id="app" style="margin: 20px;">

<?php 
 
$table_config = [
  //表格高度,innerHeight-{height}
  'height'=>'160',
  //字段显示
  'column'=>[
       ['field'=>'id','label'=>'ID','sortable'=>true,'width'=>'100'],
       ['field'=>'shop_name','label'=>'标题'], 
      
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
    'table'=>'table_demo_shop',
    'select'=>'*',
    //where查寻遵循db类，仅把value值以 $字段 形式，以便请求替换成真实的数据
    //唯一区别[]改为(),因为请求时[]被理解为数组
    'where'=> [ 
        'ORDER'=>['id'=>'DESC'],
        'shop_name(~)'=>'$shop_name', 
    ],
  ], 
  //搜索功能,要与sql中的where一一匹配
  'filter'=>[ 
      [
        'label'=>'名称',
        //搜索字段,关联表必须是__连接
        'field'=>'shop_name',
        //字段类型
        'element'=>'input',
        //placeholder
        'placeholder'=>'请输入名称回车',  
      ], 
     
  ],
  //操作
  'action'=>[
      //编辑操作，编辑是固定的edit方法
      'edit'=>'编辑',
      //删除操作,删除是固定的remove方法
      'remove'=>'删除',
      //其他操作需要用户用$vue->method('pop()','js: '); 自行实现 
  ], 
  //表单验证规则 
  'validate'=>[
      'field'=>[
          'shop_name'=>'标题'
      ],
      'required'=>[
          ['shop_name'],
      ] 
  ],
  //表单设置
  'form'=>[
        [
          'label'=>'标题',
          'field'=>'shop_name',
          'element'=>'input',
          'required'=>true,
          //焦点进入自动选中
          'focus'=>true, 
        ], 
        
  ],

];
?>
<p>{{a}} {{b}}</p>
<?php 
//通过配置生成表格
table_maker($table_config,function(&$vue){
  $vue->data("a","演示Table功能，支持分页、搜索（关联搜索）、编辑、删除");
  $vue->data("b","支持很多字段类型");
}); 
?>

<?php 
//最后一步输出VUEJS，少这个是不行的
table_maker_js(); 
?>
</div>
<?php 
admin_footer();
?>

