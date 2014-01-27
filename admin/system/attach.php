<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 路线图片管理
 * @author ld<luodongdaxia@yahoo.com.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: left.php,v 1.1 2009/08/28 24:45:23
 */

	// 加载系统函数
	require_once('../../sys_load.php');
	$verify = new Verify();
	// 生成Smarty 对象
	$smarty = new WebSmarty;
	$pdo = new MysqlPdo();

	//模板路径,生成后自行修改
	$template_list = "admin/system/attach.tpl";

	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'del':del();
			exit;
		case 'index':index();
			exit;
		default:show();
			exit;
	}

	function del(){
		global $pdo;
		$para = formatParameter($_GET["sp"], "out");
		$aid = isset($para['aid']) ? $para['aid'] : 0;
		delete_file($para['filepath']);
		delete_file(str_ireplace("_s.",".",$para['filepath']));
		delete_file(str_ireplace("_s.","_m.",$para['filepath']));
		$pdo->remove("aid={$aid}",DB_PREFIX."attach");
		page_msg('<font color=green>删除成功！</font>',$isok=true,$_SERVER['HTTP_REFERER']);
	}

	function index()
	{
		global $smarty, $pdo, $template_list;
		$page_info = "";
		$pageSize = 15;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p'])?(int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$where = "where 1 " ;
		if($_GET) {
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	    }
	    $select_columns = "select %s from ".DB_PREFIX."attach as a %s %s %s";
	    
	    $order = "order by a.aid desc";
	    $limit = "limit $offset,$pageSize";
	    $count = " count(a.aid) as count ";
	    $sql = sprintf($select_columns,'a.*',$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,$page_info,2);
		$splitPageStr=$page->get_page_html();

		foreach($res as $key=>$item){
			$res[$key]['filepath'] = str_replace('.'.$item['type'],'_s.'.$item['type'],$res[$key]['filepath']);
			$sql = "select a.*,b.title,b.cid from ".DB_PREFIX."attachindex as a left join ".DB_PREFIX."contentindex as b on a.tid=b.id where a.aid={$item['aid']}";
			$quoteInfo = $pdo->getAll($sql);
			//print_r($quoteInfo);exit;
			$res[$key]['quotecount'] =count($quoteInfo); 
			$res[$key]['quote'] =$quoteInfo; 
		}
		
		//得到该类型下的所有线路
		//$allRoute = $pdo->getAll("select * from ".DB_PREFIX."contentindex where cid={$cid} order by id desc");
		//$smarty->assign('allRoute',$allRoute);

		//得到类名
		//$smarty->assign('className',getClassName($cid));

		//得到路线名
		//$smarty->assign('routeName',getRouteName($routeId));

	 	// 查询到的结果
		$smarty->assign('photoList', $res);
		
		$smarty->assign('count',$recordCount);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);

		// 指定模板
		$smarty->show($template_list);
	}
	
	/**
	 * 处理get方式传过来的查询条件
	 */
	function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
		if(isset($Data['type']) && $Data['type'] != ""){
			if($Data['type']=='pic'){
				$ext_type="('jpg','gif','png')";
			}else{
				$ext_type="('zip','rar','txt','xls','doc','pdf')";
			}
			$where .=" and a.`type` in {$ext_type}";
			$page_info.="type={$Data['type']}&";
			$smarty->assign("type",$Data['type']);
		}
	}
?>