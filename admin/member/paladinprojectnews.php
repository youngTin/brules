<?php

	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//模板路径,生成后自行修改
	$template_edit = "admin/member/paladinprojectnews_edit.tpl";
	$template_list = "admin/member/paladinprojectnews_list.tpl";
	//新闻类型
	$news_type_text = array('1'=>'新闻','2'=>'公告');
	//新闻状态
	$flag_text = array('0'=>'无效','1'=>'有效',2=>'已经发布到网站');
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
		if (isset($Data) &&  $pdo->add($Data,'paladin_project_news')) {
   			 $pdo->getLastInsID();
   			 $msg = '保存成功';
			 page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
		} else {
			$msg = '保存失败';
			$_POST['UrlReferer'];
			page_msg($msg,$isok=false,$url=$_SERVER['HTTP_REFERER']);
		}

		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['id'])) {		
			$Data = filter($_POST);
			unset($Data['create_at']);
			$Data['edit_at']=time();
			if (isset($Data)) {
				 $pdo->update($Data , 'paladin_project_news', "id=".$_POST['id']);
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
		global $smarty, $pdo, $template_edit,$project_text,$news_type_text,$flag_text;
		
		$ValueList = array();
		$ValueList['project_text'] = $project_text;
		$ValueList['news_type_text'] = $news_type_text;
		$ValueList['flag_text'] = $flag_text;
		$smarty->assign('paladinprojectnewsInfo',$ValueList);
		$smarty->assign("EditOption" , 'New');
		$smarty->assign("url" , $_SERVER['HTTP_REFERER']);
		$smarty -> show($template_edit);
	}
	
	/**
	 * 输出编辑界面
	 */
	function edit()
	{
		global $smarty, $pdo, $template_edit,$project_text,$news_type_text,$flag_text;
		$para = formatParameter($_GET["sp"], "out");
		$Id = isset($para['id']) ? $para['id'] : 1;
		
		$ValueList = $pdo->getRow("select * from paladin_project_news where id = '$Id'");
		$ValueList['project_text'] = $project_text;
		$ValueList['news_type_text'] = $news_type_text;
		$ValueList['flag_text'] = $flag_text;
		$smarty->assign('paladinprojectnewsInfo',$ValueList);
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
		$pdo->remove("id={$id}","paladin_project_news");
		$msg = '删除成功';
		page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
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
			    $query = " DELETE FROM paladin_project_news WHERE `id` IN (". implode(",", $id) .")";
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
		global $smarty, $pdo, $template_list, $news_type_text, $project_text;
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
	    $select_columns = 'select %s from paladin_project_news as a %s %s %s';
	    
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
		$smarty->assign('news_type_text',	$news_type_text);

		foreach ($res as $key => $item) {
			if(!is_null($item['project_id']))
			$res[$key]['project_name'] = $project_text[$item['project_id']];
			if(!is_null($item['news_type']))
			$res[$key]['news_type_text'] = $news_type_text[$item['news_type']];
		}
	 	// 查询到的结果
	 	$smarty->assign("EditOption", 'delall');
		$smarty->assign('paladinprojectnewsList', $res);
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
		if (array_key_exists('news_title',$Data)) { $Data['news_title'] = $Data['news_title']; $ValueList['news_title']= "{$Data['news_title']}";}
		if (array_key_exists('news_type',$Data)) { $Data['news_type'] = $Data['news_type']; $ValueList['news_type']= "{$Data['news_type']}";}
		if (array_key_exists('news_subhead',$Data)) { $Data['news_subhead'] = $Data['news_subhead']; $ValueList['news_subhead']= "{$Data['news_subhead']}";}
		if (array_key_exists('news_brief',$Data)) { $Data['news_brief'] = $Data['news_brief']; $ValueList['news_brief']= "{$Data['news_brief']}";}
		if (array_key_exists('news_content',$Data)) { $Data['news_content'] = $Data['news_content']; $ValueList['news_content']= "{$Data['news_content']}";}
		if (array_key_exists('remark',$Data)) { $Data['remark'] = $Data['remark']; $ValueList['remark']= "{$Data['remark']}";}
		if (array_key_exists('news_mediawebsite',$Data)) { $Data['news_mediawebsite'] = $Data['news_mediawebsite']; $ValueList['news_mediawebsite']= "{$Data['news_mediawebsite']}";}
		if (array_key_exists('user_id',$Data) && ($Data['user_id'] !== '')) { $Data['user_id'] = (int)$Data['user_id'];  $ValueList['user_id']= "{$Data['user_id']}";}
		if (array_key_exists('create_at',$Data) && ($Data['create_at'] !== '')) { $Data['create_at'] = (int)$Data['create_at'];  $ValueList['create_at']= "{$Data['create_at']}";}
		if (array_key_exists('edit_at',$Data) && ($Data['edit_at'] !== '')) { $Data['edit_at'] = (int)$Data['edit_at'];  $ValueList['edit_at']= "{$Data['edit_at']}";}
		if (array_key_exists('flag',$Data) && ($Data['flag'] !== '')) { $Data['flag'] = (int)$Data['flag'];  $ValueList['flag']= "{$Data['flag']}";}
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
				if(isset($Data['news_title']) && $Data['news_title'] != ""){
			$where .=" and a.`news_title` = '{$Data['news_title']}'";
			$page_info.="news_title={$Data['news_title']}&";
			$smarty->assign("news_title",$Data['news_title']);
		}
				if(isset($Data['news_type']) && $Data['news_type'] != ""){
			$where .=" and a.`news_type` = '{$Data['news_type']}'";
			$page_info.="news_type={$Data['news_type']}&";
			$smarty->assign("news_type",$Data['news_type']);
		}
				if(isset($Data['news_subhead']) && $Data['news_subhead'] != ""){
			$where .=" and a.`news_subhead` = '{$Data['news_subhead']}'";
			$page_info.="news_subhead={$Data['news_subhead']}&";
			$smarty->assign("news_subhead",$Data['news_subhead']);
		}
				if(isset($Data['news_brief']) && $Data['news_brief'] != ""){
			$where .=" and a.`news_brief` = '{$Data['news_brief']}'";
			$page_info.="news_brief={$Data['news_brief']}&";
			$smarty->assign("news_brief",$Data['news_brief']);
		}
				if(isset($Data['news_content']) && $Data['news_content'] != ""){
			$where .=" and a.`news_content` = '{$Data['news_content']}'";
			$page_info.="news_content={$Data['news_content']}&";
			$smarty->assign("news_content",$Data['news_content']);
		}
				if(isset($Data['remark']) && $Data['remark'] != ""){
			$where .=" and a.`remark` = '{$Data['remark']}'";
			$page_info.="remark={$Data['remark']}&";
			$smarty->assign("remark",$Data['remark']);
		}
				if(isset($Data['user_id']) && $Data['user_id'] != ""){
			$where .=" and a.`user_id` = '{$Data['user_id']}'";
			$page_info.="user_id={$Data['user_id']}&";
			$smarty->assign("user_id",$Data['user_id']);
		}
				if(isset($Data['create_at']) && $Data['create_at'] != ""){
			$where .=" and a.`create_at` = '{$Data['create_at']}'";
			$page_info.="create_at={$Data['create_at']}&";
			$smarty->assign("create_at",$Data['create_at']);
		}
				if(isset($Data['edit_at']) && $Data['edit_at'] != ""){
			$where .=" and a.`edit_at` = '{$Data['edit_at']}'";
			$page_info.="edit_at={$Data['edit_at']}&";
			$smarty->assign("edit_at",$Data['edit_at']);
		}
				if(isset($Data['flag']) && $Data['flag'] != ""){
			$where .=" and a.`flag` = '{$Data['flag']}'";
			$page_info.="flag={$Data['flag']}&";
			$smarty->assign("flag",$Data['flag']);
		}
		}
?>