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
        //获取到当前菜单的等级（子菜单）
        $pid = (int)input("get.pid");
        //查询
        $data['lists'] = $this->db->table('admin_menus')->where(array('pid' => $pid))->lists();
        //返回上一级
        $backid = 0;//默认为一级目录
        if($pid > 0){
            $parent = $this->db->table('admin_menus')->where(array('mid' => $pid))->item();
            $backid = $parent['pid'];
        }
        $this->assign('pid',$pid);
        $this->assign('backid',$backid);
        $this->assign('data',$data);
        return $this->fetch();
    }
    //保存
    public function save(){
        $pid =(int)(input('post.pid'));
        //接收数组参数要加/a
        $ords = input('post.ords/a');
        $titles = input('post.titles/a');
        $controllers = input('post.controllers/a');
        $methods = input('post.methods/a');
        $ishiddens = input('post.hiddens/a');
        $status = input('post.status/a');

        foreach ($ords as $key => $value){
            //保存一级列表
            $data['pid'] = $pid;
            $data['ord'] = $value;
            $data['title'] = $titles[$key];
            $data['controller'] = $controllers[$key];
            $data['method'] = $methods[$key];
            //状态,是否隐藏,不设置默认为0;
            $data['ishidden'] = isset($ishiddens[$key]) ? 1 : 0;
            $data['status'] = isset($status[$key]) ? 1 : 0;

            if($key == 0 && $data['title']){
                //添加一级目录
                $this->db->table('admin_menus')->insert($data);
            }
            if($key > 0){
                if($data['title'] == '' && $data['controller'] == '' && $data['method'] == ''){
                    //菜单名称，控制器，方法都没有则删除一级目录
                    $this->db->table('admin_menus')->where(array('mid'=>$key))->delete();
                }else{
                    //修改一级目录
                    $this->db->table('admin_menus')->where(array('mid'=>$key))->update($data);
                }
            }
        }
        exit(json_encode(array("code" => 0,"msg" => "保存成功")));
    }
}