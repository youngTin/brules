<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 新闻模型
 * @author ld<luodongdaxia@yahoo.com.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: content1.php,v 1.1 2012/02/07 09:03:18 gfl Exp $
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
	$template_edit = "admin/column/content1.tpl";
	$template_list = "admin/column/content1_list.tpl";

	//定义基础信息
	$digest_text = array('0'=>'普通主题','1'=>'栏目推荐','2'=>'站点推荐','3'=>'头条推荐');

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
		
		global $smarty, $pdo;
		//标题处理样式
		$titlestyle="";
		if(!empty($_POST['titlecolor']))$titlestyle .= "titlecolor:".$_POST['titlecolor'].";";
		if(isset($_POST['titleb']))$titlestyle .= "titleb:".$_POST['titleb'].";";
		if(isset($_POST['titleii']))$titlestyle .= "titleii:".$_POST['titleii'].";";//斜体
		if(isset($_POST['titleu']))$titlestyle .= "titleu:".$_POST['titleu'].";"; //下划线

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
							  "alias"=>isset($_POST['alias'])?str_ireplace(' ','-',trim($_POST['alias'])):'');
			$pdo->add($contentIndex, DB_PREFIX."contentindex");
			$tid=$pdo->getLastInsID();
			// 录入详细信息到新闻模型表content1
			$content1 = array("id"=>$tid,
							  "content"=>isset($_POST['content'])?$_POST['content']:'',
							  "intro"=>isset($_POST['intro'])?$_POST['intro']:'',
							  "author"=>isset($_POST['author'])?$_POST['author']:'',
							  "fromsite"=>isset($_POST['fromsite'])?$_POST['fromsite']:''
			                  );

			$pdo->add($content1, DB_PREFIX."content1");
			$tid=$pdo->getLastInsID();
			
			if ($tid) {
				$column = new column();
				$column->addSelectVaule('11',$_POST['author']);
				$column->addSelectVaule('12',$_POST['author']);
				$column->addAttachindex($_POST['aid'],$tid,$mid=$_POST['mid']);
				$msg = '添加信息成功';
				$isok=true;
			}else{
				$msg = '添加信息失败';
				$isok=false;
			}
		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['id'])) {		
			// 修改详细信息到新闻模型表content1
			$content1 = array("content"=>$_POST['content'],
							  "intro"=>$_POST['intro'],
							  "author"=>$_POST['author'],
							  "fromsite"=>$_POST['fromsite']);
					//print_r($content1['content']);exit;
			$pdo->update($content1 , DB_PREFIX.'content1', "id=".$_POST['id']);
			// 录入公共信息到模型主表contentindex
			$contentIndex = array("cid"=>isset($_POST['cid'])?$_POST['cid']:'',
							  "mid"=>isset($_POST['mid'])?$_POST['mid']:'',
							  "title"=>isset($_POST['title'])?trim($_POST['title']):'',
							  "photo"=>isset($_POST['photo'])?$_POST['photo']:'',
							  "postdate"=>isset($_POST['postdate'])?$_POST['postdate']:'',
							  "linkurl"=>isset($_POST['linkurl'])?$_POST['linkurl']:'',
							  "digest"=>isset($_POST['digest'])?$_POST['digest']:0,
							  //"publisher"=>$_SESSION['userName'],
							  "titlestyle"=>$titlestyle,
							  "alias"=>isset($_POST['alias'])?str_ireplace(' ','-',trim($_POST['alias'])):'');
			$pdo->update($contentIndex , DB_PREFIX.'contentindex', "id=".$_POST['id']);
	   		
			$column = new column();
			$column->addSelectVaule('11',$_POST['author']);
			$column->addSelectVaule('12',$_POST['author']);
			$column->addAttachindex($_POST['aid'],$_POST['id'],$mid=$_POST['mid']);
			$msg = '修改成功';
			$isok = true;
		}
		page_msg($msg,$isok,$url=$_SERVER['HTTP_REFERER']);
	}

	/**
	 * 输出添加界面
	 */
	function add()
	{
		if(!$_SESSION['add'])page_msg('你没有权限访问',$isok=false);
		global $smarty, $pdo, $template_edit,$time_start;

		$column = new column();
		$smarty->assign('menu',$column->getWebCategory());//得到网站栏目管理列表
		
		//author
		$smarty->assign('author',$column->getSelectVaule('11'));

		//fromsite
		$smarty->assign('fromsite',$column->getSelectVaule('12'));

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
		global $smarty, $pdo, $template_edit, $time_start;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 1;
		
		$valueList = $pdo->getRow("select * from ".DB_PREFIX."contentindex where id = {$id}");
		$detailList = $pdo->getRow("select content,intro,author,fromsite from ".DB_PREFIX."content1 where id={$id}" );
		$result = array_merge($valueList, $detailList);
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
		$smarty->assign('menu',$column->getWebCategory());//得到网站栏目管理列表
		
		//author
		$smarty->assign('author',$column->getSelectVaule('11'));

		//fromsite
		$smarty->assign('fromsite',$column->getSelectVaule('12'));

		//获取该信息的附件图片aid
		$result['aid'] = $column->getAid($result['photo']);
		
		$result['content']=htmlspecialchars($result['content']);
		$result['intro']=htmlspecialchars($result['intro']);
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
		global $pdo,$smarty;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 0;
		$cid = isset($para['cid']) ? $para['cid'] : 0;
		$pdo->update(array('cid'=>-1) , DB_PREFIX.'contentindex', "id=".$id);
		//insert recycle table's
		$recycle = array('tid'=>$id,'cid'=>$cid,'deltime'=>time(),'admin'=>$_SESSION['userName']);
		$rid = $pdo->add($recycle,DB_PREFIX.'recycle');
		if($rid){
			$msg = '删除成功！';
			$isok=true;
		}else{
			$msg='删除失败！';
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
		$orderField = isset($_GET['sort']) ? 'a'.$_GET['sort'] : 'a.comnum';
		$orderValue = isset($_GET['flag']) ? $_GET['flag'] : 'asc';

		$pageSize = 15;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$where = 'where 1 ';
	   	if($_GET) {
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	    }
	    $select_columns = "select %s from ".DB_PREFIX."contentindex as a %s %s %s";
	    
	    $order = "order by $orderField $orderValue";
	    $limit = "limit $offset,$pageSize";
	    $count = " count(a.id) as count ";
	    $sql = sprintf($select_columns,'a.*',$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,$page_info,2);
		$splitPageStr=$page->get_page_html();

		$smarty->assign('digest_text',	$digest_text);
		foreach ($res as $key => $item) {
			if(!is_null($item['digest']))$res[$key]['digest_text'] = $digest_text[$item['digest']];
			//统计内容Photo Gallery数
			$sqlCount = "select count(id) as cnt from ".DB_PREFIX."attachindex where mid=1 and tid=".$item['id'];
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
				$content = array("comnum"=>$item);
				$pdo->update($content, 'web_contentindex', "id=".$key);
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
		if($_GET['action']=='getMid')echo $Mid['mid']; else return $Mid['mid'];
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
?>