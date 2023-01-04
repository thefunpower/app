<?php
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/

function get_artilce($article_title_or_id){
    if(is_int($article_title_or_id)){
       $res = db_get_one("article",'*',[
          'status'=>1,
          'id'=>$article_title_or_id, 
       ]);
    }else{
      $res = db_get_one("article",'*',[
          'status'=>1,
          'title'=>$article_title_or_id, 
       ]);
    } 
    return $res;
}

/** 
* 按分类ID或分类名，取所有文章
*/
function get_artilces_by_type($type_title)
{
   if(is_int($type_title)){
    $in = $type_title;
   }else{
    $in  = db_get("article_type",'id',['status'=>1,'title'=>$type_title]);
   }  
   $all = db_get("article",'*',[
      'status'=>1,
      'type_id'=>$in,
      'ORDER'=>['sort'=>'DESC','id'=>'DESC']
   ]);
   return $all;
}
/**
* 按分类ID或分类名，取文章分页
*/
function get_artilces_pager($type_title = null)
{
  $where = [
      'status'=>1, 
      'ORDER'=>['sort'=>'DESC','id'=>'DESC']
  ];
  if($type_title){
    if(is_int($type_title)){
      $in = $type_title;
     }else{
      $in  = db_get("article_type",'id',['status'=>1,'title'=>$type_title]);
     }  
     $where['type_id'] = $in;
  } 
  $all = db_pager("article",'*',$where);
  return $all;
}


add_action("admin.menu", function (&$menus) { 
  $menus['article'] = [
    'icon' => 'far fa-circle',
    'label' => '文章管理',
    'level'=>10,
    'url' => 'plugins/article/article.php',
    'acl' => "yy.article"
  ]; 
  $menus['article']['children'][] = [
    'icon' => 'far fa-circle',
    'label' => '文章',
    'level'=>10,
    'url' => 'plugins/article/article.php',
    'acl' => "table.article.admin"
  ]; 
  $menus['article']['children'][] = [
    'icon' => 'far fa-circle',
    'label' => '文章分类',
    'level'=>10,
    'url' => 'plugins/article/article_type.php',
    'acl' => "table.article_type.admin"
  ]; 
  
});
