<?php

	/**
	 * *(户型图)
	 * $_SESSION["upload_d_id"]

	 * *（小区图）
	 * $_SESSION["upload_f_id"]
	 * 
	 * *（上传的图片）
	 * $_SESSION['addhouse_pic']
	 */

	require_once('../../sys_load.php');
    
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	$verify = new Verify();
	//print_r($_SESSION);
	//$safe_validator->validator_4();
	//模板路径,生成后自行修改
	$template_edit = "admin/esf/addhouse.tpl";
	$template_rentedit = "admin/esf/addrenthouse.tpl";
	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'add':add(); //添加页面
			exit;
		case 'edit':edit(); //修改页面
			exit;
		case 'save':save(); //修改或添加后的保存方法
			exit;
		case 'getarea_data':getarea_data(); //ajax返回片区数组
			exit;	
		case 'selectdistrict':selectdistrict(); //选择小区输出小区列表
			exit;
		case 'selectdistrict_id':selectdistrict_id(); //根据小区id输出小区信息
			exit;
		case 'showdistrictpic':showdistrictpic(); //显示小区图片
			exit;
		case 'selectPic_2':selectPic_2(); //选择默认小区图
			exit;
		case 'selectPic_1':selectPic_1(); //选择默认户型图
			exit;
		case 'showpic':showpic(); //显示要提交数据的图片
			exit;
		case 'saveimg':saveimg(); //上传图片并保存到session
			exit;
		case 'add_pic':add_pic();//显示上传图片模板
			exit;
		case 'deldistrictpic':deldistrictpic();//删除小区系统图片
			exit;
		case 'delimg':delimg(); //删除上传的图片
			exit;
		case 'deluploadimg':deluploadimg(); //删除上传的图片
			exit;
		case 'esfcheck':esfcheck();
			exit;
		default:add();
			exit;
	}
	
	function esfcheck()
	{

		$cqr = isset($_GET["cqr"])?urldecode($_GET["cqr"]):'';
		$keepno = isset($_GET["keepno"])?urldecode($_GET["keepno"]):'';
	//	$cno = isset($_GET["cno"])?urldecode($_GET["cno"]):'';
	    $xmlstr="<?xml version='1.0' encoding='UTF-8' standalone='yes'?><root xmlns='@http://www.cdrj.net.cn/xml' self='@execquery'><query id='esfcheck'><parameter id='KEEPNO' value='".base64_encode($keepno)."'/><parameter id='CQR'  value='".base64_encode($cqr)."'/></query></root>";
		//echo htmlspecialchars($xmlstr);
		$xml = getRPC($xmlstr);
		//print_r(($xml));
		$data = xml_parser($xml);
		//print_r ($data);
		if($data){echo 1;}
		else{echo 0;}
	}
	
	/**
	 * *过滤XML数组
	 *
	 * @param unknown_type $xml
	 */
	function xml_parser($xml)
	{
		$xml_parser = &new XML();
		$data = $xml_parser->parse($xml);
		$xml_parser->destruct();
		
		$field = $data["root"]["table"]["row"]["field"];
		return $field;
	}
	
	function getRPC($xmlstr)
	{
		$wsdlURL="http://localhost:9080/DigInfo/wsdl/bizDig/DigControll.wsdl";
		//$wsdlURL="http://221.237.163.145:9080/DigInfo/wsdl/bizDig/DigControll.wsdl";
		$client = new nusoap_client($wsdlURL, true);	
		$xmlProcess= new ProcessBusinessXml();
		$client->decode_utf8 = false;
		$client->xml_encoding = 'utf-8';
		$client->soap_defencoding = 'utf-8';   
		$username = "PTPTPT";
		$password = "PTPTPT";
		$md5Key   = md5($password.date("Y-m-d"));
		$returnstr1=$client->call("userLogin",array('uName'=> $username,'uPwd'=>$password,'aKey'=>$md5Key));
		
		$client->call("setEncoding",array("arg_0_0"=>"utf-8"));
		
		$a=array('wsAddr'=>'双流','xmlStr'=>$xmlstr);
		$returnstr=$client->call("doRemoteWs",$a);	
	    //print_r (($returnstr['doRemoteWsReturn']));
		return $returnstr['doRemoteWsReturn'];
	}
	
	function deluploadimg()
	{
		global $smarty,$pdo;
		$aPara = formatParameter($_GET['sp'], "out");
		$sql = "Select * from ".DB_PREFIX_HOME."esf_pic where id = '{$aPara["pic_id"]}' ";
		$pic_info = $pdo->getRow($sql);
		if($pic_info['is_district']==1){//小区图片只删除pic表里的记录数据不删除文件
			$pdo->remove("id='{$aPara["pic_id"]}'",DB_PREFIX_HOME."esf_pic");
		}else{
			$sql="select url from ".DB_PREFIX_HOME."esf_attach where id = '{$aPara['attach_id']}'";
			$attr_info = $pdo->getRow($sql);
			$pdo->remove("id='{$aPara["pic_id"]}'",DB_PREFIX_HOME."esf_pic");
			UploadFile::DeleteFile(WEB_ROOT.$attr_info["url"]);
		}
		page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER'],0);
	}
	
	/**
	 * *删除上传的图片
	 *
	 */
	function delimg(){
		global $smarty;
		$id=isset($_GET['id'])?(int)$_GET['id']:'';
		UploadFile::DeleteFile(WEB_ROOT.$_SESSION['addhouse_pic'][$id]["url"]);
		unset($_SESSION['addhouse_pic'][$id]);
		page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER'],0);
	}
	
	/**
	 * *删除小区系统图片
	 *
	 */
	function deldistrictpic(){
		global $smarty;
		$pic_type = isset($_GET['type'])?$_GET['type']:0;
		$attach_id = isset($_GET['attach_id'])?$_GET['attach_id']:0;
		if($pic_type==1){
			unset($_SESSION["upload_f_id"][$attach_id]);
		}elseif($pic_type==2){
			unset($_SESSION["upload_d_id"][$attach_id]);
		}
		page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER'],0);
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
		global $smarty;
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
			$_SESSION['addhouse_pic'][] = $img_info;
			$msg = "图片添加成功";
		}
		else $msg = '添加失败';
		$smarty->assign("time" ,0);
		$smarty->assign("msg" ,$msg);
		$smarty->assign("url" ,$_SERVER['HTTP_REFERER']);
		$smarty ->show("upload_msg.tpl");
	}
	
	
	/**
	 * *选择一个小区的默认图片(户型图)
	 * $_SESSION["upload_d_id"]
	 */
	function selectPic_1()
	{
		$attach_id = isset($_GET["id"])?(int)$_GET["id"]:'';
		if($attach_id == '') exit;
		$check = isset($_GET["check"])?(int)$_GET["check"]:1;
		if($check == 0)
			$_SESSION["upload_f_id"][$attach_id]=$attach_id;
		else unset($_SESSION["upload_f_id"][$attach_id]);
		exit;
	}
	
	/**
	 * *选择一个小区的默认图片（小区图）
	 * $_SESSION["upload_f_id"]
	 */
	function selectPic_2()
	{
		$attach_id = isset($_GET["id"])?(int)$_GET["id"]:'';
		if($attach_id == '') exit;
		  $check = isset($_GET["check"])?(int)$_GET["check"]:1;
		if($check == 0)
			$_SESSION["upload_d_id"][$attach_id]=$attach_id;
		else unset($_SESSION["upload_d_id"][$attach_id]);
		
		exit;
	}
	/**
	 * **显示小区图片
	 *
	 */
	function showdistrictpic()
	{
		global $pdo,$smarty;
		unset($_SESSION["upload_d_id"]);
		unset($_SESSION["upload_f_id"]);
		$pid = isset($_GET['pid'])?(int)$_GET['pid']:'';
		$type = isset($_GET['type'])?(int)$_GET['type']:2;
		
		if($pid=='') exit;
		$sql = "select p.code as pic_type,p.attach_id,p.district_id,a.url from ".DB_PREFIX_HOME."esf_district_pic as p
		left join ".DB_PREFIX_HOME."esf_attach as a on p.attach_id = a.id
		where 
		p.district_id= $pid and p.flag = 1 and p.code=$type";
		$smarty->assign("picinfo",$pdo->getAll($sql));
		$smarty->assign("pic_type",$type);
		$smarty -> show("admin/esf/addhouse_showdistrictpic.tpl");
	}
	
	/**
	 * 保存修改或增加到数据库
	 */
	function save()
	{
		global $smarty, $pdo;
		//$total = new Total();
			
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new') {
			$Data = filter($_POST);
			$userInfo = array(
				'company_id'=>isset($_SESSION["companyId"])?$_SESSION["companyId"]:0,
				'name_cn'=>isset($_SESSION["companyName"])?$_SESSION["companyName"]:'',
				'user_id'=>isset($_SESSION["userId"])?$_SESSION["userId"]:0,
				'user_name'=>isset($_SESSION["userName"])?$_SESSION["userName"]:'',
				'linkman'=>isset($_SESSION["userName"])?$_SESSION["userName"]:'',
				'is_payed'=>isset($_SESSION["is_payed"])?$_SESSION["is_payed"]:0,
				"publish_ip"=> $_SERVER['REMOTE_ADDR'],
				"create_at"	=> time(),
				"edit_at"	=> time(),
				"updated_at"=> time(),
				"edit_at"=>time(),
				
				"editer"	=> isset($_SESSION["UserId"])?$_SESSION["UserId"]:0,
				"edit_ip"	=> $_SERVER['REMOTE_ADDR']
			);
			$Data=array_merge($Data, $userInfo);
	
			if (isset($Data) &&  $pdo->add($Data,DB_PREFIX_HOME."esf")) {
				 $esf_id = $pdo->getLastInsID();
	   			 $msg = '保存成功';
			} else {
				$msg = '保存失败';
			}

		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit'  and isset($_POST['id'])) {
			$Data = filter($_POST);
			$esf_id=$_POST['id'];
			$Data["updated_at"]=time();
			$Data["edit_at"]=time();
			if (isset($Data)) {
				 $pdo->update($Data , DB_PREFIX_HOME."esf", "id=".$esf_id);
				//if($Data["house_type"]==2)
				//	$total->setTotalRefresh();
				//else 
				//	$total->setTotalRentRefresh();
	   			 $msg = '修改成功';
			} else {
				$msg = '保存失败';
			}
		}
		
		/*****************提交上传的附件信息*********************/
   	    /* *(户型图)
		 * $_SESSION["upload_d_id"] type=2
		 * *（小区图）
		 * $_SESSION["upload_f_id"] type=1
		 * （上传的图片）
		 * $_SESSION['addhouse_pic']
		 */ 
		if(isset($esf_id)){
   			if(isset($Data["district_id"]) && $Data["district_id"]!=0){
   				//提交户型图
   				if (isset($_SESSION["upload_d_id"]) && sizeof($_SESSION["upload_d_id"])>0) {
	   		 		foreach($_SESSION["upload_d_id"] as $key=>$item){
	   					$data = array(
	   						"code"=>2,
	   						"attach_id"=>$item,
	   						"esf_id"=>$esf_id,
	   						"is_district"=>1, //是否属于小区图片 1属于 不能删除
	   						"is_default"=>0 //标题图片
	   					);
	   					$pdo->add($data,DB_PREFIX_HOME."esf_pic");
	   		 		}
   		 		}
   		 		//提交小区图
   		 		if (isset($_SESSION["upload_f_id"]) && sizeof($_SESSION["upload_f_id"])>0) {
	   		 		foreach($_SESSION["upload_f_id"] as $key=>$item){
	   					$data = array(
	   						"code"=>1,
	   						"attach_id"=>$item,
	   						"esf_id"=>$esf_id,
	   						"is_district"=>1, //是否属于小区图片 1属于 不能删除
	   						"is_default"=>0 //标题图片
	   					);
	   					$pdo->add($data,DB_PREFIX_HOME."esf_pic");
	   		 		}
   		 		}
   			}
   			if (isset($_SESSION["addhouse_pic"]) && sizeof($_SESSION["addhouse_pic"])>0) {
   		 		//提交上传的图片
   		 		foreach($_SESSION["addhouse_pic"] as $key=>$item){
   		 			$data = array(
	   						"name"=>$item["name"],
	   						"type"=>$item["type"],
	   						"url"=>$item["url"],
	   						"size"=>$item["size"],
	   						"update_at"=>$item["update_at"]
	   				);
	   				$pdo->add($data,DB_PREFIX_HOME."esf_attach");
	   				//print_r($_SESSION["addhouse_pic"]);
	   				//echo $pdo->getLastSql();
	   				$attr_id = $pdo->getLastInsId();
   					$data = array(
	   						"code"=>$item["pic_type"],
	   						"attach_id"=>$attr_id,
	   						"esf_id"=>$esf_id,
	   						"is_district"=>0, //是否属于小区图片 1属于 不能删除
	   						"is_default"=>0 //标题图片
	   					);
	   				$pdo->add($data,DB_PREFIX_HOME."esf_pic");
                    
	   				//echo $pdo->getLastSql();
   		 		}
   		 		unset($_SESSION["addhouse_pic"]);
   			}
   			unset($_SESSION["upload_d_id"]);
   			unset($_SESSION["upload_f_id"]);
            
            //查询一张图片设为默认图
            $esf = new SecondHouse();
            $esf->toDeImg($esf_id);
            $esf->countHouseImages((int)$esf_id);    //统计图片数量
   		 }
         

		/************************结束******************************/
		
		page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
	}

	/**
	 * 输出添加界面
	 */
	function add()
	{
		global $smarty, $pdo,$template_rentedit,$template_edit;
		$house_type = isset($_GET['house_type'])?$_GET['house_type']:2;
		// 基础代码
		$code = new BaseCode();
		// 物业类型
		$smarty->assign("property_option", $code->getPairBaseCodeByType(203));
		//产权性质
		$smarty->assign("pright_option", $code->getPairBaseCodeByType(216));
		//地区代码
		$smarty->assign("borough_option", $code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'"));
		//片区
		$smarty->assign("area_option", $code->getPidByType(DB_BOROUGH));
		//配套设施
		$smarty->assign("facilities_checkboxes", $code->getPairBaseCodeByType(217));
		//房屋朝向
		$smarty->assign("toward_option", $code->getPairBaseCodeByType(215));
		# 数字选项
		$smarty->assign("num_option", array(0,1,2,3,4,5,6,7,8,9));
		//装修情况
		$smarty->assign("fitment_option", $code->getPairBaseCodeByType(219));
		//建筑结构
		$smarty->assign("arch_option", $code->getPairBaseCodeByType(201));
		# 环线
		$circle_option = array(
			"1"=>"一环以内",
			"2"=>"一环~二环",
			"3"=>"二环~三环",
			"4"=>"三环以外"
		);
		$smarty->assign("circle_option", $circle_option);

		//租赁方式
		$rent_way_option=array(
			"0"=>"整租",
			"1"=>"合租"
		);
		$smarty->assign("rent_way_option", $rent_way_option);
		//最短租期
		$time_limit_option=array(
			"0"=>"一月",
			"1"=>"一季",
			"2"=>"一年"
		);
		$smarty->assign("time_limit_option", $time_limit_option);
		//付款方式
		$pay_way_option=array(
			0=>"月付",
			1=>"季付",
			2=>"半年付",
			3=>"年付",
			4=>"面议",
		);
		$smarty->assign("pay_way_option", $pay_way_option);
				
		if(isset($_SESSION["addhouse_pic"]) && $_SESSION["addhouse_pic"] != ''){
			foreach($_SESSION["addhouse_pic"] as $key=>$item){
				UploadFile::DeleteFile(WEB_ROOT.$item["url"]);
			}
		}
		
		$sql = "SELECT * FROM ".DB_PREFIX_HOME."user as u left join ".DB_PREFIX_HOME."member as m on m.uid=u.uid where u.uid = '{$_SESSION['userId']}'";
		$userInfo = $pdo->getRow($sql);
		$smarty->assign("userInfo",$userInfo);
		
		unset($_SESSION["addhouse_pic"]);
		unset($_SESSION['upload_d_id']);
		unset($_SESSION['upload_f_id']);
		$smarty->assign("EditOption" , 'New');
		$smarty->assign("house_type" , $house_type);
		$smarty->assign("url" , $_SERVER['HTTP_REFERER']);
		if($house_type==1 || $house_type==4){
			$smarty->assign("house_type" , $house_type);
			$smarty -> show($template_rentedit);
		}elseif($house_type==2 || $house_type==3){
			$smarty->assign("house_type" , $house_type);
			$smarty -> show($template_edit);
		}
		
	}
	/**
	 * 选择小区
	 */
	function selectdistrict()
	{
		global $pdo;
		$keyword = urldecode(isset($_POST['keyword'])?$_POST['keyword']:'');
		$sql = "select  reside,id,address  from ".DB_PREFIX_HOME."esf_district where (reside like '%$keyword%' or address like '%$keyword%')  limit 8";//2012/04/11
		$res = $pdo->getAll($sql);
		echo json_encode($res);
		exit;
	}
	

	
	//显示要提交的图片
	function showpic()
	{
		global $smarty,$pdo;
		$type = isset($_GET['type'])?(int)$_GET['type']:2;
		//$smarty->assign("picinfo",$pdo->getAll($sql));
		//修改的时候会传入二手房id
		$esf_id = isset($_GET["esf_id"])?(int)$_GET['esf_id']:0;
		$attr_info =array();
		if($esf_id != 0){
			//根据id取出添加内容时上传的图片
			$sql = "Select a.id as attach_id,a.url,b.id as pic_id,b.esf_id,b.is_district,b.code as pic_type From ".DB_PREFIX_HOME."esf_attach as a left join 
".DB_PREFIX_HOME."esf_pic as b on  a.id = b.attach_id WHERE b.esf_id = '$esf_id' and b.code = '$type'";
			$attr_info = $pdo->getAll($sql);
			$smarty->assign("attr_info",$attr_info);
		}
		$attr_id="";
		if($type==1 and (isset($_SESSION['upload_f_id']) && $_SESSION['upload_f_id']!= '')){
			foreach($_SESSION['upload_f_id'] as $key=>$item){
				foreach ($attr_info as $temp){
					//判断已经上传的图片是不是存在于小区图片中存在的话 就不需要选择
					if($temp['attach_id']==$item){
						unset($_SESSION['upload_f_id'][$key]);
						break;
					}
				}
				if(isset($_SESSION['upload_f_id'][$key])){
					$attr_id .= $item.',';
				}				
			}
		}
		if($type==2 and (isset($_SESSION['upload_d_id']) && $_SESSION['upload_d_id']!= '')){
			foreach($_SESSION['upload_d_id'] as $key=>$item){
				foreach ($attr_info as $temp){
					if($temp['attach_id']==$item){
						unset($_SESSION['upload_d_id'][$key]);
					}
				}
				if(isset($_SESSION['upload_d_id'][$key])){
					$attr_id .= $item.',';
				}				
			}
		}
		$attr_id=substr($attr_id,0,-1);
		if($attr_id != ""){
			$sql = "select a.id as attach_id,a.url,d.district_id from ".DB_PREFIX_HOME."esf_attach as a left join 
".DB_PREFIX_HOME."esf_district_pic as d on d.attach_id = a.id where a.id in($attr_id)";
			if($type==1)//户型图
				$smarty->assign("upload_f_id",$pdo->getAll($sql));
			if($type==2)//小区图
				$smarty->assign("upload_d_id",$pdo->getAll($sql));
		}
		
		if(isset($_SESSION['addhouse_pic']) && $_SESSION['addhouse_pic'] !='' && is_array($_SESSION['addhouse_pic'])){    
			$picinfo = array();
			foreach($_SESSION['addhouse_pic'] as $key=>$item){
				if($item['pic_type']==$type){
					$picinfo[] = $_SESSION['addhouse_pic'][$key];
					$picinfo[count($picinfo)-1]['id'] = $key;
				}
			}
			$smarty->assign("picinfo",$picinfo);
		}
		$smarty->assign("pic_type",$type);
		$smarty->show("admin/esf/addhouse_showpic.tpl");
	}
	
	/**
	 * 根据小区id输出小区信息
	 */
	function selectdistrict_id()
	{
		global $pdo;
		$pid = urldecode(isset($_POST['pid'])?(int)$_POST['pid']:'');
		if($pid=='') exit;
		$sql = "select * from ".DB_PREFIX_HOME."esf_district where id= $pid limit 1";//2012/04/11
		$res = $pdo->getRow($sql);
		foreach ($res as $k=>$item)
		{
				if(empty($item)||$item=='null')$res[$k] = ' ';
		}
		echo json_encode($res);
		exit;
	}

	/**
	 * 输出编辑界面
	 */
	function edit()
	{
		global $smarty, $pdo, $template_edit, $template_rentedit;
		$para = formatParameter($_GET["sp"], "out");
		// 基础代码
		$code = new BaseCode();
		$house_type=isset($para['house_type'])?$para['house_type']:2;
		$smarty->assign("house_type", $house_type);
		// 物业类型
		$smarty->assign("property_option", $code->getPairBaseCodeByType(203));
		//产权性质
		$smarty->assign("pright_option", $code->getPairBaseCodeByType(216));
		//地区代码
		$smarty->assign("borough_option", $code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'"));

		//配套设施
		$smarty->assign("facilities_checkboxes", $code->getPairBaseCodeByType(217));
		//房屋朝向
		$smarty->assign("toward_option", $code->getPairBaseCodeByType(215));
		# 数字选项
		$smarty->assign("num_option", array(0,1,2,3,4,5,6,7,8,9));
		//装修情况
		$smarty->assign("fitment_option", $code->getPairBaseCodeByType(219));
		//建筑结构
		$smarty->assign("arch_option", $code->getPairBaseCodeByType(203));
		# 环线
		$circle_option = array(
			"1"=>"一环以内",
			"2"=>"一环~二环",
			"3"=>"二环~三环",
			"4"=>"三环以外"
		);
		$smarty->assign("circle_option", $circle_option);
		#厕所
		$toilet_option=array(
			0=>0,1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9
		);
		$smarty->assign("toilet_option", $toilet_option);
		//租赁方式
		$rent_way_option=array(
			"0"=>"整租",
			"1"=>"合租"
		);
		$smarty->assign("rent_way_option", $rent_way_option);
		//最短租期
		$time_limit_option=array(
			"0"=>"一月",
			"1"=>"一季",
			"2"=>"一年"
		);
		$smarty->assign("time_limit_option", $time_limit_option);
		//付款方式
		$pay_way_option=array(
			0=>"月付",
			1=>"季付",
			2=>"半年付",
			3=>"年付",
			4=>"面议",
		);
		$smarty->assign("pay_way_option", $pay_way_option);

		$sql = "SELECT * FROM ".DB_PREFIX_HOME."user as u left join ".DB_PREFIX_HOME."member as m on m.uid=u.uid where u.uid = '{$_SESSION['userId']}'";
		$userInfo = $pdo->getRow($sql);
		$smarty->assign("userInfo",$userInfo);
		
		$Id = isset($para['id']) ? $para['id'] : 1; 
		$ValueList = $pdo->getRow("select * from ".DB_PREFIX_HOME."esf where id = '$Id'");		
		
		if($ValueList['borough']!=0){
			//片区
			$smarty->assign("area_option", $code->getPidByType($ValueList['borough']));
		}	
		$smarty->assign("facilities_item", explode(":", $ValueList['facilities']));
		
		$smarty->assign('addhouseInfo',$ValueList);
		
		$smarty->assign("EditOption" , 'Edit');
		$smarty->assign("UrlReferer" , $_SERVER['HTTP_REFERER']);
		if($house_type==1 || $house_type==4){
			$smarty->assign("house_type" , $house_type);
			$smarty -> show($template_rentedit);
		}elseif($house_type==2 || $house_type==3){
			$smarty->assign("house_type" , $house_type);
			$smarty -> show($template_edit);
		}
	}
	
	function getarea_data(){
		$code_id = isset($_GET['code'])?(int)$_GET['code']:exit;
		$code = new BaseCode();
		$Data = $code->getPidByType($code_id);
		echo json_encode($Data);
		exit;
	}

	/**
	 * 过滤数组
	 */
	function filter($Data)
	{
		$ValueList = array();
		if (array_key_exists('title',$Data)) { $Data['title'] = $Data['title']; $ValueList['title']= "{$Data['title']}";}
		if (array_key_exists('address',$Data)) { $Data['address'] = $Data['address']; $ValueList['address']= "{$Data['address']}";}
		if (array_key_exists('house_type',$Data) && ($Data['house_type'] !== '')) { $Data['house_type'] = (int)$Data['house_type'];  $ValueList['house_type']= "{$Data['house_type']}";}
		if (array_key_exists('district_id',$Data) && ($Data['district_id'] !== '')) { $Data['district_id'] = (int)$Data['district_id'];  $ValueList['district_id']= "{$Data['district_id']}";}
		if (array_key_exists('updated_at',$Data) && ($Data['updated_at'] !== '')) { $Data['updated_at'] = isset($Data["updated_at"])?strtotime($Data["updated_at"]):time();  $ValueList['updated_at']= "{$Data['updated_at']}";}
		if (array_key_exists('property',$Data)) { $Data['property'] = $Data['property']; $ValueList['property']= "{$Data['property']}";}
		if (array_key_exists('address_hide',$Data)) { $Data['address_hide'] = $Data['address_hide']; $ValueList['address_hide']= "{$Data['address_hide']}";}
		if (array_key_exists('reside',$Data)) { $Data['reside'] = $Data['reside']; $ValueList['reside']= "{$Data['reside']}";}
		if (array_key_exists('area',$Data)) { $Data['area'] = $Data['area']; $ValueList['area']= "{$Data['area']}";}
		if (array_key_exists('borough',$Data)) { $Data['borough'] = $Data['borough']; $ValueList['borough']= "{$Data['borough']}";}
		if (array_key_exists('circle',$Data)) { $Data['circle'] = $Data['circle']; $ValueList['circle']= "{$Data['circle']}";}
		if (array_key_exists('pright',$Data)) { $Data['pright'] = $Data['pright']; $ValueList['pright']= "{$Data['pright']}";}
		if (array_key_exists('porch',$Data)) { $Data['porch'] = $Data['porch']; $ValueList['porch']= "{$Data['porch']}";}
		if (array_key_exists('parlor',$Data)) { $Data['parlor'] = $Data['parlor']; $ValueList['parlor']= "{$Data['parlor']}";}
		if (array_key_exists('room',$Data)) { $Data['room'] = $Data['room']; $ValueList['room']= "{$Data['room']}";}
		if (array_key_exists('arch',$Data)) { $Data['arch'] = $Data['arch']; $ValueList['arch']= "{$Data['arch']}";}
		if (array_key_exists('toilet',$Data)) { $Data['toilet'] = $Data['toilet']; $ValueList['toilet']= "{$Data['toilet']}";}
		if (array_key_exists('total_floor',$Data) && ($Data['total_floor'] !== '')) { $Data['total_floor'] = (int)$Data['total_floor'];  $ValueList['total_floor']= "{$Data['total_floor']}";}
		if (array_key_exists('current_floor',$Data) && ($Data['current_floor'] !== '')) { $Data['current_floor'] = (int)$Data['current_floor'];  $ValueList['current_floor']= "{$Data['current_floor']}";}
		if (array_key_exists('build_year',$Data) && ($Data['build_year'] !== '')) { $Data['build_year'] = (int)$Data['build_year'];  $ValueList['build_year']= "{$Data['build_year']}";}
		if (array_key_exists('total_area',$Data) && ($Data['total_area'] !== '')) { $Data['total_area'] = (int)$Data['total_area'];  $ValueList['total_area']= "{$Data['total_area']}";}
		if (array_key_exists('toward',$Data)) { $Data['toward'] = $Data['toward']; $ValueList['toward']= "{$Data['toward']}";}
		if (array_key_exists('fitment',$Data)) { $Data['fitment'] = $Data['fitment']; $ValueList['fitment']= "{$Data['fitment']}";}
		if (array_key_exists('traffic',$Data)) { $Data['traffic'] = $Data['traffic']; $ValueList['traffic']= "{$Data['traffic']}";}
		if (array_key_exists('trade_circle',$Data) && ($Data['trade_circle'] !== '')) { $Data['trade_circle'] = $Data['trade_circle'];  $ValueList['trade_circle']= "{$Data['trade_circle']}";}
		if (array_key_exists('facilities',$Data) && ($Data['facilities'] !== '')) { $Data['facilities'] = implode(":", isset($_POST['facilities'])?$_POST['facilities']:array());  $ValueList['facilities']= "{$Data['facilities']}";}
		if (array_key_exists('selling_point',$Data) && ($Data['selling_point'] !== '')) { $Data['selling_point'] = $Data['selling_point'];  $ValueList['selling_point']= "{$Data['selling_point']}";}
		if (array_key_exists('price',$Data)) { $Data['price'] = $Data['price']; $ValueList['price']= "{$Data['price']}";}
		if (array_key_exists('map_x',$Data)) { $Data['map_x'] = $Data['map_x']; $ValueList['map_x']= "{$Data['map_x']}";}
		if (array_key_exists('map_y',$Data)) { $Data['map_y'] = $Data['map_y']; $ValueList['map_y']= "{$Data['map_y']}";}
		if (array_key_exists('limit_day',$Data)) { $Data['limit_day'] = $Data['limit_day']; $ValueList['limit_day']= "{$Data['limit_day']}";}
		if (array_key_exists('description',$Data)) { $Data['description'] = $Data['description']; $ValueList['description']= "{$Data['description']}";}
		if (array_key_exists('telphone',$Data)) { $Data['telphone'] = $Data['telphone']; $ValueList['telphone']= "{$Data['telphone']}";}
		if (array_key_exists('custom_id',$Data) && ($Data['custom_id'] !== '')) { $Data['custom_id'] = $Data['custom_id'];  $ValueList['custom_id']= "{$Data['custom_id']}";}
		if (array_key_exists('valid_owner',$Data) && ($Data['valid_owner'] !== '')) { $Data['valid_owner'] = (int)$Data['valid_owner'];  $ValueList['valid_owner']= "{$Data['valid_owner']}";}
		if (array_key_exists('valid_addr',$Data)) { $Data['valid_addr'] = $Data['valid_addr']; $ValueList['valid_addr']= "{$Data['valid_addr']}";}
		if (array_key_exists('valid_year',$Data) && ($Data['valid_year'] !== '')) { $Data['valid_year'] = (int)$Data['valid_year'];  $ValueList['valid_year']= "{$Data['valid_year']}";}
		if (array_key_exists('valid_seal',$Data) && ($Data['valid_seal'] !== '')) { $Data['valid_seal'] = (int)$Data['valid_seal'];  $ValueList['valid_seal']= "{$Data['valid_seal']}";}
		if (array_key_exists('valid_debt',$Data)) { $Data['valid_debt'] = $Data['valid_debt']; $ValueList['valid_debt']= "{$Data['valid_debt']}";}
		if (array_key_exists('flag',$Data)) { $Data['flag'] = $Data['flag']; $ValueList['flag']= "{$Data['flag']}";}
		if (array_key_exists('is_top',$Data)) { $Data['is_top'] = $Data['is_top']; $ValueList['is_top']= "{$Data['is_top']}";}
		if (array_key_exists('valid_at',$Data)) { $Data['valid_at'] = $Data['valid_at']; $ValueList['valid_at']= "{$Data['valid_at']}";}
		if (array_key_exists('valid_keepno',$Data) && ($Data['valid_keepno'] !== '')) { $Data['valid_keepno'] = (int)$Data['valid_keepno'];  $ValueList['valid_keepno']= "{$Data['valid_keepno']}";}
		if (array_key_exists('valid_area',$Data) && ($Data['valid_area'] !== '')) { $Data['valid_area'] = (int)$Data['valid_area'];  $ValueList['valid_area']= "{$Data['valid_area']}";}
		if (array_key_exists('rent_way',$Data) && ($Data['rent_way'] !== '')) { $Data['rent_way'] = (int)$Data['rent_way'];  $ValueList['rent_way']= "{$Data['rent_way']}";}
		if (array_key_exists('time_limit',$Data) && ($Data['time_limit'] !== '')) { $Data['time_limit'] = (int)$Data['time_limit'];  $ValueList['time_limit']= "{$Data['time_limit']}";}
		if (array_key_exists('pay_way',$Data) && ($Data['pay_way'] !== '')) { $Data['pay_way'] = (int)$Data['pay_way'];  $ValueList['pay_way']= "{$Data['pay_way']}";}
		if (array_key_exists('deposit',$Data) && ($Data['deposit'] !== '')) { $Data['deposit'] = (int)$Data['deposit'];  $ValueList['deposit']= "{$Data['deposit']}";}
		$ValueList['is_recommend'] = $Data['recommend'] == '1' ? 1 : 0 ;
		return $ValueList;
	}


?>