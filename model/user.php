<?php

namespace model;

use Overtrue\Pinyin\Pinyin;

class user extends \model
{
    protected $table = 'users';

    protected $field = [
        'name'  => '姓名',
        'phone' => '手机号',
        'email' => '邮件',
    ];

    protected $validate = [
        'required' => [
            'name','phone','email',
        ],
        'email' => [
            ['email'],
        ],
        'phonech' => [
            ['phone']
        ],
        'unique' => [
            ['phone'],
            ['email'],
        ]
    ];

    protected $unique_message = [
        '手机号已存在',
        '邮件已存在',
    ];


    /**
    * 写入数据前
    */
    public function before_insert(&$data)
    {
        parent::before_insert($data);
        $data['created_at'] = now();
        $name = $data['name'];
        $data['abc_first'] = Pinyin::abbr($name)->join('');
        $data['abc_full'] = Pinyin::name($name, 'none')->join('');
    }

    /**
    * 更新数据前
    */
    public function before_update(&$data, $where)
    {
        parent::before_update($data, $where);
        $name = $data['name'];
        $data['abc_first'] = Pinyin::abbr($name)->join('');
        $data['abc_full'] = Pinyin::name($name, 'none')->join('');
    }
}
