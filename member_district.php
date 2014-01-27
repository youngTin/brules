<?php
require_once('./member_config.php');
check_login();
require_once('./data/cache/base_code.php');
//$verify = new Verify();
$pdo = new MysqlPdo();
$smarty = new WebSmarty();
//模板路径,生成后自行修改
$template_edit = "member/esf_district_edit.tpl";
$template_list = "member/esf_district_list.tpl";
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
	case "delimg":delimg();
	exit;
	case 'district_showpic':district_showpic(); //显示图片
	exit;
	case 'deleteall':deleteAll(); //删除多条记录方法
	exit;
	case 'getarea_data':getarea_data();
	exit;
	case 'add_pic':add_pic();
	exit;
	case 'saveimg':saveimg();
	exit;

	default:index();
	exit;
}

function saveimg()
{ 
	global $smarty, $template_msg;
	$pic_type = isset($_POST['pic_type'])?(int)$_POST['pic_type']:1;
	if ($_FILES['file']['name']) {
		$uploadFile = new UploadFile($_FILES['file']);//图片放在upload/../公司名/
		$uploadFile->setHeight(300);
		$uploadFile->setWidth(400);
		//$uploadFile->DelOriginalImage(true); //删除原始图片
		$uploadFile -> upload();
		$img_info = $uploadFile -> getSaveInfo();//得到上传文件信息
		$img_info = $img_info[0];
		$img_info['update_at'] = time();
		$img_info['pic_type'] = $pic_type;
		$_SESSION['district_pic'][] = $img_info;
		$msg = "图片添加成功";
	}
	else $msg = '添加失败';

	$smarty->assign("time" ,0);
	$smarty->assign("msg" ,$msg);
	$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
	$smarty -> show("upload_msg.tpl");
}

function add_pic(){
	global $smarty, $pdo,$template_msg;
	$pic_type = isset($_GET['type'])?(int)$_GET['type']:1;
	$smarty->assign("pic_type" ,$pic_type);
	$smarty->show("admin/esf/upload_pic.tpl");
}

function getarea_data(){
	$code_id = isset($_GET['code'])?(int)$_GET['code']:exit;
	$code = new BaseCode();
	$Data = $code->getPidByType($code_id);
	echo json_encode($Data);
	exit;
}

function delimg()
{
	global $smarty,$template_msg,$pdo;
	if($_GET["type"]!='session'){
		$aid =  isset($_GET["id"])?(int)$_GET["id"]:0;
		$sql = "select a.url,p.attach_id From ".DB_PREFIX_HOME."esf_district_pic as p
				left join ".DB_PREFIX_HOME."esf_attach as a on a.id=p.attach_id where p.attach_id='$aid'";
		$picInfo = $pdo->getRow($sql);
		$pdo->remove("id={$picInfo['attach_id']}",DB_PREFIX_HOME."esf_attach");
		$pdo->remove("attach_id={$picInfo['attach_id']}",DB_PREFIX_HOME."esf_district_pic");
		$pdo->remove("attach_id={$picInfo['attach_id']}",DB_PREFIX_HOME."esf_pic");
		$url = $picInfo["url"];
		UploadFile::DeleteFile(WEB_ROOT.$url);
	}else{
		$id=isset($_GET['id'])?(int)$_GET['id']:'';
		//print_r($_SESSION['district_pic'][$id]["url"]);
		//echo $_SESSION['district_pic'][$id]["url"];
		UploadFile::DeleteFile(WEB_ROOT.$_SESSION['district_pic'][$id]["url"]);
		unset($_SESSION['district_pic'][$id]);
	}
	
	//$msg = "删除成功";
	page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER'],0);
}

//显示框架里的图片
function district_showpic(){
	global $smarty, $pdo;
	$type = isset($_GET["type"])?(int)$_GET["type"]:2;
	$picinfo = array();
	if(is_array($_SESSION['district_pic'])){
		foreach($_SESSION['district_pic'] as $key=>$item){
			if($item['pic_type']==$type){
				$picinfo[] = $_SESSION['district_pic'][$key];
				$picinfo[count($picinfo)-1]['id'] = $key;
			}
		}
	}
	//print_r($picinfo);
	$smarty->assign("picinfo",$picinfo);
	

	$district_id =  isset($_GET["did"])?(int)$_GET["did"]:0;

	$sql = "select a.url,p.attach_id From ".DB_PREFIX_HOME."esf_district_pic as p
		left join ".DB_PREFIX_HOME."esf_attach as a on a.id=p.attach_id where p.district_id='$district_id'
		and code=$type";
	$picInfoDB = $pdo->getAll($sql);
	$smarty->assign("picinfoDB",$picInfoDB);
	
	$smarty->show('admin/esf/district_showpic.tpl');
}
/**
		 * 保存修改或增加到数据库
		 */
