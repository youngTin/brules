<?php

require_once('./sys_load.php');
require_once('./includes/YiiPay/Config.php');
//开始接收参数 (请注意区分大小写)
//-----------------------------------------------------------------
$tradeNo    =    isset($_REQUEST["tradeNo"])?$_REQUEST["tradeNo"]:"";    //支付宝交易号
$Money        =    isset($_REQUEST["Money"])?$_REQUEST["Money"]:0;            //付款金额
$title        =    isset($_REQUEST["title"])?$_REQUEST["title"]:"";        //付款说明，一般是网站用户名
$memo        =    isset($_REQUEST["memo"])?$_REQUEST["memo"]:"";            //备注
$Sign        =    isset($_REQUEST["Sign"])?$_REQUEST["Sign"]:"";            //签名
//-----------------------------------------------------------------

if (strtoupper($Sign) != strtoupper(md5($WebID.$Key.$tradeNo.$Money.$title.$memo))){
        echo "Fail";
}else{

    //$order_sn = explode('(#',$memo);
//    $order_sn = explode('#)',$order_sn[1]);
//    $order_sn = $order_sn[0];
    $order = explode("::",$title);
    $order_sn = $order[1];
    $title = $order[0];
    $paytime = time();
    $pdo = getPdo();
    if($pdo->execute("update ".DB_PREFIX_HOME."user_order set status = '2', scores = '$Money' , money = '$Money' ,pay_sn = '$tradeNo' , paytime = '$paytime' where order_sn = '$order_sn' and username = '$title' "))
    {
        up_user_scores(intval($Money),$title);
        echo 'success';
    }
    else echo 'Fail';
}
//更新用户金额
function up_user_scores($scores,$username)
{
    $sql = " update ".DB_PREFIX_DR."user_drinfo set `now_gold` =  `now_gold` + '{$scores}'  where username = '".$username."' ";
    return getPdo()->execute($sql);
}
?>