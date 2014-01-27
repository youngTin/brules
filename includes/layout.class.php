<?php

/**
 * layout类
 * @version 1.0
 * @created 2009-08-09 03:45:59
 * @author 罗东
 */
 
require_once('BasePage.class.php');
 
class layout extends BasePage {

    /**
    * 构造函数
    * @access public
    */
    public function __construct(){
      parent::__construct();
    }

	/**
	 * 添加数据，成功则返回其主键，失败则返回NULL
	 * 
	 * @param Data
	 */
	public function add($Data = array())
	{
		$this->pdo->add($Data, DB_PREFIX_HOME.'layout_new');
   		return $this->pdo->getLastInsID();
	}

	/**
	 * 根据传入的信息，修改相关的信息，成功返回true，失败返回false
	 * 
	 * @param Data
	 */
	public function update($Data = array(), $id)
	{
		return $this->pdo->update($Data, DB_PREFIX_HOME.'layout_new',"id=".$id);
	}

	/**
	 * 找出符合条件的实体，用一个二维数组的形式返回，无符合条件的数据返回空数组
	 * 
	 * @param Filter string
	 * @param Offset
	 * @param Limit
	 * @param Sort
	 */
	public function find($where, $offset=0, $pageSize=15, $currentPage=1, $order='')
	{
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$select_columns = 'select %s from '.DB_PREFIX_HOME.'layout_new as a %s %s %s';
	    $limit = "limit $offset,$pageSize";
		$sql = sprintf($select_columns,'a.*',$where,$order,$limit);
		$viewData=$this->pdo->getAll($sql);
		return $viewData;
	}

	/**
	 * 找出符合条件的实体，用一个二维数组的形式填充到数组
	 * 
	 * @param Filter
	 * @param Offset
	 * @param Limit
	 * @param Sort
	 */
	public function fitList($Filter=array(), &$viewData, $offset=0, $pageSize=15, $currentPage, $sor =array())
	{
		
	}
	
	/**
	 * 根据传入的条件，返回符合条件的行数
	 * 
	 * @return 符合条件的数量
	 * 
	 * @param Filter
	 */
	public function recordCount($where)
	{
		$select_columns = 'select %s from '.DB_PREFIX_HOME.'layout_new as a %s';
		$sql = sprintf($select_columns,'count(a.id) as cnt',$where);
		$count=$this->pdo->getRow($sql);
		return $count['cnt'];
	}
	
	/**
	 * 返回最后一次选择查询符合条件的记录总数（不受Limit影响）
	 * 
	 */
	public function lastRecordCount()
	{
		//return Dac_Default::$recordcount;
	}

	/**
	 * 删除某个实体，成功返回true，失败返回false
	 * 
	 * @param Data
	 */
	public function delete($Id)
	{
		return $this->pdo->remove("id={$Id}", DB_PREFIX_HOME.'layout_new');
	}

	/**
	 * 禁止/允许某个实例
	 * 
	 * @param id
	 */
	public function toggle($Id)
	{
	}

	/**
	 * 根据传入的主键，取得该项目完整的信息，以一维数组的形式返回
	 * 
	 * @param id
	 */
	public function getFullInfo($Id, &$ViewData)
	{
		$ViewData = $this->pdo->getRow("select a.*,b.* from ".DB_PREFIX_HOME."layout_new as a left join ".DB_PREFIX_HOME."layout_house as b on a.id=b.layout_id where a.id = ".$Id);
	}

	/**
	 * 根据传入的主键，取得该实体常用的信息，以一维数组的形式返回
	 * 
	 * @param id
	 */
	public function getSummaryInfo($Id, &$ViewData)
	{

	}
	
	/**
	 * 根据传入的主键，取得项目名称
	 * 
	 * @param id
	 */
	public function getProjectName($Id)
	{
		$layoutInfo = $this->pdo->getRow("select project_name from ".DB_PREFIX_HOME."layout_new where id = ".$Id);
		return $layoutInfo['project_name'];
	}

	/**
	 * 根据传入的(键-值)判断是否已经存在
	 */
	public function IsExists($Id)
	{

	}

	/**
	 * 根据传入的主键和表名，检测该项目是否有附件（图片、动态、历史价格）信息
	 * 
	 * @param id
	 */
	public function checkPic($Id,$table)
	{
		$layoutInfo = $this->pdo->getRow("select count(id) as cnt from ".$table." where layout_id = '$Id'");
		if($layoutInfo['cnt']>0)
			return true;
		else 
			return false;
	}

	/**
    * 根据user_id得到信息的发布人用户名
    */
	public function getUserName($userId){
		$sql = "select 
		  username 
		from 
		  admin
		where 
		   uid=%d";
		$sql = sprintf($sql, $userId);
		
		// 执行查询
		$userName=$this->pdo->getRow($sql);
		return $userName['username'];
	}
	
	/*************************************************************************************************/
	/*                                      前台调用                                                 */
	/*************************************************************************************************/
	/**
	 * 根据传入的主键,得到该项目动态信息列表，以二维数组的形式返回
	 * 
	 * @param id
	 */
	public function getDynamic($Id,&$ViewData)
	{
		$ViewData = $this->pdo->getAll("SELECT * FROM ".DB_PREFIX_HOME."layout_dynamic where layout_id = '$Id' order by create_at desc limit 5");
		return $ViewData;
	}

	/**
	 * 根据传入的主键,得到该项目周边配套，以二维数组的形式返回
	 * 
	 * @param id
	 */
	public function getFacilities($Id,&$ViewData)
	{
		$ViewData = $this->pdo->getAll("SELECT * FROM ".DB_PREFIX_HOME."layout_facilities where region = '$Id' order by create_at desc");
		return $ViewData;
	}

	/**
	 * 根据传入的(主键-值)，返回该项目的物业类型键值
	 */
	public function getPmType($Id)
	{
		$pmType = $this->pdo->getRow("select pm_type from ".DB_PREFIX_HOME."layout_new where id=".$Id);
		$list = explode(',',$pmType['pm_type']);
		return $list;
	}
	/*********************前台调用 结束********************************************************************/
}
?>