<?php
namespace Util\data;
use think\Db;

/**
 * 
 */
class Sysdb
{
	
	//构造数据库访问的方法
	//表名
	public function table($table)
	{
		$this->where =array();
		$this->field ='*';
		$this->table = $table;
		return $this;
	}

	//指定查询字段
	public function field($field ='*')
	{
		$this->field =$field;
		return $this;	
	}
	// 排序
	public function order($order){
		$this->order = $order;
		return $this;
	}


	//指定查询条件
	public function where($where = array())
	{
		$this->where =$where;
		return $this;
	}

	//返回一条记录
	public function item()
	{
		$item =Db::name($this->table)->field($this->field)->where($this->where)->find();
		return $item ? $item :false;
	}

	//查询列表,返回列表
	public function lists()
	{
		$lists =Db::name($this->table)->field($this->field)->where($this->where)->select();
		return $lists ?$lists :false;
	}
	//自定索引列表
	public function cates($index){
		$lists =Db::name($this->table)->field($this->field)->where($this->where)->select();
		if(!$lists)
		{
			return false;
		}
		$results =[];
		foreach ($lists as $key => $value) {
			$results[$value[$index]]= $value;
			
		}
		return $results;
	}

	// 添加
	public function insert($data){
		$res = Db::name($this->table)->insert($data);
		return $res;
	}

	// 修改
	public function update($data){
		$res = Db::name($this->table)->where($this->where)->update($data);
		return $res;
	}
	// 删除
	public function delete(){
		$res = Db::name($this->table)->where($this->where)->delete();
		return $res;
	}

	//分页的方法
	public function pages($pageSize = 10){
		$total = Db::name($this->table)->where($this->where)->count();
		$query = Db::name($this->table)->field($this->field)->where($this->where);
		$this->order && $query = $query->order($this->order);
		$data = $query->paginate($pageSize,$total);
		return array('total'=>$total,'lists'=>$data->items(),'pages'=>$data->render());
	}

}