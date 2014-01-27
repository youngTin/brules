<?php
	require_once('../../sys_load.php');
	$verify = new Verify();
	$verify->validate_category();
	$smarty = new WebSmarty();
	$smarty->caching = false;
	switch(isset($_REQUEST['action'])?$_REQUEST['action']:'index')
	{
		case 'index':index(); 
			exit;
		case 'update':update_();
			break;
		case 'print_out':print_out();
			break;
		default:index();
			break;
	}
    //关联小区的id的房源
	function index(){
		$pdo=getPdo();
		$sql="select  b.traffic,b.circle,b.map_x,b.map_y ,a.id ,b.market,b.hospital,b.postoffice,b.bank,b.school,b.other,b.hotel,b.reside,b.address from home_esf as a left join home_esf_district as b on a.district_id=b.id where a.district_id >0 and a.description !='' group by a.id" ;		
		$res=$pdo->getAll($sql); 
	 	$mes="修改房源的id：";
		for ($i=0;$i<count($res);$i++){	
			$trade =$trafic='';
			if ($res[$i]['traffic']!="") 
			{
				$trafic = $res[$i]['traffic'];
			}
			if ($res[$i]['school']!="") 
			{
				$trade .="学校：".$res[$i]['school']."|";
			}	
			if ($res[$i]['market']!="") 
			{
				$trade .="商场：".$res[$i]['market']."|";
			}
			if ($res[$i]['hospital']!="") 
			{
				$trade .="医院：".$res[$i]['hospital']."|";
			}
			if ($res[$i]['postoffice']!="") 
			{
				$trade .="邮局：".$res[$i]['postoffice']."|";
			}
			if ($res[$i]['bank']!="") 
			{
				$trade .="银行：".$res[$i]['bank']."|";
			}
			if (!empty($trafic)&&$res[$i]['other']!="")
			{
				$trade .="其他：".$res[$i]['other'];
			}
							
			$sql="update  home_esf set 	traffic = '$trafic', 
										address = '".$res[$i]['address']."',
										reside = '".$res[$i]['reside']."',
										circle = '".$res[$i]['circle']."', 
										map_x = '".$res[$i]['map_x']."', 
										map_y = '".$res[$i]['map_y']."', 
										trade_circle = '$trade' 
										where id = ".$res[$i]['id'];
			
			if($pdo->execute($sql)){
				echo $res[$i]['id']."成功<br>";
			}else {
				echo $i."没有成功<br>";
			}
		}
	}
	
	//更改没有小区ID关联的发布人
	function update_(){
		$pdo=getPdo();
		$sql="update home_esf set user_id=27, user_name='lee' where district_id=0";
		$i=0;
		if($pdo->execute($sql)){
				echo "i=".($i+1)."修改成功"."<br>";
			}
	}
	
	//导出二手房联系人的电话号码
	function print_out()
	{
		$pdo=getPdo();
		$sql="select linkman,telphone ,id from home_esf ";
		$res=$pdo->getAll($sql);
		
		require_once('../../includes/phpexcel/PHPExcel.php');
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
//		$objPHPExcel->getActiveSheet()->setCellValue('A2' , 2);
//		$objPHPExcel->getActiveSheet()->setCellValue('B2' , "张三");
//		$objPHPExcel->getActiveSheet()->setCellValue('C2' , "133454637");
//		echo $res[260]['linkman'];exit();
		for ($i=2;$i<count($res)+2;$i++)
		{
			$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1);
			$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, "'".$res[$i-2]['linkman']."'");
			$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $res[$i-2]['telphone']);
		}
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		
		
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