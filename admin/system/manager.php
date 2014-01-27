<?php
	require_once('../../sys_load.php');
	$verify = new Verify();
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//template url
	$template_edit = "admin/system/manager_edit.tpl";
	$template_list = "admin/system/manager_list.tpl";

	switch(isset($_GET['action'])?$_GET['action']:'index')
		{
			case 'add':add();
				exit;
			case 'edit':edit();
				exit;
			case 'save':save();
				exit;
			case 'index':index();
				exit;
			case 'del':del();
				exit;
			default:index();
				exit;
		}
	/**
	 * save edit and add 
	 */
	function save()
	{
		global $pdo;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new') {
			
			// regist admin's table
			$admin = array("username"=>$_POST['username'], "password"=>md5($_POST['password']));
			$pdo->add($admin, "admin");
			$uid=$pdo->getLastInsID();
			
			if ($uid) {
				 $result1 = empty($_POST['set_category'])?array():$_POST['set_category'];
				 $result2 = empty($_POST['privcate'])?array():$_POST['privcate'];
				 $result = array_merge($result1, $result2);
				 foreach($result as $item){
					$pdo->add(array('uid'=>$uid,'category_id'=>$item),'admin_category');
				 }
				 $msg = 'Save success!';
			} else {
				$msg = 'Save failure!';
			}
			page_msg($msg,$isok=true,$_SERVER['HTTP_REFERER']);

		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['uid'])) {		
			$msg='';
			if(!empty($_POST['password'])){
				//modify password
				$pdo->update(array("password"=>md5($_POST['password'])), 'admin', "uid=".$_POST['uid']);
				$msg = 'The password';
			}
			//modify category
			$pdo->remove("uid={$_POST['uid']}","admin_category");

			foreach($_POST['set_category'] as $item){
				$pdo->add(array('uid'=>$_POST['uid'],'category_id'=>$item),"admin_category");
			}
			foreach($_POST['privcate'] as $item){
				$pdo->add(array('uid'=>$_POST['uid'],'category_id'=>$item),"admin_category");
			}
			$msg .= ' modify successfully!';
			page_msg($msg,$isok=true,$_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * output add interface
	 */
	function add()
	{
		global $smarty, $pdo, $template_edit;
		
		$ValueList = array();

		//all category list
		$sqlCategoryP='select id,name,mid,parent_id from category where parent_id=0 and mid=0 and flag=1 ';
		$categoryInfo=$pdo->getAll($sqlCategoryP);
		foreach($categoryInfo as $key=>$item){
			$sqlCategoryC='select id,name,mid,parent_id from category where flag=1 and parent_id='.$item['id'];
			$categoryInfo[$key]['child']=$pdo->getAll($sqlCategoryC);
		}
		$smarty->assign('categoryInfo',$categoryInfo);

		//获取栏目权限
		$columnSql='select id,name,mid,parent_id from category where mid>0 and parent_id=0 and flag=1 order by order_list desc';
		$columnInfo=$pdo->getAll($columnSql);
		foreach($columnInfo as $key=>$item){
			$sqlColumnC='select id,name,mid,parent_id from category where flag=1 and parent_id='.$item['id'].' order by order_list desc';
			$columnInfo[$key]['child']=$pdo->getAll($sqlColumnC);
			foreach($columnInfo[$key]['child'] as $ckey=>$ci){
				$child_sql="select * from category where mid>0 and parent_id=".$ci['id']."  order by order_list desc";
				$columnInfo[$key]['child'][$ckey]['child'] = $pdo->getAll($child_sql);
			}
		}
		$smarty->assign('columnInfo',$columnInfo);

		$smarty->assign('managerInfo',$ValueList);
		$smarty->assign("EditOption" , 'New');
		$smarty->assign("url" , $_SERVER['HTTP_REFERER']);
		$smarty->show($template_edit);
	}
	
	/**
	 * output edit interface
	 */
	function edit()
	{
		global $smarty, $pdo, $template_edit, $user_type_text,$flag_text;
		$para = formatParameter($_GET["sp"], "out");

		//根据user_id得到用户的相应功能
		$allowCategory = $pdo->getAll('select * from admin_category where uid='.$para['uid']);
		$list=array();
		foreach($allowCategory as $i){
			$list[]=$i['category_id'];
		}

		//获取功能列表
		$sqlCategoryP='select id,name,mid,parent_id from category where parent_id=0 and mid=0 and flag=1 order by order_list desc';
		$categoryInfo=$pdo->getAll($sqlCategoryP);
		foreach($categoryInfo as $key=>$item){
			$sqlCategoryC='select id,name,mid,parent_id from category where flag=1 and parent_id='.$item['id'].' order by order_list desc';
			$allCategoryC=$pdo->getAll($sqlCategoryC);
			foreach($allCategoryC as $ckey=>$alone){
				if(in_array($alone['id'],$list))$allCategoryC[$ckey]['check']='true';
			}
			$categoryInfo[$key]['child']=$allCategoryC;
		}
		$smarty->assign('categoryInfo',$categoryInfo);

		//获取栏目权限
		$columnSql='select id,name,mid,parent_id from category where mid>0 and parent_id=0 and flag=1 order by order_list desc';
		$columnInfo=$pdo->getAll($columnSql);
		foreach($columnInfo as $key=>$item){
			if(in_array($item['id'],$list))$columnInfo[$key]['check']='true';
			$sqlColumnC='select id,name,mid,parent_id from category where flag=1 and parent_id='.$item['id'].' order by order_list desc';
			$allColumnC=$pdo->getAll($sqlColumnC);
			foreach($allColumnC as $ckey=>$j){
				if(in_array($j['id'],$list))$allColumnC[$ckey]['check']='true';
			}
			$columnInfo[$key]['child']=$allColumnC;
			foreach($columnInfo[$key]['child'] as $ckey=>$ci){
				$child_sql="select * from category where mid>0 and parent_id=".$ci['id']."  order by order_list desc";
				$childColumn = $pdo->getAll($child_sql);
				foreach($childColumn as $cckey=>$k){
					if(in_array($k['id'],$list))$childColumn[$cckey]['check']='true';
				}
				$columnInfo[$key]['child'][$ckey]['child'] = $childColumn;
			}
		}
		$smarty->assign('columnInfo',$columnInfo);
		//print_r($columnInfo);

		$ValueList['uid'] = isset($para['uid']) ? $para['uid'] : 0;
		$ValueList['username'] = isset($para['username']) ? $para['username'] : '';

		$smarty->assign('managerInfo',$ValueList);
		$smarty->assign("EditOption" , 'edit');
		$smarty->assign("UrlReferer" , $_SERVER['HTTP_REFERER']);
		$smarty->show($template_edit);	
	}


	/**
	 * delete
	 */
	function del()
	{
		global $pdo,$smarty;
		$para = formatParameter($_GET["sp"], "out");
		$uid = isset($para['uid']) ? $para['uid'] : 0;
		//判断是否是删除最高管理员
		if($uid==1){
			page_msg('非法操作！',$isok=false,$_SERVER['HTTP_REFERER']);
		}else{
			$rst1=$pdo->remove("uid={$uid}","admin_category");
			$rst2=$pdo->remove("uid={$uid}","admin");
			if($rst1 && $rst2)$msg = '删除成功';else $msg = '删除失败';
			page_msg($msg,$isok=true,$_SERVER['HTTP_REFERER']);
		}
	}

	/**
	 * output admin list
	 */
	function index()
	{
		global $smarty, $pdo, $template_list, $user_type_text;
		$page_info = "";
		$pageSize = 15;
		$offset = 0;
		$subPages=5; //pages number
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$where = 'where 1';
	   	if($_GET) {
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	        }
	    $select_columns = 'select %s from admin as a %s %s %s';
	    
	    $order = "order by uid asc";
	    $limit = "limit $offset,$pageSize";
	    $count = " count(a.uid) as count ";
	    $sql = sprintf($select_columns,'a.*',$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();

	 	// result
		$smarty->assign('List', $res);
		// page
		$smarty->assign('splitPageStr', $splitPageStr);
		// tpl
		$smarty->show($template_list);
	}

	function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
		if(isset($Data['username']) && $Data['username'] != ""){
			$where .=" and a.username = '{$Data['username']}'";
			$page_info.="user_name={$Data['username']}&";
			$smarty->assign("username",$Data['username']);
		}
	}
?>