<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 站点设置
 * @author ld<luodongdaxia@yahoo.com.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: set_config.php,v 1.1 2012/02/07 09:03:01 gfl Exp $
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
	$template_list = "admin/set_config.tpl";

	$code = new BaseCode();
	$borough_text=$code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'");

	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'save':save(); //修改或添加后的保存方法
			exit;
		case 'index':index(); //列表页面
			exit;
		default:index();
			exit;
	}

	/**
	 * 保存修改或增加到数据库
	 */
	function save()
	{
		if(!$_SESSION['save'])page_msg('你没有权限访问',$isok=false,$url=$_SERVER['HTTP_REFERER']);
		global $pdo;

		foreach($_POST['config'] as $key=>$item){
			$data = array('db_value'=>$item);
			$pdo->update($data , 'config', "db_name='db_".$key."'");
		}
		
		page_msg('修改成功!',$isok=true,$url=$_SERVER['HTTP_REFERER']);
	}

	/**
	 * 输出列表界面
	 */
	function index()
	{
		if(!$_SESSION['index'])page_msg('你没有权限访问',$isok=false,$url=$_SERVER['HTTP_REFERER']);
		global $smarty, $pdo, $template_list,$time_start,$borough_text;

	    $sql = "select * from config";
	    
	   	$res = $pdo->getAll($sql);
		$configList=array();
		foreach($res as $item){
			$configList[$item['db_name']]=$item['db_value'];
		}
		$configList['db_footer']=htmlspecialchars($configList['db_footer']);
	 	// 查询到的结果
		$smarty->assign('configList', $configList);
		$smarty->assign('borough',$borough_text);
		//End time
		$time_end = getmicrotime();
		$time = $time_end - $time_start;
		$smarty->assign("time" , substr($time,0,7));
		// 指定模板
		$smarty->show($template_list);
	}

?>