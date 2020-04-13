<?php
namespace app\admin\controller;

/**
 * 后台首页
 * @package app\admin\controller
 */
class Home extends Baseadmin
{
    //后台首页
    public function index(){
        $data['username'] = session("admin")['username'];
        $data['gid'] = session("admin")['gid'];
        $data['groups'] = $this->db->table('admin_groups')->field("gid,title")->cates('gid');
        $this->assign('data',$data);
        return $this->fetch();
    }
    //主页面首页
    public function welcome(){
        return $this->fetch();
    }
}