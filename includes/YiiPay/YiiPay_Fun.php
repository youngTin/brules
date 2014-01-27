<?php

/*
 *====================================================================
 *					www.YiiPay.com
 *
 *                ��֧�� �ṩ����֧��
 *
 *     		��ҳ��Ϊ���ܺ������벻Ҫ�޸Ĵ��ļ�������
 *
 *====================================================================
*/

//�󶨶��֧�����˺�ʱ�������ȡһ��֧�����˺�
function GetRndAliAccount($AliAccount, $JiaoHuanTime) {	
	$result = "";
	$AliAccount = FilterAccount($AliAccount);
	//��������
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

//���˰󶨵�֧�����˺Ÿ�ʽ
function FilterAccount($AliAccount) {
	$AliAccount = str_replace(" ", "", $AliAccount);
	$AliAccount = str_replace("��", ",", $AliAccount);
	$AliAccount = str_replace(",", ";", $AliAccount);
	$AliAccount	= str_replace("��", ";", $AliAccount);	//���˿ո񣬶��ţ����ķֺ�	
	//���������ֹ��Ԫ��
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