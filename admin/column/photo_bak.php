<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 路线图片上传
 * @author ld<luodongdaxia@yahoo.com.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: left.php,v 1.1 2009/08/28 24:45:23
 */

	// 加载系统函数
	require_once('../../sys_load.php');
	
	$verify = new Verify();
	$verify->validate_recycle();

	// 生成Smarty 对象
	$smarty = new WebSmarty;
	$pdo = new MysqlPdo();

	//模板路径,生成后自行修改
	$template_edit = "admin/column/photo.tpl";
	$template_list = "admin/column/photo_list.tpl";

	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'save':save();
			exit;
		case 'del':del();
			exit;
		case 'add':add();
			exit;
		case 'index':index();
			exit;
		default:show();
			exit;
	}

	function save()
	{
		global $pdo;
		$routeId = intval(isset($_POST['routeId'])?$_POST['routeId']:0);
		$i = 1;
		//print_r($_FILES);exit;
		foreach($_FILES as $file){
			$uptool = new UploadFile($file,$path='image');
			$upsize = $uptool->upload();
			$upinfo = $uptool->getSaveInfo();
			$ras = array();
			$ras['filename']   = $upinfo[0]['name'];
			$ras['filepath']   = $upinfo[0]['url'];
			$ras['fileintro']  = $_POST['fileintro'.$i];
			$ras['type']       = $upinfo[0]['type'];
			$ras['size']       = $upinfo[0]['size'];
			$ras['filesrc']    = $upinfo[0]['checksum'];
			$ras['uploadtime'] = $_SERVER['REQUEST_TIME'];
			$pdo->add($ras, DB_PREFIX."attach");
			$lastInsId = $pdo->getLastInsID();
			if($lastInsId){
				$ras = array('mid'=>3,'tid'=>$routeId,'aid'=>$lastInsId,'pic_type'=>'photo');
				$pdo->add($ras,DB_PREFIX."attachindex");
			}
			$i++;
		}
		page_msg('<font color=green>上传成功！</font>',$isok=true);
	}
	
	function add()
	{
		$routeId = intval(isset($_GET['routeId'])?$_GET['routeId']:0);
		$cid = intval(isset($_GET['cid'])?$_GET['cid']:0);
		if(!$_SESSION['add'] and $routeId>0){
			//echo "<script>parent.notice_false();</script>"; exit;
		}
		global $smarty,$template_edit;

		//得到类名
		$smarty->assign('className',getClassName($cid));

		//得到路线名
		$smarty->assign('routeName',getRouteName($routeId));

		$smarty->assign('routeId',$routeId);
		$smarty->assign('cid',$cid);
		$smarty->show($template_edit);
	}

	function del()
	{
		global $pdo;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 0;
		$pdo->remove("id={$id}",DB_PREFIX."contentindex");
		$pdo->remove("id={$id}",DB_PREFIX."content".$para['mid']);
		$pdo->remove("tid={$id}",DB_PREFIX."recycle");
		page_msg('<font color=green>删除成功！</font>',$isok=true,'recycle.php?action=show&cid='.$para['cid']);
	}

	function index()
	{
		/*
		$routeId = intval(isset($_GET['routeId'])?$_GET['routeId']:0);
		$cid = intval(isset($_GET['cid'])?$_GET['cid']:0);
		if(!$_SESSION['add'] and $routeId and $cid){
			//echo "<script>parent.notice_false();</script>"; exit;
		}
		*/
		global $smarty, $pdo, $template_list;
		/*
		$page_info = "";
		$pageSize = 15;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$where = "where a.tid=".$routeId;

	    $select_columns = "select %s from ".DB_PREFIX."attachindex as a left join ".DB_PREFIX."attach as b on a.aid=b.aid %s %s %s";
	    
	    $order = "order by uploadtime desc";
	    $limit = "limit $offset,$pageSize";
	    $count = " count(a.id) as count ";
	    $sql = sprintf($select_columns,'a.aid as id,a.mid,a.tid,a.pic_type,b.type,b.filepath,b.fileintro,b.size,b.uploadtime',$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();

		foreach($res as $key=>$item){
			$res[$key]['filepath'] = str_replace('.'.$item['type'],'_s.'.$item['type'],$res[$key]['filepath']);
		}
		
		//得到类名
		$smarty->assign('className',getClassName($cid));

		//得到路线名
		$smarty->assign('routeName',getRouteName($routeId));
		
		$smarty->assign('routeId',$routeId);
		$smarty->assign('cid',$cid);

	 	// 查询到的结果
		$smarty->assign('photoList', $res);
		
		$smarty->assign('count',$recordCount);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);

		*/
		// 指定模板
		$smarty->show($template_list);
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
	 * According to cid be module id
	 */
	function getRouteName($routeId)
	{
		global $pdo;
		$routeInfo=$pdo->getRow("select title from ".DB_PREFIX."contentindex where id={$routeId}");
		return $routeInfo['title'];
	}

?>