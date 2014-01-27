<?php

/**
 * @name column
 * @function cms系统核心类文件
 * @version 1.0
 * @created 2009-09-09 03:45:59
 * @author 罗东
 */
 
require_once('BasePage.class.php');
 
class Column extends BasePage {

    /**
    * 构造函数
    * @access public
    */
    public function __construct(){
      parent::__construct();
    }
	
	/**
	 * 主表操作(新增、修改)
	 * @param $Data,POST提交数据,array('id'=>1)
	 * @param option,执行操作类型,$option='add',$option='update'
	 */
	public function addOrUpdateContentIndex($Data,$option='add'){
		if(!empty($Data)){
			//处理titlestyle
			//print_r($Data);
			$titlestyle=$this->processTitleStyle($Data);
			//所属相关类别
			$relatedcid="";
			if(!empty($Data['relatedcid']))$relatedcid=implode(',',$Data['relatedcid']);
			// 录入公共信息到模型主表contentindex
			$contentIndex = array("cid"=>isset($Data['cid'])?$Data['cid']:'',
							  "mid"=>isset($Data['mid'])?$_POST['mid']:'',
							  "title"=>isset($Data['title'])?trim($Data['title']):'',
							  "photo"=>isset($Data['photo'])?$Data['photo']:'',
							  "postdate"=>empty($Data['postdate'])?date('Y-m-d',time()):$Data['postdate'],
							  "linkurl"=>isset($Data['linkurl'])?$Data['linkurl']:'',
							  "digest"=>isset($Data['digest'])?$Data['digest']:0,
							  "publisher"=>$_SESSION['userName'],
							  "titlestyle"=>$titlestyle,
							  "relatedcid"=>$relatedcid,
							  "alias"=>isset($Data['alias'])?str_ireplace(' ','-',trim($Data['alias'])):'',
							  "is_comment"=>isset($Data['is_comment'])?$Data['is_comment']:1);
		}else{page_msg($msg='操作失败！',$isok=false,$url=$_SERVER['HTTP_REFERER']);}
		
		if($option=='add'){
			$this->pdo->add($contentIndex, DB_PREFIX."contentindex");
			$tid=$this->pdo->getLastInsID();
			return $tid;
		}else{
			$this->pdo->update($contentIndex , DB_PREFIX.'contentindex', "id=".$Data['id']);
			return $Data['id'];
		}
	}

	/**
	 * 根据id，得到详细信息
	 * 
	 * @param Data
	 */
	public function getDetailContentInfo($id)
	{
		$contentIndexList = $this->pdo->getRow("select * from ".DB_PREFIX."contentindex where id = {$id}");
		$contentList = $this->pdo->getRow("select * from ".DB_PREFIX."content".$contentIndexList['mid']." where id={$id}" );
		unset($contentList['id']);
		if(!empty($contentList)){
			$result = array_merge($contentIndexList, $contentList);
		}else{
			$result=$contentIndexList;
		}
		return $result;
	}

	/**
	 * 获取该网站栏目管理列表
	 * 
	 * @param Data
	 */
	public function getWebCategory()
	{
		if($_SESSION['isAdmin']){
			$module_sql=" select * from category where mid>0 and depth=1 order by order_list desc";
		}else{
			$module_sql="select c.* from admin_category as uc left join category as c on uc.category_id=c.id where uc.uid=".$_SESSION['userId']." and c.mid>0 and c.depth=1  order by c.order_list desc";
		}
		$module_category = $this->pdo->getAll($module_sql);

		foreach($module_category as $key=>$i){
			$module_category[$key]['child'] = self::getChildCategory($i['id']);
			foreach($module_category[$key]['child'] as $ckey=>$ci){
				$module_category[$key]['child'][$ckey]['child'] = self::getChildCategory($ci['id']);
			}
		}
		return $module_category;
	}

