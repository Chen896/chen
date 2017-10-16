<?php


class CommonController extends Cola_Controller
{
    public function __construct()
    {
        $this->AuthCheck();
    }

    public function AuthCheck()
    {
        CommonModel::Auth();
    }


}
