<?php

	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//模板路径,生成后自行修改
	$template_edit = "admin/member/paladinconsensus_edit.tpl";
	$template_list = "admin/member/paladinconsensus_list.tpl";
	//获取的所有项目
	$project = $pdo->getAll("select id,project_name from paladin_project");
	$project_text = array('0'=>'所有项目');
	foreach($project as $item){
		$project_text[$item['id']] = $item['project_name'];
	}

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
			case 'deleteall':deleteAll(); //删除多条记录方法
				exit;
			default:index();
				exit;
		}
	/**
	 * 保存修改或增加到数据库
	 */
	function save()
	{
		global $smarty, $pdo,$template_msg;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new') {
		$Data = filter($_POST);
		$Data['create_at'] = time();
		$Data['user_id'] = $_SESSION['userId'];
		if (isset($Data) &&  $pdo->add($Data,'paladin_consensus')) {
   			 $pdo->getLastInsID();
			 page_msg($msg='保存成功!',$isok=true,$_SERVER['HTTP_REFERER']);
		} else {
			 page_msg($msg='保存失败!',$isok=true,$_SERVER['HTTP_REFERER']);
		}

		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['id'])) {		
			$Data = filter($_POST); 
			if (isset($Data)) {
				 $pdo->update($Data , 'paladin_consensus', "id=".$_POST['id']);
				page_msg($msg='修改成功!',$isok=true,$_SERVER['HTTP_REFERER']);
			} else {
				page_msg($msg='保存失败!',$isok=true,$_SERVER['HTTP_REFERER']);
			}
		}
	}

	/**
	 * 输出添加界面
	 */
	function add()
	{
		global $smarty, $pdo, $template_edit,$project_text;
		
		$ValueList = array();
		$ValueList['project_text'] = $project_text;
		$smarty->assign('paladinconsensusInfo',$ValueList);
		$smarty->assign("EditOption" , 'New');
		$smarty->assign("url" , $_SERVER['HTTP_REFERER']);
		$smarty -> show($template_edit);
	}
	
	/**
	 * 输出编辑界面
	 */
	function edit()
	{
		global $smarty, $pdo, $template_edit,$project_text;
		$para = formatParameter($_GET["sp"], "out");
		$Id = isset($para['id']) ? $para['id'] : 1;
		$ValueList = $pdo->getRow("select * from paladin_consensus where id = '$Id'");
		$ValueList['project_text'] = $project_text;
		$smarty->assign('paladinconsensusInfo',$ValueList);
		$smarty->assign("EditOption" , 'Edit');
		$smarty->assign("UrlReferer" , $_SERVER['HTTP_REFERER']);
		$smarty -> show($template_edit);	
	}


	/**
	 * 执行删除
	 */
	function delete()
	{
		global $pdo,$template_msg,$smarty;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 0;
		$pdo->remove("id={$id}","paladin_consensus");
		page_msg($msg='删除成功!',$isok=true,$_SERVER['HTTP_REFERER']);
	}

	/**
	 * 执行多项删除
	 */
	function deleteAll()
	{
		/*
		global $pdo,$template_msg,$smarty;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'delall'){
			$id = isset($_POST['ids']) ? $_POST['ids'] : array();
			$count = count($id);
			if($count != 0){
			    $query = " DELETE FROM paladin_consensus WHERE `id` IN (". implode(",", $id) .")";
				$pdo->execute($query);
			}
		}
		page_msg($msg='多项删除删除成功!',$isok=true,$url);
		*/
	}



	/**
	 * 输出列表界面
	 */
	function index()
	{
		global $smarty, $pdo, $template_list,$project_text;
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
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	        }
	    $select_columns = 'select %s from paladin_consensus as a %s %s %s';
	    
	    $order = "order by $orderField $orderValue";
	    $limit = "limit $offset,$pageSize";
	    $count = " count(a.id) as count ";
	    $sql = sprintf($select_columns,'a.*',$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();

		$smarty->assign('project_id_text',	$project_text);
		foreach ($res as $key => $item) {
			if(!is_null($item['project_id']))
			$res[$key]['project_name'] = $project_text[$item['project_id']];
		}
	 	// 查询到的结果
	 	$smarty->assign("EditOption", 'delall');
		$smarty->assign('paladinconsensusList', $res);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);
		// 指定模板
		$smarty->show($template_list);
	}

	/**
	 * 过滤数组
	 */
	function filter($Data)
	{
		$ValueList = array();
		if (array_key_exists('project_id',$Data) && ($Data['project_id'] !== '')) { $Data['project_id'] = (int)$Data['project_id'];  $ValueList['project_id']= "{$Data['project_id']}";}
		if (array_key_exists('consensus_theme',$Data)) { $Data['consensus_theme'] = $Data['consensus_theme']; $ValueList['consensus_theme']= "{$Data['consensus_theme']}";}
		if (array_key_exists('consensus_title',$Data)) { $Data['consensus_title'] = $Data['consensus_title']; $ValueList['consensus_title']= "{$Data['consensus_title']}";}
		if (array_key_exists('consensus_url',$Data)) { $Data['consensus_url'] = $Data['consensus_url']; $ValueList['consensus_url']= "{$Data['consensus_url']}";}
		if (array_key_exists('consensus_website',$Data)) { $Data['consensus_website'] = $Data['consensus_website']; $ValueList['consensus_website']= "{$Data['consensus_website']}";}
		if (array_key_exists('consensus_status',$Data)) { $Data['consensus_status'] = $Data['consensus_status']; $ValueList['consensus_status']= "{$Data['consensus_status']}";}
		if (array_key_exists('consensus_type',$Data)) { $Data['consensus_type'] = $Data['consensus_type']; $ValueList['consensus_type']= "{$Data['consensus_type']}";}
		if (array_key_exists('create_at',$Data)) { $Data['create_at'] = $Data['create_at']; $ValueList['create_at']= "{$Data['create_at']}";}
		if (array_key_exists('user_id',$Data)) { $Data['user_id'] = $Data['user_id']; $ValueList['user_id']= "{$Data['user_id']}";}
		return $ValueList;
	}

	function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
				if(isset($Data['id']) && $Data['id'] != ""){
			$where .=" and a.`id` = '{$Data['id']}'";
			$page_info.="id={$Data['id']}&";
			$smarty->assign("id",$Data['id']);
		}
				if(isset($Data['project_id']) && $Data['project_id'] != ""){
			$where .=" and a.`project_id` = '{$Data['project_id']}'";
			$page_info.="project_id={$Data['project_id']}&";
			$smarty->assign("project_id",$Data['project_id']);
		}
				if(isset($Data['consensus_theme']) && $Data['consensus_theme'] != ""){
			$where .=" and a.`consensus_theme` = '{$Data['consensus_theme']}'";
			$page_info.="consensus_theme={$Data['consensus_theme']}&";
			$smarty->assign("consensus_theme",$Data['consensus_theme']);
		}
				if(isset($Data['consensus_title']) && $Data['consensus_title'] != ""){
			$where .=" and a.`consensus_title` = '{$Data['consensus_title']}'";
			$page_info.="consensus_title={$Data['consensus_title']}&";
			$smarty->assign("consensus_title",$Data['consensus_title']);
		}
				if(isset($Data['consensus_url']) && $Data['consensus_url'] != ""){
			$where .=" and a.`consensus_url` = '{$Data['consensus_url']}'";
			$page_info.="consensus_url={$Data['consensus_url']}&";
			$smarty->assign("consensus_url",$Data['consensus_url']);
		}
				if(isset($Data['consensus_website']) && $Data['consensus_website'] != ""){
			$where .=" and a.`consensus_website` = '{$Data['consensus_website']}'";
			$page_info.="consensus_website={$Data['consensus_website']}&";
			$smarty->assign("consensus_website",$Data['consensus_website']);
		}
				if(isset($Data['consensus_status']) && $Data['consensus_status'] != ""){
			$where .=" and a.`consensus_status` = '{$Data['consensus_status']}'";
			$page_info.="consensus_status={$Data['consensus_status']}&";
			$smarty->assign("consensus_status",$Data['consensus_status']);
		}
				if(isset($Data['consensus_type']) && $Data['consensus_type'] != ""){
			$where .=" and a.`consensus_type` = '{$Data['consensus_type']}'";
			$page_info.="consensus_type={$Data['consensus_type']}&";
			$smarty->assign("consensus_type",$Data['consensus_type']);
		}
				if(isset($Data['create_at']) && $Data['create_at'] != ""){
			$where .=" and a.`create_at` = '{$Data['create_at']}'";
			$page_info.="create_at={$Data['create_at']}&";
			$smarty->assign("create_at",$Data['create_at']);
		}
				if(isset($Data['user_id']) && $Data['user_id'] != ""){
			$where .=" and a.`user_id` = '{$Data['user_id']}'";
			$page_info.="user_id={$Data['user_id']}&";
			$smarty->assign("user_id",$Data['user_id']);
		}
		}
?>