<?
	require_once('../../sys_load.php');
	$smarty = new WebSmarty;
	//$smarty->caching = FALSE;
	$pdo = new MysqlPdo();
	if ($_GET['exp']==1) 
	{
		exlord();
	}
	$room_text = array('1'=>'一居室','2'=>'二居室','3'=>'三居室','4'=>'四居室','5'=>'多居室');
	$smarty->assign("room_text",$room_text);
	$user_id = $_SESSION["userId"];
	$house_type = isset($_GET['house_type']) ? $_GET['house_type']=='9' ? "e.flag = '9'" : "e.house_type = '{$_GET['house_type']}'" : "e.house_type= '2'";
	//分页信息
	$page_size=10;								//每页显示的条数
	$sub_pages=5;								//每次显示的页数
	$star=0;										//起始数
	$pageCurrent=isset($_GET["p"])?$_GET["p"]:0;//得到当前是第几页
	if($pageCurrent>0)$star=($pageCurrent-1)*$page_size;
	if($_POST) 	filter($_POST,$page_info,$where);
	if($_GET) 	filter($_GET,$page_info,$where);
	$sql = "select e.*,u.username from ".DB_PREFIX_HOME."esf e left join ".DB_PREFIX_HOME."user as u on u.uid = e.user_id
	where 1 and $house_type $where order by e.updated_at desc 
	limit $star,$page_size";
	$source = $pdo->getAll($sql);
	$sql = "select count(e.id) as cnt from ".DB_PREFIX_HOME."esf e 
	where 1 and $house_type 
	$where";
	$nums=$pdo->getRow($sql);

	$page=new Page($page_size,$nums['cnt'],$pageCurrent,$sub_pages,$page_info,2);
	$subPages=$page->get_page_html();
	$smarty->assign('subPages',$subPages);


	$smarty->assign("source",$source);

	$smarty->show();

	function filter($Data,&$page_info,&$where)
	{
		global $smarty, $NO_ALLOW_USER;
		//print_r($Data);
		$where = " ";
		if(isset($Data['likestr']) && $Data['likestr'] != ""){
		 	$where .= " and (e.`address` like '%{$Data['likestr']}%' or e.`reside` like '%{$Data['likestr']}%' or e.telphone like '%{$Data['likestr']}%')";
		 	$page_info.="likestr={$Data['likestr']}&";
		 	$smarty->assign("likestr",$Data['likestr']);
		}
		if(isset($Data['house_type']) && $Data['house_type'] != ""){
		 	//$where .= " and e.`house_type` = '{$Data['house_type']}' ";
		 	$page_info.="house_type={$Data['house_type']}&";
			$smarty->assign("house_type",$Data['house_type']);
		}
		if(isset($Data['is_top']) && $Data['is_top'] != ""){
		 	$where .= " and e.`is_top` = '{$Data['is_top']}' ";
		 	$page_info.="is_top={$Data['is_top']}&";
			$smarty->assign("is_top",$Data['is_top']);
		}
		if(isset($Data['room']) && $Data['room'] != 0){
			if((int)$Data['room'] > 4)
				$where .=" and e.`room` > '{$Data['room']}'";
			else $where .=" and e.`room` = '{$Data['room']}'";
			$page_info.="room={$Data['room']}&";
			$smarty->assign("room",$Data['room']);
		}
		if(isset($Data['rent_way']) && $Data['rent_way'] != ""){
			$where .=" and e.`rent_way` = '{$Data['rent_way']}'";
			$page_info.="rent_way={$Data['rent_way']}&";
			$smarty->assign("rent_way",$Data['rent_way']);
		}
		if(isset($Data['current_floor']) && $Data['current_floor'] != ""){
			$where .=" and e.`current_floor` = '{$Data['current_floor']}'";
			$page_info.="current_floor={$Data['current_floor']}&";
			$smarty->assign("current_floor",$Data['current_floor']);
		}
		if(isset($Data['start_time']) && $Data['start_time'] != ""){
			$start_time = strtotime($Data['start_time']);
			$where .=" and e.`updated_at` >= '{$start_time}'";
			$page_info.="start_time={$Data['start_time']}&";
			$smarty->assign("start_time",$Data['start_time']);
		}
		if(isset($Data['end_time']) && $Data['end_time'] != ""){
			$end_time = strtotime($Data['end_time']);
			$where .=" and e.`updated_at` <= '{$end_time}'";
			$page_info.="end_time={$Data['end_time']}&";
			$smarty->assign("end_time",$Data['end_time']);
		}
		if(isset($Data['min_price']) && $Data['min_price'] != ""){
			$min_price = $Data['min_price'];
			$where .=" and e.`price` >= '{$min_price}'";
			$page_info.="min_price={$Data['min_price']}&";
			$smarty->assign("min_price",$min_price);
		}
		if(isset($Data['max_price']) && $Data['max_price'] != ""){
			$max_price = $Data['max_price'];
			$where .=" and e.`price` <= '{$max_price}'";
			$page_info.="max_price={$Data['max_price']}&";
			$smarty->assign("max_price",$max_price);
		}
		if(isset($Data['min_total_area']) && $Data['min_total_area'] != ""){
			$min_total_area = $Data['min_total_area'];
			$where .=" and e.`total_area` >= '{$min_total_area}'";
			$page_info.="min_total_area={$Data['min_total_area']}&";
			$smarty->assign("min_total_area",$min_total_area);
		}
		if(isset($Data['max_total_area']) && $Data['max_total_area'] != ""){
			$max_total_area = $Data['max_total_area'];
			$where .=" and e.`total_area` <= '{$max_total_area}'";
			$page_info.="max_total_area={$Data['max_total_area']}&";
			$smarty->assign("max_total_area",$max_total_area);
		}
		if(isset($Data['is_recommend']) && $Data['is_recommend'] != ""){
            $where .=" and e.`is_recommend` = '{$Data['is_recommend']}'";
            $page_info.="is_recommend={$Data['is_recommend']}&";
            $smarty->assign("is_recommend",$Data['is_recommend']);
        }
        if(isset($Data['showOnly']) && $Data['showOnly'] != ""){
            foreach($NO_ALLOW_USER as $user)
            {
                $where .=" and e.`user_name` != '{$user}'";
            }
			
			$page_info.="showOnly={$Data['showOnly']}&";
			$smarty->assign("showOnly",$Data['showOnly']);
		}
	}
	
	function exlord()
	{
	
		require_once('../../includes/phpexcel/PHPExcel.php');
		global $pdo,$smarty;
		$where=' where 1';
//		if (!empty($_GET['create_at'])) 
//		{
//			$start=strtotime($_GET['create_at']);
//			$where .=" and create_at= ".$start;
//		}
		$sql="select linkman,telphone from home_esf ".$where." and description!='' group by telphone";
		$res=$pdo->getAll($sql);
		if (count($res)==0) {
			page_msg("当前时间无注册人数",$isok=true,$url=$_SERVER['HTTP_REFERER'],3);
		}
//		for ($i=0;$i<count($res);$i++)
//		{
//			if ($res[$i]['telphone']!="") 
//			{
//				$sql="select title from home_esf where telphone='".$res[$i]['telphone']."'";
//				$arr=$pdo->getAll($sql);
//				$res[$i]['title']=$arr;
//			}		
//		}
			// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
								 ->setLastModifiedBy("Maarten Balliauw")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");
		
								 // Add some data, we will use printing features
		$objPHPExcel->getActiveSheet()->setCellValue('A1' , '编号');
		$objPHPExcel->getActiveSheet()->setCellValue('B1' , '联系人');
		$objPHPExcel->getActiveSheet()->setCellValue('C1' ,'联系电话');
		for ($i=2;$i<count($res)+2;$i++)
		{
//			if ($res[$i-2]['telphone']!="") 
//			{
//				$sql="select title from home_esf where telphone='".$res[$i-2]['telphone']."'";
//				$arr=$pdo->getAll($sql);
//				$res[$i-2]['title']=$arr;
//			}
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, " ".$res[$i]['linkman']." ");
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $res[$i]['telphone']);
			$title_create='';
//			foreach ($res[$i-2]['title'] as $j => $arry)
//			{
//				$title_create .=$arry['title']."/";
//			}
//			$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $title_create);
		}
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		
		
		// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
		$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
		// Set page orientation and size
		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle("link_man");
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);
		
		$fn=date('YmdHis').".xls";  
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');  
		header("Content-Disposition: attachment;filename=$fn");  
		header('Cache-Control: max-age=0');  
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
		$objWriter->save('php://output');  
		exit;
		// Save Excel 2007 file
		//	echo WEB_ROOT."data/excel/".$tm.".php";exit();
//		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//		$objWriter->save(WEB_ROOT.'/data/excel/'.date('YmdHis').'.xlsx');
			
		page_msg("导出成功",$isok=true,$url=$_SERVER['HTTP_REFERER'],3);
	}
	
?>
