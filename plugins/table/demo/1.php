<?php 

include __DIR__.'/../../boot/app.php';  
admin_header();
?> 
 
<div id="app" style="margin: 20px;">

<?php 

/**
 * table_demo_groupby这个函数应该在include.php中，此处仅为演示使用
 */
function table_demo_groupby($flag = false){
  $all = db_get("table_demo",[
    'printer_model',
    'count'=>"COUNT(id)"
  ],[
    'status'=>1,
    'GROUP'=>'printer_model'
  ]);
  $list = [];
  if($flag){
    $list[] = [
      'name'=>'',
      'label'=>'全部型号',
    ];
  }
  foreach($all as $v){
    if($v['printer_model']){
        $list[] = [
          'value'=>$v['printer_model'],
          'label'=> $v['printer_model']."(".$v['count'].")",
          'count'=>$v['count']
        ];
    } 
  }
  return $list;
}

$printer_model = table_demo_groupby();
$status = [
      ['label'=>'上架','value'=>'1'], 
      ['label'=>'下架','value'=>'-1'],
      
];
$table_config = [
  //'acl'=>'yy.member_level',
  //'column_call'=>"get_user",
  //是店铺发布的内容
  'shop_admin'=>false,
  //批量操作
  'selection'=>[
      'field'=>'status',
      'value'=>[
        ['label'=>'选择操作','value'=>''],
        ['label'=>'下架','value'=>'-1'], 
        ['label'=>'上架','value'=>'1'],
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
       ['field'=>'id','label'=>'ID','sortable'=>true,'width'=>'100'],
       [
        'field'=>'pdf','label'=>'PDF文件','width'=>'100',
        //字段支持使用template自己组织HTML
        'template'=>"
          <a v-if='scope.row.pdf' class='link hand' href='javascript:void(0);' @click='open_pdf(scope.row.pdf)'>
          查看文件
          </a>
         ",
       ],
       ['field'=>'bili','label'=>'比例','width'=>'100'],
       [
        'field'=>'status','label'=>'状态','width'=>'100', 'sortable'=>true,
        'template'=>"
          <span v-if='scope.row.status == 1' >
              上架
          </span>
          <span v-if='scope.row.status == -1' style='color:red;' >
              下架
          </span>
         ",
       ],
       ['field'=>'printer_drive','label'=>'驱动','width'=>'100'],
       ['field'=>'title','label'=>'名称','sortable'=>true],
       ['field'=>'tips','label'=>'备注','sortable'=>true], 
       ['field'=>'shop_id','label'=>'商家ID'],
       //关联字段
       //这个字段在table_demo表是不存在的,由relation获取
       [
        'field'=>'shop.shop_name','label'=>'商家名', 
       ],
       ['field'=>'printer_model','label'=>'型号'],
      
  ], 
  /**
   * 关联定义
   * 第一个shop参数是查寻出来后赋值给谁，也是field可以使用shop.shop_name的原因
   * value中第一个参数是表名，表中id为主键；第二个参数是主表中关联字段
   */
  'relation'=>[
      //名称  => 关联表名  , 主表中的字段（目的关联到关联表的id） ,表单中字段保存到关联表中
      'shop'=>['table_demo_shop','shop_id','get'=>'one'],
      'spec'=>['table_demo_spec','product_id','get'=>'all','form_field'=>['spec'],], 
  ],
  //查寻SQL，对应搜索功能字段
  'sql'=>[
    'table'=>'table_demo',
    'select'=>'*',
    //where查寻遵循db类，仅把value值以 @字段 形式，以便请求替换成真实的数据
    //唯一区别[]改为(),因为请求时[]被理解为数组
    'where'=> [ 
        'ORDER'=>['id'=>'DESC'],
        'title(~)'=>'$title',
        'tips(~)'=>'$tips',
        'printer_model'=>'$printer_model', 
        'status'=>'$status', 
    ],
  ], 
  //搜索功能,要与sql中的where一一匹配
  //关联搜索需要配合relation定义
  'filter'=>[ 
      [
        'label'=>'名称',
        //搜索字段,关联表必须是.连接
        'field'=>'shop.shop_name',
        //字段类型
        'element'=>'input',
        //placeholder
        'placeholder'=>'请输入商家名称回车', 
      ], 
      [
        'label'=>'机器型号',
        //搜索字段
        'field'=>'printer_model',
        //字段类型
        'element'=>'select',
        'value'=> $printer_model,
        //placeholder
        'placeholder'=>'机器型号', 
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
      [
        'label'=>'名称',
        //搜索字段
        'field'=>'title',
        //字段类型
        'element'=>'input',
        //placeholder
        'placeholder'=>'请输入名称回车', 
      ],
      [
        'label'=>'备注',
        //搜索字段
        'field'=>'tips',
        //字段类型
        'element'=>'input',
        //placeholder
        'placeholder'=>'请输入备注回车', 
      ],
  ],
  //操作,edit remove是固定的两个操作
  'action'=>[
      //编辑操作，编辑是固定的edit方法
      'edit'=>'编辑',
      //其他操作需要用户用$vue->method('get_user()',"js: console.log(this.row);"); 自行实现 
      'get_user'=>'自定义按钮',
      //删除操作,删除是固定的remove方法
      'remove'=>'删除', 
  ], 
  
  //对form按tab分组显示，有时字段过多一个页面显示太多
  'form_tab'=>[
      '基础信息'=>[
        'status',  
        'title',
        'printer_drive',
        'shop_id',
        'functions',
        'address',
        'color',
        'business_hours'
      ],
      '图片及时间'=>[
         'img', 
         'imgs',
         'time1', 
         'date1',
         'datetime1'
      ],
      '其他'=>[ 
         'checkbox',
         'attr',
         'spec',
         'tips'
      ],
  ],
  //对form_tab参数有效果
  'form_tab_layout'=>[
      '基础信息'=>[
          [
            'span'=>12,
            'field'=>['select','title','shop_id','tag']
          ],
          [
            'span'=>12,
            'field'=>['address','color','business_hours']
          ],
      ] 
  ],
  //layout,共24列，可分多个，对form参数效果
  'form_layout'=>[
      [
        'span'=>12,
        'field'=>['title','shop_id']
      ],
      [
        'span'=>12,
        'field'=>['address','color','business_hours']
      ], 
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
      //'edit_dialog_width'=>'500px',


  ],
  //表单中存在需要保存到其他表的字段 
  //表单设置
  'form'=>[
        [
          'label'=>'状态',
          'field'=>'status', 
          'element'=>'radio', 
          //支持搜索
          'filterable'=>false,
          //是否多选，多选时field必须是json字段类型
          'multiple'=>false,
          'value'=>$status,
        ],
        [
          'label'=>'属性',
          'field'=>'attr', 
          'element'=>'attribute',  
          'placeholder1'=>'属性名如：温度',
          'placeholder2'=>'多值用,、或空格分隔如：标准冰、少冰、去冰、温、热',
        ],  
        [
          'label'=>'规格',
          'field'=>'spec', 
          'element'=>'sku',  
        ], 
        [
          'label'=>'标签',
          'field'=>'tag', 
          'element'=>'tag', 
        ], 
        [
          'label'=>'PDF文件',
          'field'=>'pdf', 
          'element'=>'upload', 
          //允许上传文件后缀
          'mime'=>'pdf',
          //显示方式
          'show_type'=>'pdf',
          //上传允许大小，单位M
          'size'=>5,
          //是否多文件上传，如果是多文件，field字段必须为json
          'multiple'=>false,
          //是否排序,仅当multiple为true有效果
          'sortable'=>true,
        ], 
        [
          'label'=>'自定义',
          'field'=>'functions',
          //自定义字段，callable 
          'element'=>'custom',
          //显示的内容，可以是HTML代码也可以是callable
          //如果是HTML代码请用 'callable'=>"这个是HTML代码",
          'callable'=>function(){
              echo '这里是自定义内容';
          }, 
          //'required'=>true, 
        ], 
        [
          'label'=>'标题',
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
          'label'=>'门店关联shop的',
          'field'=>'shop_id',
          'element'=>'autocomplete',
          //这个字段表中不存在，用于显示autocomplete的label
          'element_field'=>'shop.shop_name',
          'sql'=>[
            'table'=>'table_demo_shop', 
            'where'=> [ 
                'ORDER'=>['id'=>'DESC'],
                'shop_name(~)'=>'', 
                'LIMIT'=>10,
            ],
            'label'=>'shop_name', 
          ], 
          'required'=>true, 
          //焦点进入自动选中
          'focus'=>true,
        ], 
        //address字段加载的接口生成的JS对象过大，目前仅可以优化打开窗口速度快，但依然需要等待address对象加载完成，仅在首次有感觉。
        /*[
          'label'=>'地址',
          'field'=>'address',
          //address插件依赖user_address插件 
          //'field'=>'address'为例
          //数据库中address字段必须为json类型
          //且 address_detail 为varchar 类型 
          
          'element'=>'address',
          'required'=>true,  
        ], */
        [
          'label'=>'颜色',
          'field'=>'color',
          'element'=>'color',
          'required'=>true,  
        ], 
        [
          'label'=>'时间time类型',
          'field'=>'time1',
          'element'=>'time',
          'required'=>true, 
          'options'=>[
              'start' => '08:30',
              'step' => '00:15',
              'end'  => '18:30'
          ] 
        ], 
        [
          'label'=>'时间date类型',
          'field'=>'date1',
          'element'=>'date',
          'required'=>true, 
          'placeholder'=> '选择时间' 
        ], 
        [
          'label'=>'时间datetime类型',
          'field'=>'datetime1',
          'element'=>'datetime',
          'required'=>true, 
          'placeholder'=> '选择时间' 
        ], 
        [
          'label'=>'分成',
          'field'=>'bili', 
          'element'=>'number',
          //最小值
          'min' => 1,
          //最大值
          'max' => 100, 
        ], 
        

        [
          'label'=>'单选',
          'field'=>'printer_drive', 
          'element'=>'select', 
          //支持搜索
          'filterable'=>true,
          //是否多选，多选时field必须是json字段类型
          'multiple'=>false,
          'value'=>[
              ['label'=>'链科','value'=>'lianke'],
              ['label'=>'佳能','value'=>'gx'],
          ],
        ], 
        [
          'label'=>'多选',
          'field'=>'printer_drive_json', 
          'element'=>'select', 
          //支持搜索
          'filterable'=>true,
          //是否多选，多选时field必须是json字段类型
          'multiple'=>true,
          'value'=>[
              ['label'=>'链科','value'=>'lianke'],
              ['label'=>'佳能','value'=>'gx'],
          ],
        ], 
        /*[
          'label'=>'radio',
          'field'=>'status', 
          'element'=>'radio',  
          'value'=>[
              ['label'=>'状态1','value'=>'1'],
              ['label'=>'状态2','value'=>'2'],
          ],
        ],*/
         
        [
          'label'=>'多选框',
          'field'=>'checkbox', 
          'element'=>'checkbox', 
          'default'=>1,  
          'value'=>[
              ['label'=>'状态1','value'=>'1'],
              ['label'=>'状态2','value'=>'2'],
          ],
        ], 

        [
          'label'=>'单图',
          'field'=>'img', 
          'element'=>'upload', 
          //允许上传文件后缀
          'mime'=>'jpg,png',
          //显示方式
          'show_type'=>'image',
          //上传允许大小，单位M
          'size'=>5,
          //是否多文件上传，如果是多文件，field字段必须为json
          'multiple'=>false,
          //是否排序,仅当multiple为true有效果
          'sortable'=>true,
        ], 
        [
          'label'=>'多图',
          'field'=>'imgs', 
          'element'=>'upload', 
          //允许上传文件后缀
          'mime'=>'jpg,png',
          //显示方式
          'show_type'=>'image',
          //上传允许大小，单位M
          'size'=>5,
          //是否多文件上传，如果是多文件，field字段必须为json
          'multiple'=>true,
          //是否排序,仅当multiple为true有效果
          'sortable'=>true,
        ], 
        [
          'label'=>'营业时间',
          'field'=>'business_hours', 
          'element'=>'text', 
          'rows'=>3, 
        ],  

        [
          'label'=>'备注',
          'field'=>'tips',
          //编辑器字段
          'element'=>'editor', 
        ], 
  ],

];
?>
<p>{{a}} {{b}}  <a style="color:blue;" href="/plugins/table/demo/viewsource.php?viewsource=1" target="_blank">查看源码</a></p>
<?php 
/**
 * 通过配置生成表格需要的PHP代码，包含$vue对象
 */
table_maker($table_config,function(&$vue){
  $vue->data("a","演示Table功能，支持分页、搜索（关联搜索）、编辑、删除");
  $vue->data("b","支持很多字段类型");
  $vue->method('get_user()',"js: 
    console.log(this.row); 
    layer.msg('这是自定义按钮，打开调试看输出');
  ");
}); 
?>

<?php 
//最后一步输出VUEJS，少这个是不行的
table_maker_js(); 
?>
</div> 

<?php admin_footer()?>