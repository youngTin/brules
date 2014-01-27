<?php

	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//模板路径,生成后自行修改
	$template_edit = "admin/esf/member_edit.tpl";
	$template_list = "admin/esf/member_list.tpl";
	$template_msg = "../tpl/msg.tpl";

	switch(isset($_GET['action'])?$_GET['action']:'index')
		{
			case 'add':add(); //添加页面
				exit;
			case 'edit':edit(); //修改页面
				exit;
			case 'save':save(); //修改或添加后的保存方法
				exit;
			case 'index':index(); //列表页面
				exit;
			case 'delete':delete(); //删除单条记录方法
				exit;
			case 'deleteall':deleteAll(); //删除多条记录方法
				exit;
			default:index();
				exit;
		}
	/**
	 * 保存修改或增加到数据库
	 */
	function save()
	{
		global $smarty, $pdo,$template_msg;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['member_id'])) {
			$Data = filter($_POST);
			$Data_user = filter_user($_POST);
			$Data_company = filter_company($_POST);
			if (isset($Data) || isset($Data_user)) {
				 $msg="";
				 if($pdo->update( $Data,DB_PREFIX_HOME."member" , "member_id=".$_POST['member_id'])) $msg.="权限表修改成功!"; 
				 if($pdo->update( $Data_user,DB_PREFIX_HOME."user" , "user_id=".$_POST['user_id'])) $msg.="用户信息修改成功!";
				 if($_POST['password1']!="" && $_POST['password2']!="" && $_POST['password1']==$_POST['password2']){
				 	$pdo->update(array('password'=>md5($_POST['password1'])),'webuser' , "id=".$_POST['member_id']);
				 	$msg .= '密码修改成功';
				 }
				// if($pdo->update( $Data_company,'home_company' , "id=".$_POST['company_id'])) $msg.="公司信息修改成功!";
				 if($_POST['level']==1 && $_POST['user_type']==3) {
				 	$pdo->update(array("flag"=>$Data['flag'],
				 	"is_payed"=>$Data['is_payed'],
				 	"resold_valid"=>$Data['resold_valid'],
				 	"valid_from"=>$Data['valid_from'],
				 	"is_degree"=>$Data['is_degree'],
				 	"valid_thru"=>$Data['valid_thru'],
				 	"allow_second_refreshed"=>$Data['allow_second_refreshed'],
				 	"allow_rent_refreshed"=>$Data['allow_rent_refreshed']
				 	),DB_PREFIX_HOME."member","company_id=".$_POST["company_id"]);
				 	$msg .= '总公司账号修改下属经纪人信息成功!';
				 }
				 $msg .= '';
				$smarty->assign("msg" , $msg);
	   			$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
			   	$smarty -> show($template_msg);
			} else {
				$msg = '保存失败';
				$smarty->assign("msg" , $msg);
	   			$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
			   	$smarty -> show($template_msg);
			}
		}
	}

	/**
	 * 输出添加界面
	 */
	function add()
	{
		global $smarty, $pdo, $template_edit;
		$user_type_text=array(
		'1'=>'个人会员',
		'3'=>'中介公司',
		'4'=>' 独立经济人');
		$is_trial_text=array(
		'0'=>'否',
		'1'=>'是');
		$is_payed_text=array(
		'0'=>'否',
		'1'=>'是');
		$resold_valid_text=array(
		'0'=>'否',
		'1'=>'是');
		$is_admin_text=array(
		'0'=>'否',
		'1'=>'是');
		$flag_text=array(
		'1'=>'有效',
		'9'=>'待审');
		$level_text=array(
		'0'=>'开发商,个人',
		'1'=>'1级-公司账号',
		'2'=>'2级-公司店长',
		'3'=>'3级-经济人,个人');
		$is_degree_text=array(
		'0'=>'没有等级',
		'1'=>'一级公司',
		'2'=>'二级公司');
		
		$ValueList = array();
		$ValueList['is_trial_text'] = $is_trial_text;
		$ValueList['is_payed_text'] = $is_payed_text;
		$ValueList['resold_valid_text'] = $resold_valid_text;
		$ValueList['is_admin_text'] = $is_admin_text;
		$ValueList['flag_text'] = $flag_text;
		$ValueList['level_text'] = $level_text;
		$ValueList['is_degree_text'] = $is_degree_text;
		$smarty->assign('memberInfo',$ValueList);
		$smarty->assign("EditOption" , 'New');
		$smarty->assign("url" , $_SERVER['HTTP_REFERER']);
		$smarty -> show($template_edit);
	}

	/**
	 * 输出编辑界面
	 */
	function edit()
	{
		global $smarty, $pdo, $template_edit;
		$Id = isset($_GET['member_id']) ? $_GET['member_id'] : 1;
		$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : 1;
		$user_type_text=array(
		'1'=>'个人会员',
		'3'=>'中介公司',
		'4'=>' 独立经济人');
		$is_trial_text=array(
		'0'=>'否',
		'1'=>'是');
		$is_payed_text=array(
		'0'=>'否',
		'1'=>'是');
		$resold_valid_text=array(
		'0'=>'否',
		'1'=>'是');
		$is_admin_text=array(
		'0'=>'否',
		'1'=>'是');
		$flag_text=array(
		'1'=>'有效',
		'9'=>'待审');
		$level_text=array(
		'0'=>'开发商,个人',
		'1'=>'1级-公司账号',
		'2'=>'2级-公司店长',
		'3'=>'3级-经济人,个人');
		$is_degree_text=array(
		'0'=>'没有等级',
		'1'=>'一级公司',
		'2'=>'二级公司');
		$sex_text=array(
		'0'=>'女',
		'1'=>'男',
		'9'=>'保密');
		$type_text=array(
		'1'=>'开发商',
		'2'=>'不晓得啥类型',
		'3'=>'中介',
		'9'=>'系统');

		$ValueList_user = $pdo->getRow("select * from ".DB_PREFIX_HOME."user where user_id='$user_id'");

		$ValueList_user['sex_text'] = $sex_text;

		$ValueList = $pdo->getRow("select * from ".DB_PREFIX_HOME."member where member_id = '$Id'");
		$ValueList_company = $pdo->getRow("select * from ".DB_PREFIX_HOME."company where id = ".$ValueList['company_id'] );
		$ValueList_company['type_text'] = $type_text;
		$ValueList['user_type_text'] = $user_type_text;	
		$ValueList['is_trial_text'] = $is_trial_text;
		$ValueList['is_payed_text'] = $is_payed_text;
		$ValueList['resold_valid_text'] = $resold_valid_text;
		$ValueList['is_admin_text'] = $is_admin_text;
		$ValueList['flag_text'] = $flag_text;
		$ValueList['level_text'] = $level_text;
		$ValueList['is_degree_text'] = $is_degree_text;
		
		$smarty->assign('memberInfo',$ValueList);
		$smarty->assign('userInfo',$ValueList_user);
		$smarty->assign('companyInfo',$ValueList_company);
		$smarty->assign("EditOption" , 'Edit');
		$smarty->assign("UrlReferer" , $_SERVER['HTTP_REFERER']);
		$smarty -> show($template_edit);
	}


	/**
	 * 执行删除
	 */
	function delete()
	{
		global $pdo,$template_msg,$smarty;
		$Id = isset($_GET['member_id']) ? $_GET['member_id'] : 0;
		$pdo->remove( "member_id={$Id}",DB_PREFIX_HOME."member");
		$pdo->remove( "id={$Id}","webuser");
		//$userId=$pdo->getRow("select user_id from home_member where member_id={$Id}");
		$pdo->remove("user_id={$_GET['user_id']}", DB_PREFIX_HOME."user");
		$pdo->remove("user_id={$_GET['user_id']}", DB_PREFIX_HOME."esf");
		$msg = '删除成功';
		$smarty->assign("time" , 1);
		$smarty->assign("msg" , $msg);
		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
	   	$smarty -> show($template_msg);
	}

	/**
	 * 执行多项删除
	 */
	function deleteAll()
	{
	/*	global $pdo,$template_msg,$smarty;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'delall'){
			$Id = isset($_POST['ids']) ? $_POST['ids'] : array();
			$count = count($Id);
			if($count != 0){
			    $query = " DELETE FROM home_member WHERE `Id` IN (". implode(",", $Id) .")";
				$pdo->execute($query);
				$msg = '多项删除删除成功';
			}
		}*/
		$smarty->assign("msg" , $msg);
		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
	   	$smarty -> show($template_msg);
	}



	/**
	 * 输出列表界面
	 */
	function index()
	{
		global $smarty, $pdo, $template_list;
		$page_info = "";
		$PageSize = 15;
		$Offset = 0;
		$sub_pages=5;								//每次显示的页数
		$CurrentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($CurrentPage>0) $Offset=($CurrentPage-1)*$PageSize;
		$where = 'where 1 ';
		if($_GET) {
	    	advanced_search($_GET,$info,$filter_where);
	    	$where .= $filter_where ;
	    	$page_info="para=".formatParameter($info, "in")."&";
	    }
		if(isset($_GET['para'])){
			$para=formatParameter($_GET['para'], "out");
			advanced_search($para,$info,$filter_where);
		    $where .= $filter_where;
		    $page_info="para=".formatParameter($info, "in")."&";
	 	   if($para['company_id']){
	 	  	$esf_company_count = "select count(id) as cnt from ".DB_PREFIX_HOME."esf where company_id = {$para["company_id"]}";
	 	  	$smarty->assign("company_count",$pdo->getRow($esf_company_count));
	 	  }
		}
	    
	    $where .= " and (user_type = 1 or user_type=3 or user_type=4)";
		$select_columns = "select %s from ".DB_PREFIX_HOME."user as b left join ".DB_PREFIX_HOME."member as a  on a.user_id = b.user_id LEFT join ".DB_PREFIX_HOME."company as c on c.id = a.company_id left join ".DB_PREFIX_HOME."user_record as d on b.user_id = d.user_id %s %s %s";
	    $order = "group by user_id order by login_at desc";
	    $limit = "limit $Offset,$PageSize";
	    $count = " count(a.user_id) as count ";
	    $sql = sprintf($select_columns,"a.*,b.user_name,b.login_name,b.telephone,c.id as cid,c.name_cn,d.login_at",$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$RecordCount = $Count['count'];
	    $page=new Page($PageSize,$RecordCount,$CurrentPage,$sub_pages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();
		$sql = "select count(*) as cnt from ".DB_PREFIX_HOME."user_record where login_at >= ".strtotime(date("Y-m-d"));
		$smarty->assign("act_count",$pdo->getRow($sql));
		$user_type_text=array(
		'1'=>'个人会员',
		'3'=>'中介公司',
		'4'=>' 独立经济人');
		$is_trial_text=array(
		'0'=>'否',
		'1'=>'是');
		$is_payed_text=array(
		'0'=>'否',
		'1'=>'是');
		$resold_valid_text=array(
		'0'=>'否',
		'1'=>'是');
		$is_admin_text=array(
		'0'=>'否',
		'1'=>'是');
		$flag_text=array(
		'1'=>'已审核',
		'9'=>'待审');
		$level_text=array(
		'0'=>'开发商',
		'1'=>'1级-公司账号',
		'2'=>'2级-公司店长',
		'3'=>'3级-经济人,个人');
		$is_degree_text=array(
		'0'=>'没有等级',
		'1'=>'一级公司',
		'2'=>'二级公司');
		$smarty->assign('user_type_text',	$user_type_text);
		$smarty->assign('is_trial_text',	$is_trial_text);
		$smarty->assign('is_payed_text',	$is_payed_text);
		$smarty->assign('resold_valid_text',	$resold_valid_text);
		$smarty->assign('is_admin_text',	$is_admin_text);
		$smarty->assign('flag_text',	$flag_text);
		$smarty->assign('level_text',	$level_text);
		$smarty->assign('is_degree_text',	$is_degree_text);
		
		foreach ($res as $key => $item) {
		if(!is_null($item['user_type']))
		$res[$key]['user_type_text'] = $user_type_text[$item['user_type']];	
		if(!is_null($item['is_trial']))
		$res[$key]['is_trial_text'] = $is_trial_text[$item['is_trial']];
		if(!is_null($item['is_payed']))
		$res[$key]['is_payed_text'] = $is_payed_text[$item['is_payed']];
		if(!is_null($item['resold_valid']))
		$res[$key]['resold_valid_text'] = $resold_valid_text[$item['resold_valid']];
		if(!is_null($item['is_admin']))
		$res[$key]['is_admin_text'] = $is_admin_text[$item['is_admin']];
		if(!is_null($item['flag']))
		$res[$key]['flag_text'] = $flag_text[$item['flag']];
		if(!is_null($item['level']))
		$res[$key]['level_text'] = $level_text[$item['level']];
		if(!is_null($item['is_degree']))
		$res[$key]['is_degree_text'] = $is_degree_text[$item['is_degree']];
		
		$sql = "select count(id) as cnt  from ".DB_PREFIX_HOME."esf where user_id={$item['user_id']}";
		$temp = $pdo->getRow($sql);
		$res[$key]['esf_count'] = $temp["cnt"];
		}
	 	// 查询到的结果
	 	$smarty->assign("EditOption", 'delall');
		$smarty->assign('memberList', $res);
		
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
if (array_key_exists('member_id',$Data) && ($Data['member_id'] !== '')) { $Data['member_id'] = (int)$Data['member_id'];  $ValueList['member_id']= "{$Data['member_id']}";}
if (array_key_exists('user_id',$Data) && ($Data['user_id'] !== '')) { $Data['user_id'] = (int)$Data['user_id'];  $ValueList['user_id']= "{$Data['user_id']}";}
if (array_key_exists('user_type',$Data) && ($Data['user_type'] !== '')) { $Data['user_type'] = (int)$Data['user_type'];  $ValueList['user_type']= "{$Data['user_type']}";}
if (array_key_exists('level_id',$Data) && ($Data['level_id'] !== '')) { $Data['level_id'] = (int)$Data['level_id'];  $ValueList['level_id']= "{$Data['level_id']}";}
if (array_key_exists('company_id',$Data) && ($Data['company_id'] !== '')) { $Data['company_id'] = (int)$Data['company_id'];  $ValueList['company_id']= "{$Data['company_id']}";}
if (array_key_exists('pay_at',$Data) && ($Data['pay_at'] !== '')) { $Data['pay_at'] = (int)$Data['pay_at'];  $ValueList['pay_at']= "{$Data['pay_at']}";}
if (array_key_exists('is_trial',$Data) && ($Data['is_trial'] !== '')) { $Data['is_trial'] = (int)$Data['is_trial'];  $ValueList['is_trial']= "{$Data['is_trial']}";}
if (array_key_exists('is_payed',$Data) && ($Data['is_payed'] !== '')) { $Data['is_payed'] = (int)$Data['is_payed'];  $ValueList['is_payed']= "{$Data['is_payed']}";}
if (array_key_exists('resold_valid',$Data) && ($Data['resold_valid'] !== '')) { $Data['resold_valid'] = (int)$Data['resold_valid'];  $ValueList['resold_valid']= "{$Data['resold_valid']}";}
if (array_key_exists('create_at',$Data) && ($Data['create_at'] !== '')) { $Data['create_at'] = (int)$Data['create_at'];  $ValueList['create_at']= "{$Data['create_at']}";}
if (array_key_exists('auditing_at',$Data) && ($Data['auditing_at'] !== '')) { $Data['auditing_at'] = (int)$Data['auditing_at'];  $ValueList['auditing_at']= "{$Data['auditing_at']}";}
if (array_key_exists('balance',$Data) && ($Data['balance'] !== '')) { $Data['balance'] = (int)$Data['balance'];  $ValueList['balance']= "{$Data['balance']}";}
if (array_key_exists('is_admin',$Data) && ($Data['is_admin'] !== '')) { $Data['is_admin'] = (int)$Data['is_admin'];  $ValueList['is_admin']= "{$Data['is_admin']}";}
if (array_key_exists('valid_from',$Data) && ($Data['valid_from'] !== '')) { $Data['valid_from'] = (int)strtotime($Data['valid_from']);  $ValueList['valid_from']= "{$Data['valid_from']}";}
if (array_key_exists('valid_thru',$Data) && ($Data['valid_thru'] !== '')) { $Data['valid_thru'] = (int)strtotime($Data['valid_thru']);  $ValueList['valid_thru']= "{$Data['valid_thru']}";}
if (array_key_exists('leader',$Data) && ($Data['leader'] !== '')) { $Data['leader'] = (int)$Data['leader'];  $ValueList['leader']= "{$Data['leader']}";}
if (array_key_exists('flag',$Data) && ($Data['flag'] !== '')) { $Data['flag'] = (int)$Data['flag'];  $ValueList['flag']= "{$Data['flag']}";}
if (array_key_exists('agent_area',$Data)) { $Data['agent_area'] = $Data['agent_area']; $ValueList['agent_area']= "{$Data['agent_area']}";}
if (array_key_exists('allow_sells',$Data) && ($Data['allow_sells'] !== '')) { $Data['allow_sells'] = (int)$Data['allow_sells'];  $ValueList['allow_sells']= "{$Data['allow_sells']}";}
if (array_key_exists('allow_rents',$Data) && ($Data['allow_rents'] !== '')) { $Data['allow_rents'] = (int)$Data['allow_rents'];  $ValueList['allow_rents']= "{$Data['allow_rents']}";}
if (array_key_exists('allow_second_refreshed',$Data) && ($Data['allow_second_refreshed'] !== '')) { $Data['allow_second_refreshed'] = (int)$Data['allow_second_refreshed'];  $ValueList['allow_second_refreshed']= "{$Data['allow_second_refreshed']}";}
if (array_key_exists('allow_rent_refreshed',$Data) && ($Data['allow_rent_refreshed'] !== '')) { $Data['allow_rent_refreshed'] = (int)$Data['allow_rent_refreshed'];  $ValueList['allow_rent_refreshed']= "{$Data['allow_rent_refreshed']}";}
if (array_key_exists('today_rent_refreshed',$Data) && ($Data['today_rent_refreshed'] !== '')) { $Data['today_rent_refreshed'] = (int)$Data['today_rent_refreshed'];  $ValueList['today_rent_refreshed']= "{$Data['today_rent_refreshed']}";}
if (array_key_exists('today_second_refreshed',$Data) && ($Data['today_second_refreshed'] !== '')) { $Data['today_second_refreshed'] = (int)$Data['today_second_refreshed'];  $ValueList['today_second_refreshed']= "{$Data['today_second_refreshed']}";}
if (array_key_exists('level',$Data) && ($Data['level'] !== '')) { $Data['level'] = (int)$Data['level'];  $ValueList['level']= "{$Data['level']}";}
if (array_key_exists('refreshed_time',$Data)) { $Data['refreshed_time'] = $Data['refreshed_time']; $ValueList['refreshed_time']= "{$Data['refreshed_time']}";}
if (array_key_exists('allow_publish',$Data)) { $Data['allow_publish'] = $Data['allow_publish']; $ValueList['allow_publish']= "{$Data['allow_publish']}";}
if (array_key_exists('publish_sells',$Data)) { $Data['publish_sells'] = $Data['publish_sells']; $ValueList['publish_sells']= "{$Data['publish_sells']}";}
if (array_key_exists('publish_rents',$Data)) { $Data['publish_rents'] = $Data['publish_rents']; $ValueList['publish_rents']= "{$Data['publish_rents']}";}
if (array_key_exists('branch_name',$Data)) { $Data['branch_name'] = $Data['branch_name']; $ValueList['branch_name']= "{$Data['branch_name']}";}
if (array_key_exists('parent_user_id',$Data)) { $Data['parent_user_id'] = $Data['parent_user_id']; $ValueList['parent_user_id']= "{$Data['parent_user_id']}";}
if (array_key_exists('is_degree',$Data) && ($Data['is_degree'] !== '')) { $Data['is_degree'] = (int)$Data['is_degree'];  $ValueList['is_degree']= "{$Data['is_degree']}";}
if (array_key_exists('allow_recommend',$Data) && ($Data['allow_recommend'] !== '')) { $Data['allow_recommend'] = (int)$Data['allow_recommend'];  $ValueList['allow_recommend']= "{$Data['allow_recommend']}";}
if (array_key_exists('total_allow_sells',$Data) && ($Data['total_allow_sells'] !== '')) { $Data['total_allow_sells'] = (int)$Data['total_allow_sells'];  $ValueList['total_allow_sells']= "{$Data['total_allow_sells']}";}
if (array_key_exists('total_sells_count',$Data) && ($Data['total_sells_count'] !== '')) { $Data['total_sells_count'] = (int)$Data['total_sells_count'];  $ValueList['total_sells_count']= "{$Data['total_sells_count']}";}
return $ValueList;
	}
	/**
	 * 过滤数组
	 */
	function filter_user($Data)
	{
		$ValueList = array();
if (array_key_exists('login_name',$Data)) { $Data['login_name'] = $Data['login_name']; $ValueList['login_name']= "{$Data['login_name']}";}
if (array_key_exists('user_name',$Data)) { $Data['user_name'] = $Data['user_name']; $ValueList['user_name']= "{$Data['user_name']}";}
if (array_key_exists('man_code',$Data)) { $Data['man_code'] = $Data['man_code']; $ValueList['man_code']= "{$Data['man_code']}";}
if (array_key_exists('sex',$Data)) { $Data['sex'] = $Data['sex']; $ValueList['sex']= "{$Data['sex']}";}
if (array_key_exists('card_type',$Data) && ($Data['card_type'] !== '')) { $Data['card_type'] = (int)$Data['card_type'];  $ValueList['card_type']= "{$Data['card_type']}";}
if (array_key_exists('birthday',$Data)) { $Data['birthday'] = (int)$Data['birthday']; $ValueList['birthday']= "{$Data['birthday']}";}
if (array_key_exists('address',$Data) && ($Data['address'] !== '')) { $Data['address'] = (int)$Data['address'];  $ValueList['address']= "{$Data['address']}";}
if (array_key_exists('telephone',$Data)) { $Data['telephone'] = $Data['telephone']; $ValueList['telephone']= "{$Data['telephone']}";}
if (array_key_exists('mobile',$Data)) { $Data['mobile'] = $Data['mobile']; $ValueList['mobile']= "{$Data['mobile']}";}
if (array_key_exists('email',$Data)) { $Data['email'] = $Data['email']; $ValueList['email']= "{$Data['email']}";}
if (array_key_exists('description',$Data)) { $Data['description'] = $Data['description']; $ValueList['description']= "{$Data['description']}";}
return $ValueList;
	}
	
		/**
	 * 过滤数组
	 */
	function filter_company($Data)
	{
		$ValueList = array();
		if (array_key_exists('name_cn',$Data)) { $Data['name_cn'] = $Data['name_cn']; $ValueList['name_cn']= "{$Data['name_cn']}";}
		if (array_key_exists('name_en',$Data)) { $Data['name_en'] = $Data['name_en']; $ValueList['name_en']= "{$Data['name_en']}";}
		if (array_key_exists('name_short',$Data)) { $Data['name_short'] = $Data['name_short']; $ValueList['name_short']= "{$Data['name_short']}";}
		if (array_key_exists('type',$Data)) { $Data['type'] = $Data['type']; $ValueList['type']= "{$Data['type']}";}
		if (array_key_exists('address_c',$Data) && ($Data['address_c'] !== '')) {   $ValueList['address']= "{$Data['address_c']}";}
		if (array_key_exists('fax',$Data) && ($Data['fax'] !== '')) { $Data['fax'] = (int)$Data['fax'];  $ValueList['fax']= "{$Data['fax']}";}
		if (array_key_exists('homepage',$Data)) { $Data['homepage'] = $Data['homepage']; $ValueList['homepage']= "{$Data['homepage']}";}
		if (array_key_exists('email',$Data)) { $Data['email'] = $Data['email']; $ValueList['email']= "{$Data['email']}";}
		if (array_key_exists('linkman',$Data)) { $Data['linkman'] = $Data['linkman']; $ValueList['linkman']= "{$Data['linkman']}";}
		if (array_key_exists('legal_man',$Data)) { $Data['legal_man'] = $Data['legal_man']; $ValueList['legal_man']= "{$Data['legal_man']}";}
		if (array_key_exists('register_funds',$Data)) { $Data['register_funds'] = $Data['register_funds']; $ValueList['register_funds']= "{$Data['register_funds']}";}
		if (array_key_exists('patent_code',$Data)) { $Data['patent_code'] = $Data['patent_code']; $ValueList['patent_code']= "{$Data['patent_code']}";}
		if (array_key_exists('deal_scope',$Data)) { $Data['deal_scope'] = $Data['deal_scope']; $ValueList['deal_scope']= "{$Data['deal_scope']}";}
		if (array_key_exists('description_c',$Data)) { $Data['description_c'] = $Data['description_c']; $ValueList['description']= "{$Data['description_c']}";}
		if (array_key_exists('logo_url',$Data)) { $Data['logo_url'] = $Data['logo_url']; $ValueList['logo_url']= "{$Data['logo_url']}";}
		
		return $ValueList;
	}
	
	function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
		if(isset($Data['member_id']) && $Data['member_id'] != ""){
			$where .=" and a.`member_id` = '{$Data['member_id']}'";
			$page_info["member_id"]=$Data['member_id'];
			$smarty->assign("member_id",$Data['member_id']);
		}
		if(isset($Data['user_id']) && $Data['user_id'] != ""){
			$where .=" and a.`user_id` = '{$Data['user_id']}'";
			$page_info["user_id"]=$Data['user_id'];
			$smarty->assign("user_id",$Data['user_id']);
		}
		if(isset($Data['user_type']) && $Data['user_type'] != ""){
			$where .=" and a.`user_type` = '{$Data['user_type']}'";
			$page_info["user_type"]=$Data['user_type'];
			$smarty->assign("user_type",$Data['user_type']);
		}
		if(isset($Data['level_id']) && $Data['level_id'] != ""){
			$where .=" and a.`level_id` = '{$Data['level_id']}'";
			$page_info["level_id"]=$Data['level_id'];
			$smarty->assign("level_id",$Data['level_id']);
		}		
		if(isset($Data['company_id']) && $Data['company_id'] != ""){
			$where .=" and a.`company_id` = '{$Data['company_id']}'";
			$page_info["company_id"]=$Data['company_id'];
			$smarty->assign("company_id",$Data['company_id']);
		}
		if(isset($Data['name_cn']) && $Data['name_cn'] != ""){
			$where .=" and c.`name_cn` like '%{$Data['name_cn']}%'";
			$page_info["name_cn"]=$Data['name_cn'];
			$smarty->assign("name_cn",$Data['name_cn']);
		}
		if(isset($Data['pay_at']) && $Data['pay_at'] != ""){
			$where .=" and a.`pay_at` = '{$Data['pay_at']}'";
			$page_info["pay_at"]=$Data['pay_at'];
			$smarty->assign("pay_at",$Data['pay_at']);
		}
		if(isset($Data['is_trial']) && $Data['is_trial'] != ""){
			$where .=" and a.`is_trial` = '{$Data['is_trial']}'";
			$page_info["is_trial"]=$Data['is_trial'];
			$smarty->assign("is_trial",$Data['is_trial']);
		}
		if(isset($Data['is_payed']) && $Data['is_payed'] != ""){
			$where .=" and a.`is_payed` = '{$Data['is_payed']}'";
			$page_info["is_payed"]=$Data['is_payed'];
			$smarty->assign("is_payed",$Data['is_payed']);
		}
		if(isset($Data['resold_valid']) && $Data['resold_valid'] != ""){
			$where .=" and a.`resold_valid` = '{$Data['resold_valid']}'";
			$page_info["resold_valid"]=$Data['resold_valid'];
			$smarty->assign("resold_valid",$Data['resold_valid']);
		}
		if(isset($Data['create_at']) && $Data['create_at'] != ""){
			$where .=" and a.`create_at` = '{$Data['create_at']}'";
			$page_info["create_at"]=$Data['create_at'];
			$smarty->assign("create_at",$Data['create_at']);
		}
		if(isset($Data['auditing_at']) && $Data['auditing_at'] != ""){
			$where .=" and a.`auditing_at` = '{$Data['auditing_at']}'";
			$page_info["auditing_at"]=$Data['auditing_at'];
			$smarty->assign("auditing_at",$Data['auditing_at']);
		}
		if(isset($Data['balance']) && $Data['balance'] != ""){
			$where .=" and a.`balance` = '{$Data['balance']}'";
			$page_info["balance"]=$Data['balance'];
			$smarty->assign("balance",$Data['balance']);
		}
		if(isset($Data['is_admin']) && $Data['is_admin'] != ""){
			$where .=" and a.`is_admin` = '{$Data['is_admin']}'";
			$page_info["is_admin"]=$Data['is_admin'];
			$smarty->assign("is_admin",$Data['is_admin']);
		}
		if(isset($Data['valid_from']) && $Data['valid_from'] != ""){
			$where .=" and a.`valid_from` = '{$Data['valid_from']}'";
			$page_info["valid_from"]=$Data['valid_from'];
			$smarty->assign("valid_from",$Data['valid_from']);
		}
		if(isset($Data['valid_thru']) && $Data['valid_thru'] != ""){
			$where .=" and a.`valid_thru` = '{$Data['valid_thru']}'";
			$page_info["valid_thru"]=$Data['valid_thru'];
			$smarty->assign("valid_thru",$Data['valid_thru']);
		}		
		if(isset($Data['login_at']) && $Data['login_at'] != ""){
			$login_at = strtotime($Data['login_at']);
			$where .=" and d.`login_at` <= '{$login_at}'";
			$page_info["login_at"]=$Data['login_at'];
			$smarty->assign("login_at",$login_at);
		}
		if(isset($Data['leader']) && $Data['leader'] != ""){
			$where .=" and a.`leader` = '{$Data['leader']}'";
			$page_info["leader"]=$Data['leader'];
			$smarty->assign("leader",$Data['leader']);
		}
		if(isset($Data['flag']) && $Data['flag'] != ""){
			$where .=" and a.`flag` = '{$Data['flag']}'";
			$page_info["flag"]=$Data['flag'];
			$smarty->assign("flag",$Data['flag']);
		}
		if(isset($Data['agent_area']) && $Data['agent_area'] != ""){
			$where .=" and a.`agent_area` = '{$Data['agent_area']}'";
			$page_info["agent_area"]=$Data['agent_area'];
			$smarty->assign("agent_area",$Data['agent_area']);
		}
		if(isset($Data['allow_sells']) && $Data['allow_sells'] != ""){
			$where .=" and a.`allow_sells` = '{$Data['allow_sells']}'";
			$page_info["allow_sells"]=$Data['allow_sells'];
			$smarty->assign("allow_sells",$Data['allow_sells']);
		}
		if(isset($Data['allow_rents']) && $Data['allow_rents'] != ""){
			$where .=" and a.`allow_rents` = '{$Data['allow_rents']}'";
			$page_info["allow_rents"]=$Data['allow_rents'];
			$smarty->assign("allow_rents",$Data['allow_rents']);
		}
		if(isset($Data['allow_second_refreshed']) && $Data['allow_second_refreshed'] != ""){
			$where .=" and a.`allow_second_refreshed` = '{$Data['allow_second_refreshed']}'";
			$page_info["allow_second_refreshed"]=$Data['allow_second_refreshed'];
			$smarty->assign("allow_second_refreshed",$Data['allow_second_refreshed']);
		}
		if(isset($Data['allow_rent_refreshed']) && $Data['allow_rent_refreshed'] != ""){
			$where .=" and a.`allow_rent_refreshed` = '{$Data['allow_rent_refreshed']}'";
			$page_info["allow_rent_refreshed"]=$Data['allow_rent_refreshed'];
			$smarty->assign("allow_rent_refreshed",$Data['allow_rent_refreshed']);
		}
		if(isset($Data['today_rent_refreshed']) && $Data['today_rent_refreshed'] != ""){
			$where .=" and a.`today_rent_refreshed` = '{$Data['today_rent_refreshed']}'";
			$page_info["today_rent_refreshed"]=$Data['today_rent_refreshed'];
			$smarty->assign("today_rent_refreshed",$Data['today_rent_refreshed']);
		}
		if(isset($Data['today_second_refreshed']) && $Data['today_second_refreshed'] != ""){
			$where .=" and a.`today_second_refreshed` = '{$Data['today_second_refreshed']}'";
			$page_info["today_second_refreshed"]=$Data['today_second_refreshed'];
			$smarty->assign("today_second_refreshed",$Data['today_second_refreshed']);
		}
		if(isset($Data['level']) && $Data['level'] != ""){
			$where .=" and a.`level` = '{$Data['level']}'";
			$page_info["level"]=$Data['level'];
			$smarty->assign("level",$Data['level']);
		}
		if(isset($Data['refreshed_time']) && $Data['refreshed_time'] != ""){
			$where .=" and a.`refreshed_time` = '{$Data['refreshed_time']}'";
			$page_info["refreshed_time"]=$Data['refreshed_time'];
			$smarty->assign("refreshed_time",$Data['refreshed_time']);
		}
		if(isset($Data['allow_publish']) && $Data['allow_publish'] != ""){
			$where .=" and a.`allow_publish` = '{$Data['allow_publish']}'";
			$page_info["allow_publish"]=$Data['allow_publish'];
			$smarty->assign("allow_publish",$Data['allow_publish']);
		}
		if(isset($Data['publish_sells']) && $Data['publish_sells'] != ""){
			$where .=" and a.`publish_sells` = '{$Data['publish_sells']}'";
			$page_info["publish_sells"]=$Data['publish_sells'];
			$smarty->assign("publish_sells",$Data['publish_sells']);
		}
		if(isset($Data['publish_rents']) && $Data['publish_rents'] != ""){
			$where .=" and a.`publish_rents` = '{$Data['publish_rents']}'";
			$page_info["publish_rents"]=$Data['publish_rents'];
			$smarty->assign("publish_rents",$Data['publish_rents']);
		}
		if(isset($Data['branch_name']) && $Data['branch_name'] != ""){
			$where .=" and a.`branch_name` = '{$Data['branch_name']}'";
			$page_info["branch_name"]=$Data['branch_name'];
			$smarty->assign("branch_name",$Data['branch_name']);
		}
		if(isset($Data['parent_user_id']) && $Data['parent_user_id'] != ""){
			$where .=" and a.`parent_user_id` = '{$Data['parent_user_id']}'";
			$page_info["parent_user_id"]=$Data['parent_user_id'];
			$smarty->assign("parent_user_id",$Data['parent_user_id']);
		}
		if(isset($Data['is_degree']) && $Data['is_degree'] != ""){
			$where .=" and a.`is_degree` = '{$Data['is_degree']}'";
			$page_info["is_degree"]=$Data['is_degree'];
			$smarty->assign("is_degree",$Data['is_degree']);
		}
		if(isset($Data['login_name']) && $Data['login_name'] != ""){
			$where .=" and (b.`login_name` like '%{$Data['login_name']}%' or b.user_name like '%{$Data['login_name']}%')";
			$page_info["login_name"]=$Data['login_name'];
			$smarty->assign("login_name",$Data['login_name']);
		}
		if(isset($Data['telephone']) && $Data['telephone'] != ""){
			$where .=" and b.`telephone` like '%{$Data['telephone']}%'";
			$page_info["telephone"]=$Data['telephone'];
			$smarty->assign("telephone",$Data['telephone']);
		}
	}
?>