<?php
/**
* @Created 2011-4-26 下午04:50:33
* @name MemberLogin.class.php
* 会员登录系统类   
* 只存储变量用户名home_username和登录时间home_logintime
* @author QQ:304260440
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: Memberlogin.class.php,v 1.1 2012/02/07 08:59:18 gfl Exp $
* @example :
* $member = new MemberLogin(30*24*60*60,"Session"); //实例化登录类 Session登录方式
* if ($member->IsLogin()) //判断是否登录
* {
* 	echo "UserName:".$member->GetSession("home_username"); //获取sesssion登录名
* 	//echo "UserName:".$member->GetCookie("home_username"); //获取Cookie登录名
* 	echo "<br>登录时间:".$member->GetSession("home_logintime"); //获取登录时间
* 	//echo "<br>登录时间:".$member->GetCookie("home_logintime");//获取Cookie登录时间
* }
* else if($_POST['dopost'] =='reg') //用户注册
* {
* 	if ($member->CheckUser($username,$password)) //检查用户名密码
	{
		$member->SaveInfo($username); //写入信息
		if ($member->IsLogin())
		{
			echo '登录成功';
			exit();
		}
		else 
		{
			page_msg('登录失败',$isok=false,$member->M_Url);
			exit();
		}
	}
	else 
	{
		page_msg('用户名或密码错误',$isok=false,$member->M_Url);
		exit();
	}
* }
*/
require_once('./sys_load.php');
class MemberLogin extends BasePage
{
	public  $M_ID; 	        //会员自增ID
	public  $M_login_name;	//会员ID
	public  $M_Type;	    //会员类型 经纪人和个
	public  $M_Scores;	    //会员积分
	public  $M_UserName;    //用户名
	public  $M_LoginTime;	//最后一次登录时间
	public  $M_Url;	        //记录最后次URL
	public   $key;          //key值 数据库保存md5值格式为:md5(密码+key) 防止破译md5
	private  $M_KeepTime;	//cookie保存时间
	private  $M_notallow;	//非法关键字以后可以写入数据库
	private  $M_Way;        //记录Cookie和Session
	

	/**
      +----------------------------------------------------------
      * 构造函数
      +----------------------------------------------------------
      * @param $kptime	保存时间
      * @param	$type	Cookie和Session 默认为Cookie	
      +----------------------------------------------------------
	  */
	function __construct($kptime = -1,$way = "Cookie") //构造函数
	{
		
		parent::__construct(); //调用父类构造函数初始化数据库类
		session_register("home_username");
		session_register("home_logintime");
		session_register("home_usertype");
		session_register("home_userid");
		$this->M_Way = $way;
		if ($kptime==-1) //默认cookie保存为时间3天
		{
			$this->M_KeepTime= 3600 * 24 * 3;
		}
		else
		{
			$this->M_KeepTime=$kptime;
		}
		if ($this->M_Way=="Cookie")
		{
			$this->M_login_name = $this->GetCookie("home_username");
			$this->M_LoginTime = $this->GetCookie("home_logintime");
			$this->M_Type = $this->GetCookie("home_usertype");
			$this->M_ID = $this->GetCookie("home_userid");
		}
		else
		{
			$this->M_login_name = $this->GetSession("home_username");
			$this->M_LoginTime = $this->GetSession("home_logintime");
			$this->M_Type = $this->GetSession("home_usertype");
			$this->M_ID = $this->GetSession("home_userid");
		}
	
		$this->M_notallow = 'admin,userid,色情,法轮功,靠,麻痹';
		//$this->M_Url = $this->GetCurUrl();
		$this->M_Url = "javascript:history.back(-1)";
		$this->key = 'fc114'; //设定过后不能修改 否则验证会通不过
	}
	
