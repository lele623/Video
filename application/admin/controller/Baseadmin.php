<?php
namespace app\admin\controller;
use think\Controller;
use Util\database\Sysdb;

/**
 * 非法用户判断
 * @package app\admin\controller
 */
class Baseadmin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->_admin=session('admin');
        //未登录则不能进入后台
        if(!$this->_admin){
            header('location: /admin.php/admin/account/login');
            exit;
        }
        //判断用户是否有权限
        $this->db = new Sysdb();
    }
}