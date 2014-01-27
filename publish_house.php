<?php
/**
* FILE_NAME : house_item.php   FILE_PATH : E:\home+\house_item.php
* 发布房屋
* @author younglly@163.com
* ChengDu CandorSoft Co., Ltd.
* @version 1.0 Tue Mar 13 13:31:21 CST 2012
*/  
require_once('member_config.php');
require_once('./data/cache/base_code.php');
$smarty = new WebSmarty();
$smarty->caching = false;

switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'publish':publish();
			exit;
		case 'option':option();
			exit;
		case 'save' : save();break;
		case 'selectdistrict' : selectdistrict();break;
		case 'selectdistrict_id' : selectdistrict_id();break;
		case 'saveimg':saveimg();break; //上传图片并保存到session
		case 'add_pic':add_pic();break;//显示上传图片模板
		case 'preview':preview();break; //预览本地图片
		case 'getarea_data':getarea_data();break; //ajax返回片区数组
		default:index();
			exit;
	}


function index()
{
	global $smarty,$hb;
	global $pdo,$borough_option,$property_option,$pright_option,$borough_option,$circle_option,$rent_way_option,$time_limit_option,$pay_way_option,$resold,$lesse_text;
    $house_type = isset($_GET['house_type'])?$_GET['house_type']:2;
	// 基础代码
	$code = new BaseCode();
	// 物业类型
	$smarty->assign("property_option", $property_option);
	//产权性质
	$smarty->assign("pright_option", $pright_option);
	//地区代码
	$smarty->assign("borough_option", $borough_option);
	//片区
	$smarty->assign("area_option", $code->getPidByType(DB_BOROUGH));
	//配套设施
	$smarty->assign("facilities_checkboxes", $code->getPairBaseCodeByType(217));
	//房屋朝向
	$smarty->assign("toward_option", $code->getPairBaseCodeByType(215));
	//数字选项
	$smarty->assign("num_option", array(0,1,2,3,4,5,6,7,8,9));
	//装修情况
	$smarty->assign("fitment_option", $code->getPairBaseCodeByType(219));
	//建筑结构
	$smarty->assign("arch_option", $code->getPairBaseCodeByType(201));
	//环线
	$smarty->assign("circle_option", $circle_option);
	//地铁
	$smarty->assign("tube_option", $tube_option);
	//租赁方式
	$smarty->assign("rent_way_option", $rent_way_option);
	//最短租期
	$smarty->assign("time_limit_option", $time_limit_option);
	//付款方式
	$smarty->assign("pay_way_option", $pay_way_option);
			
	if(isset($_SESSION["addhouse_pic"]) && $_SESSION["addhouse_pic"] != ''){
		foreach($_SESSION["addhouse_pic"] as $key=>$item){
			UploadFile::DeleteFile(WEB_ROOT.$item["url"]);
		}
	}

	if(isset($_POST))
	{
		$smarty->assign('posts',$_POST);
	}

	$seoTitle =  '房源发布-成都二手房-成都租房-二手房交易-二手房代办过户-二手房买卖-和睦家';
	$smarty->assign('description',$hb['metadescrip']);
	$smarty->assign('seoTitle',$seoTitle);

	$smarty->show('publish_house.tpl');


}

function option(){
	global $smarty,$member,$hb;
	//统计用户数
	$user_num = getPdo()->getRow("select count(*) as cnt from home_user");
	$smarty->assign('user_num',$user_num['cnt']+BASE_NUMBER);
	require_once('./member_config.php');
	$smarty->assign('isLogin',0);
	if ($member->IsLogin())
	{
		$smarty->assign('isLogin',1);
	}
	$seoTitle =  '房源发布-成都二手房-成都租房-二手房交易-二手房代办过户-二手房买卖-和睦家';
	$smarty->assign('description',$hb['metadescrip']);
	$smarty->assign('seoTitle',$seoTitle);
	$smarty->show('publish_option.tpl');
}

function publish()
{
	
}

