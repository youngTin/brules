<?php
/**
 * 会员中心忘记密码
* @Created 2012-4-12 
* @name member_forgetpass.php
* @author QQ:279532103
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_forgetpass.php,v 1.1 2012/04/12 09:02:32 gfl Exp $
*/
session_start();

require_once('./member_config.php');
require_once('./data/cache/base_code.php');
$member = new MemberLogin(30*24*60*60,"Session");
$smarty = new WebSmarty();
$smarty->caching = false;
/**
 * 已登录跳转会员首页
 * */
if ($member->IsLogin())
{
	 Header("Location: index.php");  
}
switch(isset($_GET['action'])?$_GET['action']:'index')
{
	case 'index':index();break; //登录页面
	case 'getback':getback();break;//登录处理
	case 'editpass':editPass();break;
	case 'dopass':dopass();break;
	default:index();break;
}

function index()
{
	global  $smarty;

	$smarty->assign('posts',$_POST);
	$smarty->show('mydr/forgetpass.tpl');
}

function getback()
{
	global $member;
	InfoCheck($_POST);
	extract($_POST);
	$svali = GetCkVdValue();
	if(strtolower($vdcode)!=$svali || $svali=='')
	{
		ResetVdValue();
		page_prompt("验证码出错!!",false,'forgetpass.html',3,$_POST);
	}
	//检查用户是否存在
	if(!$member->CheckUserName($username))page_prompt('用户名不存在',false,'member_forgetpass.php',3,$_POST);
	//检查用户名与EMAIL是否匹配
	if(!$member->checkEailInUsername($email,$username))page_prompt('用户名与email不匹配',false,'member_forgetpass.php',3,$_POST);
	//发送邮件
	$keyCode = array('username'=>$username,'email'=>$email);
	$code = urlencode(authcode(serialize($keyCode),'ENCODE',SMTP_LINK_PWD,1800));//过期时间半个小时30*60
	$smtpserver=SMTP_SERVER;
	$port =SMTP_PORT; //smtp服务器的端口，一般是 25 
	$smtpuser = SMTP_USER; //您登录smtp服务器的用户名
	$smtppwd = SMTP_PWD; //您登录smtp服务器的密码
	$mailtype = "HTML"; //邮件的类型，可选值是 TXT 或 HTML ,TXT 表示是纯文本的邮件,HTML 表示是 html格式的邮件
	$sender = SMTP_SENDUSER; 
	//发件人,一般要与您登录smtp服务器的用户名($smtpuser)相同,否则可能会因为smtp服务器的设置导致发送失败
	$smtp  =   new Smtp2($smtpserver,$port,true,$smtpuser,$smtppwd,$sender); 
	$smtp->debug = SMTP_DEBUG; //是否开启调试,只在测试程序时使用，正式使用时请将此行注释
	$to = $email; //收件人
	$subject = "和睦家网密码修改确认信";
	$body = "
	亲爱的和睦家会员：$username 您好<br>
	如果您并没有访问过 和睦家网，或没有进行上述操作，请忽 略这封邮件。您不需要退订或进行其他进一步的操作。<br>
	您的和睦家密码修改链接如下：<a href='".URL."/member_forgetpass.php?action=editpass&code=$code' target='_blank'>".URL."/member_forgetpass.php?action=editpass&code=$code</a><br>
    本邮件请使用HTML方式显示，否则以上链接可能无法正确显示。<br>
    如果点击以上链接不能进入，请把以上链接复制粘贴到浏览器的地址栏，然后回车来执行此链接。<br>
    此链接半小时内有效，如链接失效请到官方网站(<a href='".URL."/member_forgetpass.php'>".URL."/member_forgetpass.php</a>)重新发送修改确认信！<br>
    请勿回复此信件  ";
	$send=$smtp->sendmail($to,$sender,$subject,$body,$mailtype);
	if($send==1){
	   page_prompt('邮件发送成功',true,'index.html',3); ;
	}else{
	   page_prompt('邮件发送失败',false,$_SERVER['HTTP_REFERER'],3,$_POST); 
	   //echo "原因：".$this->smtp->logs;
	}
}
/**
+----------------------------------------------------------
* 密码修改
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function editPass()
{
	global  $member,$smarty; 
	$code=$_GET['code'];
	//验证连接
	$code = authcode($code,'DECODE',SMTP_LINK_PWD);
	if(empty($code))page_prompt('验证失败或已超时，请重新发送验证邮件',false,'member_forgetpass.php',3);
	$userinfo = unserialize($code);
	//验证用户名和email
	if(!$member->checkEailInUsername($userinfo['email'],$userinfo['username']))page_prompt('用户名与email不匹配',false,'member_forgetpass.php',3,$_POST);
	$smarty->assign('userinfo',$_GET['code']);
	$smarty->show('member/member_editpass.tpl');
}
/**
+----------------------------------------------------------
* 保存修改密码
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function dopass()
{
	global $member;
	@extract($_POST);
	//验证码
	$svali = GetCkVdValue();
	if(strtolower($vdcode)!=$svali || $svali=='')
	{
		ResetVdValue();
		page_prompt("验证码出错!!",false,$_SERVER['HTTP_REFERER'],3,$_POST);
	}
	//验证提交的用户是否和需要修改密码的用户一直
		//验证连接
		$code = authcode($userinfo,'DECODE',SMTP_LINK_PWD);
		if(empty($code))page_prompt('验证失败或已超时，请重新发送验证邮件',false,'member_forgetpass.php',3);
		$Uinfo = unserialize($code);
		if($Uinfo['username']!=$username)page_prompt('非法用户提交',false,$_SERVER['HTTP_REFERER'],3,$_POST);
	//验证用户是否存在
	if(!$member->CheckUserName($username))page_prompt('用户名不存在',false,$_SERVER['HTTP_REFERER'],3,$_POST);
	//验证密码
	if(utf8_strlen($password)<6||utf8_strlen($password)>15)page_prompt('密码不能为空且至少6位最多15位！',false,'member_forgetpass.php',3);
	if($password!=$repassword)page_prompt('两次密码输入不一致！',false,'member_forgetpass.php',3);
	//修改密码
	$password = md5($password.$member->key);
	if(getPdo()->execute(" update ".DB_PREFIX_HOME."user set password = '$password' where username = '$username' "))
		page_prompt('密码修改成功',false,'index.php',3);
	else 
		page_prompt('密码修改失败',false,$_SERVER['HTTP_REFERER'],3);
}
/**
+----------------------------------------------------------
* 提交信息Check
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function  InfoCheck($post)
{
	@extract($post);
	$url = 'forgetpass.html' ;
	//用户名不能为空 且25字
	if(empty($username)||utf8_strlen($username)>25||utf8_strlen($username)<3)page_prompt('用户名不能为空，且长度小于25位',false,$url,3,$post);
	//联系电话不能为空
	if(!preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",$email))page_prompt('邮箱格式不正确',false,$url,3,$post);
	
}