<?php
/**
* 会员中心AJAX获取
* @Created 2010-7-9上午09:34:53
* @name ajax.php
* @author 304260440@qq.com
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_ajax.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
error_reporting(0);
require_once('../sys_load.php');
$input_info = array();
if(isset($_GET))$_POST = array_merge($_POST, $_GET);
foreach ($_POST as $k=>$v)
{
	$input_info[] = strip_tags($v);
}
if (!$input_info[1] || !$input_info[0]) return ;
$pdo=new MysqlPdo();

switch ($input_info[0])
{
	case 'm_esf': getesf(); //获取二手房小区数据库
		exit();
	case 'm_esfinfo': m_info();
		exit();
	case 'addSession': addSession();
		exit();
	default:getesf();
		exit();
}

/**
 * 二手房小区数据库获取
 * 这里只获取小区数据库 小区名称
 * */
function getesf()
{
	global $input_info,$pdo;
	$k = $input_info[1];
	$result = $pdo->getAll("SELECT reside FROM home_user_database WHERE reside LIKE  '%$k%' limit 10");
	$num = Count($result);
	for ($i=0;$i<=$num;$i++)
	{
		echo $result[$i]['reside']. "\n";
	}
}
/**
 * 获取详细内容完成填充
 * */
function m_info()
{
	global $pdo;
	$k = strip_tags($_GET['k']);
	$result = $pdo->getRow("select * from home_user_database where reside='$k' limit 1");
	unset($_SESSION['do']);
	$picarray = explode(',',$result['attach_id']);
	$num = count($picarray);
	for ($i=0;$i<($num-1);$i++)
	{
			$res = $pdo->getRow("SELECT * FROM home_esf_attach where id=$picarray[$i]");
		    $url= $res['url'];
		    $id = $res['id'];
		    $str .= "
          	 
      <div style=\"float:left;display:block;width:102px;overflow:hidden;margin:15px 0 0 10px;line-height:18px;\"> <a href=\"javascript:void($id);\" onclick=\"$(\'commpic_$id\').click()\"><img src=\"$url\" width=\"100\" height=\"75\"></a>
      <input name=\"selCommImages[]\" id=\"commpic_$id\" value=\"$id\" onclick=\"javascript:selcommimage(this);\" type=\"checkbox\" style=\"width:14px;height:18px;line-height:18px;margin:0;padding:0\">打勾选中</div>";
	}
//	$_SESSION['do'] = $result['attach_id']; 
	echo $result['address'].'|'.$result['borough'].'|'.$result['region'].'|'.$result['direction'].'|'.$result['description'].'|'.$str;       //返回格式 地址|行政区|片区|方位|小区描述
}
//新增Session 2010/07/14
function addSession()
{
	global $input_info;
	if (!is_numeric($input_info[1]) || empty($input_info[1]))
	{
		return ;
	}
	
	if ($input_info[2]=='unchecked') //删除或取消选中
	{
			$a =  str_replace($input_info[1].',','',$_SESSION['do']);
			$_SESSION['do'] = $a;
	}
	elseif ($input_info[2]=='checked') //小区选中
	{
		if ($_SESSION['num']==5)
		{
			echo "最多只能上传5张图片";
			return ;
		}
		$_SESSION['do'] .= $input_info[1].',';
	}
}
?>