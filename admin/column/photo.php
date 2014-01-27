<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 路线图片管理
 * @author ld<luodongdaxia@yahoo.com.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: left.php,v 1.1 2009/08/28 24:45:23
 */

	// 加载系统函数
	require_once('../../sys_load.php');
	
	$verify = new Verify();
	$verify->validate_pic_edit();

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
		case 'edit':edit();
			exit;
		case 'order':order();
			exit;
		case 'index':index();
			exit;
		default:show();
			exit;
	}

	function save()
	{
		if(!$_SESSION['save'])page_msg('你没有权限访问',$isok=false);
		global $pdo;
		$tid = intval(isset($_POST['tid'])?$_POST['tid']:0);
		$mid = intval(isset($_POST['mid'])?$_POST['mid']:0);
		if($tid and $mid){
			$i = 1;
			foreach($_FILES as $file){
				if(!empty($file['name']) and $file['error']==0){
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
						$ras = array('mid'=>$mid,'tid'=>$tid,'aid'=>$lastInsId,'pic_type'=>'photo');
						$pdo->add($ras,DB_PREFIX."attachindex");
					}
					$i++;
				}
			}
			page_msg('<font color=green>上传成功！</font>',$isok=true,$_SERVER['HTTP_REFERER']);
		}else{
			page_msg('<font color=green>非法操作！</font>',$isok=false,$_SERVER['HTTP_REFERER']);
		}
	}
	
	function add()
	{
		if(!$_SESSION['add'])page_msg('你没有权限访问',$isok=false);
		$tid = intval(isset($_GET['tid'])?$_GET['tid']:0);
		$cid = intval(isset($_GET['cid'])?$_GET['cid']:0);
		if(@!$_SESSION['add'] and $tid>0){
			//echo "<script>parent.notice_false();</script>"; exit;
		}
		global $smarty,$template_edit;

		$column = new column();
		//得到类名
		$smarty->assign('className',$column->getClassName($cid));

		//得到内容信息标题
		$smarty->assign('contentName',$column->getContentName($tid));

		//得到模型mid
		$smarty->assign('mid',$column->getMid($cid));

		$smarty->assign('tid',$tid);
		$smarty->assign('cid',$cid);
		$smarty->show($template_edit);
	}

	function edit()
	{
		
		global $pdo;
		$para = formatParameter($_GET["sp"], "out");
		$id = intval(isset($para['id'])?$para['id']:0);
		$tid = intval(isset($para['tid'])?$para['tid']:0);
		$mid = intval(isset($para['mid'])?$para['mid']:0);
		if(@!$_SESSION['edit'] || $tid || $id){
			//echo "<script>parent.notice_false();</script>"; exit;
		}
		global $smarty,$template_edit;
		$pdo->update(array('pic_type'=>'photo'),DB_PREFIX."attachindex", "tid=".$tid." and mid=".$mid);
		$pdo->update(array('pic_type'=>'Relevant pictures'),DB_PREFIX."attachindex", "mid=".$mid." and id=".$id);
		$pdo->update(array('photo'=>$para['filepath']),DB_PREFIX."contentindex", "id=".$tid);
		page_msg('<font color=green>设置成功！</font>',$isok=true,$_SERVER['HTTP_REFERER']);
	}

	function del()
	{
		global $pdo;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 0;
		$aid = isset($para['aid']) ? $para['aid'] : 0;
		//delete_file($para['filepath']);
		//delete_file(str_ireplace("_s.",".",$para['filepath']));
		$pdo->remove("id={$id}",DB_PREFIX."attachindex");
		//$pdo->remove("aid={$aid}",DB_PREFIX."attach");
		page_msg('<font color=green>删除成功！</font>',$isok=true,$_SERVER['HTTP_REFERER']);
	}

	function index()
	{
		$tid = intval(isset($_GET['tid'])?$_GET['tid']:0);
		$cid = intval(isset($_GET['cid'])?$_GET['cid']:0);
		
		if(@!$_SESSION['add'] and $tid and $cid){
			//echo "<script>parent.notice_false();</script>"; exit;
		}

		global $smarty, $pdo, $template_list;		
		$page_info = "";
		$pageSize = 15;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p'])?(int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$where = "where a.mid<>'itinerary' ";
        if($_GET) {
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	    }
	    $select_columns = "select %s from ".DB_PREFIX."attachindex as a left join ".DB_PREFIX."attach as b on a.aid=b.aid %s %s %s";
	    
	    $order = "order by a.order_list desc";
	    $limit = "limit $offset,$pageSize";
	    $count = " count(a.id) as count ";
	    $sql = sprintf($select_columns,'a.id,a.mid,a.aid,a.tid,a.pic_type,a.order_list,b.type,b.filepath,b.fileintro,b.size,b.uploadtime',$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();

		foreach($res as $key=>$item){
			$res[$key]['filepath'] = str_replace('.'.$item['type'],'_s.'.$item['type'],$res[$key]['filepath']);
		}
		
		//得到该类型下的所有信息
		$allInfo = $pdo->getAll("select * from ".DB_PREFIX."contentindex where cid={$cid} order by id desc");
		$smarty->assign('allInfo',$allInfo);

		$column = new column();
		//得到类名
		$smarty->assign('className',$column->getClassName($cid));

		//得到内容信息标题
		$smarty->assign('contentName',$column->getContentName($tid));

	 	// 查询到的结果
		$smarty->assign('photoList', $res);
		
		$smarty->assign('count',$recordCount);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);

		// 指定模板
		$smarty->show($template_list);
	}

	function order()
	{
		if(!$_SESSION['order'])page_msg('你没有权限访问',$isok=false);
		global $pdo;
		//print_r($_POST);exit;
		if($_POST['option']=='order'){
			if (isset($_POST['taxis'])) {
				foreach($_POST['taxis'] as $key=>$item){
					$content = array("order_list"=>$item);
					$pdo->update($content, 'web_attachindex', "id=".$key);
				}
				$url=$_SERVER['HTTP_REFERER'];
				page_msg($msg='Update successfully!',$isok=true,$url);
				exit;
			}
		}else{
			if (isset($_POST['describe'])) {
				foreach($_POST['describe'] as $key=>$item){
					$content = array("fileintro"=>$item);
					$pdo->update($content, 'web_attach', "aid=".$key);
				}
				$url=$_SERVER['HTTP_REFERER'];
				page_msg($msg='Update successfully!',$isok=true,$url);
				exit;
			}
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
			//$where .=" and a.`cid` = '{$Data['cid']}'";
			$page_info.="cid={$Data['cid']}&";
			$smarty->assign("cid",$Data['cid']);
		}
		if(isset($Data['tid']) && $Data['tid'] != ""){
			$where .=" and a.`tid` = '{$Data['tid']}'";
			$page_info.="tid={$Data['tid']}&";
			$smarty->assign("tid",$Data['tid']);
		}
	}

?>