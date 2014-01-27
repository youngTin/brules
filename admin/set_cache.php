<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 站点设置
 * @author ld<luodongdaxia@yahoo.com.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: set_cache.php,v 1.1 2012/02/07 09:03:01 gfl Exp $
 */

	// 加载系统函数
	require_once('../sys_load.php');
	$verify = new Verify();
	$verify->validate_set_config();

	//start time
	$time_start = getmicrotime();

	// 生成Smarty 对象
	$smarty = new WebSmarty;
	$pdo = new MysqlPdo();

	//模板路径,生成后自行修改
	$template_list = "admin/set_cache.tpl";

	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'save':save(); //缓存
			exit;
		case 'index':index(); //列表页面
			exit;
		default:index();
			exit;
	}

	/**
	 * 缓存
	 */
	function save()
	{
		if(!$_SESSION['save'])page_msg('你没有权限访问',$isok=false,$url=$_SERVER['HTTP_REFERER']);
		$cacheFun = isset($_POST['action'])?$_POST['action']:'web_config';
		if($cacheFun=='all'){
			//更新所有缓存
			$cacheFun = array(
				'0'=>'web_config'
			);
		}
		$cache = new Cache();
		$result = $cache->update($cacheFun);
		page_msg($result[1],$result[0],$_SERVER['HTTP_REFERER']);
	}

	/**
	 * 输出列表界面
	 */
	function index()
	{
		if(!$_SESSION['index'])page_msg('你没有权限访问',$isok=false,$url=$_SERVER['HTTP_REFERER']);
		global $smarty,$template_list,$time_start;

		//End time
		$time_end = getmicrotime();
		$time = $time_end - $time_start;
		$smarty->assign("time" , substr($time,0,7));
		// 指定模板
		$smarty->show($template_list);
	}

?>