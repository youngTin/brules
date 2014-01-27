<?php

	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	//模板路径,生成后自行修改
	$template_edit = "admin/esf/company_info.tpl";
	$template_list = "admin/esf/company_list.tpl";
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
			case 'saveimg':saveimg(); //修改公司图片
				exit;
			case "savelogo":savelogo();
				exit;
			case 'company_img':company_img(); //列表页面
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
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new') {
		$Data = filter($_POST);
		if (isset($Data) &&  $pdo->add($Data,DB_PREFIX_HOME.'company')) {
   			 $pdo->getLastInsID();
   			 $msg = '保存成功';
			 $smarty->assign("msg" , $msg);
	   		 $smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
			 $smarty -> show($template_msg);
		} else {
			$msg = '保存失败';
			$_POST['UrlReferer'];
			$smarty->assign("msg" , $msg);
	   		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
			$smarty -> show($template_msg);
		}

		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['id'])) {		
			$Data = filter($_POST); 
			if (isset($Data)) {
				 $pdo->update($Data , DB_PREFIX_HOME.'company', "id=".$_POST['id']);
	   			 $msg = '修改成功';
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
		
		$ValueList = array();
																																																												$smarty->assign('companyInfo',$ValueList);
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
	
		$para = formatParameter($_GET["sp"], "out");
		$company_id = isset($para['id']) ? $para['id'] : 1;
		$sql = "select * from ".DB_PREFIX_HOME."company where id = $company_id";
		$company_info = $pdo->getRow($sql);
		$smarty->assign('company_info',$company_info);
		$sql = "select a.id as att_id,a.url,i.id from ".DB_PREFIX_HOME."attach as a ,".DB_PREFIX_HOME."img as i where i.attach_id = a.id and i.company_id = $company_id and i.default_val = 0 order by is_frist desc limit 1";
		$img_info = $pdo->getRow($sql);
		$smarty->assign('companyId',$company_id);
		$smarty->assign('imgInfo',$img_info);
		$smarty->assign("EditOption" , 'edit');
		$smarty->show($template_edit);
	}


	/**
	 * 执行删除
	 */
	function delete()
	{
		global $pdo,$template_msg,$smarty;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 0;
		$pdo->remove("id={$id}",DB_PREFIX_HOME."company");
		$msg = '删除成功';
		$smarty->assign("msg" , $msg);
		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
	   	$smarty -> show($template_msg);
	}

	/**
	 * 执行多项删除
	 */
	function deleteAll()
	{
		global $pdo,$template_msg,$smarty;
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'delall'){
			$id = isset($_POST['ids']) ? $_POST['ids'] : array();
			$count = count($id);
			if($count != 0){
			    $query = " DELETE FROM ".DB_PREFIX_HOME."company WHERE `id` IN (". implode(",", $id) .")";
				$pdo->execute($query);
				$msg = '多项删除删除成功';
			}
		}
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
		$orderField = isset($_GET['sort']) ? 'a'.$_GET['sort'] : 'a.id';
		$orderValue = isset($_GET['flag']) ? $_GET['flag'] : 'desc';

		$pageSize = 15;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$where = 'where 1 and type = 3 ';
	   	if($_GET) {
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	        }
	    $select_columns = "select %s from ".DB_PREFIX_HOME."company as a %s %s %s";
	    
	    $order = "order by $orderField $orderValue";
	    $limit = "limit $offset,$pageSize";
	    $count = " count(a.id) as count ";
	    $sql = sprintf($select_columns,'a.*',$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();

	 	// 查询到的结果
	 	$smarty->assign("EditOption", 'delall');
		$smarty->assign('companyList', $res);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);
		// 指定模板
		$smarty->show($template_list);
	}
	
	function company_img()
	{
		$pdo = new MysqlPdo();
		$smarty = new WebSmarty;	
		$company_id = $_GET["companyId"];
		$sql = "select a.id as att_id,a.url,i.id from ".DB_PREFIX_HOME."attach as a ,".DB_PREFIX_HOME."img as i where i.attach_id = a.id and i.company_id = $company_id and i.default_val = 0 order by is_frist desc limit 1";
		$img_info = $pdo->getRow($sql);
		$sql = "select logo_url from ".DB_PREFIX_HOME."company where id = $company_id ";
		$logo_info = $pdo->getRow($sql); //获取附件信息
		$smarty->assign('logo_info',$logo_info);
		$smarty->assign('imgInfo',$img_info);
		$smarty->assign('companyId',$company_id);
		
		$smarty->show('admin/esf/company_img.tpl');
	}
	
	/**
	 * *保存公司图片
	 *
	 */
	function saveimg()
	{
		global $smarty, $pdo;
		$company_id = isset($_GET["companyId"])?$_GET["companyId"]:$_POST['companyId'];
		$user_id= isset($_GET["userId"])?$_GET["userId"]:$_POST['userId'];
		if ($_FILES['file']['name']) {
			$uploadFile = new UploadFile($_FILES['file']);//图片放在upload/../公司名/
			$uploadFile->setHeight(150);
			$uploadFile->setWidth(200);
			$uploadFile -> upload();
			$img_info = $uploadFile -> getSaveInfo();//得到上传文件信息
			$img_info = $img_info[0];
			$img_info['update_at'] = time();
			
			$pdo->add($img_info,DB_PREFIX_HOME.'attach'); //插入附件表
			$att_id = $pdo->getLastInsID();	//获取附件id
			if($att_id){
				$sql = "select a.id as att_id,a.url,i.id from ".DB_PREFIX_HOME."attach as a ,".DB_PREFIX_HOME."img as i where i.attach_id = a.id and i.company_id = $company_id and i.default_val = 0";
				$arr_info = $pdo->getAll($sql); //获取附件信息
				foreach($arr_info as $key => $item){ //删除附件信息
					$item['s_url'] = str_replace('.','_s.',$item['url']);
					$uploadFile->DeleteFile(WEB_ROOT.$item['url']);
					$uploadFile->DeleteFile(WEB_ROOT.$item['s_url']);
					$pdo->execute("delete from ".DB_PREFIX_HOME."attach where id = '{$item['att_id']}'");
				}
				$pdo->remove("company_id=$company_id and default_val=0",DB_PREFIX_HOME."img");
				//echo $pdo->getLastSql();
				$pdo->add(array('company_id'=>$company_id,'attach_id'=>$att_id,'user_id'=>$user_id,'default_val'=>0),DB_PREFIX_HOME."img");
				$msg = "图片添加成功";
			}else{$msg = "图片添加失败";}
			//$pdo -> update($img_info,'home_attach',"id='" . $post['ID'] . "'");//写入附件表
		}
		else $msg = '添加失败';
		$smarty->assign("msg" ,$msg);
		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
		$smarty -> show("../tpl/msg.tpl");
	}
	
	
		/**
	 * *保存公司图片
	 *
	 */
	function savelogo()
	{
		global $smarty, $pdo;
		$company_id = isset($_GET["companyId"])?$_GET["companyId"]:$_POST['companyId'];
		if ($_FILES['file']['name']) {
			$uploadFile = new UploadFile($_FILES['file']);//图片放在upload/../公司名/
			$uploadFile->setHeight(190);
			$uploadFile->setWidth(940);
			$uploadFile -> upload();
			$img_info = $uploadFile -> getSaveInfo();//得到上传文件信息
			$img_info = $img_info[0];
			$img_info['update_at'] = time();
			//$pdo->add($img_info,'home_attach'); //插入附件表
			//$att_id = $pdo->getLastInsID();	//获取附件id
			if($img_info){
				$sql = "select logo_url from ".DB_PREFIX_HOME."company where id = $company_id ";
				$arr_info = $pdo->getRow($sql); //获取附件信息
				$arr_info['s_logo_url'] = str_replace('.','_s.',$arr_info['logo_url']);
				echo WEB_ROOT.$arr_info['logo_url'];
				$uploadFile->DeleteFile(WEB_ROOT.$arr_info['logo_url']);
				$uploadFile->DeleteFile(WEB_ROOT.$arr_info['s_logo_url']);
				
				$pdo->execute("update ".DB_PREFIX_HOME."company set logo_url = '{$img_info['url']}' where id = $company_id");
				//echo $pdo->getLastSql();
				$msg = "图片添加成功";
			}else{$msg = "图片添加失败";}
			//$pdo -> update($img_info,'home_attach',"id='" . $post['ID'] . "'");//写入附件表
		}
		else $msg = '添加失败';
		$smarty->assign("msg" ,$msg);
		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
		$smarty -> show("../tpl/msg.tpl");
	}
	


	/**
	 * 过滤数组
	 */
	function filter($Data)
	{
		$ValueList = array();
	if (array_key_exists('name_cn',$Data)) { $Data['name_cn'] = $Data['name_cn']; $ValueList['name_cn']= "{$Data['name_cn']}";}
	if (array_key_exists('name_short',$Data)) { $Data['name_short'] = $Data['name_short']; $ValueList['name_short']= "{$Data['name_short']}";}
	if (array_key_exists('address',$Data)) { $Data['address'] = $Data['address']; $ValueList['address']= "{$Data['address']}";}
	if (array_key_exists('zip',$Data)) { $Data['zip'] = $Data['zip']; $ValueList['zip']= "{$Data['zip']}";}
	if (array_key_exists('telephone',$Data) && ($Data['telephone'] !== '')) { $Data['telephone'] = $Data['telephone'];  $ValueList['telephone']= "{$Data['telephone']}";}
	if (array_key_exists('fax',$Data) && ($Data['fax'] !== '')) { $Data['fax'] = (int)$Data['fax'];  $ValueList['fax']= "{$Data['fax']}";}
	if (array_key_exists('homepage',$Data)) { $Data['homepage'] = $Data['homepage']; $ValueList['homepage']= "{$Data['homepage']}";}
	if (array_key_exists('email',$Data)) { $Data['email'] = $Data['email']; $ValueList['email']= "{$Data['email']}";}
	if (array_key_exists('linkman',$Data)) { $Data['linkman'] = $Data['linkman']; $ValueList['linkman']= "{$Data['linkman']}";}
	if (array_key_exists('legal_man',$Data)) { $Data['legal_man'] = $Data['legal_man']; $ValueList['legal_man']= "{$Data['legal_man']}";}
	if (array_key_exists('patent_code',$Data)) { $Data['patent_code'] = $Data['patent_code']; $ValueList['patent_code']= "{$Data['patent_code']}";}
	if (array_key_exists('deal_scope',$Data)) { $Data['deal_scope'] = $Data['deal_scope']; $ValueList['deal_scope']= "{$Data['deal_scope']}";}
	if (array_key_exists('description',$Data)) { $Data['description'] = $Data['description']; $ValueList['description']= "{$Data['description']}";}
								return $ValueList;
	}

	function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
				if(isset($Data['id']) && $Data['id'] != ""){
			$where .=" and a.`id` = '{$Data['id']}'";
			$page_info.="id={$Data['id']}&";
			$smarty->assign("id",$Data['id']);
		}
				if(isset($Data['name_cn']) && $Data['name_cn'] != ""){
			$where .=" and a.`name_cn` = '{$Data['name_cn']}'";
			$page_info.="name_cn={$Data['name_cn']}&";
			$smarty->assign("name_cn",$Data['name_cn']);
		}
				if(isset($Data['name_short']) && $Data['name_short'] != ""){
			$where .=" and a.`name_short` = '{$Data['name_short']}'";
			$page_info.="name_short={$Data['name_short']}&";
			$smarty->assign("name_short",$Data['name_short']);
		}
				if(isset($Data['address']) && $Data['address'] != ""){
			$where .=" and a.`address` = '{$Data['address']}'";
			$page_info.="address={$Data['address']}&";
			$smarty->assign("address",$Data['address']);
		}
				if(isset($Data['zip']) && $Data['zip'] != ""){
			$where .=" and a.`zip` = '{$Data['zip']}'";
			$page_info.="zip={$Data['zip']}&";
			$smarty->assign("zip",$Data['zip']);
		}
				if(isset($Data['telephone']) && $Data['telephone'] != ""){
			$where .=" and a.`telephone` = '{$Data['telephone']}'";
			$page_info.="telephone={$Data['telephone']}&";
			$smarty->assign("telephone",$Data['telephone']);
		}
				if(isset($Data['fax']) && $Data['fax'] != ""){
			$where .=" and a.`fax` = '{$Data['fax']}'";
			$page_info.="fax={$Data['fax']}&";
			$smarty->assign("fax",$Data['fax']);
		}
				if(isset($Data['homepage']) && $Data['homepage'] != ""){
			$where .=" and a.`homepage` = '{$Data['homepage']}'";
			$page_info.="homepage={$Data['homepage']}&";
			$smarty->assign("homepage",$Data['homepage']);
		}
				if(isset($Data['email']) && $Data['email'] != ""){
			$where .=" and a.`email` = '{$Data['email']}'";
			$page_info.="email={$Data['email']}&";
			$smarty->assign("email",$Data['email']);
		}
				if(isset($Data['linkman']) && $Data['linkman'] != ""){
			$where .=" and a.`linkman` = '{$Data['linkman']}'";
			$page_info.="linkman={$Data['linkman']}&";
			$smarty->assign("linkman",$Data['linkman']);
		}
				if(isset($Data['legal_man']) && $Data['legal_man'] != ""){
			$where .=" and a.`legal_man` = '{$Data['legal_man']}'";
			$page_info.="legal_man={$Data['legal_man']}&";
			$smarty->assign("legal_man",$Data['legal_man']);
		}
				if(isset($Data['patent_code']) && $Data['patent_code'] != ""){
			$where .=" and a.`patent_code` = '{$Data['patent_code']}'";
			$page_info.="patent_code={$Data['patent_code']}&";
			$smarty->assign("patent_code",$Data['patent_code']);
		}
				if(isset($Data['deal_scope']) && $Data['deal_scope'] != ""){
			$where .=" and a.`deal_scope` = '{$Data['deal_scope']}'";
			$page_info.="deal_scope={$Data['deal_scope']}&";
			$smarty->assign("deal_scope",$Data['deal_scope']);
		}
				if(isset($Data['description']) && $Data['description'] != ""){
			$where .=" and a.`description` = '{$Data['description']}'";
			$page_info.="description={$Data['description']}&";
			$smarty->assign("description",$Data['description']);
		}
		}
?>