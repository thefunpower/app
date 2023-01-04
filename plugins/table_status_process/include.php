<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/
/**
* 审核流程
* 表中需要有status_process字段
* 演示添加审核
* add_to_table_status_process('店铺审核','commerce_shopinfo');
*/

add_action("admin.menu",function(&$menus){  
    $menus['yy']['children'][] = [
        'icon' => 'far fa-circle',
        'label' => '审核流程',
        'url' => 'plugins/table_status_process/table_status_process.php', 
        'acl'=>'yy.table_status_process.admin'
    ];
}); 


add_action("table.vue",function(&$opt){
  $vue = $opt['vue'];
  $data = $opt['data']; 
  if($data['action']['status_process']){
    $vue->data("is_status_process",false);
    $vue->data("status_process_form","js:{}");
    $vue->data("status_process_top","js:[]");
    $vue->data("status_process_his","js:[]");
    $vue->data("status_process_dis",false);
    $vue->data("status_process_can_change",false); 
    $vue->data("active_status_process",1);
    $vue->data("active_status_success",0);
    $vue->data("active_status_his_last",1);

    $vue->method("status_process()","js:
      this.is_status_process = true;
      this.active_status_success = 0;
      this.active_status_process = 1;
      this.status_process_top = []; 
      ajax('/plugins/table_status_process/api/admin/status_process.php',{
        name:'".$data['sql']['table']."',
        nid:this.row.id
      },function(res){
        _this.status_process_top = res.data;
        _this.active_status_process = res.active_status_process - 1;
        _this.active_status_success = res.success;
        _this.status_process_his = res.his;
        _this.active_status_his_last = res.his_last;
        _this.status_process_can_change = res.can_change;
      });   
    "); 
    $vue->method("status_process_save()","js:
        this.status_process_dis = true;
        ajax('/plugins/table_status_process/api/admin/status_process_save.php',{
          name:'".$data['sql']['table']."',
          nid:this.row.id,
          data:this.status_process_form
        },function(res){
           ".vue_message()."
           if(res.code == 0){
            _this.is_status_process = false;
            _this.load_page();
           }
           _this.status_process_dis = false;
        });   
    ");
  } 
  $opt['vue']  = $vue;  
});

add_action("table.html",function(&$opt){
  $vue = $opt['vue'];
  $data = $opt['data'];
  if($data['action']['status_process']){
    include __DIR__.'/status_process_pop.php';
  }
});

/**
* 设置审核状态
*/
function set_table_status_process($name,$nid,$title,$desc,$status){
  db_insert("table_status_process",[
    'name'=>$name,
    'nid'=>$nid,
    'title'=>$title,
    'desc'=>$desc,
    'status'=>$status,
    'created_at'=>now()
  ]);
}
/**
* 获取审核情况
*/
function get_table_status_process($name,$nid){
  $all = db_get("table_status_process","*",[
    'name'=>$name,
    'nid'=>$nid, 
    'is_del'=>0, 
    'ORDER'=>['id'=>'ASC']
  ]);
  return $all;
}
/**
* 加入审批
*/
function add_to_table_status_process($title,$name){
  $res = db_get_one("table_status_process_set",'*',['name'=>$name]);
  if(!$res){
    db_insert("table_status_process_set",[
      'title'=>$title,
      'name'=>$name,
      'created_at'=>now()
    ]);
  }
}
/**
* 获取所有的审核过程
*/
function get_table_status_process_code($name,$show_array=false){
    $arr = _get_table_status_process($name); 
    $nid = $arr['nid'];
    $array = $arr['array'];
    $all_2 = db_get("table_status_process","*",['nid'=>$nid,'is_del'=>0,]); 
    foreach($all_2 as $v){
        $last = $v; 
    }
    if($show_array){ 
      return $array;
    }
    if($v['next_user_id'] == 0){
        return true;
    }else{
        return false;
    }

} 
/**
 * 获取当前应该参与审核的user_id
 */
function get_table_status_process_next($name,$nid,$user_id,$ignore_error = false){
    $step = get_table_status_process_step($name,$nid); 
    if(!$step){
      json_error(['msg'=>'审核结束']);
    }
    $arr = _get_table_status_process($name);
    $nid = $arr['nid'];
    $array = $arr['array'];
    $res = db_get_one("table_status_process","*",['is_del'=>0, 'nid'=>$nid,'ORDER'=>['id'=>'DESC']]); 
    if($res){
        if($res['next_user_id'] > 0 ){
          if($user_id == $res['next_user_id']){           
            $user_id = $res['next_user_id'];
          }else{
            if($ignore_error){
              return;
            }
            json_error(['msg'=>'当前流程审核员非此帐号']);
          }
        }else{
          if($ignore_error){
              return;
          }
          json_error(['msg'=>'流程已结束']);
        }        
    } 
    $v = $array[$step-1]; 
    if($user_id != $v['user_id']){
      if($ignore_error){
        return;
      }
      json_error(['msg'=>'当前流程审核员非此帐号']);
    } 
    $v['next_user_id'] = $array[$step]['user_id']?:0;
    $v['step'] = $step+1;
    return $v; 
}
/**
* 获取审核记录
*/
function get_table_status_process_his($name,$nid){
  $all = db_get("table_status_process","*",[
    'nid'=>$nid,
    'name'=>$name,
  ]);
  $list = [];
  foreach($all as $v){
    $user = get_user($v['user_id']);
    $is_end = 0;
    if($v['next_user_id'] == 0){
      $is_end = 1;
    }
    $list[] = [
      'user'=>$user['user'],
      'body'=>$v['body'],
      'time'=>$v['created_at'],
      'status'=>$v['status']==1?'通过':'拒绝',
      'color'=>$v['status']==1?'blue':'red',
      'is_end'=>$is_end,
    ];
  }
  return $list;
}
/**
* 获取审核step
*/
function get_table_status_process_step($name,$nid){
  $arr = _get_table_status_process($name); 
  $array = $arr['array'];  
  $res = db_get_one("table_status_process","*",['is_del'=>0, 'nid'=>$nid,'ORDER'=>['id'=>'DESC']]);  
  if($res){ 
    if($res['next_user_id'] > 0){
      return $res['step'];
    }else{
      return 100;
    }
  }
  return 1;
}

/**
* 公共的
*/
function _get_table_status_process($name){
    $nid = db_get_one("table_status_process_set","id",['name'=>$name]); 
    $all = db_get('table_status_process_set_detail','*',['nid'=>$nid]);
    $nid = [];
    $array = []; 
    foreach($all as $v){
      $nid[] = $v['id']; 
      $user = get_user($v['user_id']); 
      $array[] = [
        'user_id' => $user['id'],
        'user_name' => $user['user'],
        'title' => $v['title'], 
      ]; 
    }
    return ['nid'=>$nid,'array'=>$array];
}
/**
* 获取status_process对应label
*/
function status_process($status_process = null){
  $arr = [
    'wait'=>'待审核',
    'process'=>'审核中',
    'finish'=>'通过',
    'finish_error'=>'拒绝',
  ];
  if(!$status_process){
    return $arr;
  }
  return $arr[$status_process];
}


function status_process_table_column(){
  return [[
      'field'=>'status','label'=>'审核状态','width'=>'130', 'sortable'=>true,
      'template'=>"
        <span v-if=\"scope.row.status_process == 'wait'\" >
            待审核
        </span>
        <span v-if=\"scope.row.status_process == 'process'\" >
            审核中
        </span>
        <span v-if=\"scope.row.status_process == 'finish'\" class='blue' >
            通过
        </span>  
        <span v-if=\"scope.row.status_process == 'finish_error'\" class='red' >
            拒绝
        </span>  
       ",
  ]];
}