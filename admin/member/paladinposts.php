<?php

	require_once('../../sys_load.php');
	require_once('../../data/cache/base_code.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//模板路径,生成后自行修改
	$template_edit = "admin/member/paladinposts_edit.tpl";
	$template_list = "admin/member/paladinposts_list.tpl";
	//有效标志[0:无效 1:有效]
	$flag_text=array('0'=>'无效','1'=>'有效');
	//是否置顶[0:不置顶 1:置顶]
	$top_text=array('0'=>'未置顶','1'=>'置顶');
	//获取系统所有项目
	$allproject = $pdo->getAll('select id,project_name from paladin_project');
	$project_text = array();
	foreach($allproject as $row){
		$project_text[$row['id']] = $row['project_name'];
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
		$Data['user_name']=$_SESSION['userName'];
		$Data['create_at']=time();//创建时间
		$Data['edit_at']=time();  //最后修改时间
		if (isset($Data) &&  $pdo->add($Data,'paladin_posts')) {
   			 $pdo->getLastInsID();
   			 page_msg('保存成功!',$isok=true,$url=$_SERVER['HTTP_REFERER']);
		} else {
			page_msg('添加失败！',$isok=false,$url=$_SERVER['HTTP_REFERER']);
		}

		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['id'])) {		
			$Data = filter($_POST); 
			unset($Data['create_at']);
			unset($Data['user_name']);
			$Data['edit_at']=time();
			if (isset($Data)) {
				 $pdo->update($Data , 'paladin_posts', "id=".$_POST['id']);
	   			 page_msg('修改成功！',$isok=true,$url=$_SERVER['HTTP_REFERER']);
			} else {
				page_msg('修改失败！',$isok=false,$url=$_SERVER['HTTP_REFERER']);
			}
		}
	}

	/**
	 * 输出添加界面
	 */
	function add()
	{
		global $smarty, $pdo, $template_edit,$flag_text,$house_media_text,$project_text,$top_text;
		
		$ValueList = array();
		$ValueList['flag_text'] = $flag_text;
		$ValueList['house_media_text'] = $house_media_text;
		$ValueList['project_id_text'] = $project_text;
		$ValueList['top_text'] = $top_text;
		$smarty->assign('paladinpostsInfo',$ValueList);
		$smarty->assign("EditOption" , 'New');
		$smarty->assign("url" , "/admin/member/paladinposts.php?action=index");
		$smarty -> show($template_edit);
	}
	
	/**
	 * 输出编辑界面
	 */
	function edit()
	{
		global $smarty, $pdo, $template_edit,$flag_text,$house_media_text,$project_text,$top_text;
		$para = formatParameter($_GET["sp"], "out");
		$Id = isset($para['id']) ? $para['id'] : 1;
		if($Id){
			$ValueList = $pdo->getRow("select * from paladin_posts where id = '$Id'");
			$ValueList['flag_text'] = $flag_text;
			$ValueList['house_media_text'] = $house_media_text;
			$ValueList['project_id_text'] = $project_text;
			$ValueList['top_text'] = $top_text;
			$ValueList['remark']=stripslashes(htmlspecialchars($ValueList['remark']));
			$smarty->assign('paladinpostsInfo',$ValueList);
			$smarty->assign("EditOption" , 'Edit');
			$smarty->assign("UrlReferer" , $_SERVER['HTTP_REFERER']);
			$smarty -> show($template_edit);
		}else{
			page_msg('操作失败！',$isok=false,$_SERVER['HTTP_REFERER']);
		}
	}


	/**
	 * 执行删除
	 */
	function delete()
	{
		global $pdo,$template_msg,$smarty;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 0;
		$pdo->remove("id={$id}","paladin_posts");
		$msg = '删除成功!';
		page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
	}

	/**
	 * 执行多项删除
	 */
	function deleteAll()
	{
		/*global $pdo,$template_msg,$smarty;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'delall'){
			$id = isset($_POST['ids']) ? $_POST['ids'] : array();
			$count = count($id);
			if($count != 0){
			    $query = " DELETE FROM paladin_posts WHERE `id` IN (". implode(",", $id) .")";
				$pdo->execute($query);
				$msg = '多项删除删除成功';
			}
		}
		$smarty->assign("msg" , $msg);
		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
	   	$smarty -> show($template_msg);
		*/
	}



	/**
	 * 输出列表界面
	 */
	function index()
	{
		global $smarty, $pdo, $template_list, $flag_text, $house_media_text,$project_text;
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
	    $select_columns = 'select %s from paladin_posts as a %s %s %s';
	    
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
		$smarty->assign('flag_text',	$flag_text);
		$smarty->assign('house_media_text',$house_media_text);
	 	// 查询到的结果
	 	$smarty->assign("EditOption", 'delall');
		$smarty->assign('paladinpostsList', $res);
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
		if (array_key_exists('posts_name',$Data)) { $Data['posts_name'] = $Data['posts_name']; $ValueList['posts_name']= "{$Data['posts_name']}";}
		if (array_key_exists('posts_url',$Data)) { $Data['posts_url'] = $Data['posts_url']; $ValueList['posts_url']= "{$Data['posts_url']}";}
		if (array_key_exists('posts_website',$Data)) { $Data['posts_website'] = $Data['posts_website']; $ValueList['posts_website']= "{$Data['posts_website']}";}
		if (array_key_exists('posts_hit',$Data) && ($Data['posts_hit'] !== '')) { $Data['posts_hit'] = (int)$Data['posts_hit'];  $ValueList['posts_hit']= "{$Data['posts_hit']}";}
		if (array_key_exists('posts_top',$Data) && ($Data['posts_top'] !== '')) { $Data['posts_top'] = (int)$Data['posts_top'];  $ValueList['posts_top']= "{$Data['posts_top']}";}
		if (array_key_exists('remark',$Data)) { $Data['remark'] = $Data['remark']; $ValueList['remark']= "{$Data['remark']}";}
		if (array_key_exists('user_id',$Data) && ($Data['user_id'] !== '')) { $Data['user_id'] = (int)$Data['user_id'];  $ValueList['user_id']= "{$Data['user_id']}";}
		if (array_key_exists('create_at',$Data) && ($Data['create_at'] !== '')) { $Data['create_at'] = (int)$Data['create_at'];  $ValueList['create_at']= "{$Data['create_at']}";}
		if (array_key_exists('edit_at',$Data) && ($Data['edit_at'] !== '')) { $Data['edit_at'] = (int)$Data['edit_at'];  $ValueList['edit_at']= "{$Data['edit_at']}";}
		if (array_key_exists('flag',$Data) && ($Data['flag'] !== '')) { $Data['flag'] = (int)$Data['flag'];  $ValueList['flag']= "{$Data['flag']}";}
		if (array_key_exists('project_id',$Data) && ($Data['project_id'] !== '')) { $Data['project_id'] = (int)$Data['project_id'];  $ValueList['project_id']= "{$Data['project_id']}";}
		if (array_key_exists('posts_num',$Data) && ($Data['posts_num'] !== '')) { $Data['posts_num'] = (int)$Data['posts_num'];  $ValueList['posts_num']= "{$Data['posts_num']}";}
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
				if(isset($Data['posts_name']) && $Data['posts_name'] != ""){
			$where .=" and a.`posts_name` = '{$Data['posts_name']}'";
			$page_info.="posts_name={$Data['posts_name']}&";
			$smarty->assign("posts_name",$Data['posts_name']);
		}
				if(isset($Data['posts_url']) && $Data['posts_url'] != ""){
			$where .=" and a.`posts_url` = '{$Data['posts_url']}'";
			$page_info.="posts_url={$Data['posts_url']}&";
			$smarty->assign("posts_url",$Data['posts_url']);
		}
				if(isset($Data['posts_website']) && $Data['posts_website'] != ""){
			$where .=" and a.`posts_website` = '{$Data['posts_website']}'";
			$page_info.="posts_website={$Data['posts_website']}&";
			$smarty->assign("posts_website",$Data['posts_website']);
		}
				if(isset($Data['posts_hit']) && $Data['posts_hit'] != ""){
			$where .=" and a.`posts_hit` = '{$Data['posts_hit']}'";
			$page_info.="posts_hit={$Data['posts_hit']}&";
			$smarty->assign("posts_hit",$Data['posts_hit']);
		}
				if(isset($Data['posts_top']) && $Data['posts_top'] != ""){
			$where .=" and a.`posts_top` = '{$Data['posts_top']}'";
			$page_info.="posts_top={$Data['posts_top']}&";
			$smarty->assign("posts_top",$Data['posts_top']);
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