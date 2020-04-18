<?php
namespace app\admin\controller;
use Util\database\Sysdb;

/**
 * 角色管理
 * @package app\admin\controller
 */
class Roles extends Baseadmin
{
    public function index()
    {
        //角色列表查询
        $data['roles'] = $this->db->table('admin_groups')->lists();
        $this->assign('data',$data);
        return $this->fetch();
    }
    //角色添加编辑
    public function add(){
        $menus_list = $this->db->table('admin_menus')->where(array('status' => 0))->cates('mid');
        $menus = $this->gettreeitems($menus_list);
        $results = array();
        foreach ($menus as $value){
            $value['children'] = isset($value['children']) ? $this->formatMenus($value['children']) : false;
            $results[] = $value;
        }
        $this->assign('menus',$results);
        return $this->fetch();
    }
    //角色添加编辑 无限极分类
    private function gettreeitems($items){
        $tree = array();
        foreach ($items as $item){
            if(isset($items[$item['pid']])){
                $items[$item['pid']]['children'][] = &$items[$item['mid']];
            }else{
                $tree[] = &$items[$item['mid']];
            }
        }
        return $tree ;
    }
    //角色添加编辑 无限极分类转二级分类
    private function formatMenus($items,&$res = array()){
        foreach ($items as $item){
            if(!isset($item['children'])){
                $res[] = $item;
            }else{
                $tem = $item['children'];
                unset($item['children']);
                $res[] = $item;
                $this->formatMenus($tem,$res);
            }
        }
        return $res;
    }
    //保存
    public function save(){
        $data['title'] = trim(input('post.title'));
        $menus = input('post.menu/a');
        if($data['title']){
            exit(json_encode(array('code'=>1,'mag'=>'角色名称不能为空')));
        }
        //如果设置了权限则转化为json格式存入数据库
        $menus && $data['rights'] = json_encode($menus);

        $this->db->table(['admin_groups'])->insert($data);
        exit(json_encode(array('code'=>0,'msg'=>'保存成功')));

    }
}