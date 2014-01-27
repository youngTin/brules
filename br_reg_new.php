<?php
/**
 * 会员注册页面
* @Created 2010-5-27 上午11:28:05
* @name reg_new.php
* @author QQ:304260440
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_reg_new.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
session_start();
header("Content-Type:text/html; charset=utf-8");
error_reporting(0);

require_once('./sys_load.php');
require_once('./member_config.php');
require_once('./data/cache/base_code.php');
$smarty = new WebSmarty();
$smarty->caching = false;
$pdo=new MysqlPdo();
$member = new MemberLogin(30*24*60*60,"Session");//使用公共的用户登录类
$check = new FromValidate();

/**
 * 已登录跳转会员首页
 * */
if ($member->IsLogin()&&$_GET['action']!='checkVerCode')
{
	 Header("Location: /index.php");  
}
	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'index':index(); //首页页面
			exit;
		case 'save':save(); //保存注册信息
			exit();	
		case 'checkuser':checkuser();//检查用户名是否存在
			exit();
        case 'checkVerCode':checkVerCode(); //检测验证码
            exit();    
		default:index();
			exit;
	}
//会员注册
	function index()
	{
		global $smarty, $pdo,$hb;
		$_GET['mty'] = isset($_GET['mty']) ? $_GET['mty'] :1 ;
		$smarty->assign('seoTitle','会员注册-和睦家');
		$smarty->assign('description',$hb['metadescrip']);
		if ($_GET['mty']=='1') //普通用户
		{
			$smarty->show('brules/register1.tpl');
			return 1;
		}
		/*
		if ($_GET['mty']=='2') //经纪人
		{
			$smarty->show('member/reg_agent.tpl');
			return 1;
		}
		if ($_GET['mty']=='3') //开发商
		{
			$smarty->show('member/reg_developers.tpl');
			return 1;
		}
		*/
		
		

		$smarty->show('member/register.tpl'); //选择页面
	}
	/**
	 * 保存注册信息
	 * */
	function save()
	{
		global $smarty, $pdo,$member,$check,$member_type;
		
		extract($_POST);     
		$svali = GetCkVdValue();
		if(strtolower($vdcode)!=$svali || $svali=='')
		{
			ResetVdValue();
			page_msg("验证码出错!!",false,'javascript:history.back(-1)',3);
			exit();
		}
			////////////////////////////个人注册//////////////////////////////////////			
			$username = trim($username);
			$password = trim($password);
			$repassword = trim($repassword);
			if ($member->CheckUserName($username))
			{
				page_prompt("用户名已经存在!",false,'javascript:history.back(-1)',3);
				return false;
			}
			if(($check->CheckName($username))==false){
				page_prompt("用户名只能为3-16位数字、字母、下划线!",false,'javascript:history.back(-1)',3);
				return false;
			}
			if (($check->CheckLength($username,3,16))==false)
			{
				page_prompt("用户名只能为3-16位长度!",true,'javascript:history.back(-1)',3);
				return false;
			}
			if (($check->CheckLength($password,6,16))==false)
			{
				page_prompt("密码只能为6-16位长度!",false,'javascript:history.back(-1)',3);
				return false;
			}
			if ($password != $repassword)
			{
				page_prompt("两次输入的密码不一致,请重新输入!",false,'javascript:history.back(-1)',3);
				return false;
			}
			//if (!$check->CheckEmail($email))
//            {
//                page_prompt("邮箱格式不正确,请重新输入!",false,'javascript:history.back(-1)',3);
//                return false;
//            }
            if (!$check->CheckMPhone($phone))
			{
				page_prompt("手机号码不正确,请重新输入!",false,'javascript:history.back(-1)',3);
				return false;
			}
			     
			$password = md5($password.$member->key);
			$time = time();//登录时间
			$ip = getClientIp();//登录IP
			$sql = "INSERT INTO `home_user` (`user_type`,`username`, `password`,`logintime`,`ip`,`telephone`, `email`,`create_at`) VALUES ('1','$username', '$password','$time','$ip','$phone', '$email',".$time.")";
			if ($pdo->execute($sql))
			{	$uid = $pdo->getLastInsId();
			
				//插入用户附表
				getPdo()->execute('insert into '.DB_PREFIX_DR."user_drinfo set uid = '$uid' , tel = '$phone' ,`username` = '$username' ");
				//模拟登录--增加附表记录
				$member->SaveInfo($username,$member_type[1],$uid);
				//注册赠送积分
				//update_s('reg_scores',0);
				
				//邀请人赠送
				//$tid = $tid-BASE_NUMBER;
				if(!empty($inuser)>0&&$uinfo=isExistId($inuser))
				{     
					upInviteInt($inuser,$uinfo['username'],$uid,$username);
                    
				}
				page_prompt("注册成功,3秒钟后将转向会员登录页!",true,'/index.html',3);
				return false;
			}
			
			exit;
		
	}
	/**
	 * 注册页面AJAX检查用户名是否存在
	 * */
	function checkuser()
	{
		global $smarty, $pdo,$member;
		extract($_GET);
		if (strlen($username)<3 || strlen($username)>20)
		{
			echo "<img src='/ui/member/img/icon_detection_no.gif'><font>用户名长度有误,长度为3到20个字符!!</font>";
			return false;
		}
		if (ereg("[^a-zA-Z0-9]",$username))
		{
			echo "<img src='/ui/member/img/icon_detection_no.gif'><font>用户名含非法字符,请重新填写!</font>";
			return false;
		}
		if ($member->CheckUserName($username))
		{
			echo "<img src='/ui/member/img/icon_detection_no.gif'><font>用户名已经存在,请重新填写!</font>";
			return false;
		}
		else 
		{
			echo "<img src='/ui/member/img/icon_detection_yes.gif'>";
		}
	}
	
/**
 * 检查邀请ID是否存在
 * */
function isExistId($tid)
{
	return getPdo()->find(DB_PREFIX_HOME.'user',"uid='$tid'",'uid,username');
}
/**
 * 更新邀请人积分
 * */
function upInviteInt($inuid,$inusername,$uid,$username)
{
    global $scores_option;
    $pdo = getPdo();
    $type = 'invite_scores' ;
    $pname = $scores_option[$type][0];
    $operation = '增加';
    $pscores = $scores_option[$type][1] ;
    $time = time();
	$pdo->execute(" update ".DB_PREFIX_DR."user_drinfo set `in_gold`=`in_gold`+".INVITE_SCORES." where uid = '$inuid' ");
    $pdo->execute("INSERT INTO `".DB_PREFIX_DR."user_invite` (`uid`, `username`, `in_uid`, `in_username`, `addtime`, `gold`)
                         VALUES ('$uid', '$username', '$inuid', '$inusername', '$time', '".INVITE_SCORES."')");
    //$pdo->execute("INSERT INTO `".DB_PREFIX_HOME."user_operation` (`uid`, `pname`, `product`, `operation`, `score`, `time`, `sta`) VALUES ('$tid', '$pname', '$type', '$operation', '$pscores', '$time', '1')");
}

/**
*检查验证码 
*/
function checkVerCode($vercode='')
{
    $vercode = $_POST['ajax']=='1' ? $_POST['vercode'] : $vercode ;
    $svali = GetCkVdValue();
    if(strtolower($vercode)!=$svali || $svali=='')
    {
        ResetVdValue();
        if($_POST['ajax']=='1')echo '0';
        else page_msg("验证码出错!!",true,'javascript:history.back(-1)',3);
        exit();
    }
    else if($_POST['ajax']=='1') echo '1';
}

?>
