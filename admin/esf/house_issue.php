<?php
/**
 * Created on 2009-1-4 
 * 二手房录入
 * @since home_V2008
 * @author 庄飞<27834252@qq.com>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: house_issue.php,v 1.1 2012/02/07 09:03:29 gfl Exp $
 */
require_once("../../sys_load.php");

$pdo	= getPdo();
$smarty	= new WebSmarty;
$resold	= new Resold;

$msg	= $aPara = array();

$aPara = formatParameter($_GET['sp'], "out");
//checkParameter($aPara);

// 生成SecondHouse对象
#$esf = new SecondHouse;

// 基础代码
$code = new BaseCode();

// 物业类型
$smarty->assign("property_option", $code->getPairBaseCodeByType(203));

//产权性质
$smarty->assign("pright_option", $code->getPairBaseCodeByType(216));

//地区代码
$smarty->assign("borough_option", $code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'"));

//配套设施
$smarty->assign("facilities_checkboxes", $code->getPairBaseCodeByType(217));

//房屋朝向
$smarty->assign("toward_option", $code->getPairBaseCodeByType(215));

# 数字选项
$smarty->assign("num_option", array(0,1,2,3,4,5,6,7,8,9));


//楼盘方位(新加)
$direction_option = Array ( '226' => '东部片区', '228' => '南部片区', '227' => '西部片区', '229' => '北部片区', '230' => '中部片区', "231"=> "高校片区" ) ;

$smarty->assign("direction_option", $direction_option);


$circle_option = array(
	"1"=>"一环以内",
	"2"=>"一环~二环",
	"3"=>"二环~三环",
	"4"=>"三环以外"
);
$smarty->assign("circle_option", $circle_option);

//片区
//$smarty->assign("area_option", $code->getPairBaseCodeByType(226));

//装修情况
$smarty->assign("fitment_option", $code->getPairBaseCodeByType(219));

//建筑结构
$smarty->assign("arch_option", $code->getPairBaseCodeByType(201));
# 获取联系人信息
# 如果来自中介或个人则读 Session
# 如果来自管理后台, 则读取对应的帐号信息
$aUser = $resold->getUserById($_SESSION['userId']);
$smarty->assign($aUser);

if(!empty($_POST['reside']))
{
	$aPara['house_type'] = 2;

	$rId = $resold->saveOrUpdate($aPara); #[type]
	
	//$total = new Total();
	//$total->setTotalPublish(); //统计出售数据
	
	#echo $resold->pdo->getLastSQL();
	$resold->appendAttach($rId);
	
	$resold->countImages($rId);

	//$resold->appendMemoryWord($_POST['reside']);

	page_msg($msg="房源提交成功!",$isok=true,$url=$_SERVER['HTTP_REFERER']);
}
# 如果房源编号不为空， 则查询房源
if(isset($aPara['rId']) && $aPara['rId']>0)
{

	$esf = $resold->getOneById($aPara['rId']);

	$smarty->assign($esf);
	$smarty->assign("attach", $resold->getAttachesById($aPara['rId']));

			//片区
	if($esf['borough']!=0){
		$smarty->assign("area_option", $code->getPidByType($esf['borough']));
	}
}

$smarty->assign("msg", $msg);
$smarty->show();
?>