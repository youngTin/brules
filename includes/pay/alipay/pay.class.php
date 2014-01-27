<?php
/**
* FILE_NAME : pay.class.php   FILE_PATH : E:\home+\includes\pay\alipay\pay.class.php
* 支付宝即时到帐接口
* @author younglly@163.com
* ChengDu CandorSoft Co., Ltd.
* @version 1.0 Fri Mar 02 10:10:56 CST 2012
*/ 

define('N_PATH',dirname(__FILE__));

class pay {
	public  $order_sn = '';//网站订单系统中的唯一订单号
	public  $name = '';//订单名称
	public  $body = '';//订单详细描述；
	public  $totle_fee = '0.01'; //订单总金额；最小0.01
	public  $show_url = '';//商品展示地址，要用 http://格式的完整路径，不允许加?id=123这类自定义参数
	
    /**
    +----------------------------------------------------------
    * 支付宝提交接口地址
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param 
    +----------------------------------------------------------
    * @return 
    +----------------------------------------------------------
    */
	public function go_url(){ 
		include(N_PATH.'/../pay.config.php');
		include(N_PATH.'/lib/alipay_service.class.php');
		
		$parameter = array(
                    "service"            => "create_direct_pay_by_user",
                    "payment_type"        => "1",   //支付类型(1.商品购买)
                    
                    "partner"            => trim($alipay_config['partner']),
                    "_input_charset"    => trim(strtolower($alipay_config['input_charset'])),
                    "seller_email"        => trim($alipay_config['seller_email']),
                    "return_url"        => trim($alipay_config['return_url']),
                    "notify_url"        => trim($alipay_config['notify_url']),
                    
                    "out_trade_no"        => $this->order_sn,
                    "subject"            => $this->name,       //商品名称，必填
                    "body"                => $this->body,       //商品描述，必填
                    "total_fee"            => $this->totle_fee,   //price、quantity能代替total_fee。即存在total_fee，就不能存在price和quantity；存在price、quantity，就不能存在total_fee。
                    
                    "paymethod"            => trim($alipay_info['paymehod']),
                    "defaultbank"        => trim($alipay_info['dbank']),  //默认网银
                    
                    "anti_phishing_key"    => trim($alipay_info['anti_phishing_key']),  //防钓鱼时间戳
                    "exter_invoke_ip"    => $alipay_info['exter_invoke_ip'],  //用户在创建交易时，该用户当前所使用机器的IP。如果商户申请后台开通防钓鱼IP地址检查选项，此字段必填，校验用。
                    
                    "show_url"            => $this->show_url,
                  //  "extra_common_param"=> "mod^alipay",  //公用扩展参数,参数格式：参数名1^参数值1|参数名2^参数值2|……多条数据用“|”间隔
            );

            //构造即时到帐接口
            $alipayService = new AlipayService($alipay_config);
            $html_text = $alipayService->create_direct_pay_by_user($parameter);
            return  $html_text;
	}
	
	/**
	+----------------------------------------------------------
	* 支付宝服务器异步通知
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function notify_url(){
		include(N_PATH."/../pay.config.php");
		include(N_PATH."/lib/alipay_notify.class.php");
		include(N_PATH.'/../payDo.class.php');
		
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($aliapy_config);
		$verify_result = $alipayNotify->verifyNotify();
		$text_info = 'fail';
		if($verify_result) {//验证成功
		    $out_trade_no	= $_POST['out_trade_no'];	    //获取订单号
		    $trade_no		= $_POST['trade_no'];	    	//获取支付宝交易号
		    $total_fee		= $_POST['total_fee'];			//获取总价格
		    $info			= $_POST['body'];			//获取总价格
			$info = formatParameter($info,'out');
		    if($_POST['trade_status'] == 'TRADE_FINISHED'||$_POST['trade_status'] == 'TRADE_SUCCESS') {
				$paydo = new payDo($out_trade_no,$info['uid']);
				if($is_ext = $paydo->toTab(DB_PREFIX_HOME.'user_order')->is_order()){ 
					if($paydo->toTab(DB_PREFIX_HOME.'user_order')->up_order()){ // 更新订单状态
						//更新用户积分
						if($paydo->toTab(DB_PREFIX_HOME.'member')->up_user_score($info['scores']))
						{
							//插入支持日志
							$paydo->toTab(DB_PREFIX_HOME.'user_pay_log')->in_pay_log('alipay',$info['scores'],$total_fee);
							//插入用户操作日志表
							$paydo->toTab(DB_PREFIX_HOME.'user_operation')->in_op_log($info['scores']);
							$text_info = 'success';
						}
					}
				}
		    }
		        
		}
		echo $text_info ;
	}
	
}
?>