<?php
namespace app\admin\controller;
use Util\database\Sysdb;

/**
 * 权限管理
 * @package app\admin\controller
 */
class Menu extends Baseadmin
{
    //菜单列表
    public function index(){
        $pid = (int)input("get.pid");
        $data['lists'] = $this->db->table('admin_menus')->where(array('pid' => $pid))->lists();
        $backid = 0;
        if($pid > 0){
            $parent = $this->db->table('admin_menus')->where(array('mid' => $pid))->item();
            $backid = $parent['pid'];
        }
        $this->assign('pid',$pid);
        $this->assign('backid',$backid);
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function sace(){

    }
}