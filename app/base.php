<?php
/**
 * CRUD 基础类
 */

namespace app;

class base
{
    protected $model;
    protected $model_class;
    protected $input;
    protected $where = [];
    protected $add_success_msg = '操作成功';
    protected $edit_success_msg = '操作成功';

    public function __construct()
    {
        $model = $this->model;
        if($model) {
            $this->model_class = new $model();
        }
        $this->input = g();
        $this->init();
    }

    protected function init() {}

    /**
    * 添加
    */
    public function action_add()
    {
        $data = $this->input['data'];
        $res  = $this->model_class->insert($data);
        return json_success(['msg' => $this->add_success_msg]);
    }

    /**
    * 编辑
    */
    public function action_edit()
    {
        $data = $this->input['data'];
        $id   = $data['id'];
        if(!$id) {
            return json_error(['msg' => '操作异常']);
        }
        unset($data['id']);
        $res  = $this->model_class->update($data, $id);
        return json_success(['msg' => $this->add_success_msg]);
    }

    /**
    * 分页显示
    */
    public function action_pager()
    {
        $where = $this->where;
        $where['ORDER'] = ['id' => 'DESC'];
        $this->pager_where($where);
        $all = $this->model_class->pager($where);
        return json($all);
    }
    /**
    * 分页条件
    */
    protected function pager_where(&$where) {}

}
