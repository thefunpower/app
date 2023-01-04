<?php 
/*
    Copyright (c) 2021-2031, All rights reserved.
    This is NOT a freeware, use is subject to license terms 
    Connect Email: sunkangchina@163.com 
    Code Vesion: v1.0.x 
*/

include __DIR__.'/../../boot/app.php';    
/**
* 上传 
* /api/admin/upload.php  
* type: upload|crop|hash
*/
//系统.常用功能.上传
access('system.upload');
$uploader = new \lib\Upload;
$uploader->user_id = 0;
$type = g('type')?:'upload';  
switch ($type) {
    case 'upload':  
        $ret = $uploader->one();  
        unset($ret['local_path']);
        $ret['code'] = 0;
        //wangeditor
        if(g('is_editor')){ 
            $a = $ret;
            unset($ret);
            $ret['errno'] = 0;
            $ret['data'] = [
                'url'=>$a['data']
            ]; 
        }  
        json($ret);
        break;
    case 'crop':
        $f    = $_FILES['file'];
        $type = $f['type'];
        if($f['error'] != 0){
            json(['code'=>250,'msg'=>'上传文件失败']);
        }
        $ext  = substr($type,strrpos($type,'/')+1);
        $tmp  = $f['tmp_name'];
        $path = '/uploads/crop/'.date('Y-m')."/";
        $dest = PATH.$path;
        if(!is_dir($dest)){
            mkdir($dest,0777,true);
        }
        $name = uniqid(true).".".$ext;
        $dest = $dest.$name;
        if(!move_uploaded_file($tmp, $dest)){
            json(['code'=>0,'msg'=>'上传文件失败']);
        } 
        $data['code'] = 0;
        $data['status'] = 200;
        $data['data']  = static_url().$path.$name; 
        do_action("upload.after",$data);
        json($data);
        break; 
    case 'hash': 
        $data = g('data'); 
        if(!$data){
            json(['code'=>250,'msg'=>'缺少data参数']);
        }
        $data = $uploader->getHash($data);
        if($data){
            json(['code'=>0,'data'=>static_url().$data['url']]); 
        }else{
            json(['code'=>250,'msg'=>'文件未上传']);
        }
        break;
}

