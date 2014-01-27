<?php
/**
 * Created on 2008-06-05
 * 二手房图片
 * @since home_V2008
 * @author like<like@fc114.com>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: esf_pic.php,v 1.1 2012/02/07 09:03:29 gfl Exp $
 */

session_start();

// 加载系统函数
require_once('../../sys_load.php');

// 生成Smarty 对象
$smarty = new WebSmarty;

// 生成SecondHouse对象
$esf = new SecondHouse;
$resold	= new Resold;

$aPara = array();
$type  = $atId  = $esfId  = 0;

if(!empty($_GET['sp'])){
    $aPara = formatParameter($_GET['sp'], 'out');
    $esfId = isset($aPara['esfId'])?$aPara['esfId']:'';
    $type =  isset($aPara['type'])?$aPara['type']:'';
    $atId =  isset($aPara['atid'])?$aPara['atid']:'';
}

if($type==1){
    //删除图片
    $resold->removePic($atId);
    $resold->countImages($esfId);
}

$test = $esf->countEsfAttach($esfId);

if(!empty($_FILES['file1']) && ($esf->countEsfAttach($esfId)<= 5 )){
	
	$resold->appendAttach($esfId);
	$resold->countImages($esfId);
}

$smarty->assign("attach", $esf->getAttachByEsfId($esfId));

// 指定模板
$smarty->show();


?>