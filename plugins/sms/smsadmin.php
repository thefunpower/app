<?php

/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/

include __DIR__ . '/../../boot/app.php'; 
use plugins\sms\SMS;
admin_header();
?>

<div id="app" style="margin: 20px;">

<?php  
$info = SMS::less();  
$html = "
<p>
  剩余：<b style='color:green;'>".$info['sms_less']."</b>
  已发：".$info['sms_used']."  
  共：".bcadd($info['sms_less'] , $info['sms_used'])."  
</p>
";
$status = [
  ['label'=>'发送成功','value'=>1],
  ['label'=>'发送失败','value'=>-1],
];
$table_config = [ 
  'after_search_bar'=>$html,
  //表格高度,innerHeight-{height}
  'height'=>'250',
  //字段显示
  'column'=>[  
       ['field'=>'title','label'=>'手机号','width'=>'109'],
       ['field'=>'body','label'=>'内容','width'=>''], 
       [
        'field'=>'status','label'=>'支付状态','width'=>'300',  
        'template'=>"
          <span v-if='scope.row.status == 1' >
              成功
          </span>
          <span v-if='scope.row.status == -1' style='color:red;' >
              失败
          </span>
         ",
       ],
       ['field'=>'created_at','label'=>'发送时间'],  
  ], 
  /**
   * 关联定义
   * 第一个shop参数是查寻出来后赋值给谁，也是field可以使用shop.shop_name的原因
   * value中第一个参数是表名，表中id为主键；第二个参数是主表中关联字段
   */
  'relation'=>[
      //名称  => 关联表名  , 主表中的字段（目的关联到关联表的id） ,表单中字段保存到关联表中
      //'type'=>['commerce_types','type_id','get'=>'one'],
      //'spec'=>['table_demo_spec','product_id','get'=>'all','form_field'=>['spec'],], 
  ],
  //查寻SQL，对应搜索功能字段
  'sql'=>[
    'table'=>'sms',
    'select'=>'*',
    //where查寻遵循db类，仅把value值以 @字段 形式，以便请求替换成真实的数据
    //唯一区别[]改为(),因为请求时[]被理解为数组
    'where'=> [ 
        'ORDER'=>['id'=>'DESC'],
        'title(~)'=>'$title', 
        'body'=>'$body', 
    ],
  ], 
  //搜索功能,要与sql中的where一一匹配
  //关联搜索需要配合relation定义
  'filter'=>[ 
     [
        'label'=>'状态',
        //搜索字段
        'field'=>'status',
        //字段类型
        'element'=>'select',
        'value'=> $status, 
        'placeholder'=>'状态', 
      ],
      [
        'label'=>'手机号',
        //搜索字段,关联表必须是.连接
        'field'=>'title',
        //字段类型
        'element'=>'input',
        //placeholder
        'placeholder'=>'手机号', 
      ], 
       
  ],
  //操作,edit remove是固定的两个操作
  'action'=>[
      //编辑操作，编辑是固定的edit方法
      //'edit'=>'编辑', 
      //删除操作,删除是固定的remove方法
      //'remove'=>'删除', 
  ],  
  //HTML属性
  "html_option"=>[ 
      'edit_dialog_width'=>'600px',  
  ],
  //表单中存在需要保存到其他表的字段 
  //表单设置
  'form'=>[ 
        
         
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
<?php
admin_footer();
?>