	/**
	 * 得到该网站的相关栏目列表
	 */
	 function getRelatedCategory($menu,$mid){
		$relatedcategory=array();
		foreach($menu as $list){
			if($list['mid']==$mid)$relatedcategory[]=$list;
		}
		return $relatedcategory;
	 }

	/**
	 * 根据cid,获得内容信息标题
	 */
	function getCategoryInfo($cid)
	{
		$sql = "select * from category where id={$cid}";
		$info=$this->pdo->getRow($sql);
		return $info;
	}

	/**
	 * 根据id,获得内容信息标题
	 */
	function getContentName($id)
	{
		$sql = "select title from ".DB_PREFIX."contentindex where id={$id}";
		$info=$this->pdo->getRow($sql);
		return $info['title'];
	}

	/**
	 * 根据栏目cid，得到栏目classname
	 *
	 * @param Data
	 */
	function getClassName($cid)
	{
		$className=$this->pdo->getRow("select name from category where id={$cid}");
		return $className['name'];
	}

	/**
	 * 根据栏目cid，得到模型mid
	 */
	function getMid($cid)
	{
		$Mid=$this->pdo->getRow("select mid from category where id={$cid}");
		return $Mid['mid'];
	}

	/**
	 * 根据栏目id，得到模型mid
	 */
	function getMid2($id)
	{
		$sql = "select mid from ".DB_PREFIX."contentindex where id={$id}";
		$info=$this->pdo->getRow($sql);
		return $info['mid'];
	}

	/**
	 * 根据web_contentindex表中的photo信息,获取该图片的aid
	 */
	function getAid($photo)
	{
		$photo = str_ireplace("_s.", ".", $photo);
		$Aid=$this->pdo->getRow("select aid from web_attach where filepath='{$photo}'");
		return $Aid['aid'];
	}

	/**
	 * According to selectid be selectvalue
	 * 
	 * @param id
	 */
	public function getSelectVaule($selectId){
		$selectValue=$this->pdo->getAll("select * from ".DB_PREFIX."selectvalue where selectid=".$selectId);
		$keyValue=array();
		foreach($selectValue as $item){
			$keyValue[$item['valueid']]=$item['value'];
		}
		return $keyValue;
	}

	/**
	 * add selectvalue
	 */
	public function addSelectVaule($selectId,$selectValue){
		if(!empty($selectValue)){
			$countValue=$this->pdo->getRow("select count(valueid) as cnt from ".DB_PREFIX."selectvalue where value='".$selectValue."' and selectid=".$selectId);
			if(!$countValue['cnt']){
				$this->pdo->add(array('selectid'=>$selectId,'usetime'=>time(),'value'=>$selectValue), DB_PREFIX."selectvalue");
			}
		}
	}
	
	 /**
	 * add info to attachindex
	 */
	 public function addAttachindex($aid,$tid,$mid){
		 if($aid==0){
			//$this->pdo->remove("mid='".$mid."' and tid=".$tid,DB_PREFIX."attachindex");
			$this->pdo->update(array('pic_type'=>'photo'),DB_PREFIX."attachindex", "mid='".$mid."' and tid=".$tid);
		 }else{
			$this->pdo->update(array('pic_type'=>'photo'),DB_PREFIX."attachindex", "mid='".$mid."' and tid=".$tid);
			//查询插入的相关图片是否存在 附件关联表中 web_attachindex
			$isInsertSql = "select id,aid from ".DB_PREFIX."attachindex where mid='{$mid}' and tid={$tid} and aid={$aid}";
			$infoInsert=$this->pdo->getRow($isInsertSql);
			if(isset($infoInsert['id'])){
				$this->pdo->update(array('pic_type'=>'Relevant pictures'),DB_PREFIX."attachindex", "mid='".$mid."' and tid=".$tid." and aid=".$aid);
			}else{
				$this->pdo->add(array('mid'=>$mid,'tid'=>$tid,'aid'=>$aid,'pic_type'=>'Relevant pictures'),DB_PREFIX."attachindex");
			}
		 }
	 }

