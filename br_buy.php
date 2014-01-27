<?php
/**
* FILE_NAME : member_order.php   FILE_PATH : E:\home+\member_order.php
* 积分订单
* @author younglly@163.com
* ChengDu CandorSoft Co., Ltd.
* @version 1.0 Fri Mar 02 09:22:11 CST 2012
*/ 

session_start();
require_once 'member_config.php'; //引入全局配置
check_login();
$smarty = new WebSmarty();
$smarty->caching = false;
$pdo=new MysqlPdo();

$user_type = utype;
$user_name = uname;
$user_id   = uid;
$smarty->assign('user_name',$user_name);
$smarty->assign('user_type',$user_type);
switch(isset($_GET['action'])?$_GET['action']:'index')
{
    case  'gopay' : gopay();break;
    case  'buy' : buy();break;
    case  'getorder' : getorder();break;
    case 'confirm': confirm();break;
    case 'del': delone();break;
    default:buy();break;
}

/**
+----------------------------------------------------------
* 订单首页
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/


function gopay(){
    global $smarty;
    require_once('./includes/pay/pay.config.php');
    $para = formatParameter($_GET['sp'],'out');
    $oinfo = is_own_order($para['order_sn']);
    
    require_once('./includes/YiiPay/Config.php'); 
    $smarty->assign('account',$AliAccount);
    $smarty->assign('oinfo',$oinfo);
    $smarty->assign('note',urlencode("网站订单号：(#{$oinfo['order_sn']}#),请不要随意更改，否则充值失败"));
    $smarty->assign('payway',$payway);
    $smarty->assign('seoTitle','订单确认信息');
    $smarty->show('brules/buy_gopay.tpl');
}

function confirm(){
    require_once('./includes/YiiPay/Config.php'); 
    $tradeNo    =    isset($_REQUEST["tradeNo"])?$_REQUEST["tradeNo"]:"";    //支付宝交易号
    $Money        =    isset($_REQUEST["Money"])?$_REQUEST["Money"]:0;            //付款金额
    $title        =    isset($_REQUEST["title"])?$_REQUEST["title"]:"";        //付款说明，一般是网站用户名
    $memo        =    isset($_REQUEST["memo"])?$_REQUEST["memo"]:"";            //备注
    
    $order = explode("::",$title);
    $order_sn = $order[1];
    $title = $order[0];
    $oinfo = is_own_order($order_sn);
    if($oinfo['scores']==$Money)
    {
        getPdo()->execute("update ".DB_PREFIX_HOME."user_order set status = '1' , scores = '$Money' , money = '$Money' ,pay_sn = '$tradeNo' where order_sn = '$order_sn' and username = '$title' ");
        page_prompt("充值成功,3秒之后将进入会员中心..",true,'index.html',3);
    }
    
}

function delone(){
    $para = formatParameter($_GET['sp'],'out');
    @extract($para);
    if(is_numeric($order_sn)&&$oinfo = is_own_order($order_sn))
    {
        $sql = " delete from ".DB_PREFIX_HOME."user_order where order_sn = '$order_sn' and uid = '".UID."' ";
        if(getPdo()->execute($sql)) 
            ShowMsg('删除成功',$_SERVER['HTTP_REFERER']);
        else 
            ShowMsg('删除失败',$_SERVER['HTTP_REFERER']);
        exit;
    }
}

function buy(){
    global  $smarty ; 
    
    global  $smarty;
    $pageSize = 15;
    $offset = 0;
    $subPages=5;//每次显示的页数
    $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
    if($currentPage>0) $offset=($currentPage-1)*$pageSize;
    $where = ' where 1 ';
    if(isset($_GET))
    {
        @extract($_GET);
        $date_f = "/^[1-9]\d{3}-[0-1]\d-[0-3]\d$/";
        if(preg_match($date_f,$start))
        {
            $starts = strtotime($start);
            $where .= " and uo.addtime >= '$starts' ";
            $page_info .= "order_sn={$start}&";
        }
        if(preg_match($date_f,$end))
        {
            $ends = strtotime($end);
            $where .= " and uo.addtime <= '$ends' ";
            $page_info .= "end={$end}&";
        }
        if($status!='-1'&&is_numeric($status))
        {
            $where .= " and uo.status = '$status' ";
            $page_info .= "status={$status}&";
        }
    }
    $where .= " and uo.uid = '".UID."' ";
    $sql = " select uo.*,u.username from ".DB_PREFIX_HOME."user_order as uo 
            left join ".DB_PREFIX_HOME."user as u  on  u.uid = uo.uid 
    " ;
    $orderBy = " order by uo.addtime desc ";
    $limit = " limit $offset,$pageSize  ";
    $res = getPdo()->getAll($sql.$where.$orderBy.$limit); 
    $count = getPdo()->getRow(" select count(id) as count,sum(scores) as tscores from ".DB_PREFIX_HOME."user_order as uo 
            left join ".DB_PREFIX_HOME."user as u  on  u.uid = uo.uid
    " );
    include_once('./data/cache/base_code.php');

    $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,3);
    $splitPageStr=$page->get_page_html();
    $info = array('scores'=>'50','uid'=>uid);
    
    $smarty->assign('order_status',$order_status_text);
    $smarty->assign('list',$res);
    $smarty->assign('num',$count['count']);
    $smarty->assign('tscores',$count['tscores']);
    $smarty->assign('splitPageStr', $splitPageStr);
    
    $smarty->assign('ratio',1);
    $smarty->assign('seoTitle','积分购买');
    $smarty->show('brules/buy.tpl');
}

function is_own_order($order_sn){
    $oinfo = getPdo()->getRow("select * from ".DB_PREFIX_HOME."user_order where order_sn = '$order_sn' and status = '0' and uid = '".UID."' ");
    if(!$oinfo)
    {
        ShowMsg('传入错误，该订单不存在或不属于您',$_SERVER['HTTP_REFERER']);exit;
    }
    return $oinfo;
}

function getorder(){
    $scores = $_POST['scores'];
    if(!preg_match('/^\d{0,5}$/',$scores))exit(false);
    $time = time();
    $s = get_order_sn();
    $money = round($scores / 1,2);
    $sql = " insert into ".DB_PREFIX_HOME."user_order set uid = '".UID."' ,username = '".USERNAME."' , order_sn = '$s' ,scores = '$scores' ,money = '$money' , status = '0' , addtime = '$time' ";
    if(getPdo()->execute($sql))
    {
        $sp = array('order_sn'=>$s);
        echo formatParameter($sp,'in');exit;
    }
    exit(false);
    
}
function get_order_sn()
{
    $s = date("Ymdhis");
    $s .= round(0,9);
    return $s;
}
function  get_radio(){
    
}
?>