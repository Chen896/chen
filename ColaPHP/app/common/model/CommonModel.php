<?php

//验证权限[统一]
class CommonModel extends Cola_Model
{
    protected $_table = 'member';

    public static function Auth()
    {
        echo '统一权限验证';
        // try {
        //     $data = $this->sql("select * from foobar limit 5;");
        //     return $data;
        // } catch (Exception $e) {
        //     echo $e;
        // }
    }


}