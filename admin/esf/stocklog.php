<?php

	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//模板路径,生成后自行修改
	$template_edit = "admin/esf/fc114stocklog_edit.tpl";
	$template_list = "admin/esf/fc114stocklog_list.tpl";
	$template_msg = "../tpl/msg.tpl";

	switch(isset($_GET['action'])?$_GET['action']:'index')
		{


			case 'index':index(); //列表页面
				exit;
			case 'delete':delete(); //删除单条记录方法
				exit;
			default:index();
				exit;
		}


	/**
	 * 执行删除
	 */
	function delete()
	{
		global $pdo,$template_msg,$smarty;
		$para = formatParameter($_GET["sp"], "out");
		$Id = isset($para['Id']) ? $para['Id'] : 0;
		$pdo->remove("Id={$Id}", DB_PREFIX_HOME."stock_log");
		$msg = '删除成功';
		$smarty->assign("msg" , $msg);
		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
	   	$smarty -> show($template_msg);
	}

	/**
	 * 执行多项删除
	 */
	function deleteAll()
	{
		global $pdo,$template_msg,$smarty;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'delall'){
			$Id = isset($_POST['ids']) ? $_POST['ids'] : array();
			$count = count($Id);
			if($count != 0){
			    $query = " DELETE FROM ".DB_PREFIX_HOME."stock_log WHERE `Id` IN (". implode(",", $Id) .")";
				$pdo->execute($query);
				$msg = '多项删除删除成功';
			}
		}
		$smarty->assign("msg" , $msg);
		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
	   	$smarty -> show($template_msg);
	}



	/**
	 * 输出列表界面
	 */
	function index()
	{
		global $smarty, $pdo, $template_list;
		$page_info = "";
		$Sort = isset($_GET['sort']) ? 'a'.$_GET['sort'] : 'a.Id';
		$Flag = isset($_GET['flag']) ? $_GET['flag'] : 'desc';
		if($Sort == '' || $Flag == ''){$Sort = 'Id';$Flag = 'desc';}
		$PageSize = 15;
		$Offset = 0;
		$sub_pages=5;								//每次显示的页数
		$CurrentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($CurrentPage>0) $Offset=($CurrentPage-1)*$PageSize;
		$where = 'where 1 ';
	    if($_POST) {
	    	advanced_search($_POST,$page_info,$filter_where);
	    	$where .= $filter_where;
	    	$smarty->assign("is_search","1"); //是否是高级搜索
	    }
	   	if($_GET) {
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	    	$smarty->assign("is_search","1"); //是否是高级搜索
	    }
		$select_columns = "select %s from ".DB_PREFIX_HOME."stock_log as a %s %s %s";

	    $order = "order by $Sort $Flag";
	    $limit = "limit $Offset,$PageSize";
	    $count = " count(a.Id) as count ";
	    $sql = sprintf($select_columns,'a.*',$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$RecordCount = $Count['count'];
	    $page=new Page($PageSize,$RecordCount,$CurrentPage,$sub_pages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();

	 	// 查询到的结果
	 	$smarty->assign("EditOption", 'delall');
		$smarty->assign('fc114stocklogList', $res);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);
		// 指定模板
		$smarty->show($template_list);
	}



	function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
				if(isset($Data['Id']) && $Data['Id'] != ""){
			$where .=" and a.`Id` = '{$Data['Id']}'";
			$page_info.="Id={$Data['Id']}&";
			$smarty->assign("Id",$Data['Id']);
		}
				if(isset($Data['p_user_name']) && $Data['p_user_name'] != ""){
			$where .=" and a.`p_user_name` = '{$Data['p_user_name']}'";
			$page_info.="p_user_name={$Data['p_user_name']}&";
			$smarty->assign("p_user_name",$Data['p_user_name']);
		}
				if(isset($Data['c_user_id']) && $Data['c_user_id'] != ""){
			$where .=" and a.`c_user_id` = '{$Data['c_user_id']}'";
			$page_info.="c_user_id={$Data['c_user_id']}&";
			$smarty->assign("c_user_id",$Data['c_user_id']);
		}
				if(isset($Data['content']) && $Data['content'] != ""){
			$where .=" and a.`content` = '{$Data['content']}'";
			$page_info.="content={$Data['content']}&";
			$smarty->assign("content",$Data['content']);
		}
				if(isset($Data['updated_at']) && $Data['updated_at'] != ""){
			$where .=" and a.`updated_at` = '{$Data['updated_at']}'";
			$page_info.="updated_at={$Data['updated_at']}&";
			$smarty->assign("updated_at",$Data['updated_at']);
		}
				if(isset($Data['company_id']) && $Data['company_id'] != ""){
			$where .=" and a.`company_id` = '{$Data['company_id']}'";
			$page_info.="company_id={$Data['company_id']}&";
			$smarty->assign("company_id",$Data['company_id']);
		}
				if(isset($Data['name_cn']) && $Data['name_cn'] != ""){
			$where .=" and a.`name_cn` = '{$Data['name_cn']}'";
			$page_info.="name_cn={$Data['name_cn']}&";
			$smarty->assign("name_cn",$Data['name_cn']);
		}
				if(isset($Data['p_user_id']) && $Data['p_user_id'] != ""){
			$where .=" and a.`p_user_id` = '{$Data['p_user_id']}'";
			$page_info.="p_user_id={$Data['p_user_id']}&";
			$smarty->assign("p_user_id",$Data['p_user_id']);
		}
		}
?>