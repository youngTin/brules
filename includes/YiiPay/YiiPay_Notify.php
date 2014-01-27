<?php
include_once("Config.php");

/*
 *====================================================================
 *					www.YiiPay.com
 *
 *                易支付 提供技术支持
 *
 *     		本页面为支付完成后获取返回的参数及处理......
 *
 *====================================================================
*/

//开始接收参数 (请注意区分大小写)
//-----------------------------------------------------------------
$tradeNo	=	isset($_REQUEST["tradeNo"])?$_REQUEST["tradeNo"]:"";	//支付宝交易号
$Money		=	isset($_REQUEST["Money"])?$_REQUEST["Money"]:0;			//付款金额
$title		=	isset($_REQUEST["title"])?$_REQUEST["title"]:"";		//付款说明，一般是网站用户名
$memo		=	isset($_REQUEST["memo"])?$_REQUEST["memo"]:"";			//备注
$Sign		=	isset($_REQUEST["Sign"])?$_REQUEST["Sign"]:"";			//签名
//-----------------------------------------------------------------

if (strtoupper($Sign) != strtoupper(md5($WebID.$Key.$tradeNo.$Money.$title.$memo))){
		echo "Fail";
	}else{
		/*付款成功
		 ********************************************************************
		 会员使用支付宝付款时，可以放2个参数，分别是“付款说明”(title)和“备注”(memo)，您可以灵活使用这2个参数进行自动发货
		 $UserName	=	$title	'如充值的用户名放在title中
		 $remark	=	$memo	'如充值类型放在memo中（付款成功后是开通VIP还是开通其它服务等不同类型）
		 *******************************************************************
		*/
		
		//配置MYSQL数据库连接信息
		$mysql_server_name	=	"localhost"; 	//数据库服务器名称
		$mysql_username		=	"root"; 		// 连接数据库用户名
		$mysql_password		=	"";				// 连接数据库密码
		$mysql_database		=	""; 			// 数据库的名字
		
		$mysql_conn = mysql_connect($mysql_server_name, $mysql_username, $mysql_password);
		if ($mysql_conn){
			mysql_select_db($mysql_database, $mysql_conn);
			
		 	/********************************************************************
			为了防止用户填错“付款说明”或“备注”导致充值失败，您可以先检查用户名是否存在，再决定自动发货，以解决这个问题
			//$UserNameIsExist	=	true;	//此处修改为您的检测代码,当然如果您觉得没有必要，也可以不检测
			*/
			$rs=mysql_query("Select * From 用户表名 Where UserName='$title'");	//将查询sql语句的结果存到$rs变量中
			$num=mysql_num_rows($rs);											//mysql_num_rows函数的作用就是返回记录笔数.就是你的数据表中的总笔数
			if($num>0){
				$UserNameIsExist	=	true;	//该用户名存在
			}
			else{
				$UserNameIsExist	=	false;	//用户名不存在
			}
			//*******************************************************************
			
			if ($UserNameIsExist==true){		/*如果用户名存在，就自动发货*/
				/*
				 此处编写您更新数据库（自动发货）的代码
				 
				**********更新数据库事例开始*********************************************************
				/* 增加用户余额 */
				mysql_query("Update 用户表名 set 余额字段名=余额字段名+".($Money)." Where UserName='$title'");
				/* 增加充值记录 */
				mysql_query("Insert Into 订单表名(tradeNo,UserName,Money,PayTime) Values('$tradeNo','$title',$Money,'".date('Y-m-d H:i:s',time())."')");
				
				ob_clean();					//消除之前的输出
				echo "Success";				//此处返回值（Success）不能修改，当检测到此字符串时，就表示充值成功
			 	/* **********更新数据库事例结束********************************************************* */
			}else{
				echo "UserName does not exist!";	//当用户名不存在时，就提示此信息，并且不会自动发货
			}
			//*******************************************************************
			mysql_close($mysql_conn);
		}else{
			echo "Conect failed";		//连接数据库失败
		}
	}
?>
