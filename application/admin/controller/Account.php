<?php
namespace  app\admin\controller;
use think\Controller;
use Util\database\Sysdb;

/**
 * 登陆页
 * @package app\admin\controller
 */
class Account extends Controller
{
    //登陆页面
    public function login(){
        return $this->fetch();
    }
    //登陆验证
    public function dologin(){
        $username = trim(input('post.username'));
        $password = trim(input('post.password'));
        if($username == ''){
            exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
        }
        if($password == ''){
            exit(json_encode(array('code'=>1,'msg'=>'密码不能为空')));
        }
        // 验证用户
        $this->db = new Sysdb;
        $admin = $this->db->table('admin')->where(array('username'=>$username))->item();
        if(!$admin){
            exit(json_encode(array('code'=>1,'msg'=>'用户不存在')));
        }
        if(md5($admin['username'].$password) != $admin['password']){
            exit(json_encode(array('code'=>1,'msg'=>'密码错误')));
        }
        //判断是否被禁用
        if($admin['state'] == '1'){
            exit(json_encode(array('code'=>1,'msg'=>'用户已被禁用')));
        }
        // 设置用户session
        session('admin',$admin);
        exit(json_encode(array('code'=>0,'msg'=>'登录成功')));
    }
}