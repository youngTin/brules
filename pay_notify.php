<?php
require_once('./sys_load.php');
$smarty = new WebSmarty();

//alipay
require_once('./includes/pay/alipay/pay.class.php');
$pay = new pay();
$pay->notify_url();
/** test OK
include('./includes/pay/payDo.class.php');
$info = 'c2NvcmVzYDEwYHVpZGAyMw%3D%3D';
$info = formatParameter($info,'out');
$text_info = 'fail'; $total_fee = '0.01';
$paydo = new payDo('201203050233590',$info['uid']);
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
echo $text_info;
*/
?>