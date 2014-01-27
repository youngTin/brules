<?php 
/**
 * Created on 2008-03-21
 * 会员登录
 * @author ld<luodongdaxia@yahoo.com.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: login.class.php,v 1.2 2012/02/08 02:59:35 lyx Exp $
 */

require_once('BasePage.class.php');

class Login extends BasePage {

	// 登录名
	private $loginName;

	// 密码
	private $password;


	/**
     * 构造函数
     * @access public 
     */
    public function __construct(){
        parent::__construct();
    }

    /**
    * 后台用户登录
    * @access public 
    * @param  $name   登录名
    * @param  $pwd    密码
    * @return 
    */
    public function vlogin($name, $pwd){
		$this->loginName = $name;
		$this->password = $pwd;

        // 调用公用方法进行登录验证
		$userInfo = $this->getLoginInfo();

		// 没有登录成功
		if(empty($userInfo)){$_SESSION['msg'] = "用户名与密码不匹配，请重新输入！";return;};

		// 没取到信息重新登录
		if(empty($userInfo['uid'])) {$_SESSION['msg'] = "获取用户信息失败，请得新登录！";return;};

		// 用户ID
		$_SESSION['userId'] = $userInfo['uid'];

		// 用户真实姓名
		$_SESSION['userName'] = $userInfo['username'];

		// 是否是最高管理员
		$_SESSION['isAdmin'] = $userInfo['isadmin'];
		
		// 写在登陆信息
		$this->pdo->update(array('logintime'=>time(),'ip'=>$this->clientIp),'admin','uid='.$userInfo['uid']);
		
		redirect("/admin/admin.php?action=index");return;
		//if($_SESSION["userType"]>=9){redirect("../admin.php?action=index");return;}
    }

    /**
    +----------------------------------------------------------
    * 用户退出
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @return 
    +----------------------------------------------------------
    */
    public function logout(){
        // 删除所有Session
        session_destroy();
		// 用户ID
		//@setcookie('userId',null,time()+3600*24*30,'/',DOMAIN);
		// 用户登录名
		//@setcookie('userName',null,time()+3600*24*30,'/',DOMAIN);	
        // 跳转页面
        redirect("/admin/admin.php");
    }

    /**
    * 从统一平台登录,用户登录成功，返回用户的详细信息
    * @access private 
    * @return maix
    */
	private function getLoginInfo(){		
		$sql = sprintf("select * from admin where username='%s' AND password='%s'", addslashes($this->loginName), md5($this->password));
		$aUser = $this->pdo->getRow($sql);
		return $aUser;
	}

    /**
    * 得到单位信息
    * @access private 
    * @return maix
    */
	private function getCompanyInfo($companyId){
		$sql = "select * from companywhere id=%d AND flag=1";
		$sql = sprintf($sql, $companyId);
		
		// 执行查询
		return $this->pdo->getRow($sql);
	}
	
	/**
    * 根据uid得到用户名
    * @access private 
    * @return name
    */
	public function getUserName($uid){
		$sql = "select username from admin where uid=%d AND";
		$sql = sprintf($sql, $uid);
		
		// 执行查询
		$userName=$this->pdo->getRow($sql);
		return $userName['username'];
	}

	
   function __destruct() {
       unset($_SESSION['msg']);
   }

} 
?>