	 /**
	 * 删除attachindex表中的记录信息，同时如果该附件没引用，则删除attach表中信息，清除附件文件
	 */
	 public function delAttach($tid,$mid){
		 $isSql = "select a.*,b.filepath from ".DB_PREFIX."attachindex as a left join ".DB_PREFIX."attach as b on a.aid=b.aid where a.mid='{$mid}' and a.tid={$tid}";
		 $info=$this->pdo->getRow($isSql);
		 if(isset($info['id'])){
			//remove
			$this->pdo->remove("id=".$info['id'],DB_PREFIX."attachindex");
			$isQuote = $this->pdo->getRow('select count(*) as cnt from '.DB_PREFIX.'attachindex where aid='.$info['aid']);
			if(!$isQuote['cnt']){
				delete_file($info['filepath']);
				delete_file(str_ireplace(".","_s.",$info['filepath']));
				$this->pdo->remove("aid=".$info['aid'],DB_PREFIX."attach");
			}
		 }
	 }
	
	/****************************内部方法**********************************/
	/**
	 * 处理文件标题样式信息，titlestyle
	 * @param $Data,POST提交数据,array('titlecolor'=>'#fff','titleb'=>1,'titleii'=>1,'titleu'=>0)
	 */
	 private function processTitleStyle($Data){
		//标题处理样式
		$titlestyle='';
		if(!empty($Data['titlecolor']))$titlestyle .= "titlecolor:".$Data['titlecolor'].";";
		if(isset($Data['titleb']))$titlestyle .= "titleb:".$Data['titleb'].";";
		if(isset($Data['titleii']))$titlestyle .= "titleii:".$Data['titleii'].";";//斜体
		if(isset($Data['titleu']))$titlestyle .= "titleu:".$Data['titleu'].";"; //下划线
		return $titlestyle;
	 }

	/**
	 * 根据pid，获取pid的下级分类栏目信息
	 */
	private function getChildCategory($pid){
		if($_SESSION['isAdmin']){
			$module_child_sql="select * from category where mid>0 and parent_id=".$pid."  order by order_list desc";
		}else{
			$module_child_sql="select c.* from admin_category as uc left join category as c on uc.category_id=c.id where uc.uid=".$_SESSION['userId']." and c.mid>0 and c.parent_id=".$pid."  order by c.order_list desc";
		}
		$result = $this->pdo->getAll($module_child_sql);
		return $result;
	}


	/*****下面两个方法，根据功能来说，应该不属于该类********/
	/**
	 * getall view spot
	 */
	 public function getAllViewSpot($str=''){
		  $keyValue = array();
		  if(!empty($str)){
				$pieces = explode("-->", $str);
				foreach($pieces as $item){
					$box = explode(".", $item);
					$keyValue[]=$box[0];
				}
		  }
		  
		  $all=$this->pdo->getAll("select ct.id,ct.cid,ct.title,c.name from ".DB_PREFIX."contentindex as ct left join category as c on ct.cid=c.id where ct.mid=2 and cid>0");
		  $allViewSpot=array();
		  $list=array();
		  foreach($all as $key=>$item){
				if(!in_array($item['cid'],$list)){
					$allViewSpot[$item['cid']]['name']=$item['name'];
				}
				if(count($keyValue)){
					if(in_array($item['id'],$keyValue))$item['flag']=1;else $item['flag']=0;
				}
				$allViewSpot[$item['cid']]['child'][]=$item;
		  }
		  return $allViewSpot;
	 }

	/**
	 * explode sightspot,key-value pair(key = value) 
	 * 85.布达拉宫-->89.唐古拉山-->68.纳木措湖
	 */
	 public function explodeSightspot($str){
		 $pieces = explode("-->", $str);
		 $keyValue = array();
		 foreach($pieces as $item){
			$box = explode(".", $item);
			$keyValue[$box[0]]=$box[1];
		 }
		 return $keyValue;
	 }

}
?>