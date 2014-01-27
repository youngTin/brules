<?php
/**
* 小区数据库
* @Created 2010-7-7下午02:07:45
* @name g_database.php
* @author 304260440@qq.com
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_g_database.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
session_start();
require_once 'config.php'; //引入全局配置
check_login();
require_once('../sys_load.php');
require_once('../data/cache/base_code.php');
$smarty = new WebSmarty();
$smarty->caching = false;
$pdo=new MysqlPdo();
$user_type = utype;
$user_name = uid;
$smarty->assign('user_name',$user_name);
$smarty->assign('user_type',$user_type);
switch(isset($_GET['action'])?$_GET['action']:'index')
{
	case 'index':index(); //登录页面
		exit;
	case 'save': save(); //保存
		exit();
	case 'edit': edit(); //修改删除
		exit();
	default:index();
		exit;
}

function index()
{
	global $smarty,$borough_text,$pdo,$user_name,$user_type;
	if ($user_type=='个人')
	{
		ShowMsg("个人用户无此功能!3秒后将自动返回..",'javascript:history.back(-1)',0,3000);
		exit();
	}
	
	if ($_SESSION['info']) //如果用户上传了图片而直接未提交 先删除图片
	{
		$picarray = explode(',',$_SESSION['info']);
		$num = count($picarray);
		for ($i=0;$i<($num-1);$i++)
		{
				//图片文件一起删除
			$arrAttach = $pdo->getRow("select * from home_esf_attach where id='$picarray[$i]'");
			$attach = realpath(WEB_ROOT . $arrAttach['url']);
			$m_pic = str_replace(strrchr($attach,'.'),'_m'.strrchr($attach,'.'),$attach);  
			$s_pic = str_replace(strrchr($attach,'.'),'_s'.strrchr($attach,'.'),$attach); 
			@unlink($s_pic);
			@unlink($m_pic);
			@unlink($attach);	
			$pdo->execute("DELETE FROM `home_esf_attach` WHERE (`id`='$picarray[$i]')");
			unset($_SESSION['info']);	
		}
	}
    // 基础代码
    $code = new BaseCode();
    //地区代码
    $smarty->assign("borough_option", $borough_text);
    //楼盘方位(新加)
    $direction_option = Array ( '226' => '东部片区', '228' => '南部片区', '227' => '西部片区', '229' => '北部片区', '230' => '中部片区' ) ;
    $smarty->assign("direction_option", $direction_option);
    $circle_option = array(
            "1"=>"一环以内",
            "2"=>"一环~二环",
            "3"=>"二环~三环",
            "4"=>"三环以外"
            );
    $smarty->assign("circle_option", $circle_option);
    $res = $pdo->getAll("select * from home_user_database where login_name='$user_name'");
	foreach ($res as $k=>$v)
	{
		$res[$k]['borough'] =$borough_text[$res[$k]['borough']]; //区县
		$res[$k]['region'] = getBaseCode($res[$k]['region']); //片区
		$res[$k]['direction'] = $direction_option[$res[$k]['direction']]; //方位(东西南北片区)
		$res[$k]['circle'] = $circle_option[$res[$k]['circle']]; //环线
		if ($res[$k]['sta']) //是否百科网收录
			$res[$k]['sta'] = '是';
		else 
			$res[$k]['sta'] = '否';
		$res[$k]['picnum'] = (Count(explode(',',$res[$k]['attach_id']))-1).'张';
	}
	$smarty->assign('res',$res);
	$smarty->assign('do','add');
	$smarty->show('member/g_database.tpl');
}

/**
 * 小区数据库删除修改
 * 
 * */
