<?php
include_once("YiiPay_Fun.php");
/*
 *====================================================================
 *					www.YiiPay.com
 *
 *                 	易支付 提供技术支持
 *
 *     本页面为配置文件，请配置相关信息
 *
 *====================================================================
*/

//查询商户ID和商户Key的网址：http://www.YiiPay.com/SiteModify.asp

//此处请修改为自己的商户ID (将100修改为您自己的数字ID)
$WebID	=	3689;

//此处请修改为自己的商户Key (Key = "ABCD" ,修改""号内 ABCD 为您的密钥)
$Key	=	"4b6d204a45b14912a76086f3b976defe";

//此处请修改为商户在易支付网站绑定的支付宝账号
//绑定支付宝账号的网址：http://www.YiiPay.com/Download.asp
//若绑定多个支付宝账号，请用“;”英文分号分隔，并运行多个软件
$AliAccount	=	"sivic2000@yahoo.cn";

//如果您同时绑定了多个支付宝账号，则在此设置变换支付宝账号收款的间隔时间
$JiaoHuanTime	=	0;					//单位：分钟
//如果“$AliAccount”参数只绑定一个支付宝账号，则“$JiaoHuanTime”参数将不被使用
//“$JiaoHuanTime”如设置为“0”，则随机改变收款的支付宝账号；若设置为“60”，则每60分钟变换一次收款的支付宝账号

//是否启用跳转功能 值为“1”或“0”(1:付款成功后，自动跳转 0:付款成功后，不自动跳转)
$IsNotify	=	1;

//*******************************************************************
//=====以下代码不要修改=====
$AliAccount	=	GetRndAliAccount($AliAccount,$JiaoHuanTime);
?>