<?php
/**
* 找回密码
* @Created 2010-7-21下午02:02:57
* @name resetpassword.php
* @author 304260440@qq.com
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_resetpassword.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
session_start();
//error_reporting(0);
require_once 'config.php';
require_once('../sys_load.php');
require_once '../libs/MemberLogin.class.php'; //引入数据库
require_once '../libs/FromValidate_class.php';
require_once 'mail.php'; 
$smarty = new WebSmarty();
$smarty->caching = false;
$pdo=new MysqlPdo();
$member = new MemberLogin(30*24*60*60,"Session");
$pdo=new MysqlPdo();
$check = new FromValidate;
/**
 * 已登录跳转会员首页
 * */
if ($member->IsLogin())
{
	 Header("Location: index.php");  
}
	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'index':index(); //首页页面
			exit;
			exit();
		case 'get': get(); //找回密码
			exit();
		case 'getpasswd':getpasswd(); //修改密码
			exit();
		default:index();
			exit;
	}
	function index()
	{
		global $pdo,$smarty;
		$smarty->assign('resetpassword',false);
		$smarty->show();
	}
	function get()
	{
		global $pdo;
		extract($_POST);
		$svali = GetCkVdValue();
		if(strtolower($vdcode)!=$svali || $svali=='')
		{
			ResetVdValue();
			ShowMsg('验证码出错!!',-1);
			exit();
		}
		if (empty($username) || empty($email))
		{
			ShowMsg('请填写完整用户名和邮箱!',-1);
			exit();
		}
		$username = strip_tags($username);
		$res = $pdo->getRow("select * from home_user where username='$username'");
		if (!is_array($res))
		{
			ShowMsg('用户名不存在!',-1);
			exit();
		}
		if (empty($res['email']))
		{
			ShowMsg('用户未设置密报邮箱!',-1);exit();
		}
		if ($email!=$res['email'])
		{
			ShowMsg('密报邮箱不正确!',-1);exit();
		}
		newsendmail($res['uid'],$username,$email);
		ShowMsg('找回密码成功,请登录你邮箱取回密码!','login.php',0,3000);
	}
	//修改密码
	function getpasswd()
	{
		global $pdo,$smarty,$member;
		if(isset($_GET))$_POST = array_merge($_POST, $_GET);
		extract($_POST);
		if ($do=='update')  //修改密码
		{
			if (empty($uid) || !is_numeric($uid))
			{
				ShowMsg('对不起，请不要非法提交','login.php');exit();
			}
			$uid = ereg_replace("[^0-9]","",$uid);
			$res = $pdo->getRow("select * from home_pwd_tmp where uid='$uid'");
			if (!is_array($res))
			{
				ShowMsg('对不起，请不要非法提交','login.php');exit();
			}
			//临时密码最多只运行3天内修改
			$tptim= (60*60*24*3);
			$dtime = time();
			if($dtime - $tptim > $res['mailtime'])
			{
				$pdo->execute("DELETE FROM from home_pwd_tmp where uid='$uid'");
				ShowMsg("对不起，临时密码修改期限已过期","login.php");
				exit();
			}
			if (!$password || empty($password))
			{
				ShowMsg('临时密码不能为空!',-1);exit();
			}
			if (!$newpassword || empty($newpassword) || !$towpassword || empty($towpassword) )
			{
				ShowMsg('新密码不能为空!',-1);
				exit();
			}
			$password = md5(trim($password));
			if ($password != $res['pwd'])
			{
				ShowMsg('临时密码错误!',-1);exit();
			}
			if ($newpassword != $towpassword)
			{
				ShowMsg('新密码输入不一致',-1);exit();
			}
			$key = $member->key; //key值
			$pwd = md5(trim($newpassword).$key);
			$pdo->execute("UPDATE `home_user` SET `password`='$pwd' WHERE (`uid`='$uid')"); //更新home_user表密码
			$pdo->execute("DELETE FROM  home_pwd_tmp where uid='$uid'"); //删除临时表密码
			ShowMsg('恭喜你,你已成功修改密码!请牢记你修改的新密码.新密码为:'.$newpassword,'login.php',0,3000);exit();
		}
		if ($id)
		{
			$res = $pdo->getRow("select * from home_pwd_tmp where uid='$id'");
			if (is_array($res)) //修改密码才能访问修改密码页面
					$smarty->assign('resetpassword',true);
			else 
					$smarty->assign('resetpassword',false);
		}
		$smarty->assign('uid',$id);
		$smarty->show();
	}
?>