function edit()
{
	global $pdo,$user_name,$smarty,$borough_text;
	if(isset($_GET))$_POST = array_merge($_POST, $_GET);
	extract($_POST);
	if (!is_numeric($id))
	{
		ShowMsg('参数有误',-1,0,3000);
		exit();
	}
	if ($do=='del') //删除
	{
		$res = $pdo->getRow("select * from home_user_database where id='$id'")	;
		if(!is_array($res))
		{
			ShowMsg('读取小区数据库失败,请联系管理员!',-1,0,3000);
			exit();
		}
		else 
		{
			$picArray = explode(',',$res['attach_id']);
			$num = Count($picArray);
			for ($i=0;$i<($num-1);$i++)
			{
						//图片文件一起删除
				$arrAttach = $pdo->getRow("select * from home_esf_attach where id='$picArray[$i]'");
				$attach = realpath(WEB_ROOT . $arrAttach['url']);
				$m_pic = str_replace(strrchr($attach,'.'),'_m'.strrchr($attach,'.'),$attach);  
				$s_pic = str_replace(strrchr($attach,'.'),'_s'.strrchr($attach,'.'),$attach); 
				@unlink($s_pic);
				@unlink($m_pic);
				@unlink($attach);	
				$pdo->execute("DELETE FROM `home_esf_attach` WHERE (`id`='$picArray[$i] ')");
			}
			$f = $pdo->execute("DELETE FROM `home_user_database` WHERE (`id`='$id')");
			if ($f)
			{
				ShowMsg('删除小区数据库成功!!',-1,0,3000);
				exit();
			}
			
		}
		
	}
	elseif ($do=='edit')
	{
		//获取小区数据库列表
			    // 基础代码
	    $code = new BaseCode();
	    //地区代码
	    $smarty->assign("borough_option", $borough_text);
	    //楼盘方位(新加)
	    $direction_option = Array ( '226' => '东部片区', '228' => '南部片区', '227' => '西部片区', '229' => '北部片区', '230' => '中部片区' ) ;
	    $smarty->assign("direction_option", $direction_option);
	    $circle_option = array(
	            "1"=>"一环以内",
	            "2"=>"一环~二环",
	            "3"=>"二环~三环",
	            "4"=>"三环以外"
	            );
	    $smarty->assign("circle_option", $circle_option);
	    $res = $pdo->getAll("select * from home_user_database where login_name='$user_name'");
		foreach ($res as $k=>$v)
		{
			$res[$k]['borough'] =$borough_text[$res[$k]['borough']]; //区县
			$res[$k]['region'] = getBaseCode($res[$k]['region']); //片区
			$res[$k]['direction'] = $direction_option[$res[$k]['direction']]; //方位(东西南北片区)
			$res[$k]['circle'] = $circle_option[$res[$k]['circle']]; //环线
			if ($res[$k]['sta']) //是否百科网收录
				$res[$k]['sta'] = '是';
			else 
				$res[$k]['sta'] = '否';
			$res[$k]['picnum'] = (Count(explode(',',$res[$k]['attach_id']))-1).'张';
		}
		$smarty->assign('res',$res);
		//获取小区数据库列表结束
		//处理编辑内容
		 $database = $pdo->getRow("select * from home_user_database where login_name='$user_name' and id='$id'");
			    //地区代码
	     $smarty->assign("borough_option", $borough_text);
	     $smarty->assign('borough',$database['borough']);
		         //楼盘方位(新加)
	    $direction_option = Array ( '226' => '东部片区', '228' => '南部片区', '227' => '西部片区', '229' => '北部片区', '230' => '中部片区' ) ;
	    $smarty->assign("direction_option", $direction_option);
	    $smarty->assign('direction',$database['direction']);
	    $circle_option = array(
	            "1"=>"一环以内",
	            "2"=>"一环~二环",
	            "3"=>"二环~三环",
	            "4"=>"三环以外"
	            );
			//片区
			if($database['borough']!=0){
				$smarty->assign("area_option", $code->getPidByType($database['borough']));
					$smarty->assign("area", $database['region']);
			}
	    $smarty->assign("circle_option", $circle_option);
	    $smarty->assign('circle',$database['circle']);
	$smarty->assign('id',$database['attach_id']);
	 $smarty->assign('database',$database);
	 $smarty->assign('do','updata');
	 $smarty->show('member/g_database.tpl');
	}
}
/**
 * 小区数据库保存
 * */
function save()
{
	global $pdo,$user_name;
	extract($_POST);
	$reside = strip_tags(htmlspecialchars_decode($reside,ENT_NOQUOTES));
	if (strlen($reside) >100 && strlen($reside)<2)
	{
		ShowMsg('小区标题长度有误,请重新填写',-1,0,3000);
		exit();
	}
	$address = strip_tags(htmlspecialchars_decode($address,ENT_NOQUOTES));
	if (strlen($address)>150 && strlen($address)<2)
	{
		ShowMsg('地址长度有误,请重新填写',-1,0,3000);
		exit();
	}
/*	if (!is_numeric($borough) || !is_numeric($area) || !is_numeric($direction) || !is_numeric($circle))
	{
		ShowMsg('填写有误,请重新填写',-1,0,3000);
		exit();
	}*/
	$description = strip_tags(htmlspecialchars_decode($description,ENT_NOQUOTES));
	if (strlen($description)>600 && strlen($description)<2)
	{
		ShowMsg('小区描述长度有误,请重新填写',-1,0,3000);
		exit();
	}
	$time = time();
	$attach_id = @$_SESSION['info'];
	if ($do=='add') //增加小区数据库
	{
		$sql = "INSERT INTO `home_user_database` (`login_name`, `reside`, `address`, `borough`, `region`, `direction`, `circle`, `description`, `attach_id`, `sta`,`time`)
				 VALUES ('$user_name', '$reside', '$address', '$borough', '$area', '$direction', '$circle', '$description', '$attach_id', '0','$time')";
	}
	elseif ($do=='updata') //更新小区数据库
	{
		$r = $pdo->getRow("select attach_id from home_user_database where id='$dbid'");
		$attach_id = $attach_id.$r['attach_id'];
		$sql = "UPDATE home_user_database set reside='$reside',address='$address',borough='$borough',region='$area',direction='$direction',circle='$circle',description='$description',attach_id='$attach_id',time='$time' where id='$dbid' ";
		unset($_SESSION['info']);
	}
	if ($pdo->execute($sql))
	{
		unset($_SESSION['info']);	
		ShowMsg('增加小区数据库成功,请等待审核!','g_database.php?action=index&do=index',0,3000);
		exit();
	}

}
function getBaseCode($code)
{
	global $pdo;
	if (empty($code))
		return 0;
	$res = $pdo->getRow("SELECT * FROM `home_code_basic` WHERE `code` LIKE '%$code%'");
	if (is_array($res))
		return $res['name'];
	else 
		return 0;
}
?>