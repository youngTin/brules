<?php

	require_once('../../sys_load.php');
	$verify = new Verify();

	require_once('../../data/cache/base_code.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//模板路径,生成后自行修改
	$template_edit = "admin/esf/fc114userdatabase_edit.tpl";
	$template_list = "admin/esf/fc114userdatabase_list.tpl";

	$sta_text = array(
	'1' => '是',
	'0' => '否');

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
		if (isset($Data) &&  $pdo->add($Data,'home_user_database')) {
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
			if (isset($Data)) {
				 $pdo->update($Data , 'home_user_database', "id=".$_POST['id']);
				 //将通过审核的数据插入或移除home_database
				 //todo
				 if($Data['sta']==0){
					//$pdo->remove("id=".$_POST['id'],"home_database");
				 }else{
					$pdo->add($Data,'home_database');
				 }
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
		global $smarty, $pdo, $template_edit;
		
		$ValueList = array();
		$smarty->assign('fc114userdatabaseInfo',$ValueList);
		$smarty->assign("EditOption" , 'New');
		$smarty->assign("url" , $_SERVER['HTTP_REFERER']);
		$smarty -> show($template_edit);
	}
	
	/**
	 * 输出编辑界面
	 */
	function edit()
	{
		global $smarty, $pdo, $template_edit, $sta_text;
		$para = formatParameter($_GET["sp"], "out");
		$Id = isset($para['id']) ? $para['id'] : 1;
		
		$ValueList = $pdo->getRow("select * from home_user_database where id = '$Id'");
		$ValueList['sta_text'] = $sta_text;
		$smarty->assign('fc114userdatabaseInfo',$ValueList);
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
		$id = (int)isset($para['id']) ? $para['id'] : 0;
		if($id){
			$pdo->remove("id={$id}","home_user_database");
			$msg = '删除成功';
			page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
		}else{
			page_msg('操作失败！',$isok=false,$url=$_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * 执行多项删除
	 */
	function deleteAll()
	{
		global $pdo,$template_msg,$smarty;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'delall'){
			$id = isset($_POST['ids']) ? $_POST['ids'] : array();
			$count = count($id);
			if($count != 0){
			    $query = " DELETE FROM home_user_database WHERE `id` IN (". implode(",", $id) .")";
				$pdo->execute($query);
				$msg = '多项删除删除成功';
			}
		}
		page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
	}



	/**
	 * 输出列表界面
	 */
	function index()
	{
		global $smarty, $pdo, $template_list,$borough_text, $sta_text;
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
	    $select_columns = 'select %s from home_user_database as a %s %s %s';
	    
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
			$res[$key]['borough_text'] = isset($borough_text[$item['borough']])?$borough_text[$item['borough']]:'';
		}

		$smarty->assign("sta_text",$sta_text);
	 	// 查询到的结果
	 	$smarty->assign("EditOption", 'delall');
		$smarty->assign('fc114userdatabaseList', $res);
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
		if (array_key_exists('login_name',$Data)) { $Data['login_name'] = $Data['login_name']; $ValueList['login_name']= "{$Data['login_name']}";}
		if (array_key_exists('reside',$Data)) { $Data['reside'] = $Data['reside']; $ValueList['reside']= "{$Data['reside']}";}
		if (array_key_exists('address',$Data)) { $Data['address'] = $Data['address']; $ValueList['address']= "{$Data['address']}";}
		if (array_key_exists('borough',$Data) && ($Data['borough'] !== '')) { $Data['borough'] = (int)$Data['borough'];  $ValueList['borough']= "{$Data['borough']}";}
		if (array_key_exists('region',$Data) && ($Data['region'] !== '')) { $Data['region'] = (int)$Data['region'];  $ValueList['region']= "{$Data['region']}";}
		if (array_key_exists('direction',$Data)) { $Data['direction'] = $Data['direction']; $ValueList['direction']= "{$Data['direction']}";}
		if (array_key_exists('circle',$Data)) { $Data['circle'] = $Data['circle']; $ValueList['circle']= "{$Data['circle']}";}
		if (array_key_exists('description',$Data)) { $Data['description'] = $Data['description']; $ValueList['description']= "{$Data['description']}";}
		if (array_key_exists('attach_id',$Data)) { $Data['attach_id'] = $Data['attach_id']; $ValueList['attach_id']= "{$Data['attach_id']}";}
		if (array_key_exists('sta',$Data) && ($Data['sta'] !== '')) { $Data['sta'] = (int)$Data['sta'];  $ValueList['sta']= "{$Data['sta']}";}
		if (array_key_exists('time',$Data) && ($Data['time'] !== '')) { $Data['time'] = (int)$Data['time'];  $ValueList['time']= "{$Data['time']}";}
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
				if(isset($Data['login_name']) && $Data['login_name'] != ""){
			$where .=" and a.`login_name` = '{$Data['login_name']}'";
			$page_info.="login_name={$Data['login_name']}&";
			$smarty->assign("login_name",$Data['login_name']);
		}
				if(isset($Data['reside']) && $Data['reside'] != ""){
			$where .=" and a.`reside` = '{$Data['reside']}'";
			$page_info.="reside={$Data['reside']}&";
			$smarty->assign("reside",$Data['reside']);
		}
				if(isset($Data['address']) && $Data['address'] != ""){
			$where .=" and a.`address` = '{$Data['address']}'";
			$page_info.="address={$Data['address']}&";
			$smarty->assign("address",$Data['address']);
		}
				if(isset($Data['borough']) && $Data['borough'] != ""){
			$where .=" and a.`borough` = '{$Data['borough']}'";
			$page_info.="borough={$Data['borough']}&";
			$smarty->assign("borough",$Data['borough']);
		}
				if(isset($Data['region']) && $Data['region'] != ""){
			$where .=" and a.`region` = '{$Data['region']}'";
			$page_info.="region={$Data['region']}&";
			$smarty->assign("region",$Data['region']);
		}
				if(isset($Data['direction']) && $Data['direction'] != ""){
			$where .=" and a.`direction` = '{$Data['direction']}'";
			$page_info.="direction={$Data['direction']}&";
			$smarty->assign("direction",$Data['direction']);
		}
				if(isset($Data['circle']) && $Data['circle'] != ""){
			$where .=" and a.`circle` = '{$Data['circle']}'";
			$page_info.="circle={$Data['circle']}&";
			$smarty->assign("circle",$Data['circle']);
		}
				if(isset($Data['description']) && $Data['description'] != ""){
			$where .=" and a.`description` = '{$Data['description']}'";
			$page_info.="description={$Data['description']}&";
			$smarty->assign("description",$Data['description']);
		}
				if(isset($Data['attach_id']) && $Data['attach_id'] != ""){
			$where .=" and a.`attach_id` = '{$Data['attach_id']}'";
			$page_info.="attach_id={$Data['attach_id']}&";
			$smarty->assign("attach_id",$Data['attach_id']);
		}
				if(isset($Data['sta']) && $Data['sta'] != ""){
			$where .=" and a.`sta` = '{$Data['sta']}'";
			$page_info.="sta={$Data['sta']}&";
			$smarty->assign("sta",$Data['sta']);
		}
				if(isset($Data['time']) && $Data['time'] != ""){
			$where .=" and a.`time` = '{$Data['time']}'";
			$page_info.="time={$Data['time']}&";
			$smarty->assign("time",$Data['time']);
		}
		}
?>