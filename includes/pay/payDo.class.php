<?php


class payDo{
    public $tab ;
    public $uid ;
    public $type ;
    public $orderid ;
    public $trade_no ;
    public $pname='购买积分所得' ;
    public $product='buy_scores' ;
    public $select='alipay' ;
    public $operation='增加' ;
    public $traderid='系统管理员' ;
    public $sta='1' ;
    public $order_status ;
    public $time ;
    
    public function __construct($orderid,$uid){
    	$this->orderid = $orderid;
    	$this->uid = $uid ;
    	$this->time = time();
    }
    
    public function toTab($table){
    	 $this->tab = $table;
    	 return $this ;
    }
    
    public function is_order(){
    	$sql = " select id from ".$this->tab." where status = '0' and order_sn = '$this->orderid' and uid = '$this->uid' ";
    	if($res = getPdo()->getRow($sql)){
    		return $res ; 
    	}
    	return  false;
    }
    
    public function up_order(){
    	$sql = " update  ".$this->tab." set status = '1' , paytime = '$this->time' where order_sn = '$this->orderid' and uid = '$this->uid' ";
    	if($res = getPdo()->execute($sql)){ 
    		return true;
    	} 
    	return false;
    }
    
    public function in_op_log($scores){
    	$sql = " insert into  ".$this->tab." set uid = '$this->uid' , pname = '$this->pname' , product = '$this->product' , operation = '$this->operation' , `select` = '$this->select' , score = '$scores' , traderid = '$this->traderid' , `time` = '$this->time' , sta = '$this->sta' ";
    	return getPdo()->execute($sql);
    }
    /**
    +----------------------------------------------------------
    * 插入支付日志
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param int $payment 支付方式
    * @param int $scores 购买积分数
    * @param float $paymoney  付款金额
    +----------------------------------------------------------
    * @return 
    +----------------------------------------------------------
    */
    public function in_pay_log($payment='alipay',$scores,$paymoney , $status = '1'){
    	$sql = " insert into ".$this->tab." set uid = '$this->uid' , order_sn = '$this->orderid' , payment = '$payment' , scores = '$scores' , money = '$paymoney' , status = '$status' , addtime = '$this->time' ";
    	return getPdo()->execute($sql);
    }
	/**
	+----------------------------------------------------------
	* 更新用户积分
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function up_user_score($scores){
		$sql = " update  ".$this->tab." set `total_integral` = `total_integral` + $scores where uid = '$this->uid' ";
		return getPdo()->execute($sql);
	}
    
}

?>