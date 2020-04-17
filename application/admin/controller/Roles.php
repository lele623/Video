<?php
namespace app\admin\controller;
use Util\database\Sysdb;

class Roles extends Baseadmin
{
    public function index()
    {
        return $this->fetch();
    }
}