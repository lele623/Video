<?php
namespace Util\database;
use think\Db;

/**
 * 数据库处理类
 * @package Util\database
 */
class Sysdb
{
    //获取表名
    public function table($table)
    {
        $this->where=array();
        $this->field='*';
        $this->table=$table;
        return $this;
    }
    //获取查询字段
    public function field($field='*')
    {
        $this->field=$field;
        return $this;
    }
    //获取条件
    public function where($where)
    {
        $this->where=$where;
        return $this;
    }
    //返回记录
    public function item()
    {
        $item=Db::name($this->table)->field($this->field)->where($this->where)->find();
        return $item ? $item:false;
    }
    //查询列表
    public function lists()
    {
        $lists=Db::name($this->table)->field($this->field)->where($this->where)->select();
        return $lists ? $lists:false;
    }
    //查询结果自定义索引列表
    public function cates($index){
        $lists=Db::name($this->table)->field($this->field)->where($this->where)->select();
        if(!$lists){
            return false;
        }
        $results = [];
        foreach ($lists as  $key => $value ){
            $results[$value[$index]] = $value;
        }
        return $results;
    }
    //添加数据
    public function insert($data){
        $res = Db::name($this->table)->insert($data);
        return $res;
    }
    //修改数据
    public function update($data){
        $res = Db::name($this->table)->where($this->where)->update($data);
        return $res;
    }
    //删除数据
    public function delete(){
        $res = Db::name($this->table)->where($this->where)->delete();
        return $res;
    }
}