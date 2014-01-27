<?php
/**
*	会员中心全局配置文件  
* @Created 2010-7-5上午09:34:09
* @name config.php
* @author 304260440@qq.com
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_config.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
require_once('./sys_load.php');
define('MEMBER_OPEN',1); //是否开启会员中心(包括注册登录) 1开启 0关闭
define('REFRESH_NUM',3); //允许刷新房源量
define('PUB_ALLOW_NUM',3);//个人允许发布房源量
$member = new MemberLogin(30*24*60*60,"Session");

if (MEMBER_OPEN==0)
{
	ShowMsg("<font color=red>会员中心维护中...开放时间请详见本站公告!</font>",'javascript:history.back(-1)',0,3000);
	exit();
}
//$_SESSION['home_username'] = 'younglly001';
//$_SESSION['home_userid'] = '22';
//TODO:

define('USERNAME',$_SESSION['home_username']);
define('UID',$uid = $_SESSION['home_userid']);
define('UTYPE',$_SESSION['home_usertype']);

	
/**
* 检查用户是否登录
* @access public 
*/
function check_login()
{
	global $member;
	if (!$member->IsLogin())
	{
		header("Location:login.shtml");
		exit();
	}
}
 /**
	* 函数 update_s
	* @access public
	* @param	$type	类型
	* @param	$money	金额
	* @param	$scores 积分
	* @param	$operator	增加||减少
	* @return	
    */
function update_s($type,$money=0,$scores=0,$operation='增加')
{
	global $scores_option;
	
	if (!array_key_exists($type,$scores_option))
	{
        if($money=='ajax')return ;
		page_msg('更新积分失败!',$isok=false,'index.php');
		return false;
		exit;
	}
	$uid = $_SESSION['home_userid'];
    $money = $money=='ajax' ? 0 : $money;
	$pname = $scores_option[$type][0]; //积分名称
	if($scores==0){//积分数
		$pscores = $scores_option[$type][1];
	}else{
		$pscores = $scores;
	}
	$time = time(); //交易时间

	//更新总积分 总金额
	$sql = "Update `home_member` set total_integral=total_integral+{$pscores} ,total_money=total_money+{$money} where uid='$uid'; ";
	$res = getPdo()->execute($sql);
	
	//更新详细记录
	getPdo()->execute("INSERT INTO `home_user_operation` (`uid`, `pname`, `product`, `operation`, `score`, `time`, `sta`)
						 VALUES ('$uid', '$pname', '$type', '$operation', '$pscores', '$time', '1')");
}
?>