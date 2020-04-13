<?php
namespace app\admin\controller;
use Util\database\Sysdb;
/**
 * 管理员管理
 * @package app\admin\controller
 */
class Admin extends Baseadmin
{
    //管理员列表
    public function index(){
        //查询所有管理员
        $data['lists'] = $this->db->table('admin')->lists();
        $data['groups'] = $this->db->table('admin_groups')->cates('gid');
        $this->assign('data',$data);
        return $this->fetch();
    }
    //添加管理员
    public function add(){
        //编辑
        $id = (int)input('get.id');
        //查询要编辑的记录
        $data['item'] = $this->db->table('admin')->where(array('id'=>$id))->item();

        //添加,查询所有角色
        $data['groups'] = $this->db->table('admin_groups')->cates('gid');
        $this->assign('data',$data);
        return $this->fetch();
    }
    //提交管理员
    public function save()
    {
        $id = (int)input('post.id');
        $data['username'] = trim(input('post.username'));
        $data['gid'] = (int)(input('post.gid'));
        $password = trim(input('post.pwd'));
        $data['truename'] = trim(input('post.truename'));
        $data['state'] = trim(input('post.state'));
        //二次验证
        if(!$data['username']){
            exit(json_encode(array('code'=>1,'msg'=>'用户名不能为空')));
        }
        if(!$data['gid']){
            exit(json_encode(array('code'=>1,'msg'=>'请选择角色')));
        }
        if($id == 0 && !$password){
            exit(json_encode(array('code'=>1,'msg'=>'密码不能为空')));
        }
        if(!$data['truename']){
            exit(json_encode(array('code'=>1,'msg'=>'真实姓名不能为空')));
        }

        if($password){
            //密码加密
            $data['password'] = md5($data['username'].$password);
        }
        //编辑管理员不做时修改默认为true
        $res = true;
        if($id == 0){
            //判断用户是否存在
            $item = $this->db->table('admin')->where(array('username'=>$data['username']))->item();
            if($item){
                exit(json_encode(array('code'=>1,'msg'=>'该用户已存在')));
            }
            $data['add_time'] = time();
            $res = $this->db->table('admin')->insert($data);
        }else{
            $this->db->table('admin')->where(array('id' => $id))->update($data);
        }

        if(!$res){
            exit(json_encode(array('code'=>1,'msg'=>'提交失败')));
        }
        exit(json_encode(array('code'=>0,'msg'=>'提交成功')));
    }
    //删除管理员
    public function delete(){
        $id = (int)input('post.id');
        $res = $this->db->table('admin')->where(array('id'=>$id))->delete();
        if(!$res){
            exit(jons_encode(array('code' => 1,'msg' => '删除失败')));
        }
        exit(json_encode(array('code' => 0,'msg' => '删除成功')));
    }
}