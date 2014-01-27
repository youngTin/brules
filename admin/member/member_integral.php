<?php
/**
* FILE_NAME : member_integral.php   FILE_PATH : E:\home+\admin\member\member_integral.php
* 会员积分
* @author younglly@163.com
* ChengDu CandorSoft Co., Ltd.
* @version 1.0 Wed Feb 29 13:51:54 CST 2012
*/ 
require_once('../../sys_load.php');
$pdo = new MysqlPdo();
$smarty = new WebSmarty();
$verify = new Verify();

switch(isset($_GET['action'])?$_GET['action']:'index')
{
	case 'add':add(); break;//添加页面
	case 'info' : info(); break;//详细页面
	default:index();break;
}

function index(){
	global $smarty;
	
	$pageSize = 15;
    $offset = 0;
    $subPages=5;//每次显示的页数
    $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
    if($currentPage>0) $offset=($currentPage-1)*$pageSize;
    $where = ' where 1 ';
    if(isset($_GET))
    {
    	@extract($_GET);
    	if(!empty($username))
    	{
    		$where .= " and u.username like '%{$username}%' ";
    		$page_info .= "username={$username}&";
    	}
    }
    
	$sql =" select uo.*,u.username from ".DB_PREFIX_HOME."user_operation as uo
			left join ".DB_PREFIX_HOME."user as u on u.uid = uo.uid 
			".$where.' group by uo.id order by uo.id desc'; 
	$limit = " limit $offset,$pageSize ";
    $res = getPdo()->getAll($sql.$limit);
	$count = getPdo()->getRow(" select count(id) as count from ".DB_PREFIX_HOME."user_operation as uo
			left join ".DB_PREFIX_HOME."user as u on u.uid = uo.uid 
			".$where); 
    $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,2);
	$splitPageStr=$page->get_page_html();
	
	$smarty->assign('list',$res);
    $smarty->assign('splitPageStr', $splitPageStr);
	$smarty->show('admin/member/member_integral_list.tpl');
}

function info(){
	global $smarty;
	$para = formatParameter($_GET["sp"], "out");
    $Id = isset($para['Id']) ? $para['Id'] : 1;
	$sql = " select uo.*,u.username from ".DB_PREFIX_HOME."user_operation as uo
			left join ".DB_PREFIX_HOME."user as u on u.uid = uo.uid
			where uo.id = '$Id'  ";
	$Info = getPdo()->getRow($sql);
	include_once('../../data/cache/base_code.php');

	$Info['sta'] = $transactiona_status_text[$Info['sta']];
	
    $smarty->assign('Info',$Info);
	$smarty->show('admin/member/member_integral_info.tpl');
}

?>