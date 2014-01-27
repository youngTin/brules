<?php

require_once('./sys_load.php');
$smarty = new WebSmarty();

require_once("./includes/pay/pay.config.php");
require_once("./includes/pay/alipay/lib/alipay_notify.class.php");
$alipayNotify = new AlipayNotify($aliapy_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功

    $out_trade_no	= $_GET['out_trade_no'];	//获取订单号
    $trade_no		= $_GET['trade_no'];		//获取支付宝交易号
    $total_fee		= $_GET['total_fee'];		//获取总价格

    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		
    	$smarty->show('pay_success.tpl');
    }
	
}
else {
	$smarty->show('pay_success.tpl');
   // ShowMsg('验证不成功','index.php');
}

?>