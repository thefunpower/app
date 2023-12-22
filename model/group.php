<?php

namespace model;

class group extends \model
{
    protected $table = 'groups';
    /**
    * 写入数据前
    */
    public function before_insert(&$data)
    {
        $data['created_at'] = now();
    }
}
