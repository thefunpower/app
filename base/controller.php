<?php
/**
 * CRUD 基础类
 */

namespace base;

use IRoute;
use helper_v3\Form;

class controller
{
    /**
     * 是否访客可访问
     */
    protected $is_guest = false;
    /**
     * 用户标识
     */
    protected $gid;
    /**
     * model类字符串，如\core\sys\model\user
     */
    protected $model;
    /**
     * new model返回的实例，用于查寻、添加、修改操作
     * 如 $this->model_class->find(id)
     */
    protected $model_class;
    /**
     * 请求参数
     */
    protected $input;
    /**
     * 分页要条件
     */
    protected $where = [];
    /**
     * 添加操作成功提示
     */
    protected $add_success_msg = '操作成功';
    /**
     * 修改操作成功提示
     */
    protected $edit_success_msg = '操作成功';
    /**
     * 站点ID
     */
    protected $site_id;
    /**
     * 用户ID
     */
    protected $user_id;
    /**
     * 用户信息
     */
    protected $user_info;
    /**
     * 请求的包名，如core app
     */
    protected $package;
    /**
     * 请求模块名 如 employee
     */
    protected $module;
    /**
     * 请求控制器名 user
     */
    protected $controller;
    /**
     * 请求方法名 index
     */
    protected $action;
    /**
     * 允许访问的方法
     */
    protected $allow_action = [];
    /**
     * 开启关联查寻
     */
    protected $relation = false;
    /**
     * 构造函数
     */
    public function __construct()
    {
        global $current_db,$config;
        $route = IRoute::get_action();
        $this->package = $route['package'];
        $this->module = $route['module'];
        $this->controller = $route['controller'];
        $this->action = $route['action'];
        $model = $this->model;
        if($model) {
            $this->model_class = new $model();
        }
        $lang = 'zh-cn';
        \lib\Validate::lang($lang);
        $this->input = g();
        $this->init();
        if(!$current_db) {
            $current_db = 'default';
        }
        $this->gid = Form::guest_cookie();
        /**
         * 对应用开通进行判断，未开通的提示，忽略系统内置的应用
         */
        if($this->package != 'modules') {
            $app_slug = $this->module;
            $ignore_app_slug = $config['ignore_app_slug'];
            if($ignore_app_slug && !in_array($app_slug, $ignore_app_slug) && !get_app_is_open($app_slug)) {
                echo view('/error/app_not_find');
                exit;
            }
        }
        $allow_action = $this->allow_action;
        if($allow_action) {
            if(!in_array($this->action, $allow_action)) {
                echo view('/error/app_cannot_use');
                exit;
            }
        }
    }
    /**
     * 显示视图
     */
    public function view($name, $par = [])
    {
        $file = PATH . '/' . $this->package . '/' . $this->module . '/view/' . $this->controller . '/' . $name . '.php';
        $file = str_replace("//", "/", $file);
        if(file_exists($file)) {
            extract($par);
            include $file;
        } else {
            return view($name, $par);
        }
    }
    /**
     * 初始化
     */
    protected function init()
    {
       
    }
    /**
    * 首页
    */
    public function action_index()
    {
        return $this->view("index");
    }
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
        $this->where = $where;
        if($this->relation) {
            $all = $this->model_class->relation()->pager($where);
        } else {
            $all = $this->model_class->pager($where);
        }
        $this->pager_data($all);
        return json($all);
    }
    /**
     * 分页显示数据库
     */
    protected function pager_data(&$data) {}
    /**
    * 分页条件
    */
    protected function pager_where(&$where) {}
    /**
     * 软删除
     */
    public function delete()
    {
        $id = $this->input['id'];
        $user = $this->model_class->find($id);
        if($user) {
            $status = $user['status'];
            if($status == 1) {
                $status = -1;
            } else {
                $status = 1;
            }
            $this->model_class->f_update(['status' => $status], ['id' => $id]);
        }
        return json_success(['msg' => '操作成功']);
    }
}
