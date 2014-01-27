<?php
	require_once('../../sys_load.php');
	require_once('../../data/cache/base_code.php');
	$verify = new Verify();

	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//模板路径,生成后自行修改
	$template_edit = "admin/member/paladinproject_edit.tpl";
	$template_list = "admin/member/paladinproject_list.tpl";
	// 基础代码
	$code = new BaseCode();
	$status_text=$code->getPairBaseCodeByType(222);
	////$direction_text=$code->getPairBaseCodeByType(205);
	$region_text=$code->getPairBaseCodeByType(224);//新房片区
	//$borough_text=$code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'");
	////$circle_text=$code->getPairBaseCodeByType(211);
	////$pm_type_text=$code->getPairBaseCodeByType(223," order by top desc");

	//得到新房管理人员
	//$new_layout_keeper=$pdo->getAll('select b.user_id,b.user_name from home_member as a left join home_user as b  on a.user_id=b.user_id where a.user_type=10 or a.user_type=11');

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
			case 'delete':del(); //删除单条记录方法
				exit;
			case 'ajaxDigest':ajaxDigest(); //删除多条记录方法
				exit;
			case 'order':order(); //删除多条记录方法
				exit;
			default:index();
				exit;
		}
	/**
	 * 保存修改或增加到数据库
	 */
	function save()
	{	//todo 安全性
		global $smarty, $pdo;
		//print_r($_SESSION);exit;
		//出来物业类型，用逗号分割
		$pm_type = isset($_POST['pm_type'])?$_POST['pm_type']:array();
		$_POST['pm_type'] = implode(",", $pm_type);
		if(isset($_POST['media'])){
		$_POST['media']=implode(",",$_POST['media']);
		}
		$_POST['mediaperson']=implode(",",$_POST['mediaperson']);
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new') {
			$_POST['create_at'] = time();
			$_POST['user_id'] = $_SESSION['home_userid'];
			$pdo->add($_POST, 'paladin_project');
   			$lastInsID=$pdo->getLastInsID();
			if ($lastInsID) {
				 $url = "/paladin/project.php?&sp=".formatParameter(array('id'=>$lastInsID));
				 page_msg($msg='保存成功!',$isok=true,$url);
			} else {
				 page_msg($msg='保存失败!',$isok=false,$url=$_SERVER['HTTP_REFERER']);
			}

		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['id'])) {
			$id = intval($_POST['id']);
			if (isset($_POST)) {
				$pdo->update($_POST, 'paladin_project',"id=".$id);
				page_msg($msg='修改成功!',$isok=true,$url=$_SERVER['HTTP_REFERER']);
			} else {
				page_msg($msg='保存失败!',$isok=false,$url=$_SERVER['HTTP_REFERER']);
			}
		}
	}

	/**
	 * 输出添加界面
	 */
	function add()
	{
		global $smarty, $template_edit,$pdo,$house_media_text,$media_name_1;
		global $direction_text,$region_text,$borough_text,$circle_text,$pm_type_text,$layout_status_value;
		$media_name_info=$pdo->getAll("select * from paladin_mediaperson");
		$ValueList = array();
		$ValueList['direction_text'] = $direction_text;
		$ValueList['region_text'] = $region_text;
		$ValueList['borough_text'] = $borough_text;
		$ValueList['circle_text'] = $circle_text;
		$ValueList['pm_type_text'] = $pm_type_text;
		$ValueList['project_status_value'] = $layout_status_value;
		$smarty->assign('projectInfo',$ValueList);
		$smarty->assign("EditOption" , 'new');
		$smarty->assign("media_name_info",$media_name_info);
		$smarty->assign("house_media_text",$house_media_text);
		$smarty->assign("url" , $_SERVER['HTTP_REFERER']);
		$smarty -> show($template_edit);
	}
	
	/**
	 * 输出编辑界面
	 */
	function edit()
	{
		global $smarty, $pdo, $template_edit,$house_media_text;
		global $direction_text,$region_text,$borough_text,$circle_text,$pm_type_text,$layout_status_value;

		//$para = formatParameter($_GET["sp"], "out");
		//$layout_id = isset($para['id']) ? $para['id'] : 1;
		$project_id = isset($_GET['id'])?$_GET['id']:0;
		if(intval($project_id)){
			$ValueList = $pdo->getRow("select * from paladin_project where id = '$project_id'");
			$media_name_info=$pdo->getAll("select * from paladin_mediaperson");
			$ValueList['direction_text'] = $direction_text;
			$ValueList['region_text'] = $region_text;
			$ValueList['borough_text'] = $borough_text;
			$ValueList['circle_text'] = $circle_text;
			$ValueList['pm_type_text'] = $pm_type_text;
			$ValueList['project_status_value'] = $layout_status_value;
			//处理物业类型
			$ValueList['pm_type_selected'] = explode(',',$ValueList['pm_type']);
			//媒体类型
			$ValueList['pm_media_selected'] = explode(',',$ValueList['media']);
			//媒体对接人
			$ValueList['pm_media_person'] = explode(',',$ValueList['mediaperson']);

			// 楼盘信息
			$_SESSION['project_name']=$ValueList['project_name'];
			$smarty->assign("project_id" , $project_id);
			$smarty->assign("tablist",'info');
			$smarty->assign('projectInfo',$ValueList);
			$smarty->assign("EditOption" , 'Edit');
			$smarty->assign("media_name_info",$media_name_info);
			$smarty->assign("house_media_text",$house_media_text);
			//$smarty->assign("UrlReferer" , $_SERVER['HTTP_REFERER']);
			$smarty -> show($template_edit);
		}else{
			page_msg($msg='非法操作!',$isok=false,$url=$_SERVER['HTTP_REFERER']);
		}
	}
	
	/**
	 * 执行删除
	 */
	function del(){
		global $pdo;
		$para = formatParameter($_GET['sp'], "out");
		if(isset($para['id']) && $para['id']>0){
			$rst = $pdo->remove("id=".$para['id'],"paladin_project");
			page_msg($msg='操作成功!',$isok=true,$url=$_SERVER['HTTP_REFERER']);
		}else{
			page_msg($msg='非法操作，请返回!',$isok=false,$url=$_SERVER['HTTP_REFERER']);
		}
	}
	
	/**
	 * 执行多项删除
	 */
	function deleteAll()
	{
		/*
		global $pdo,$template_msg,$smarty;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'delall'){
			$Id = isset($_POST['ids']) ? $_POST['ids'] : array();
			$count = count($Id);
			if($count != 0){
			    $query = " DELETE FROM home_layout WHERE `Id` IN (". implode(",", $Id) .")";
				$pdo->execute($query);
				$msg = '多项删除删除成功';
			}
		}
		$smarty->assign("msg" , $msg);
		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
	   	$smarty -> show($template_msg);
		*/
	}



	/**
	 * 输出列表界面
	 */
	function index()
	{
		//echo "<meta http-equiv='refresh' content='1;url=http://www.fun.com/paladin/project.php'>";   
		
		global $smarty, $pdo, $template_list;
		global $status_text,$borough_text;
		//获取当前登录用户信息
		$sql = "select * from home_user where username='".$_SESSION['home_username']."'";
		$user_list=$pdo->getRow($sql);
		
		$layout = new layout();
		$page_info = "";
		$sort = isset($_GET['sort']) ? $_GET['sort'] : 'a.id';
		$flag = isset($_GET['flag']) ? $_GET['flag'] : 'desc';
		$sub_pages=5;								//每次显示的页数
		$pageSize=10;								//每页显示条数数
		$offset=0;
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		$order = "order by $sort $flag";
		$where = "where 1 ";
	   	if($_GET) {
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	    }
				
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$select_columns = 'select %s from paladin_project as a %s %s %s';
	    $limit = "limit $offset,$pageSize";
		$sql = sprintf($select_columns,'a.*',$where,$order,$limit);
		$projectList=$pdo->getAll($sql);
		$select_columns = 'select %s from paladin_project as a %s';
		$sql = sprintf($select_columns,'count(a.id) as cnt',$where);
		$recordCount=$pdo->getRow($sql);
		
	    $page=new Page($pageSize,$recordCount['cnt'],$currentPage,$sub_pages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();
		
		$smarty->assign('status_text',	$status_text);
		$smarty->assign('borough_text',	$borough_text);

	 	// 查询到的结果
		$smarty->assign('projectList', $projectList);

		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);
		// 指定模板
		$smarty->show($template_list);
	}


	function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
		if(isset($Data['project_name']) && $Data['project_name'] != ""){
			$where .=" and a.`project_name` like '%{$Data['project_name']}%'";
			$page_info.="project_name={$Data['project_name']}&";
			$smarty->assign("project_name",$Data['project_name']);
		}
		if(isset($Data['developer']) && $Data['developer'] != ""){
			$where .=" and a.`developer` = '{$Data['developer']}'";
			$page_info.="developer={$Data['developer']}&";
			$smarty->assign("developer",$Data['developer']);
		}
		if(isset($Data['direction']) && $Data['direction'] != ""){
			$where .=" and a.`direction` = '{$Data['direction']}'";
			$page_info.="direction={$Data['direction']}&";
			$smarty->assign("direction",$Data['direction']);
		}
		if(isset($Data['region']) && $Data['region'] != ""){
			$where .=" and a.`region` = '{$Data['region']}'";
			$page_info.="region={$Data['region']}&";
			$smarty->assign("region",$Data['region']);
		}
		if(isset($Data['borough']) && $Data['borough'] != ""){
			$where .=" and a.`borough` = '{$Data['borough']}'";
			$page_info.="borough={$Data['borough']}&";
			$smarty->assign("borough",$Data['borough']);
		}
		if(isset($Data['circle']) && $Data['circle'] != ""){
			$where .=" and a.`circle` = '{$Data['circle']}'";
			$page_info.="circle={$Data['circle']}&";
			$smarty->assign("circle",$Data['circle']);
		}
		if(isset($Data['pm_type']) && $Data['pm_type'] != ""){
			$where .=" and a.`pm_type` = '{$Data['pm_type']}'";
			$page_info.="pm_type={$Data['pm_type']}&";
			$smarty->assign("pm_type",$Data['pm_type']);
		}
		if(isset($Data['flag']) && $Data['flag'] != ""){
			$where .=" and a.`flag` = '{$Data['flag']}'";
			$page_info.="flag={$Data['flag']}&";
			$smarty->assign("flag",$Data['flag']);
		}
		if(isset($Data['is_top']) && $Data['is_top'] != ""){
			$where .=" and a.`is_top` = '{$Data['is_top']}'";
			$page_info.="is_top={$Data['is_top']}&";
			$smarty->assign("is_top",$Data['is_top']);
		}
	}
?>