function save()
{
	
	if(!isset($_POST['house_type'])||intval($_POST['house_type'])>2||intval($_POST['house_type'])<=0){
		$_POST['house_type'] = $_POST['house_type'] == 1 ? 1 : 2 ;
		ShowMsg("提交信息有误，请重新提交!",'publish_house.php?action=esf_add&house_type='.$_POST['house_type'],0,3000);exit;	
	}
	extract($_POST); 
	
    $username = $_POST['username'] = $_SESSION['home_username'] != '' ? $_SESSION['home_username'] : 0;
    $userid = $_POST['userid'] = $_SESSION['home_userid'] >0 ? $_SESSION['home_userid'] : 0;
    $user_type = utype;
    $type = $house_type;
    // 生成SecondHouse对象
	$esf = new SecondHouse();
    //匿名提交 必填信息必须检查
    InfoCheck($_POST);
    $esfid = $esf->addEsf($type, $_POST);    //调用addEsf()函数添加数据

	//pics1户型  pisc2室内
	$pics1 = resetFileArray($_FILES['pics1']);
	$pics2 = resetFileArray($_FILES['pics2']);
	//开始上传
	$img_pic1=saveUploadImg($pics1,1,$esfid);
	$img_pic2=saveUploadImg($pics2,0,$esfid);
	
	
	//$esf->addEsfRent($esfid, $rent_way, $time_limit, $pay_way, $deposit, $fees);	//增加新添加记录到home_esf_rent
	//查询一张图片设为默认图
	$esf->toDeImg($esfid);
	$esf->countHouseImages((int)$esfid);	//统计图片数量
	
	  //增加积分 匿名提交 不需要添加积分等
if($userid>0)
{	  
	if ($result['url'])
	{
			update_s('pub_esftp1_pic',0,pub_esftp1_pic);  //更新发布房源积分
			update_s('pub_esfp1_scores',0,pub_esfp2_scores);  //更新发布房源积分
	}
	else 
	{
			update_s('pub_esfp1_scores',0,pub_esfp2_scores);  //更新发布房源积分
	}

	//2010/07/09 增加Session记录写入数据库 小区数据库自动完成
	if (!empty($_SESSION['do']))
	{
		 $pic = $_SESSION['do'];
		 getPdo()->execute("UPDATE `home_esf` SET `attach_id`='$pic' WHERE (`id`='$esfid')");	//更新小区数据库图片
	}
	//2010/07/27 增加房源数量限制
	$m_info = getPdo()->getRow("select allow_publish from home_member where uid='$userid'");
	if ($user_type=='个人')
	$num = personal_num;
	else 
	$num = agent_num;
	
	if (intval($m_info['allow_publish'])<$num)
	{
	getPdo()->execute("UPDATE home_member SET allow_publish=allow_publish+1 WHERE uid='$userid'");	
	}
}
	ShowMsg("发布成功,3秒钟后将转向房源信息页面!",'house_item.php?sp='.formatParameter(array('id'=>$esfid,'house_type'=>$type),'in'),0,3000);
	
}

/**
 * 选择小区
 */
function selectdistrict()
{

	$keyword = urldecode(isset($_GET['query'])?$_GET['query']:'');
	$sql = "select pid,reside from ".DB_PREFIX_HOME."esf_district where ( `reside` like '%$keyword%'  ) and flag = 1  limit 8";
	$info = getPdo()->getAll($sql); 
	if(count($info)>0){
		foreach ($info as $val)
		{
			$arr[] = $val['reside']	;
			$data[] = $val['pid'];
			
			
		}
		$msg['query'] = $keyword;
		$msg['suggestions'] = $arr;
		$msg['data'] = $data;
		echo json_encode($msg);
	}
	
	exit;
}
/**
 * 根据小区id输出小区信息
 */
function selectdistrict_id()
{
	$pid = urldecode(isset($_POST['pid'])?(int)$_POST['pid']:'');
	if($pid=='') exit;
	$sql = "select * from ".DB_PREFIX_HOME."esf_district where pid= '$pid' and flag = 1 limit 1";
	echo json_encode(getPdo()->getRow($sql));
	exit;
}
function getarea_data(){
		$code_id = isset($_GET['code'])?(int)$_GET['code']:exit;
		if($code_id>0){
			$code = new BaseCode();
			$Data = $code->getPidByType($code_id);
			echo json_encode($Data);
		}else{
			echo json_encode(array());
		}
		exit;
	}
