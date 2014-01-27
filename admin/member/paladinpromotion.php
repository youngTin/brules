<?php

	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//模板路径,生成后自行修改
	$template_edit = "admin/member/paladinpromotion_edit.tpl";
	$template_list = "admin/member/paladinpromotion_list.tpl";
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
		$Data['user_id']=$_SESSION['userId'];
		$Data['create_at']=time();//创建时间
		$Data['edit_at']=time();  //最后修改时间
		$Data['user_name']=$_SESSION['userName'];
		if (isset($Data) &&  $pdo->add($Data,'paladin_promotion')) {
   			 $pdo->getLastInsID();
   			 $msg = '保存成功';
			 page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
		} else {
			$msg = '保存失败';
			page_msg($msg,$isok=false,$url=$_SERVER['HTTP_REFERER']);
		}

		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['id'])) {		
			$Data = filter($_POST); 
			unset($Data['create_at']);
			$Data['edit_at']=time();
			if (isset($Data)) {
				$pdo->update($Data , 'paladin_promotion', "id=".$_POST['id']);
	   			$msg = '修改成功';
				page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
			} else {
				$msg = '保存失败';
				page_msg($msg,$isok=false,$url=$_SERVER['HTTP_REFERER']);
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
		$smarty->assign('paladinpromotionInfo',$ValueList);
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
		
		$ValueList = $pdo->getRow("select * from paladin_promotion where id = '$Id'");
		$ValueList['project_text'] = $project_text;
		$smarty->assign('paladinpromotionInfo',$ValueList);
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
		$pdo->remove("id={$id}","paladin_promotion");
		$msg = '删除成功';
		page_msg($msg,$isok=false,$url=$_SERVER['HTTP_REFERER']);
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
			    $query = " DELETE FROM paladin_promotion WHERE `id` IN (". implode(",", $id) .")";
				$pdo->execute($query);
				$msg = '多项删除删除成功';
			}
		}
		*/
		$msg = '该功能暂未开通！';
		page_msg($msg,$isok=false,$url=$_SERVER['HTTP_REFERER']);
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
	    $select_columns = 'select %s from paladin_promotion as a %s %s %s';
	    
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

		foreach ($res as $key => $item) {
			$res[$key]['project_name']= $project_text[$item['project_id']];
		}
	 	// 查询到的结果
	 	$smarty->assign("EditOption", 'delall');
		$smarty->assign('paladinpromotionList', $res);
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
		if (array_key_exists('promotion_info',$Data)) { $Data['promotion_info'] = $Data['promotion_info']; $ValueList['promotion_info']= "{$Data['promotion_info']}";}
		if (array_key_exists('promotion_time',$Data)) { $Data['promotion_time'] = $Data['promotion_time']; $ValueList['promotion_time']= "{$Data['promotion_time']}";}
		if (array_key_exists('project_id',$Data) && ($Data['project_id'] !== '')) { $Data['project_id'] = (int)$Data['project_id'];  $ValueList['project_id']= "{$Data['project_id']}";}
		if (array_key_exists('promotion_type',$Data)) { $Data['promotion_type'] = $Data['promotion_type']; $ValueList['promotion_type']= "{$Data['promotion_type']}";}
		if (array_key_exists('create_at',$Data)) { $Data['create_at'] = $Data['create_at']; $ValueList['create_at']= "{$Data['create_at']}";}
		if (array_key_exists('user_id',$Data)) { $Data['user_id'] = $Data['user_id']; $ValueList['user_id']= "{$Data['user_id']}";}
		if (array_key_exists('user_name',$Data)) { $Data['user_name'] = $Data['user_name']; $ValueList['user_name']= "{$Data['user_name']}";}
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
				if(isset($Data['promotion_info']) && $Data['promotion_info'] != ""){
			$where .=" and a.`promotion_info` = '{$Data['promotion_info']}'";
			$page_info.="promotion_info={$Data['promotion_info']}&";
			$smarty->assign("promotion_info",$Data['promotion_info']);
		}
				if(isset($Data['promotion_time']) && $Data['promotion_time'] != ""){
			$where .=" and a.`promotion_time` = '{$Data['promotion_time']}'";
			$page_info.="promotion_time={$Data['promotion_time']}&";
			$smarty->assign("promotion_time",$Data['promotion_time']);
		}
				if(isset($Data['project_id']) && $Data['project_id'] != ""){
			$where .=" and a.`project_id` = '{$Data['project_id']}'";
			$page_info.="project_id={$Data['project_id']}&";
			$smarty->assign("project_id",$Data['project_id']);
		}
				if(isset($Data['promotion_type']) && $Data['promotion_type'] != ""){
			$where .=" and a.`promotion_type` = '{$Data['promotion_type']}'";
			$page_info.="promotion_type={$Data['promotion_type']}&";
			$smarty->assign("promotion_type",$Data['promotion_type']);
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
				if(isset($Data['user_name']) && $Data['user_name'] != ""){
			$where .=" and a.`user_name` = '{$Data['user_name']}'";
			$page_info.="user_name={$Data['user_name']}&";
			$smarty->assign("user_name",$Data['user_name']);
		}
		}
?>