/**
	 * 保存修改或增加到数据库
	 */
function save()
{
	global $smarty, $pdo,$template_msg;
	if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new') {
		$Data = filter($_POST);

		if (isset($Data) &&  $pdo->add($Data,DB_PREFIX_HOME.'esf_district')) {
			$district_id = $pdo->getLastInsID();
			$pdo->execute("update ".DB_PREFIX_HOME."esf_district set pid = '$district_id' where id =  '$district_id'");

			$msg = '保存成功';

		} else {
			$msg = '保存失败';

		}

	}
	if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['Id'])) {
		$Data = filter($_POST);
		
		if (isset($Data)) {
			$pdo->update($Data , DB_PREFIX_HOME."esf_district", "Id=".$_POST['Id']);
			$msg = '修改成功';
			$district_id = $_POST['Id'];
		} else {
			$msg = '保存失败';
			
		}
	}

	//保存小区图片
	if(isset($district_id) && $district_id>0){
		if(is_array($_SESSION['district_pic'])){
			foreach($_SESSION['district_pic'] as $key=>$item){
				$pdo->add($item,DB_PREFIX_HOME.'esf_attach');
				$attach_id = $pdo->getLastInsID();
				if($attach_id){
					$district_pic = array(
					"attach_id"=>$attach_id,
					"district_id" => $district_id,
					"code" => $item["pic_type"],
					"flag" => 1
					);
					$pdo->add($district_pic,DB_PREFIX_HOME."esf_district_pic");
					echo $pdo->getLastInsId();
				}
			}
		}
		unset($_SESSION['district_pic']);
	}
	
	page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);

}

/**
		 * 输出添加界面
		 */
function add()
{
	global $smarty, $pdo, $template_edit;
	$area_text=array(
	'0'=>'否',
	'1'=>'是');
	$borough_text=array(
	'0'=>'否',
	'1'=>'是');
	$flag_text=array(
	'0'=>'待审核',
	'1'=>'通过审核');
	$code = new BaseCode();
	// 物业类型
	$property_text=$code->getPairBaseCodeByType(203);
	$borough_text=$code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'");
	$area_text = $code->getPidByType(510104);
	$ValueList = array();
	$ValueList['property_text'] = $property_text;
	$ValueList['area_text'] = $area_text;
	$ValueList['borough_text'] = $borough_text;
	$ValueList['flag_text'] = $flag_text;
	$smarty->assign('districtInfo',$ValueList);
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
	$Id = isset($para['Id']) ? $para['Id'] : 1;
	$code = new BaseCode();
	$flag_text=array(
	'0'=>'未通过',
	'1'=>'通过审核');
	$code = new BaseCode();
	// 物业类型
	$property_text=$code->getPairBaseCodeByType(203);
	//地区代码
	$borough_text=$code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'");

	$ValueList = $pdo->getRow("select * from ".DB_PREFIX_HOME."esf_district where Id = '$Id'");
	$ValueList['property_text'] = $property_text=$code->getPairBaseCodeByType(203);
	$ValueList['area_text'] = $code->getPidByType($ValueList['borough']);
	$ValueList['borough_text'] =$code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'");
	$ValueList['flag_text'] = $flag_text;
	$smarty->assign('districtInfo',$ValueList);
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
	$para = formatParameter($_GET["sp"], "out");
	$id = isset($para['Id']) ? $para['Id'] : 0;
	$pdo->remove("Id={$id}",DB_PREFIX_HOME."esf_district");
	$msg = '删除成功';
	page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
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
			$query = " DELETE FROM ".DB_PREFIX_HOME."esf_district WHERE `id` IN (". implode(",", $id) .")";
			$pdo->execute($query);
			$msg = '多项删除删除成功';
		}
	}
	page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
}



/**
		 * 输出列表界面
		 */