/**
+----------------------------------------------------------
* 提交信息Check
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function  InfoCheck($post)
{
	@extract($post);
	$url = 'publish_house.php?action=esf_add&house_type='.$house_type ;
	//标题不能为空 且25字
	if(empty($title)||utf8_strlen($title)>25)page_prompt('标题不能为空，且长度小于25位',false,$url,3,$post);
	//小区不能为空 且要大于2位 小于20位
	if(utf8_strlen($reside)<2||utf8_strlen($reside)>20)page_prompt('小区不能为空，且长度大于2位',false,$url,3,$post);
	//房源地址不能为空 
	if(utf8_strlen($address)<3)page_prompt('房源地址不能为空且大于3位',false,$url,3,$post);
	//总价不能为空 且只能为整数
	if(strlen($price)<1||!is_numeric($price)||$price<1)page_prompt('价格不能为空且不能小于1',false,$url,3,$post);
	//总价格式
	if(!preg_match("/^[1-9]\d{1,10}(\.\d{1,2})?$/",$price))page_prompt('价格格式不正确，只能为整数或2位小数',false,$url,3,$post);
	//区县不能为0
	if(empty($borough))page_prompt('区县必须选择',false,$url,3,$post);
	//建筑面积不能为空
	if($total_area<=1||!is_numeric($total_area))page_prompt('建筑面积必填且为数字',false,$url,3,$post);
	//联系人不能为空
	if(utf8_strlen($linkman)<2)page_prompt('联系人不能为空且大于1位',false,$url,3,$post);
	//联系电话不能为空
	if(!preg_match("/^1\d{10}$/",$telphone))page_prompt('联系电话不正确',false,$url,3,$post);
	
}

/**
	 * 调用上传页面模板
	 *
	 */
	function add_pic(){
		global $smarty, $pdo;
		$pic_type = isset($_GET['type'])?(int)$_GET['type']:1;
		$smarty->assign("pic_type" ,$pic_type);
		$smarty->show("admin/esf/upload_pic.tpl");
	}
	/**
	 * *上传图片
	 *
	 */
	function saveimg()
	{	
		
		
		return $img_info;
		
		
		
	}
/**
+----------------------------------------------------------
* file文件多上传重新组成数组
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function resetFileArray($file)
{
	$arr = array();
	if(count($file['name'])>0)
	{
		foreach ($file['name'] as $key=>$val)
		{
			$arr[$key]['name']  = $val;
			$arr[$key]['type'] = $file['type'][$key];
			$arr[$key]['tmp_name'] = $file['tmp_name'][$key];
			$arr[$key]['error'] = $file['error'][$key];
			$arr[$key]['size'] = $file['size'][$key];
		}
	}
	return $arr;
}
/**
+----------------------------------------------------------
* 上传图片
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param $file 上传文件
* @param $pic_type 图片所属类 （0室内图，1户型图，2小区图）
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function saveUploadImg($file,$pic_type,$esfid)
{
	if(count($file)>0)
	{
		$esf = new SecondHouse();
		for($i=0;$i<count($file);$i++)
		{
			$uploadFile = new UploadFile($file[$i]);//图片放在upload/../公司名/
			$uploadFile->setHeight(300);
			$uploadFile->setWidth(400);
			//$uploadFile->DelOriginalImage(true); //删除原始图片
			$uploadFile -> upload();
			$img_info = $uploadFile -> getSaveInfo();//得到上传文件信息
			$img_info = $img_info[0];
			//上传成功插入数据库
			//保存图片信息
			if(!empty($img_info)&&is_array($img_info)){
				//插入数据库
				$pdo = new MysqlPdo();
				$pdo->add(array(
	                    "name"=>$img_info['name'], 
	                    "url"=>$img_info['url'], 
	                    "type"=>$img_info['type'], 
	                    "size"=>$img_info['size'], 
	                    "checksum"=>$img_info['checksum'],
	                    "update_at"=>time()
	                    ), DB_PREFIX_HOME."esf_attach");
				$aid = $pdo->getLastInsID();
	            // 加附件与文件关联
	            $pdo->add(array("esf_id"=>$esfid, 
            					"code"=>$pic_type, 
            					"title"=>'', 
            					"description"=>0, 
            					"is_default"=>0, 
            					"attach_id"=>$aid
            					), DB_PREFIX_HOME."esf_pic");
			}
		}
	}
	return $img_info;
}
function preview()
{
	
}
?>
