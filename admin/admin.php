<?php
	//加载系统配置
	require_once('../sys_load.php');
	$smarty = new WebSmarty();
	$smarty->caching = false;
	$smarty->cache_lifetime = 60;
	switch(isset($_GET['action'])?$_GET['action']:'login_show')
	{
		case 'index':index(); //后台登录主页面
			exit;
		case 'login_show':login_show();  //输入后台登录界面
			exit;
		case 'login':login();            //登录后台
			exit;
		case 'out':out();                //退出后台
			exit;
		default:login_show();
			exit;
	}
		
	/**
	 * 主界面
	 */
	function index()
	{
		global $smarty;
		//安全性验证
		$safe_validator=new Verify();
		$smarty->show('admin/admin.tpl');
	}
	
	/**
	 * 显示后台登录界面
	 */
	function login_show()
	{
		global $smarty;
		if(isset($_SESSION['userId']))redirect('admin.php?action=index');
		$smarty->show('admin/login.tpl');
	}

	/**
	 * 用户登录
	 */
	function login()
	{
        $svali = GetCkVdValue();
        if(strtolower($_POST['ck'])!=$svali || $svali=='')
        {
            ResetVdValue();
            page_msg("验证码出错!!",false,'javascript:history.back(-1)',3);
            exit();
        }
		$loginName = $_POST['user_name'];
		$passWord = $_POST['password'];
		if(!empty($loginName) and !empty($passWord)) 
		{
			$login = new login();
			$login->vlogin($loginName, $passWord);
			page_msg($msg=$_SESSION['msg'],$isok=false,$url='/admin/admin.php');
		}else{
			page_msg('用户名或密码不能为空！',$isok=false,'/admin/admin.php');
		}
	}

	/**
	 * 用户退出
	 */
	function out()
	{
		//安全性验证
		//$safe_validator=new Verify();
		$login=new login();
		$login->logout();
	}

?>