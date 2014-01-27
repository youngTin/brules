<?php
// 加载系统函数
	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
$smarty->caching = false;


$company_id = $_GET["companyId"];



$where = "";
if($_GET["level"]==1){
	$where = " and company_id = $company_id ";
	if($_GET["branch_id"] != 0 || $_GET["branch_id"])
		$where .= isset($_GET["branch_id"])?" and branch_id =".$_GET["branch_id"]:"";

	//查询分店
	$sql_branch = "select * from ".DB_PREFIX_HOME."esf_branch where company_id = $company_id";
	
	$branch_info = $pdo->getAll($sql_branch);
	$smarty->assign("branch_id",$_GET["branch_id"]);
	$smarty->assign("branch_info",$branch_info);
}

if($_GET["level"]==3){
	$where = " and user_id = {$_GET["user_id"]}";
}
if(isset($_GET['start_time']) && $_GET['start_time'] != ""){
	$start_time = $_GET['start_time'];
	$where .=" and `total_time` >= '{$start_time}'";
	$smarty->assign("start_time",$_GET['start_time']);
}
if(isset($_GET['end_time']) && $_GET['end_time'] != ""){
	$end_time = $_GET['end_time'];
	$where .=" and `total_time` <= '{$end_time}'";
	$smarty->assign("end_time",$_GET['end_time']);
}
 $sql = "select sum(refresh_cnt) as refresh_cnt,sum(publish_cnt) as publish_cnt,total_time,sum(rent_refresh_cnt) as rent_refresh_cnt,sum(rent_publish_cnt) as rent_publish_cnt from ".DB_PREFIX_HOME."esf_total where 1 $where group by total_time order by total_time desc limit 40";
$total_Info = $pdo->getAll($sql);
$smarty->assign("total_Info",$total_Info);
$smarty->assign("level",$_GET["level"]);
$smarty->assign("companyId",$_GET["companyId"]);

$smarty->show("");
?>