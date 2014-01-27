<?php
	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	$verify = new Verify();
	//模板路径,生成后自行修改
	$template_add= $template_edit= "admin/esf/rent_edit.tpl";

	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'edit':edit(); //修改页面
			exit;
		case 'save':save(); //修改或添加后的保存方法
			exit;
		default:add();break;
	}
	
	function save(){
		global $smarty, $pdo;
		$esf = new SecondHouse;
        $_POST = dhtmlspecialchars($_POST);
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new') {
			$esf_id = $esf->addEsf(1, $_POST);    //调用addEsf()函数添加数据
		    //新添加的ID号
		    $rent_way = isset($_POST['rent_way'])?$_POST['rent_way']:'';
		    $time_limit = isset($_POST['time_limit'])?$_POST['time_limit']:'';
		    $pay_way = isset($_POST['pay_way'])?$_POST['pay_way']:'';
		    $deposit =  isset($_POST['deposit'])?$_POST['deposit']:'';
		    $fees = isset($_POST['fees'])?$_POST['fees']:'';
		    $esf->addEsfRent($esf_id, $rent_way, $time_limit, $pay_way, $deposit, $fees);
		    //保存图片信息
			if(!empty($_SESSION['addhouse_pic'])&&$esf->addEsfAttach2($esf_id,'',$_SESSION['addhouse_pic']))
			{
				unset($_SESSION['addhouse_pic']);
			}
            $msg = "房源提交成功!";
		}
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit') {
			$esf_id = $_POST['hidEsfId'] = $_POST['id'];
		    $isOkesf = $esf->UpdateEsf($_POST);
		    $isOkrent = $esf->UpdateEsfRent($_POST);
            //保存图片信息
            if(!empty($_SESSION['addhouse_pic'])&&$esf->addEsfAttach2($esf_id,'',$_SESSION['addhouse_pic']))
            {
                unset($_SESSION['addhouse_pic']);
            }
		    $msg="房源修改成功!";
		}
        if($esf_id){
            //查询一张图片设为默认图
            $esf->toDeImg($esf_id);
            $esf->countHouseImages((int)$esf_id);    //统计图片数量
        }
        page_msg($msg,$isok=true,$url=$_SERVER['HTTP_REFERER']);
	}
	
		/**
	 * 输出添加界面
	 */
	function add()
	{
		global $smarty, $pdo, $template_add;
		// 生成SecondHouse对象
		$esf = new SecondHouse;
		// 基础代码
		$code = new BaseCode();
		// 物业类型
		$smarty->assign("property_option", $code->getPairBaseCodeByType(203));
		//产经性质
		$smarty->assign("pright_option", $code->getPairBaseCodeByType(216));
		//楼盘方位(新加)
		$direction_option = Array ( '226' => '东部片区', '228' => '南部片区', '227' => '西部片区', '229' => '北部片区', '230' => '中部片区' ) ;
		$smarty->assign("direction_option", $direction_option);
		//片区
		//$smarty->assign("area_option", $code->getPairBaseCodeByType(226));
		//地区代码
		$smarty->assign("borough_option", $code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'"));
		//装修程度
		$smarty->assign("facilities_checkboxes", $code->getPairBaseCodeByType(217));
		//建筑结构
		$smarty->assign("arch_option", $code->getPairBaseCodeByType(201));
		//房屋朝向
		$smarty->assign("toward_option", $code->getPairBaseCodeByType(215));
		//装修情况
		$smarty->assign("fitment_option", $code->getPairBaseCodeByType(219));
		//获取联系人信息
		$aUser = $esf->getUserById($_SESSION['userId']);
		$smarty->assign($aUser);
		$smarty->assign("EditOption" , 'new');

		$esf->pdo = null;
		// 指定模板
		$smarty->show($template_add);
	}

	/**
	 * 输出编辑界面
	 */
	function edit()
	{
		global $smarty, $pdo, $template_edit;

		$esf = new SecondHouse;
		// 基础代码
		$code = new BaseCode();
		$sPara = isset($_GET['sp'])?$_GET['sp']:'';   //获取参数
		$aPara = formatParameter($sPara, "out");
		$smarty->assign('id',$aPara['id']);
		if(!empty($aPara['id'])) {
		    //$aEsf = $esf->getEsfById($aPara['esfId']);
		    $aEsfRent = $esf->getEsfRentById($aPara['id']);
		    //$smarty->assign($aEsf);
		    $smarty->assign('addhouseInfo',$aEsfRent);
		}
		
		// 物业类型
		$smarty->assign("property_option", $code->getPairBaseCodeByType(203));
		//产经性质
		$smarty->assign("pright_option", $code->getPairBaseCodeByType(216));
		//方位
		$smarty->assign("direction_option", $code->getPairBaseCodeByType(205));
		//地区代码
		$smarty->assign("borough_option", $code->getPairBaseCodeByType(107, " AND SUBSTRING(code, 1, 4)='5101'  AND code != '510100'"));
		
		//配套设施
		$smarty->assign("facilities_checkboxes", $code->getPairBaseCodeByType(217));
		
		//装修情况
		$smarty->assign("fitment_option", $code->getPairBaseCodeByType(219));
		//建筑结构
		$smarty->assign("arch_option", $code->getPairBaseCodeByType(201));
		//房屋朝向
		$smarty->assign("toward_option", $code->getPairBaseCodeByType(215));
		//楼盘方位(新加)
		$direction_option = Array ( '226' => '东部片区', '228' => '南部片区', '227' => '西部片区', '229' => '北部片区', '230' => '中部片区' ) ;
		$smarty->assign("direction_option", $direction_option);
		//片区
		if($aEsfRent['borough']!=0){
			$smarty->assign("area_option", $code->getPidByType($aEsfRent['borough']));
		}
		
		$smarty->assign("direction_value", explode(":", $aEsfRent['direction']));
		$smarty->assign("area_value", explode(":", $aEsfRent['area']));
		
		$smarty->assign("facilities_value", explode(":", $aEsfRent['facilities'])); //修改数据时，读取相应数据
		$smarty->assign("borough_value", explode(":", $aEsfRent['borough']));
		$smarty->assign("fitment_value", explode(":", $aEsfRent['fitment']));
		$smarty->assign("property_value", explode(":", $aEsfRent['property']));
		$smarty->assign("EditOption" , 'Edit');

		 $smarty->show($template_edit);
	}
    
    function dhtmlspecialchars($str)
    {
        if(is_array($str))
        {
            foreach($str as $key=>$val)
            {
                if(is_array($val))
                {
                    return dhtmlspecialchars($val);
                }
                else
                {
                    $str[$key] = htmlspecialchars($val);
                }
            }
        }
        else
        {
            $str = htmlspecialchars($str);
        }
        return $str;
    }
?>