function index()
{
	global $smarty, $pdo, $template_list;
	$page_info = "";
	$orderField = isset($_GET['sort']) ? 'a'.$_GET['sort'] : 'a.Id';
	$orderValue = isset($_GET['order']) ? $_GET['order'] : 'desc';

	unset($_SESSION['district_pic']);

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
	$select_columns = "select %s from ".DB_PREFIX_HOME."esf_district as a %s %s %s";

	$order = "order by $orderField $orderValue";
	$limit = "limit $offset,$pageSize";
	$count = " count(a.Id) as count ";
	$sql = sprintf($select_columns,'a.*',$where,$order,$limit);
	$sqlcount = sprintf($select_columns,$count,$where,'','');
	$res = $pdo->getAll($sql);
	$Count = $pdo->getRow($sqlcount);
	$recordCount = $Count['count'];
	$page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",2);
	$splitPageStr=$page->get_page_html();
	$code = new BaseCode();
	// 物业类型
	$property_text=$code->getPairBaseCodeByType(203);
	//地区代码
	$borough_text=$code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'");

	$flag_text=array(
	'0'=>'待审核',
	'1'=>'通过审核');

	$smarty->assign('property_text',	$property_text);
	$smarty->assign('borough_text',	$borough_text);
	$smarty->assign('flag_text',	$flag_text);
	foreach ($res as $key => $item) {
		if(!is_null($item['property']))
		$res[$key]['property_text'] = $property_text[$item['property']];
		if(!is_null($item['area'])){
			//片区
			$area_text=$code->getPidByType($item['borough']);
			$res[$key]['area_text'] = $area_text[$item['area']];
		}
		if(!is_null($item['borough']))
		$res[$key]['borough_text'] = $borough_text[$item['borough']];
		if(!is_null($item['flag']))
		$res[$key]['flag_text'] = $flag_text[$item['flag']];
	}
	// 查询到的结果
	$smarty->assign("EditOption", 'delall');
	$smarty->assign('esfdistrictList', $res);
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
	if (array_key_exists('pid',$Data) && ($Data['pid'] !== '')) { $Data['pid'] = (int)$Data['pid'];  $ValueList['pid']= "{$Data['pid']}";}
	if (array_key_exists('reside',$Data)) { $Data['reside'] = $Data['reside']; $ValueList['reside']= "{$Data['reside']}";}
	if (array_key_exists('address',$Data)) { $Data['address'] = $Data['address']; $ValueList['address']= "{$Data['address']}";}
	if (array_key_exists('property',$Data) && ($Data['property'] !== '')) { $Data['property'] = (int)$Data['property'];  $ValueList['property']= "{$Data['property']}";}
	if (array_key_exists('area',$Data) && ($Data['area'] !== '')) { $Data['area'] = (int)$Data['area'];  $ValueList['area']= "{$Data['area']}";}
	if (array_key_exists('borough',$Data) && ($Data['borough'] !== '')) { $Data['borough'] = (int)$Data['borough'];  $ValueList['borough']= "{$Data['borough']}";}
	if (array_key_exists('traffic',$Data)) { $Data['traffic'] = $Data['traffic']; $ValueList['traffic']= "{$Data['traffic']}";}
	if (array_key_exists('college',$Data)) { $Data['college'] = $Data['college']; $ValueList['college']= "{$Data['college']}";}
	if (array_key_exists('highschool',$Data)) { $Data['highschool'] = $Data['highschool']; $ValueList['highschool']= "{$Data['highschool']}";}
	if (array_key_exists('nurseryschool',$Data)) { $Data['nurseryschool'] = $Data['nurseryschool']; $ValueList['nurseryschool']= "{$Data['nurseryschool']}";}
	if (array_key_exists('market',$Data)) { $Data['market'] = $Data['market']; $ValueList['market']= "{$Data['market']}";}
	if (array_key_exists('postoffice',$Data)) { $Data['postoffice'] = $Data['postoffice']; $ValueList['postoffice']= "{$Data['postoffice']}";}
	if (array_key_exists('bank',$Data)) { $Data['bank'] = $Data['bank']; $ValueList['bank']= "{$Data['bank']}";}
    if (array_key_exists('hospital',$Data)) { $Data['hospital'] = $Data['hospital']; $ValueList['hospital']= "{$Data['hospital']}";}
    if (array_key_exists('school',$Data)) { $Data['school'] = $Data['school']; $ValueList['school']= "{$Data['school']}";}
    if (array_key_exists('hotel',$Data)) { $Data['hotel'] = $Data['hotel']; $ValueList['hotel']= "{$Data['hotel']}";}
	if (array_key_exists('attris',$Data)) { $Data['attris'] = $Data['attris']; $ValueList['attris']= "{$Data['attris']}";}
	if (array_key_exists('other',$Data)) { $Data['other'] = $Data['other']; $ValueList['other']= "{$Data['other']}";}
	//if (array_key_exists('flag',$Data) && ($Data['flag'] !== '')) { $Data['flag'] = (int)$Data['flag'];  $ValueList['flag']= "{$Data['flag']}";}
	if (array_key_exists('map_x',$Data)) { $Data['map_x'] = $Data['map_x']; $ValueList['map_x']= "{$Data['map_x']}";}
	if (array_key_exists('map_y',$Data)) { $Data['map_y'] = $Data['map_y']; $ValueList['map_y']= "{$Data['map_y']}";}
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
	if(isset($Data['pid']) && $Data['pid'] != ""){
		$where .=" and a.`pid` = '{$Data['pid']}'";
		$page_info.="pid={$Data['pid']}&";
		$smarty->assign("pid",$Data['pid']);
	}
	if(isset($Data['reside']) && $Data['reside'] != ""){
		$where .=" and a.`reside` = '{$Data['reside']}'";
		$page_info.="reside={$Data['reside']}&";
		$smarty->assign("reside",$Data['reside']);
	}
	if(isset($Data['address']) && $Data['address'] != ""){
		$where .=" and a.`address` = '{$Data['address']}'";
		$page_info.="address={$Data['address']}&";
		$smarty->assign("address",$Data['address']);
	}
	if(isset($Data['property']) && $Data['property'] != ""){
		$where .=" and a.`property` = '{$Data['property']}'";
		$page_info.="property={$Data['property']}&";
		$smarty->assign("property",$Data['property']);
	}
	if(isset($Data['area']) && $Data['area'] != ""){
		$where .=" and a.`area` = '{$Data['area']}'";
		$page_info.="area={$Data['area']}&";
		$smarty->assign("area",$Data['area']);
	}
	if(isset($Data['borough']) && $Data['borough'] != ""){
		$where .=" and a.`borough` = '{$Data['borough']}'";
		$page_info.="borough={$Data['borough']}&";
		$smarty->assign("borough",$Data['borough']);
	}
	if(isset($Data['traffic']) && $Data['traffic'] != ""){
		$where .=" and a.`traffic` = '{$Data['traffic']}'";
		$page_info.="traffic={$Data['traffic']}&";
		$smarty->assign("traffic",$Data['traffic']);
	}
	if(isset($Data['college']) && $Data['college'] != ""){
		$where .=" and a.`college` = '{$Data['college']}'";
		$page_info.="college={$Data['college']}&";
		$smarty->assign("college",$Data['college']);
	}
	if(isset($Data['highschool']) && $Data['highschool'] != ""){
		$where .=" and a.`highschool` = '{$Data['highschool']}'";
		$page_info.="highschool={$Data['highschool']}&";
		$smarty->assign("highschool",$Data['highschool']);
	}
	if(isset($Data['nurseryschool']) && $Data['nurseryschool'] != ""){
		$where .=" and a.`nurseryschool` = '{$Data['nurseryschool']}'";
		$page_info.="nurseryschool={$Data['nurseryschool']}&";
		$smarty->assign("nurseryschool",$Data['nurseryschool']);
	}
	if(isset($Data['market']) && $Data['market'] != ""){
		$where .=" and a.`market` = '{$Data['market']}'";
		$page_info.="market={$Data['market']}&";
		$smarty->assign("market",$Data['market']);
	}
	if(isset($Data['postoffice']) && $Data['postoffice'] != ""){
		$where .=" and a.`postoffice` = '{$Data['postoffice']}'";
		$page_info.="postoffice={$Data['postoffice']}&";
		$smarty->assign("postoffice",$Data['postoffice']);
	}
	if(isset($Data['bank']) && $Data['bank'] != ""){
		$where .=" and a.`bank` = '{$Data['bank']}'";
		$page_info.="bank={$Data['bank']}&";
		$smarty->assign("bank",$Data['bank']);
	}
	if(isset($Data['hospital']) && $Data['hospital'] != ""){
		$where .=" and a.`hospital` = '{$Data['hospital']}'";
		$page_info.="hospital={$Data['hospital']}&";
		$smarty->assign("hospital",$Data['hospital']);
	}
	if(isset($Data['other']) && $Data['other'] != ""){
		$where .=" and a.`other` = '{$Data['other']}'";
		$page_info.="other={$Data['other']}&";
		$smarty->assign("other",$Data['other']);
	}
	if(isset($Data['flag']) && $Data['flag'] != ""){
		$where .=" and a.`flag` = '{$Data['flag']}'";
		$page_info.="flag={$Data['flag']}&";
		$smarty->assign("flag",$Data['flag']);
	}
}
?>