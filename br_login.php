<?php
/**
 * 会员中心登录页面
* @Created 2010-5-27 上午11:33:39
* @name login.php
* @author QQ:304260440
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_login.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
session_start();
header("Content-Type:text/html; charset=utf-8");
extract($_GET);

require_once('./member_config.php');
$smarty = new WebSmarty();
$smarty->caching = false;
$pdo=new MysqlPdo();
/**
 * 已登录跳转会员首页
 * */
if ($member->IsLogin())
{
	 Header("Location: index.php");  
}

switch(isset($_GET['action'])?$_GET['action']:'index')
{
	case 'index':index(); //登录页面
		exit;
	case 'login':login();//登录处理
		exit();
	default:index();
		exit;
}
/**
 * 会员注册页
 * */
	function index()
	{
		global $smarty, $pdo;
		if($_REQUEST['ajax'])
			$smarty->show('ajax_login.tpl');
		else
			$smarty->show('brules/login.tpl');
	}
/**
 * 会员登录
 * */
	function login()
	{
		global $member,$smarty,$pdo,$member_type;
		extract($_POST);
		
		if (empty($username) || empty($password))
		{
			if($ajax)exit('0');
			page_msg("用户名或密码不能为空!",true,'javascript:history.back(-1)',3);
			exit();
		}
		if (!$member->CheckUserName($username,false,$ajax))
		{
			if($ajax)exit('0');
			exit();
		}
		if ($member->CheckUser($username,$password,$ajax))
		{
			$row = $pdo->getRow("select u.uid,u.user_type,u.logintime,u.name,m.total_money from `home_user` as u 
								left join home_member as m on u.uid=m.uid
								where u.username like '$username'");
			$member->SaveInfo($username,$row['user_type'],$row['uid']);
			if ($member->IsLogin())
			{
                /*
				//增加积分时间限制
				$ntime=date("Ymd");
				$logintime = date("Ymd",$row['logintime']);
				//$nowtime = strtotime("$ntime-24 hour"); //现在时间减24小时
				if (intval($ntime)>intval($logintime)) //大于一天才增加登录积分
				{
					//增加积分 2010/07/05
                    $money = 0;
                    if($ajax)$money='ajax';
					update_s('login_scores',$money);
				}
                */
				//更新登录时间
				$time = time();
				$uid = $row['uid'];
				$pdo->execute("UPDATE home_user SET logintime='$time' WHERE uid='$uid'");
					//经纪人每天扣1块
				/*$subtime = $row['logintime']-time(); //登录据今天有好多天
						if (intval($row['user_type'])==2)
				{
					if ($row['logintime'] > 24*60*60) //大于一天才扣费
					{
						if ($row['total_money']>=1) //需充值过后金额大于1才扣除
						{
							for ($i=0;$i<$row['total_money'];$i++)
							{
							$pdo->execute("UPDATE home_member SET total_money=total_money-1 where uid='$uid'");
							//更新付费记录
							$time = time();
							$pdo->execute("INSERT INTO `home_user_operation` (`uid`, `pname`, `product`, `operation`, `score`, `time`, `sta`)
								 VALUES ('$uid', '经纪人每日扣费', 'cost', '减少', '', '$time', '1')");
							}
						}
					}*/
				//}
				if($ajax)exit("$uid");
				page_prompt1("登录成功,3秒之后将进入会员中心..",true,'index.html',3);
				exit();
			}
			if($ajax)exit('-1');
			page_msg("登录失败!",true,'javascript:history.back(-1)',3);
			page_prompt1("登录失败!",true,'javascript:history.back(-1)',3);
			exit();
		}
		else 
		{
			if($ajax)exit('0');
			page_msg("用户名或密码错误!",true,'javascript:history.back(-1)',3);
			exit();
		}	
		
	}
?>
