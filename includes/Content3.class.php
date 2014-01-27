<?php

/**
 * @name column
 * @function cms系统核心类文件
 * @version 1.0
 * @created 2009-09-09 03:45:59
 * @author 罗东
 */
 
require_once('BasePage.class.php');
 
class Content3 extends BasePage {
	
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
		$rArray['relatedCategory']=$column->getRelatedCategory($rArray['menu'],$this->mid);//得到该类的相关分类
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
		$manager=$this->getManager();
		// 录入详细信息到旅游路线模型表content3
		$content = array("id"=>$tid,
						  "destinations"=>isset($_POST['destinations'])?$_POST['destinations']:'',
						  "prices"=>isset($_POST['prices'])?$_POST['prices']:'',
						  "departuredates"=>isset($_POST['departuredates'])?$_POST['departuredates']:'',
						  "content"=>isset($_POST['content'])?$_POST['content']:'',
						  "cost"=>isset($_POST['cost'])?$_POST['cost']:'',
						  "sightspot"=>isset($_POST['sightspot'])?$_POST['sightspot']:'',
						  "uid"=>isset($_POST['uid'])?$_POST['uid']:$_SESSION['userId'],
						  "username"=>isset($manager[$_POST['uid']])?$manager[$_POST['uid']]:$_SESSION['userName'],
						  "description"=>isset($_POST['description'])?$_POST['description']:'',
						  "keywords"=>isset($_POST['keywords'])?$_POST['keywords']:'',
						  "weight"=>isset($_POST['weight'])?$_POST['weight']:'',
						  "highlights"=>isset($_POST['highlights'])?$_POST['highlights']:''
						  );

	    if($option=='add'){
			$this->pdo->add($content, DB_PREFIX."content1");
			$tid=$this->pdo->getLastInsID();
		}else{
			$this->pdo->update($content , DB_PREFIX.'content1', "id=".$Data['id']);
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

	/************内部操作方法**************/
    /**
	 * 得到后台所有管理人员
	 */
	private function getManager()
	{
		global $pdo;
		$manager = $pdo->getAll("select uid,username from admin");
		$rlt = array();
		foreach($manager as $i){
			$rlt[$i['uid']]=$i['username'];
		}
		return $rlt;
	}
	
}
?>