<?php 
/**
* 会员公告 
* @Created 2010-6-28上午10:46:46
* @name group.php
* @author 304260440@qq.com
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_group.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
session_start();
require_once 'config.php'; //引入全局配置
check_login();
require_once('../sys_load.php');
$smarty = new WebSmarty();
$smarty->caching = false;
$pdo=new MysqlPdo();
$user_type = utype;
$user_name = uname;
$smarty->assign('user_name',$user_name);
$smarty->assign('user_type',$user_type);
switch(isset($_GET['action'])?$_GET['action']:'index')
{
	case 'index':index(); //登录页面
		exit;
	default:index();
		exit;
}
function index()
{
	global $pdo,$smarty,$user_name,$user_type;

	if ($user_type=='个人')
	{
		ShowMsg("个人用户无此功能!3秒后将自动返回..",'javascript:history.back(-1)',0,3000);
		exit();
	}
	
	if(isset($_GET))$_POST = array_merge($_POST, $_GET);
	extract($_POST);
	if ($do=='index' || !isset($do))
	{
		$sql = "select m.cement,u.username from home_member as m left join home_user as u on u.uid=m.uid where u.username like '$user_name'";
		$res = $pdo->getRow($sql);
		$smarty->assign($res);
		$smarty->show();
	}
	elseif ($do=='save')
	{
		$body = addslashes(substr($body,0,300));
		$uid = uid;
		$sql = "UPDATE `home_member` SET cement='$body' WHERE `uid`='$uid'";
			if ($pdo->execute($sql))
			{
				ShowMsg("更新成功!三秒后将自动转向..",'javascript:history.back(-1)',0,3000);
				exit();
			}
			else 
			{
				ShowMsg("更新失败!三秒后将自动转向..",'javascript:history.back(-1)',0,3000);
				exit();
			}
		
	
	}

}
?>