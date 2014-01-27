<?php
// 加载系统函数
// 加载系统函数
	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
$smarty->caching = false;

$company_id = $_GET["companyId"];



//查询分店
$sql_branch = "select * from ".DB_PREFIX_HOME."esf_branch where company_id = $company_id";
$branch_info = $pdo->getAll($sql_branch);
$smarty->assign("branch_info",$branch_info);
$dateList = array();
$dateList[0] = date('Ymd');
$dateList[1] =  date('Ymd',strtotime(date('Ymd').' - 1 day'));
$dateList[2] =  date('Ymd',strtotime(date('Ymd').' - 2 day'));
$dateList[3] =  date('Ymd',strtotime(date('Ymd').' - 3 day'));
$dateList[4] =  date('Ymd',strtotime(date('Ymd').' - 4 day'));
$dateList[5] =  date('Ymd',strtotime(date('Ymd').' - 5 day'));
$dateList[6] =  date('Ymd',strtotime(date('Ymd').' - 6 day'));
$smarty->assign("dateList",$dateList);
$where = "";
if(isset($_GET['total_time']) && $_GET['total_time'] != ""){
	$total_time = $_GET['total_time'];
	$where .=" and t.`total_time` = '{$total_time}'";
	$smarty->assign("total_time",$_GET['total_time']);
}else{
	$total_time = date("Ymd");
	$where .=" and t.`total_time` = '".date("Ymd")."'";
	$smarty->assign("total_time",date("Ymd"));
}
if(isset($_GET['branch_id']) && $_GET['branch_id'] != ""){
	$branch_id = $_GET['branch_id'];
	$where .=" and t.`branch_id` = '{$branch_id}'";
	$smarty->assign("branch_id",$_GET['branch_id']);
}else{
	$branch_id = $branch_info[0]['branch_id'];
	$where .=" and t.`branch_id` = '{$branch_info[0]['branch_id']}'";
	$smarty->assign("branch_id",$branch_info[0]['branch_id']);
}

$sql = "select m.user_id,u.user_name,u.login_name from ".DB_PREFIX_HOME."member m 
left join ".DB_PREFIX_HOME."user u on m.user_id=u.user_id where m.branch_id =  $branch_id
";
$user_Info = $pdo->getAll($sql);
foreach($user_Info as $key=>$item){
	$sql = "select t.refresh_cnt,t.publish_cnt,t.total_time,t.rent_refresh_cnt,t.rent_publish_cnt from ".DB_PREFIX_HOME."esf_total as t where t.user_id = {$item["user_id"]} and t.total_time=$total_time limit 1";
	 $total_info = $pdo->getRow($sql);
	 $user_Info[$key]["refresh_cnt"]=$total_info["refresh_cnt"]?$total_info["refresh_cnt"]:0;
	 $user_Info[$key]["publish_cnt"]=$total_info["publish_cnt"]?$total_info["publish_cnt"]:0;
	 $user_Info[$key]["rent_refresh_cnt"]=$total_info["rent_refresh_cnt"]?$total_info["rent_refresh_cnt"]:0;
	 $user_Info[$key]["rent_publish_cnt"]=$total_info["rent_publish_cnt"]?$total_info["rent_publish_cnt"]:0;
}
$total_Info = $user_Info;
$smarty->assign("total_Info",$total_Info);
$sql = "select sum(t.refresh_cnt) as refresh_cnt,
sum(t.publish_cnt) as publish_cnt,t.total_time,sum(t.rent_refresh_cnt) as rent_refresh_cnt,
sum(t.rent_publish_cnt) as rent_publish_cnt from ".DB_PREFIX_HOME."esf_total as t where t.company_id = $company_id $where";
$smarty->assign("total_cnt",$pdo->getRow($sql));
$smarty->assign("level",1);
$smarty->assign("companyId",$company_id);
$smarty->show();
?>