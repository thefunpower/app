<?php
/**
 * 员工管理
 */

namespace app\sys;

class user extends \app\base
{
    protected $model = "\model\user";
    
    public function action_index()
    {
        return view('sys/user/index');
    }

    /**
    * 分页条件
    */
    protected function pager_where(&$where)
    {
        $wq = $this->input['wq'];
        if($wq) {
            $or = [
                'name[~]' => $wq,
                'phone[~]' => $wq,
                'email[~]' => $wq,
                'abc_first[~]' => $wq,
                'abc_full[~]' => $wq,
            ];
            $where['OR'] = $or;
        }
    }

}
