<?php

	//header("Location: http://www.517ab.com/bbs"); /* Redirect browser */
    //exit;
	// 加载系统函数
	require_once('sys_load.php');
	require_once('data/cache/base_code.php');
	$smarty = new WebSmarty();
	$smarty->caching = false;

//	echo $_SERVER['REQUEST_URI'];
	if($_SERVER['REQUEST_URI']=='/')$smarty->assign('titleNav','index');
	if(stripos($_SERVER['REQUEST_URI'],'/index')!==false)$smarty->assign('titleNav','index');
	if(stripos($_SERVER['REQUEST_URI'],'/house_list')!==false){
		if(isset($_GET['house_type']) && $_GET['house_type']==1){
			$smarty->assign('titleNav','house_rent');
		}else{
			$smarty->assign('titleNav','house_sold');
		}
		if(isset($_GET['s_type']))
		{
			$titleNav = $_GET['s_type']==1 ? 'house_rent' : 'house_sold' ;
			$smarty->assign('titleNav',$titleNav);
		}
	}
	if(stripos($_SERVER['REQUEST_URI'],'/house_item')!==false){
		$para = formatParameter($_GET["sp"], "out"); 
		if($para['hosue_type']==1){
			$smarty->assign('titleNav','house_rent');
		}else{
			$smarty->assign('titleNav','house_sold');
		}
	}
	if(stripos($_SERVER['REQUEST_URI'],'/member')!==false){
		$smarty->assign('titleNav','member');
	}

	if(stripos($_SERVER['REQUEST_URI'],'/helper')!==false){
		$smarty->assign('titleNav','helper');
	}

	if(stripos($_SERVER['REQUEST_URI'],'/member_pub')!==false)$smarty->assign('titleNav','publish_house');
	$smarty->show("load_nav.html");

?>
