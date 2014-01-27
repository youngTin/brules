<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 新闻模型
 * @author ld<luodongdaxia@163.com>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: content.php,v 1.1 2012/02/07 09:03:18 gfl Exp $
 */

	// 加载系统函数
	require_once('../../sys_load.php');

	$verify = new Verify();
	$verify->validate_column();
	// 生成Column 对象
	$column = new Column();
	
	//首先获取通过cid,得到mid
	$cid = intval(isset($_GET['cid']) ? $_GET['cid'] : $_POST['cid']);

	//根据模型mid，声明对于模型类
	$mid = $column->getMid($cid);
	if($mid){
		eval('$content=new Content'.$mid.'('.$mid.');');
	}else{
		page_msg($msg='信息出错，请返回！',$isok=false,$url=$_SERVER['HTTP_REFERER']);
	}

	// start time
	$time_start = getmicrotime();

	// 生成Smarty 对象
	$smarty = new WebSmarty;

	// 定义基础信息
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
		case 'ajaxMid':ajaxMid(); //ajax获得mid
			exit;
		case 'option':option();
			exit;
		case 'order':order();
			exit;
		case 'pubview':pubview();
			exit;
		case 'pubcancel':pubcancel();
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
		global $smarty,$column,$content;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new') {
			// 录入公共信息到模型主表contentindex、主要信息出入content表
			$tid=$column->addOrUpdateContentIndex($_POST,$option='add');
			
			$mid=$column->getMid2($tid);
			$result = $content->addOrUpdateContent($_POST,$tid,$option='add');
			if ($result) {
				$column->addAttachindex($_POST['aid'],$tid,$mid=$_POST['mid']);
				$msg = '添加信息成功';
				$isok=true;
			}else{
				$msg = '添加信息失败';
				$isok=false;
			}
		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['id'])) {		// 录入公共信息到模型主表contentindex
			$column=new Column();
			$tid=$column->addOrUpdateContentIndex($_POST,$option='update');
			$mid=$column->getMid2($tid);
			$result = $content->addOrUpdateContent($_POST,$tid,$option='update');
			if ($result) {
				$column->addAttachindex($_POST['aid'],$tid,$mid=$_POST['mid']);
				$msg = '添加信息成功';
				$isok=true;
			}else{
				$msg = '添加信息失败';
				$isok=false;
			}
		}
		page_msg($msg,$isok,$url=$_SERVER['HTTP_REFERER']);
	}

	/**
	 * 输出添加界面
	 */
	function add()
	{
		if(!$_SESSION['add'])page_msg('你没有权限访问',$isok=false);
		global $smarty,$column,$content, $time_start,$mid,$cid;
		if($cid && $mid){
			$result = $content->exportCommonContent();
			$categoryInfo = $column->getCategoryInfo($cid);//获得该栏目信息
			$result['content'] = $categoryInfo['description'];
			$result['cid']=$cid;
			$result['mid']=$mid;
			$result['EditOption']='New';
			$result['url']=$_SERVER['HTTP_REFERER'];
			$smarty->assign("result" , $result);
			//End time
			$time_end = getmicrotime();
			$time = $time_end - $time_start;
			$smarty->assign("time" , substr($time,0,7));
			$smarty -> show('admin/column/content'.$result['mid'].'.tpl');
		}else{
			header('Location:'.$_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * 输出编辑界面
	 */
	function edit()
	{
		if(!$_SESSION['edit'])page_msg('你没有权限访问',$isok=false);
		global $smarty, $time_start,$column,$content,$mid,$cid;

		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if($id){
			$result1 = $column->getDetailContentInfo($id);
			$result2 = $content->exportCommonContent();
			$result = array_merge($result1, $result2);
			$result['relatedcid']=explode(',',$result['relatedcid']);

			//分解样式字段titlestyle  titlecolor:crimson;titleb:1;
			if(!empty($result['titlestyle'])){
				$styleArray = explode(';',$result['titlestyle']);
				foreach($styleArray as $j){
					if(!empty($j)){
					$aloneStyle=explode(':',$j);
					$result[$aloneStyle[0]]=$aloneStyle[1];}
				}
			}

			//获取该信息的附件图片aid
			$result['aid'] = $column->getAid($result['photo']);
			
			@$result['content']=stripslashes(htmlspecialchars($result['content']));
			@$result['intro']=stripslashes(htmlspecialchars($result['intro']));

			$result['EditOption']='Edit';
			$result['url']=$_SERVER['HTTP_REFERER'];
			$smarty->assign('result',$result);

			//End time
			$time_end = getmicrotime();
			$time = $time_end - $time_start;
			$smarty->assign("time" , substr($time,0,7));
			$smarty -> show('admin/column/content'.$result['mid'].'.tpl');
		}else{
			page_msg($msg='操作失败！',$isok=true,$url=$_SERVER['HTTP_REFERER']);
		}
	}
	
	/**
	 * 执行删除
	 */
	function delete()
	{
		if(!$_SESSION['delete'])page_msg('你没有权限访问',$isok=false);
		global $smarty;
		$pdo = new MysqlPdo();

		//$para = formatParameter($_GET["sp"], "out");
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$mid = isset($_GET['mid']) ? $_GET['mid'] : 0;
		$cid = isset($_GET['cid']) ? $_GET['cid'] : 0;
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
	{	ob_clean();
		if(!$_SESSION['index'])page_msg('你没有权限访问',$isok=false);
		global $smarty, $digest_text,$content, $time_start,$column,$mid;
		$pdo=new MysqlPdo();
		$smarty->assign('className',$column->getClassName($_GET['cid']));
		$smarty->assign('cid',$_GET['cid']);
		$smarty->assign('mid',$mid);

		$page_info = "";
		$orderField = isset($_GET['sort']) ? 'a'.$_GET['sort'] : 'a.id';
		$orderValue = isset($_GET['flag']) ? $_GET['flag'] : 'desc';

		$pageSize = 15;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$where = 'where 1 ';
	   	if($_GET) {
	    	$content->advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	    }
	    $select_columns = "select %s from ".DB_PREFIX."contentindex as a left join ".DB_PREFIX."content".$mid." as b on a.id=b.id %s %s %s";
	    $order = "order by $orderField $orderValue";
	    $limit = "limit $offset,$pageSize";
	    $count = " count(a.id) as count ";
	    $sql = sprintf($select_columns,'b.*,a.*',$where,$order,$limit);
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
			$sqlCount = "select count(id) as cnt from ".DB_PREFIX."attachindex where mid=".$mid." and tid=".$item['id'];
			$photoNum = $pdo->getRow($sqlCount);
			$res[$key]['photoNum']=$photoNum['cnt'];
		}

		// 查询到的结果
		$smarty->assign('contentindexList', $res);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);

		//End time
		$time_end = getmicrotime();
		$time = $time_end - $time_start;
		$smarty->assign("time" , substr($time,0,7));
		// 指定模板
		$smarty -> show('admin/column/content'.$mid.'_list.tpl');
	}

	/**
	 * 集体操作
	 */
	function option()
	{
		$pdo = new MysqlPdo();
		//排序
		if($_POST['job']=='order'){
			if (isset($_POST['taxis'])) {
				foreach($_POST['taxis'] as $key=>$item){
					$content = array("comnum"=>$item);
					$pdo->update($content, 'web_contentindex', "id=".$key);
				}
				$url=$_SERVER['HTTP_REFERER'];
				page_msg($msg='排序成功!',$isok=true,$url);
				exit;
			}
		}
		//发布信息
		if($_POST['job']=='pubview'){
			if(@!$_SESSION['option'])page_msg('你没有权限访问',$isok=false);
			if (isset($_POST['ids'])) {
				foreach($_POST['ids'] as $key=>$item){
					$content = array("ifpub"=>1);
					$pdo->update($content, 'web_contentindex', "id=".$item);
				}
				$url=$_SERVER['HTTP_REFERER'];
				page_msg($msg='审核成功!',$isok=true,$url);
				exit;
			}
		}
		//取消发布信息
		if($_POST['job']=='pubcancel'){
			if(@!$_SESSION['option'])page_msg('你没有权限访问',$isok=false);
			if (isset($_POST['ids'])) {
				foreach($_POST['ids'] as $key=>$item){
					$content = array("ifpub"=>0);
					$pdo->update($content, 'web_contentindex', "id=".$item);
				}
				$url=$_SERVER['HTTP_REFERER'];
				page_msg($msg='取消审核成功!',$isok=true,$url);
				exit;
			}
		}
		//删除
		if($_POST['job']=='delete'){
			if(!$_SESSION['delete'])page_msg('你没有权限访问',$isok=false);
			$cid = isset($_GET['cid']) ? $_GET['cid'] : 0;
			if (isset($_POST['ids'])) {
				foreach($_POST['ids'] as $key=>$item){
					$pdo->update(array('cid'=>-1) , DB_PREFIX.'contentindex', "id=".$item);
					//insert recycle table's
					$recycle = array('tid'=>$item,'cid'=>$cid,'deltime'=>time(),'admin'=>$_SESSION['userName']);
					$rid = $pdo->add($recycle,DB_PREFIX.'recycle');
				}
				$url=$_SERVER['HTTP_REFERER'];
				page_msg($msg='删除成功!',$isok=true,$url);
				exit;
			}
		}
		//永久删除
		if($_POST['job']=='destroy'){
			if(@!$_SESSION['destroy'])page_msg('你没有权限访问',$isok=false);
			$mid = isset($_GET['mid']) ? $_GET['mid'] : 0;
			if (isset($_POST['ids'])) {
				foreach($_POST['ids'] as $key=>$item){
					//如果有附件图片，则删除attachindex表中的记录信息
					$pdo->remove("tid={$item} and mid=".$mid,DB_PREFIX."attachindex");
					$pdo->remove("id={$item}",DB_PREFIX."content".$mid);
					$pdo->remove("id={$item}",DB_PREFIX."contentindex");
				}
				$url=$_SERVER['HTTP_REFERER'];
				page_msg($msg='该功能未实现!',$isok=true,$url);
				exit;
			}
		}
	}
	
	/**
	 * 单独操作-排序
	 */
	function order()
	{
		//if(!$_SESSION['edit'])page_msg('你没有权限访问',$isok=false);
		$pdo = new MysqlPdo();
		if (isset($_POST['taxis'])) {
			foreach($_POST['taxis'] as $key=>$item){
				$content = array("comnum"=>$item);
				$pdo->update($content, 'web_contentindex', "id=".$key);
			}
			$url=$_SERVER['HTTP_REFERER'];
			page_msg($msg='排序成功!',$isok=true,$url);
			exit;
		}
	}
	/**
	 * 单独操作-发布信息
	 */
	function pubview()
	{
		if(@!$_SESSION['option'])page_msg('你没有权限访问',$isok=false);
		$pdo = new MysqlPdo();
		if (isset($_GET['id'])) {		
				$content = array("ifpub"=>1);
				$pdo->update($content, 'web_contentindex', "id=".$_GET['id']);
				$url=$_SERVER['HTTP_REFERER'];
				page_msg($msg='审核成功!',$isok=true,$url);
				exit;
		}
	}
	/**
	 * 单独操作-取消发布
	 */
	function pubcancel()
	{
		if(@!$_SESSION['option'])page_msg('你没有权限访问',$isok=false);
		$pdo = new MysqlPdo();
		if (isset($_GET['id'])) {		
				$content = array("ifpub"=>0);
				$pdo->update($content, 'web_contentindex', "id=".$_GET['id']);
				$url=$_SERVER['HTTP_REFERER'];
				page_msg($msg='取消审核成功!',$isok=true,$url);
				exit;
		}
	}

	/**
	 * ajax set essence
	 */
	function ajaxDigest()
	{
		$pdo = new MysqlPdo();
		$data = array('digest'=>$_GET['digest']);
		return $pdo->update($data , DB_PREFIX.'contentindex', "id=".$_GET['id']);
	}

	/**
	 * ajax, According to cid be module id
	 */
	function ajaxMid()
	{
		global $pdo;
		$cid=intval(isset($_GET['cid'])?$_GET['cid']:1);
		$Mid=$pdo->getRow("select mid from category where id={$cid}");
		echo $Mid['mid'];
	}
?>