<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 旅游路线模型
 * @author ld<luodongdaxia@yahoo.com.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: content3.php,v 1.1 2012/02/07 09:03:18 gfl Exp $
 */

	// 加载系统函数
	require_once('../../sys_load.php');
	$verify = new Verify();
	$verify->validate_column();

	//start time
	$time_start = getmicrotime();

	// 生成Smarty 对象
	$smarty = new WebSmarty;
	$pdo = new MysqlPdo();

	//模板路径,生成后自行修改
	$template_edit = "admin/column/content3.tpl";
	$template_list = "admin/column/content3_list.tpl";

	//定义基础信息
	$digest_text = array('0'=>'普通主题','1'=>'栏目推荐','2'=>'站点推荐','3'=>'头条推荐');

	//系统管理员
	$manager=getManager();

	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'add':add(); //添加页面
			exit;
		case 'edit':edit(); //修改页面
			exit;
		case 'save':save(); //修改或添加后的保存方法
			exit;
		case 'index':index(); //列表页面
			exit;
		case 'delete':delete(); //删除单条记录方法
			exit;
		case 'ajaxDigest':ajaxDigest(); //ajax设置置顶
			exit;
		case 'getMid':getMid($_GET['cid']); //ajax设置置顶
			exit;
		case 'order':order();
			exit;
		default:index();
			exit;
	}

	/**
	 * 保存修改或增加到数据库
	 */
	function save()
	{
		if(!$_SESSION['save'])page_msg('你没有权限访问',$isok=false);
		
		global $smarty, $pdo, $manager;
		//标题处理样式
		$titlestyle="";
		if(!empty($_POST['titlecolor']))$titlestyle .= "titlecolor:".$_POST['titlecolor'].";";
		if(isset($_POST['titleb']))$titlestyle .= "titleb:".$_POST['titleb'].";";
		if(isset($_POST['titleii']))$titlestyle .= "titleii:".$_POST['titleii'].";";//斜体
		if(isset($_POST['titleu']))$titlestyle .= "titleu:".$_POST['titleu'].";"; //下划线
		//所属相关类别
		$relatedcid="";
		if(!empty($_POST['relatedcid']))$relatedcid=implode(',',$_POST['relatedcid']);

		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new') {
			// 录入公共信息到模型主表contentindex
			$contentIndex = array("cid"=>isset($_POST['cid'])?$_POST['cid']:'',
							  "mid"=>isset($_POST['mid'])?$_POST['mid']:'',
							  "title"=>isset($_POST['title'])?trim($_POST['title']):'',
							  "photo"=>isset($_POST['photo'])?$_POST['photo']:'',
							  "postdate"=>empty($_POST['postdate'])?date('Y-m-d',time()):$_POST['postdate'],
							  "linkurl"=>isset($_POST['linkurl'])?$_POST['linkurl']:'',
							  "digest"=>isset($_POST['digest'])?$_POST['digest']:0,
							  "publisher"=>$_SESSION['userName'],
							  "titlestyle"=>$titlestyle,
							  "relatedcid"=>$relatedcid,
							  "alias"=>isset($_POST['alias'])?str_ireplace(' ','-',trim($_POST['alias'])):'');
			$pdo->add($contentIndex, DB_PREFIX."contentindex");
			$tid=$pdo->getLastInsID();
			
			// 录入详细信息到旅游路线模型表content3
			$content3 = array("id"=>$tid,
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

			$pdo->add($content3, DB_PREFIX."content3");
			$tid=$pdo->getLastInsID();

			if ($tid) {
				$column = new column();
				$column->addAttachindex($_POST['aid'],$tid,$mid=$_POST['mid']);
				$msg = '添加信息成功';
				$isok=true;
			}else{
				$msg = '添加信息失败';
				$isok=false;
			}
		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['id'])) {
			// 录入公共信息到模型主表contentindex
			$contentIndex = array("cid"=>isset($_POST['cid'])?$_POST['cid']:'',
							  "mid"=>isset($_POST['mid'])?$_POST['mid']:'',
							  "title"=>isset($_POST['title'])?trim($_POST['title']):'',
							  "photo"=>($_POST['photo']?$_POST['photo']:''),
							  "postdate"=>empty($_POST['postdate'])?date('Y-m-d',time()):$_POST['postdate'],
							  "linkurl"=>isset($_POST['linkurl'])?$_POST['linkurl']:'',
							  "digest"=>isset($_POST['digest'])?$_POST['digest']:0,
							  "titlestyle"=>$titlestyle,
							  "relatedcid"=>$relatedcid,
							  "alias"=>isset($_POST['alias'])?str_ireplace(' ','-',trim($_POST['alias'])):'');

			$pdo->update($contentIndex , DB_PREFIX.'contentindex', "id=".$_POST['id']);

			// 修改详细信息到旅游路线模型表content3
			$content3 = array("destinations"=>isset($_POST['destinations'])?$_POST['destinations']:'',
							  "prices"=>isset($_POST['prices'])?$_POST['prices']:'',
							  "departuredates"=>isset($_POST['departuredates'])?$_POST['departuredates']:'',
							  "content"=>isset($_POST['content'])?$_POST['content']:'',
							  "cost"=>isset($_POST['cost'])?$_POST['cost']:'',
							  "sightspot"=>isset($_POST['sightspot'])?$_POST['sightspot']:'',
							  "description"=>isset($_POST['description'])?$_POST['description']:'',
							  "keywords"=>isset($_POST['keywords'])?$_POST['keywords']:'',
							  "weight"=>isset($_POST['weight'])?$_POST['weight']:'',
							  "highlights"=>isset($_POST['highlights'])?$_POST['highlights']:'',
							  "uid"=>isset($_POST['uid'])?$_POST['uid']:$_SESSION['userId'],
							  //"username"=>$manager[$_POST['uid']]
						     );
			$pdo->update($content3 , DB_PREFIX.'content3', "id=".$_POST['id']);
	   		
			$column = new column();
			$column->addAttachindex($_POST['aid'],$_POST['id'],$mid=$_POST['mid']);
			$msg = '修改成功';
			$isok=true;
		}
		page_msg($msg,$isok,$url=$_SERVER['HTTP_REFERER']);
	}

	/**
	 * 输出添加界面
	 */
	function add()
	{
		if(!$_SESSION['add'])page_msg('你没有权限访问',$isok=false);
		
		global $smarty, $pdo, $template_edit,$time_start,$manager;

		$column = new column();
		$column_list = $column->getWebCategory();
		$smarty->assign('menu',$column_list);//得到网站栏目管理列表
		
		foreach($column_list as $key=>$list){
			if($list['mid']==3)$relatedcid=$list['child'];
		}
		$smarty->assign('relatedcid',$relatedcid);
		
		//author
		$smarty->assign('author',$column->getSelectVaule('11'));

		//fromsite
		$smarty->assign('fromsite',$column->getSelectVaule('12'));

		//getall view spot 
		$smarty->assign('allViewSpot',$column->getAllViewSpot());

		//get manager
		$smarty->assign('manager',$manager);

		$smarty->assign('cid',$_GET['cid']);
		$smarty->assign('mid',getMid($_GET['cid']));
		$smarty->assign("EditOption" , 'New');
		$smarty->assign("url" , $_SERVER['HTTP_REFERER']);

		//End time
		$time_end = getmicrotime();
		$time = $time_end - $time_start;
		$smarty->assign("time" , substr($time,0,7));

		$smarty -> show($template_edit);
	}

	/**
	 * 输出编辑界面
	 */
	function edit()
	{
		if(!$_SESSION['edit'])page_msg('你没有权限访问',$isok=false);
		
		global $smarty, $pdo, $template_edit, $time_start,$manager;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 1;
		
		$routeSql="select ct.*,c.* from ".DB_PREFIX."contentindex as ct left join ".DB_PREFIX."content3 as c on ct.id=c.id where ct.id = {$id}";
		$result = $pdo->getRow($routeSql);

		//分解样式字段titlestyle  titlecolor:crimson;titleb:1;
		if(!empty($result['titlestyle'])){
			$styleArray = explode(';',$result['titlestyle']);
			foreach($styleArray as $j){
				if(!empty($j)){
				$aloneStyle=explode(':',$j);
				$result[$aloneStyle[0]]=$aloneStyle[1];}
			}
		}

		$column = new column();
		$column_list = $column->getWebCategory();
		$smarty->assign('menu',$column_list);//得到网站栏目管理列表
		
		foreach($column_list as $key=>$list){
			if($list['mid']==3)$relatedcid=$list['child'];
		}
		$smarty->assign('relatedcid',$relatedcid);
		$result['relatedcid']=explode(',',$result['relatedcid']);

		//this route's all view spot 
		$allViewSpot = $column->getAllViewSpot($result['sightspot']);		
		$smarty->assign('allViewSpot',$allViewSpot);

		//获取该信息的附件图片aid
		$result['aid'] = $column->getAid($result['photo']);

		$result['content']=htmlspecialchars($result['content']);
		$result['highlights']=htmlspecialchars($result['highlights']);
		
		//get manager
		$smarty->assign('manager',$manager);

		$smarty->assign('result',$result);
		$smarty->assign('cid',$result['cid']);
		$smarty->assign('mid',$result['mid']);
		$smarty->assign("EditOption" , 'Edit');
		$smarty->assign("UrlReferer" , $_SERVER['HTTP_REFERER']);
		
		//End time
		$time_end = getmicrotime();
		$time = $time_end - $time_start;
		$smarty->assign("time" , substr($time,0,7));

		$smarty -> show($template_edit);	
	}
	
	/**
	 * 执行删除
	 */
	function delete()
	{
		if(!$_SESSION['delete'])page_msg('你没有权限访问',$isok=false);
		global $pdo, $smarty;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 0;
		$cid = isset($para['cid']) ? $para['cid'] : 0;
		//判断是否有日程信息
		$sql="select count(*) as cnt from itinerary where tid={$id}";
		$itinerary = $pdo->getRow($sql);
		if(!$itinerary['cnt']){
			$pdo->remove("id={$id}",DB_PREFIX."contentindex");
			$pdo->remove("id={$id}",DB_PREFIX."content3");
			$pdo->remove("tid={$id}",DB_PREFIX."attachindex");
			$msg = '删除成功！';
			$isok = true;
		}else{
			$msg='删除失败！请先删除日程信息';
			$isok=false;
		}
		page_msg($msg,$isok,$url=$_SERVER['HTTP_REFERER']);
	}

	/**
	 * 输出列表界面
	 */
	function index()
	{
		
		if(!$_SESSION['index'])page_msg('你没有权限访问',$isok=false);
		global $smarty, $pdo, $template_list, $digest_text, $time_start;
		$page_info = "";
		$orderField = isset($_GET['sort']) ? 'a'.$_GET['sort'] : 'b.weight';
		$orderValue = isset($_GET['flag']) ? $_GET['flag'] : 'asc';

		$pageSize = 15;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		//判断是否是最高管理员，是则查看所以的路线，否则只能查看自己负责的路线
		//$where = 'where uid='.$_SESSION['userId'];
		$where = 'where 1 ';
		if($_SESSION['isAdmin'])$where = 'where 1 ';
	   	if($_GET) {
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	    }
	    $select_columns = "select %s from ".DB_PREFIX."contentindex as a left join ".DB_PREFIX."content3 as b on a.id=b.id %s %s %s";
	    
	    $order = "order by $orderField $orderValue";
	    $limit = "limit $offset,$pageSize";
	    $count = " count(a.id) as count ";
	    $sql = sprintf($select_columns,'a.*,b.username,b.weight',$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();

		$smarty->assign('digest_text',	$digest_text);
		foreach ($res as $key => $item) {
			if(!is_null($item['digest']))$res[$key]['digest_text'] = $digest_text[$item['digest']];
			//统计该路线日程记录条数
			$sqlCount = "select count(id) as cnt from itinerary where tid=".$item['id'];
			$itineraryNum = $pdo->getRow($sqlCount);
			$res[$key]['itineraryNum']=$itineraryNum['cnt'];
			//统计该路线Photo Gallery数
			$sqlCount = "select count(id) as cnt from ".DB_PREFIX."attachindex where mid=3 and tid=".$item['id'];
			$photoNum = $pdo->getRow($sqlCount);
			$res[$key]['photoNum']=$photoNum['cnt'];

		}

		//得到类名
		$smarty->assign('className',getClassName($_GET['cid']));
		$smarty->assign('cid',$_GET['cid']);
		$smarty->assign('mid',getMid($_GET['cid']));
	 	// 查询到的结果
		$smarty->assign('contentindexList', $res);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);

		//End time
		$time_end = getmicrotime();
		$time = $time_end - $time_start;
		$smarty->assign("time" , substr($time,0,7));
		// 指定模板
		$smarty->show($template_list);
	}
	
    function order()
	{
		//if(!$_SESSION['edit'])page_msg('你没有权限访问',$isok=false);
		global $pdo;
		//print_r($_POST);exit;
		if (isset($_POST['taxis'])) {
			foreach($_POST['taxis'] as $key=>$item){
				$content = array("weight"=>$item);
				$pdo->update($content, 'web_content3', "id=".$key);
			}
			$url=$_SERVER['HTTP_REFERER'];
			page_msg($msg='Update successfully!',$isok=true,$url);
			exit;
		}
	}

	/**
	 * 处理get方式传过来的查询条件
	 */
	function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
		if(isset($Data['cid']) && $Data['cid'] != ""){
			$where .=" and a.`cid` = '{$Data['cid']}' or a.relatedcid like '%{$Data['cid']}%'";
			$page_info.="cid={$Data['cid']}&";
			$smarty->assign("cid",$Data['cid']);
		}
		if(isset($Data['title']) && $Data['title'] != ""){
			$where .=" and a.`title` = '{$Data['title']}'";
			$page_info.="title={$Data['title']}&";
			$smarty->assign("title",$Data['title']);
		}
	}

	/**
	 * According to cid be module classname
	 *
	 * @param Data
	 */
	function getClassName($cid)
	{
		global $pdo;
		$className=$pdo->getRow("select name from category where id={$cid}");
		return $className['name'];
	}

	/**
	 * According to cid be module id
	 */
	function getMid($cid)
	{
		global $pdo;
		$Mid=$pdo->getRow("select mid from category where id={$cid}");
		if(@$_GET['action']=='getMid')echo $Mid['mid']; else return $Mid['mid'];
	}
	/**
	 * ajax set essence
	 */
	function ajaxDigest()
	{
		global $pdo;
		$data = array('digest'=>$_GET['digest']);
		return $pdo->update($data , DB_PREFIX.'contentindex', "id=".$_GET['id']);
	}

	/**
	 * 得到后台所有管理人员
	 */
	function getManager()
	{
		global $pdo;
		$manager = $pdo->getAll("select uid,username from admin");
		$rlt = array();
		foreach($manager as $i){
			$rlt[$i['uid']]=$i['username'];
		}
		return $rlt;
	}

?>