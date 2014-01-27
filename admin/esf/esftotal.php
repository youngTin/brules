<?php

	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//模板路径,生成后自行修改
	$template_edit = "admin/esf/fc114esftotal_edit.tpl";
	$template_list = "admin/esf/fc114esftotal_list.tpl";
	$template_msg = "../tpl/msg.tpl";

	switch(isset($_GET['action'])?$_GET['action']:'index')
		{
	
			case 'index':index(); //列表页面
				exit;
			default:index();
				exit;
		}

	/**
	 * 输出列表界面
	 */
	function index()
	{
		global $smarty, $pdo, $template_list;
		$page_info = "";
		$orderField = isset($_GET['sort']) ? 'a'.$_GET['sort'] : 'a.Id';
		$orderValue = isset($_GET['flag']) ? $_GET['flag'] : 'desc';
		$type = isset($_GET["type"])?$_GET["type"]:1;
		$smarty->assign("type",$type);
		$pageSize = 15;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$where = 'where 1 ';
	   	if($_GET) {
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	    }
	        
	   if($type == 1) {
	   		$select_columns = "select %s from ".DB_PREFIX_HOME."esf_total as t 
left join ".DB_PREFIX_HOME."company as c on c.id=t.company_id where 1 and t.company_id >0
	    group by t.company_id %s";
	   		$Field = "t.company_id,c.name_cn"; 
	   		$count = " count(t.company_id) as count ";
	   }
	   else {
	  	 	$select_columns = "select %s from (select t.user_id,c.user_name from ".DB_PREFIX_HOME."esf_total as t 
left join ".DB_PREFIX_HOME."user as c on c.user_id=t.user_id where 1 and t.company_id =0
	    group by c.user_id %s) as t1";
	  	 	$Field = "user_id,user_name";
	  	 	$count = " count(user_id) as count ";
	   	}
	   $limit = "limit $offset,$pageSize"; 
	   

	   
	    $sql = sprintf($select_columns,$Field,$limit);
	    $sqlcount = sprintf($select_columns,$count,'');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."type=$type&p=",2);
		$splitPageStr=$page->get_page_html();
		
		$today =  date('Ymd');
		$yestoday =  date('Ymd',strtotime(date('Ymd').' - 1 day'));
		$weekday =  date('Ymd',strtotime(date('Ymd').' - 7 day'));
		foreach($res as $key=>$item){
			//今日发布数据
			if($type ==1)
				$sql="select sum(refresh_cnt) as t_refresh_cnt,sum(publish_cnt) as t_publish_cnt,sum(rent_refresh_cnt) as t_rent_refresh_cnt,sum(rent_publish_cnt) as t_rent_publish_cnt from ".DB_PREFIX_HOME."esf_total where company_id = ".$item['company_id']." and total_time = $today";			
			else 
				$sql="select sum(refresh_cnt) as t_refresh_cnt,sum(publish_cnt) as t_publish_cnt,sum(rent_refresh_cnt) as t_rent_refresh_cnt,sum(rent_publish_cnt) as t_rent_publish_cnt from ".DB_PREFIX_HOME."esf_total where user_id = ".$item['user_id']." and total_time = $today";	
			$temp1 = $pdo->getRow($sql);
			$res[$key]["t_refresh_cnt"] = $temp1['t_refresh_cnt']?$temp1['t_refresh_cnt']:0;
			$res[$key]["t_publish_cnt"] = $temp1['t_publish_cnt']?$temp1['t_publish_cnt']:0;
			$res[$key]["t_rent_refresh_cnt"] = $temp1['t_rent_refresh_cnt']?$temp1['t_rent_refresh_cnt']:0;
			$res[$key]["t_rent_publish_cnt"] = $temp1['t_rent_publish_cnt']?$temp1['t_rent_publish_cnt']:0;
			
			//昨日发布数据
			if($type ==1)
				$sql="select sum(refresh_cnt) as y_refresh_cnt,sum(publish_cnt) as y_publish_cnt,sum(rent_refresh_cnt) as y_rent_refresh_cnt,sum(rent_publish_cnt) as y_rent_publish_cnt from ".DB_PREFIX_HOME."esf_total where company_id = ".$item['company_id']." and total_time = $yestoday";		
			else 
				$sql="select sum(refresh_cnt) as y_refresh_cnt,sum(publish_cnt) as y_publish_cnt,sum(rent_refresh_cnt) as y_rent_refresh_cnt,sum(rent_publish_cnt) as y_rent_publish_cnt from ".DB_PREFIX_HOME."esf_total where user_id = ".$item['user_id']." and total_time = $yestoday";	
			$temp1 = $pdo->getRow($sql);
			$res[$key]["y_refresh_cnt"] = $temp1['y_refresh_cnt']?$temp1['y_refresh_cnt']:0;
			$res[$key]["y_publish_cnt"] = $temp1['y_publish_cnt']?$temp1['y_publish_cnt']:0;
			$res[$key]["y_rent_refresh_cnt"] = $temp1['y_rent_refresh_cnt']?$temp1['y_rent_refresh_cnt']:0;
			$res[$key]["y_rent_publish_cnt"] = $temp1['y_rent_publish_cnt']?$temp1['y_rent_publish_cnt']:0;

			//一周发布数据
			if($type ==1)
				$sql="select sum(refresh_cnt) as w_refresh_cnt,sum(publish_cnt) as w_publish_cnt,sum(rent_refresh_cnt) as w_rent_refresh_cnt,sum(rent_publish_cnt) as w_rent_publish_cnt from ".DB_PREFIX_HOME."esf_total where company_id = ".$item['company_id']." and total_time >= $weekday";		
			else 
				$sql="select sum(refresh_cnt) as w_refresh_cnt,sum(publish_cnt) as w_publish_cnt,sum(rent_refresh_cnt) as w_rent_refresh_cnt,sum(rent_publish_cnt) as w_rent_publish_cnt from ".DB_PREFIX_HOME."esf_total where user_id = ".$item['user_id']." and total_time >= $weekday";		
			$temp1 = $pdo->getRow($sql);
			$res[$key]["w_refresh_cnt"] = $temp1['w_refresh_cnt']?$temp1['w_refresh_cnt']:0;
			$res[$key]["w_publish_cnt"] = $temp1['w_publish_cnt']?$temp1['w_publish_cnt']:0;
			$res[$key]["w_rent_refresh_cnt"] = $temp1['w_rent_refresh_cnt']?$temp1['w_rent_refresh_cnt']:0;
			$res[$key]["w_rent_publish_cnt"] = $temp1['w_rent_publish_cnt']?$temp1['w_rent_publish_cnt']:0;
			
		}
	 	// 查询到的结果
	 	$smarty->assign("EditOption", 'delall');
		$smarty->assign('fc114esftotalList', $res);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);
		// 指定模板
		$smarty->show($template_list);
	}

	/**
	 * 过滤数组
	 */
	function filter($Data)
	{
		$ValueList = array();
		if (array_key_exists('user_id',$Data) && ($Data['user_id'] !== '')) { $Data['user_id'] = (int)$Data['user_id'];  $ValueList['user_id']= "{$Data['user_id']}";}
		if (array_key_exists('company_id',$Data) && ($Data['company_id'] !== '')) { $Data['company_id'] = (int)$Data['company_id'];  $ValueList['company_id']= "{$Data['company_id']}";}
		if (array_key_exists('refresh_cnt',$Data) && ($Data['refresh_cnt'] !== '')) { $Data['refresh_cnt'] = (int)$Data['refresh_cnt'];  $ValueList['refresh_cnt']= "{$Data['refresh_cnt']}";}
		if (array_key_exists('publish_cnt',$Data) && ($Data['publish_cnt'] !== '')) { $Data['publish_cnt'] = (int)$Data['publish_cnt'];  $ValueList['publish_cnt']= "{$Data['publish_cnt']}";}
		if (array_key_exists('total_time',$Data) && ($Data['total_time'] !== '')) { $Data['total_time'] = (int)$Data['total_time'];  $ValueList['total_time']= "{$Data['total_time']}";}
		if (array_key_exists('branch_id',$Data) && ($Data['branch_id'] !== '')) { $Data['branch_id'] = (int)$Data['branch_id'];  $ValueList['branch_id']= "{$Data['branch_id']}";}
		if (array_key_exists('rent_refresh_cnt',$Data) && ($Data['rent_refresh_cnt'] !== '')) { $Data['rent_refresh_cnt'] = (int)$Data['rent_refresh_cnt'];  $ValueList['rent_refresh_cnt']= "{$Data['rent_refresh_cnt']}";}
		if (array_key_exists('rent_publish_cnt',$Data) && ($Data['rent_publish_cnt'] !== '')) { $Data['rent_publish_cnt'] = (int)$Data['rent_publish_cnt'];  $ValueList['rent_publish_cnt']= "{$Data['rent_publish_cnt']}";}
								return $ValueList;
	}

	function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
				if(isset($Data['Id']) && $Data['Id'] != ""){
			$where .=" and a.`Id` = '{$Data['Id']}'";
			$page_info.="Id={$Data['Id']}&";
			$smarty->assign("Id",$Data['Id']);
		}
				if(isset($Data['user_id']) && $Data['user_id'] != ""){
			$where .=" and a.`user_id` = '{$Data['user_id']}'";
			$page_info.="user_id={$Data['user_id']}&";
			$smarty->assign("user_id",$Data['user_id']);
		}
				if(isset($Data['company_id']) && $Data['company_id'] != ""){
			$where .=" and a.`company_id` = '{$Data['company_id']}'";
			$page_info.="company_id={$Data['company_id']}&";
			$smarty->assign("company_id",$Data['company_id']);
		}
				if(isset($Data['refresh_cnt']) && $Data['refresh_cnt'] != ""){
			$where .=" and a.`refresh_cnt` = '{$Data['refresh_cnt']}'";
			$page_info.="refresh_cnt={$Data['refresh_cnt']}&";
			$smarty->assign("refresh_cnt",$Data['refresh_cnt']);
		}
				if(isset($Data['publish_cnt']) && $Data['publish_cnt'] != ""){
			$where .=" and a.`publish_cnt` = '{$Data['publish_cnt']}'";
			$page_info.="publish_cnt={$Data['publish_cnt']}&";
			$smarty->assign("publish_cnt",$Data['publish_cnt']);
		}
				if(isset($Data['total_time']) && $Data['total_time'] != ""){
			$where .=" and a.`total_time` = '{$Data['total_time']}'";
			$page_info.="total_time={$Data['total_time']}&";
			$smarty->assign("total_time",$Data['total_time']);
		}
				if(isset($Data['branch_id']) && $Data['branch_id'] != ""){
			$where .=" and a.`branch_id` = '{$Data['branch_id']}'";
			$page_info.="branch_id={$Data['branch_id']}&";
			$smarty->assign("branch_id",$Data['branch_id']);
		}
				if(isset($Data['rent_refresh_cnt']) && $Data['rent_refresh_cnt'] != ""){
			$where .=" and a.`rent_refresh_cnt` = '{$Data['rent_refresh_cnt']}'";
			$page_info.="rent_refresh_cnt={$Data['rent_refresh_cnt']}&";
			$smarty->assign("rent_refresh_cnt",$Data['rent_refresh_cnt']);
		}
				if(isset($Data['rent_publish_cnt']) && $Data['rent_publish_cnt'] != ""){
			$where .=" and a.`rent_publish_cnt` = '{$Data['rent_publish_cnt']}'";
			$page_info.="rent_publish_cnt={$Data['rent_publish_cnt']}&";
			$smarty->assign("rent_publish_cnt",$Data['rent_publish_cnt']);
		}
		}
?>