	/**
      +----------------------------------------------------------
      * 函数 CheckUserName
      * 该函数用于检查用户名的合法性 
      * $ckhas为true包含检查用户名是否存在
      *	$ckhas为false只检查用户名是否合法
      * 修改记录：
      +----------------------------------------------------------
      * @access 
      +----------------------------------------------------------
      * @param	$login_name	用户ID
      * @param	$ckhas	是否检查用户名存在
      +----------------------------------------------------------
      * @return bool 	通过返回true 否则返回false
      +----------------------------------------------------------
	  */
	function CheckUserName($login_name,$ckhas=TRUE,$ajax=false)
	{
		global $dsql;
		$nas = explode(',',$this->M_notallow);
		if (in_array($login_name,$nas))	//验证敏感字段
		{
			if($ajax)exit('0');
			page_msg('你的用户名属于非法内容,请认真填写',$isok=false,$this->M_Url);
			return false;
			exit;
		}
		/*
		if(eregi("[^a-z0-9-]",$login_name))	//验证特殊字符
		{
			page_msg('用户名不能含特殊字符,请认真填写',$isok=false,$this->M_Url);
			return false;
			exit;
		}
		*/
		if ($ckhas)
		{
			$row = $this->pdo->getRow("select * from home_user where username='$login_name'");
			
			if (!$row)
			{
				return false;	
			}
			if (is_array($row))
			{
				return true;
				exit;
			}
		}
		return TRUE;
	}
	/**
      +----------------------------------------------------------
      * 函数	CheckUser
      * 检查用户名密码是否合法 
      * 
      * 修改记录：
      +----------------------------------------------------------
      * @access 
      +----------------------------------------------------------
      * @param	$login_name	用户名
      * @param	$password	密码
      +----------------------------------------------------------
      * @return bool
      +----------------------------------------------------------
      */
	function CheckUser($login_name,$password,$ajax=false)
	{
		if (!$this->CheckUserName($login_name))
		{	if($ajax) exit('0');
			page_msg("用户名不存在,请重新填写!",$isok=false,$this->M_Url);
			
			
		}
		$row = $this->pdo->getRow("select uid,user_type,username,password from `home_user` where username like '$login_name'");
		if (is_array($row))
		{
			
			if ($row['password'] != md5(trim($password).$this->key))
			{
				return false;
			}
				return true;
		}
		else 
		{
			return false;
		}
	}
   static public function GetUserInfo($uid)
   {
       $info =getPdo()->getRow("select * from home_user as hu  left join dr_user_drinfo as du on du.uid = hu.uid where hu.uid = '$uid'");
       return $info;
   }
	/**
	 * 写入Cookie
	 * @param	$key	Cookie名
	 * @param	$value	Cookie值
	 * @param	$kptime	保存时间
	 * @param	$sp		保存路径
	 * */
	function PutCookie($key,$value,$kptime,$sp="/")
	{
		setcookie($key,$value,time()+$kptime,$sp);
	}
	/**
	 * 删除Cookie
	 * @param	$key	删除Cookie名
	 * */
	function DelCookie($key)
	{
		setcookie($key,'',time()-360000,"/");
	}
	/**
	 * 获取Cookie
	 * @param	$key	待获取Cookie名
	 * */
	function GetCookie($key)
	{
		if (!isset($_COOKIE[$key]))
		{
			return '';
		}
		return $_COOKIE[$key];
	}
	/**
	 * 写入Session
	 * */
	function PutSession($key,$value)
	{
		$_SESSION[$key] = $value;
	}
	/**
	 * 删除Session
	 * */
	function DelSession($key)
	{
		session_destroy();
	}
	/**
	 * 获取Session
	 **/
	function GetSession($key)
	{
		if ($_SESSION[$key]==null)
		{
			return '';
		}
		return $_SESSION[$key];
	}
	/**
	 * 保存用户信息Cookie
	 * @param $login_name	用户名
	 * @param $user_type	用户类型
	 * @param $uid			用户ID
	 * */
	function SaveInfo($login_name,$user_type,$uid)
	{
		$this->M_login_name = $login_name;
		$this->M_LoginTime = time();
		//$row = $this->pdo->getRow("select uid,user_type from `home_user` where username like '$login_name'"); //附加将用户类型也保存为session
		$this->M_Type = $user_type;
		$this->M_ID = $uid;
		
		if ($this->M_Way=="Cookie")
		{
			if ($this->M_KeepTime>0)
			{
				$this->PutCookie('home_username',$this->M_login_name,$this->M_KeepTime);
				$this->PutCookie("home_logintime",$this->M_LoginTime,$this->M_KeepTime);
				$this->PutCookie("home_usertype",$this->M_Type,$this->M_KeepTime);
				$this->PutCookie("home_userid",$this->M_ID,$this->M_KeepTime);
			}
			else
			{
				$this->PutCookie("home_username",$this->M_login_name);
				$this->PutCookie("home_logintime",$this->M_LoginTime);
				$this->PutCookie("home_usertype",$this->M_Type);
				$this->PutCookie("home_userid",$this->M_ID);
			}
		}
		else
		{
			$this->PutSession('home_username',$this->M_login_name);
			$this->PutSession('home_logintime',$this->M_LoginTime);
			$this->PutSession("home_usertype",$this->M_Type);
			$this->PutSession("home_userid",$this->M_ID);
		}
	}
	/**
	+----------------------------------------------------------
	* 检查用户EMAIL与用户名是否匹配
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	function checkEailInUsername($email,$username)
	{
		return $this->pdo->find(DB_PREFIX_HOME.'user'," email = '$email' and username = '$username' ");
	}
	/**
	 * 是否登录
	 * */
	function IsLogin()
	{
		if ($this->M_Way=="Cookie")
		{
			$tmp = $this->GetCookie("home_username");
			if (!empty($tmp))
			{
				return true;
			}
			return false;
		}
		else 
		{
			$tmp = $this->GetSession("home_username");
			if (!empty($tmp))
			{
				return true;
			}
			return false;
		}
	}
	/**
	 * 退出登录
	 * */
	function ExitLogin()
	{
		if ($this->M_Way=="Cookie")
		{
			$this->DelCookie("home_username");
			$this->DelCookie("home_logintime");
			$this->DelCookie("home_usertype");
			$this->DelCookie("home_userid");
		}
		else
		{
			session_destroy();
		}
	}
	/**
	 * 过滤非字母数字字符串和点
	 * */
	function PregStr($str)
	{
		$fnum = ereg_replace("[^0-9a-zA-Z\.]",'',$str);
		return $fnum;
	}
	/**
	 * 测试是否带有非法字符
	 * */
	function TestPreg($str)
	{
		if (empty($str))
		{
			return false;
		}
		if (eregi("[^0-9a-z]",$str))
		{
			return false;
		}
		return true;
	}
	//获得当前的脚本网址
	function GetCurUrl()
	{
		if(!empty($_SERVER["REQUEST_URI"]))
		{
			$scriptName = $_SERVER["REQUEST_URI"];
			$nowurl = $scriptName;
		}
		else
		{
			$scriptName = $_SERVER["PHP_SELF"];
			if(empty($_SERVER["QUERY_STRING"]))
			{
				$nowurl = $scriptName;
			}
			else
			{
				$nowurl = $scriptName."?".$_SERVER["QUERY_STRING"];
			}
		}
		return $nowurl;
	}

}
?>