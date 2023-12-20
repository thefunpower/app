<?php 
/**
 * 
$model = new demo;
$model->insert(['event_data'=>'test','ss'=>222]); 
$model->update(['event_data'=>'test','ss'=>222],['id'=>2]); 
$res = $model->find(1);
$res = $model->find(['id'=>[1,2]]);
$res = $model->find(['event_data[~]'=>'数据'],$limit=1);
$res = $model->sum('id',['event_data[~]'=>'数据']);
$res = $model->count(['event_data[~]'=>'数据']);
$res = $model->max('id',['event_data[~]'=>'t']);

*/


namespace model; 

class demo extends \model{ 
	protected $table = 'wp_e_events';
	/**
	* 写入数据前
	*/
	public function before_insert(&$data){
		//$data['event_data'] = '我是数据';
		$data['created_at'] = now();
	}
	/**
	* 写入数据后
	*/
	public function after_insert($id){
		 
	}

	/**
	* 更新数据前
	*/
	public function before_update(&$data,$where){ 
	}
	/**
	* 更新数据后
	*/
	public function after_update($row_count,$data,$where){ 
	}
	
}