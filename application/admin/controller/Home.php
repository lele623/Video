<?php
namespace app\admin\controller;
use think\Cache;
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
    //清理缓存
    public function clearcache(Cache $cache){
        $cache->clear();
        //获取到缓存文件路径
        $path =CACHE_PATH;
        //清空文件
        $this->deldir($path);
        echo "<h2 style='text-align: center;margin-top: 5%'>请除缓存成功~</h2><script>setTimeout(function(){window.location.href = '/admin/Home/index';}, 1000 )</script>";
    }
    //清空文件夹函数和清空文件夹后删除空文件夹函数的处理
    public function deldir($path){
        //如果是目录则继续
        if(is_dir($path)){
            //扫描一个文件夹内的所有文件夹和文件并返回数组
            $p = scandir($path);
            foreach($p as $val){
                //排除目录中的.和..
                if($val !="." && $val !=".." && $val !="log"){
                    //如果是目录则递归子目录，继续操作
                    if(is_dir($path.$val)){
                        //子目录中操作删除文件夹和文件
                        $this->deldir($path.$val.'/');
                        //目录清空后删除空文件夹
                        @rmdir($path.$val.'/');
                    }else{
                        //如果是文件直接删除
                        @unlink($path.$val);
                    }
                }
            }
        }
    }


}