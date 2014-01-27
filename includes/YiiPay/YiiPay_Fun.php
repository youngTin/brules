<?php

/*
 *====================================================================
 *					www.YiiPay.com
 *
 *                易支付 提供技术支持
 *
 *     		本页面为功能函数，请不要修改此文件的内容
 *
 *====================================================================
*/

//绑定多个支付宝账号时，随机获取一个支付宝账号
function GetRndAliAccount($AliAccount, $JiaoHuanTime) {	
	$result = "";
	$AliAccount = FilterAccount($AliAccount);
	//构建数组
	$Arr	=	explode(";", $AliAccount);
	$N=count($Arr);
	if($N > 0) {
		if($JiaoHuanTime > 0) {				
			$idx = floor((time()/60)/$JiaoHuanTime) % $N;
		}else {
			$idx = floor( ($N * rand(0, 9)/10));
		}		
		$result = $Arr[$idx];
	}
	else {
		$result = $AliAccount;
	}
	
	return $result;
}

//过滤绑定的支付宝账号格式
function FilterAccount($AliAccount) {
	$AliAccount = str_replace(" ", "", $AliAccount);
	$AliAccount = str_replace("，", ",", $AliAccount);
	$AliAccount = str_replace(",", ";", $AliAccount);
	$AliAccount	= str_replace("；", ";", $AliAccount);	//过滤空格，逗号，中文分号	
	//过滤数组防止空元素
	$Arr	=	explode(";" , $AliAccount);
	$N= count($Arr);
	$Str	=	"";
	$ands = '';
	for ($i = 0; $i < $N; $i++) {
		if($Arr[$i] != "") {
			$Str .= $ands . $Arr[$i];
			$ands = ';';
		}
	}
	return $Str;
}
?>