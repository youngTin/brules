<?php
	require_once('../sys_load.php');
	//start time
	$time_start = getmicrotime();
	
	$verify = new Verify();
	$smarty = new WebSmarty;

	$type=isset($_GET['type'])?$_GET['type']:'list';

	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'index':index();
			break;
		case 'waterimg':waterimg();
			break;
		case 'watertextlib':watertextlib();
			break;
		default:index();
			exit;
	}

	/**
	 * index category column view
	 */ 
	function index(){
		//if(!$_SESSION['index'])page_msg('123',$isok=false);
		global $type,$smarty,$time_start,$hb;
		$path = WEB_ROOT.'/'.$hb['default_tplpath'];
		$io = new Io();
		$file = $io->list_dir($path);
		foreach($file as $key=>$row){
			$pos = strpos($row['name'], $type);
			if ($pos === false) {
				unset($file[$key]);
			}
		}
		$smarty->assign('file',$file);
		$smarty->assign('type',$type);
		$smarty->show();
		//End time
		$time_end = getmicrotime();
		$time = $time_end - $time_start;
	 }

	 /**
	 * 选择水印图片
	 */ 
	function waterimg(){
		//if(!$_SESSION['index'])page_msg('123',$isok=false);
		global $type,$smarty,$time_start,$hb;
		$path = WEB_ROOT.'/admin/images/water';
		$io = new Io();
		$file = $io->list_dir($path);
		$smarty->assign('file',$file);
		$smarty->assign('type',$type);
		$smarty->show();
		//End time
		$time_end = getmicrotime();
		$time = $time_end - $time_start;
	 }

	 /**
	 * 选择水印文字
	 */ 
	function watertextlib(){
		//if(!$_SESSION['index'])page_msg('123',$isok=false);
		global $type,$smarty,$time_start,$hb;
		$path = WEB_ROOT.'/includes/encode';
		$io = new Io();
		$file = $io->list_dir($path);
		$smarty->assign('file',$file);
		$smarty->assign('type',$type);
		$smarty->show();
		//End time
		$time_end = getmicrotime();
		$time = $time_end - $time_start;
	 }

?>