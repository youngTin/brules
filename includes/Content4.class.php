<?php

/**
 * @name column
 * @function cms系统核心类文件
 * @version 1.0
 * @created 2009-09-09 03:45:59
 * @author 罗东
 */
 
require_once('BasePage.class.php');
 
class Content4 extends BasePage {
	
	/**
    * 功能mid
    * @var integer
	* @access private
    */
	private $mid  = 0;

    /**
    * 构造函数
    * @access public
    */
    public function __construct($mid){
      parent::__construct();
	  $this->mid=$mid;
    }

	/**
	 * 输出添加信息界面(add和edit编辑模板的输出数据)
	 * 
	 * @param Data
	 */
	public function exportCommonContent()
	{
		$column = new Column();
		$rArray = array();
		$rArray['menu']=$column->getWebCategory();//得到网站栏目管理列表
		return $rArray;
	}

	/**
	 * 附表操作(新增、修改)
	 * @param $Data,POST提交数据,array('id'=>1)
	 * @param $id,操作数据的id
	 * @param option,执行操作类型,$option='add',$option='update'
	 */
	public function addOrUpdateContent($Data,$tid,$option='add')
	{
		// 录入详细信息到新闻模型表content1
		$content = array("id"=>$tid,
						 "intro"=>isset($Data['intro'])?$Data['intro']:'');
	    if($option=='add'){
			$this->pdo->add($content, DB_PREFIX."content4");
			$tid=$this->pdo->getLastInsID();
		}else{
			$this->pdo->update($content , DB_PREFIX.'content4', "id=".$Data['id']);
			$tid=$Data['id'];
		}
		return $tid;
	}
	
	/**
	 * 高级所搜
	 */
	public function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
		if(isset($Data['cid']) && $Data['cid'] != ""){
			$where .=" and a.`cid` = '{$Data['cid']}'";
			$page_info.="cid={$Data['cid']}&";
			$smarty->assign("cid",$Data['cid']);
		}
		if(isset($Data['title']) && $Data['title'] != ""){
			$where .=" and a.`title` = '{$Data['title']}'";
			$page_info.="title={$Data['title']}&";
			$smarty->assign("title",$Data['title']);
		}
	}

}
?>