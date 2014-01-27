<?php

$payway = array('alipay'=>array('flag'=>1,
								'name'=>'支付宝'
								),
				'tenpay'=>array('flay'=>0,
								'name'=>'财付通'),
				);
//支付提交地址
$payurl = array(
	'alipay' => '',		
	'tenpay' => '',		
);
//支付返回地址
$returnurl = array(
	'alipay' => '',
	'tenpay' => '',
);
//支付宝信息
$alipay_config = array(
	'partner' => '2088002188092028',//合作身份者id，以2088开头的16位纯数字
	'key' => 'ichcwvlh1ddv7jes8c6n1e4yrh89dex4' ,//安全检验码，以数字和字母组成的32位字符
	'seller_email' => 'younglly@163.com' ,//签约支付宝账号或卖家支付宝帐户
	'return_url' => 'http://' ,//页面跳转同步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
	'notify_url' =>'http://' ,//服务器异步通知页面路径，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
	'sign_type' => 'MD5',//签名方式 不需修改
	'input_charset' => 'utf-8',//字符编码格式 目前支持 gbk 或 utf-8
	'transport' => 'http',//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
);
$alipay_info = array(
	'paymethod' => '',//默认支付方式,//directPay（余额支付） bankPay（网银支付） cartoon（卡通）creditPay（信用支付） CASH（网点支付）
	'dbank' => '',//默认网银代号
	//扩展功能-防钓鱼,
	//注意：
	//1.请慎重选择是否开启防钓鱼功能
	//2.exter_invoke_ip、anti_phishing_key一旦被使用过，那么它们就会成为必填参数
	//3.开启防钓鱼功能后，服务器、本机电脑必须支持SSL，请配置好该环境。
	'anti_phishing_key' => '',//防钓鱼时间戳
	'exter_invoke_ip' => '',//获取客户端的IP地址
	'show_url' => '',//商品展示地址，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
);
?>