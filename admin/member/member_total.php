<?php
	set_time_limit(0);
	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty();
	$verify = new Verify();
	
//	error_reporting(E_ALL);
//	date_default_timezone_set('Europe/London');
	
	//文件路径
	$total_list="admin/member/member_total_list.tpl";
	
	switch (isset($_GET['action'])?$_GET['action']:'index')
	{
			case 'index':index();
				break;
			case 'print':print_();
				break;
			case 'print_1':print_1();
				break;
			case 'print_2':print_2();
				break;
			default:index();
				break;
	}
		
	//查询
	function index()
	{
		global $smarty, $pdo, $total_list;	
		$where=$where1=" 1 ";
		$tim="时间:";
		if (!empty($_GET['create_at'])) {
			$start=strtotime($_GET['create_at']);
			$where .=" and create_at >= ".$start;
			$where1 .=" and b.addtime >= ".$start;					
		}
		if (!empty($_GET['create_at01'])){
			$end=strtotime($_GET['create_at01']);
			$where .=" and create_at <= ".$end;
			$where1 .=" and b.addtime <= ".$end;
		}
		if(empty($_GET['create_at'])&&empty($_GET['create_at01'])){
			$where .=" and DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(`create_at`,'%Y%m%d') =0";
			$where1 .=" and DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(b.addtime,'%Y%m%d') =0";
		}
		if (!empty($_GET['create_at'])&&empty($_GET['create_at01'])) {
			$tim .=$_GET['create_at']."--今日|";			
		}elseif (empty($_GET['create_at'])&&!empty($_GET['create_at01'])){
			$tim .=$_GET['create_at01']."--之前日期|";		
		}elseif (!empty($_GET['create_at'])&&!empty($_GET['create_at01'])) {
			$tim .=$_GET['create_at']."--".$_GET['create_at01']."|";
		}else $tim="当前日期:".date("Y-m-d")."|";
		//本周统计
		$sq="select * from home_user where DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(`create_at`,'%Y%m%d') <=".date("w");
		$arr0= $pdo->getAll($sq);
		$week_count=count($arr0);
		//查询注册会员
		$sql="select username ,uid,telephone from home_user where $where";
		$arr= $pdo->getAll($sql);
		$act_count=count($arr);
        /*
		//foreach ($arr as $key => $user){
//			$sql="select title ,district_id  from home_esf where user_id=".$user['uid'];
//			$house=$pdo->getAll($sql);
//			$arr[$key]['act_count']=count($house);
//			$sql="select title,district_id,home_esf.id,home_esf.house_type from home_esf,home_user_cons where home_esf.id =home_user_cons.esf_id and home_user_cons.uid= ".$user['uid'];
//			$watch=$pdo->getAll($sql);
//			$arr[$key]['watch_count']=count($watch);
//			$arr[$key]['house_info']=$watch;
//		}
		//查询今日发布房源
		$sql="select id,title,district_id,user_id,create_at,user_name,telphone from home_esf where $where";
//		$sql="select id,title,district_id,user_id,create_at,user_name from home_esf where DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(`create_at`,'%Y%m%d') =0";
		$arry= $pdo->getAll($sql);
		$report=count($arry);
		foreach ($arry as $key1 => $house1){
			$sql="select * from home_user as a left join home_user_cons as b  on a.uid=b.uid  where b.esf_id=".$house1['id'];
			$report_user=$pdo->getAll($sql);
			if (count($report_user)!=0) {
				$res=$report_user;
				$arry[$key1]['customer_info']=$res;	
				$arry[$key1]['watched']=count($report_user);
			}				
		}
        
		//查询今日查看房东信息记录
		$sql="select a.id,a.title,a.user_name,a.create_at,b.uid from  home_user_cons as b left join home_esf as a on a.id=b.esf_id where $where1 GROUP BY b.esf_id";		
//		$sql="select a.id,a.title,a.user_name,a.create_at,b.uid from  home_user_cons as b left join home_esf as a on a.id=b.esf_id where DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(b.addtime,'%Y%m%d') =0 GROUP BY b.esf_id";		
		$res=$pdo->getAll($sql);
		$watched=count($res);
		foreach ($res as $key2 =>$house2){ 
			if($house2['id']>0)
			{
				$sql="select a.username,a.telephone,a.uid from home_user as a left join home_user_cons as b on a.uid=b.uid where b.esf_id=".$house2['id'];			
				$wat_count=$pdo->getAll($sql);
			}
			
			$res[$key2]['watch_count']=count($wat_count);
			$res[$key2]['customer']=$wat_count;
		}
//		echo date("Y-m-d H:i:s",1341384997);
		$flag_text=array(
		'1'=>'已审核',
		'9'=>'待审');
		*/
		$smarty->assign('act_count',	$act_count);
		$smarty->assign('report',		$report);
		$smarty->assign('watched',		$watched);
		$smarty->assign('flag_text',	$flag_text);
		$smarty->assign('list',  		$arr);
		$smarty->assign('house_list',  	$arry);
		$smarty->assign('house',  	    $res);
		$smarty->assign('tim',  	    $tim);
		$smarty->assign('week_count',  	    $week_count);
		$smarty->assign('create_at',  	 $_GET['create_at']);
		$smarty->assign('create_at01',   $_GET['create_at01']);
		
		$smarty->show($total_list);
	}
	
	function print_()
	{
		require_once('../../includes/phpexcel/PHPExcel.php');
		global $pdo;
		$where=$where1=" 1 ";
		$tim="时间:";
		if (!empty($_GET['create_at'])) {
			$start=strtotime($_GET['create_at']);
			$where .=" and create_at >= ".$start;
			$where1 .=" and b.addtime >= ".$start;					
		}
		if (!empty($_GET['create_at01'])){
			$end=strtotime($_GET['create_at01']);
			$where .=" and create_at <= ".$end;
			$where1 .=" and b.addtime <= ".$end;
		}
		if(empty($_GET['create_at'])&&empty($_GET['create_at01'])){
			$where .=" and DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(`create_at`,'%Y%m%d') =0";
			$where1 .=" and DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(b.addtime,'%Y%m%d')=0";
		}	
		if (!empty($_GET['create_at'])&&empty($_GET['create_at01'])) {
			$tim .=$_GET['create_at']."--今日|";
			$tm=$_GET['create_at'];
		}elseif (empty($_GET['create_at'])&&!empty($_GET['create_at01'])){
			$tim .=$_GET['create_at01']."--之前日期|";		
			$tm=$_GET['create_at01'];
		}elseif (!empty($_GET['create_at'])&&!empty($_GET['create_at01'])) {
			$tim .=$_GET['create_at']."--".$_GET['create_at01']."|";
			$tm=$_GET['create_at']."--".$_GET['create_at01'];
		}else {
			$tim="当前日期:".date("Y-m-d")."|";
			$tm=date("Y-m-d");
		}
		
		//查询注册会员
		$sql="select username ,uid,telephone from home_user where $where";
		$arr= $pdo->getAll($sql);
		$act_count=count($arr);
		foreach ($arr as $key => $user){
			$sql="select title ,district_id from home_esf where user_id=".$user['uid'];
			$house=$pdo->getAll($sql);
			$arr[$key]['act_count']=count($house);
			$sql="select title,district_id,home_esf.id from home_esf,home_user_cons where home_esf.id =home_user_cons.esf_id and home_user_cons.uid= ".$user['uid'];
			$watch=$pdo->getAll($sql);
			$arr[$key]['watch_count']=count($watch);
			$arr[$key]['house_info']=$watch;
		}
		
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
	$objPHPExcel->getActiveSheet()->setCellValue('B1' , '注册会员');
	$objPHPExcel->getActiveSheet()->setCellValue('C1' ,'发布房源');
	$objPHPExcel->getActiveSheet()->setCellValue('D1' ,'查看房源');
    $objPHPExcel->getActiveSheet()->setCellValue('E1' ,'查看房源的详细');
	$objPHPExcel->getActiveSheet()->setCellValue('F1' ,'联系电话');
	for ($i=2;$i<=count($arr)+1;$i++) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $arr[$i-2]['username']);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $arr[$i-2]['act_count']);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $arr[$i-2]['watch_count']);
		
		$title="";
		foreach ($arr[$i-2]['house_info'] as $j => $value){
			$title .=$value['title']."/";
		}
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $i,$title);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, empty($arr[$i-2]['telephone'])?'暂无':$arr[$i-2]['telephone']);
	}
	$objPHPExcel->getActiveSheet()->setCellValue('D' . (count($arr)+2),"查询时间:".$tim);

	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	
	// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

	
	// Set page orientation and size
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	
	// Rename sheet
	//$objPHPExcel->getActiveSheet()->setTitle("regisiter_".$tm);
	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	//$objPHPExcel->setActiveSheetIndex(0);
	
	$fn=date('YmdHis').".xls";  
	header('Content-Type: application/vnd.ms-excel; charset=utf-8');  
	header("Content-Disposition: attachment;filename=$fn");  
	header('Cache-Control: max-age=0');  
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
	$objWriter->save('php://output');  
	exit;
	// Save Excel 2007 file
	//	echo WEB_ROOT."data/excel/".$tm.".php";exit();
//	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//	$objWriter->save(str_replace('.php', '.xlsx', WEB_ROOT."data/excel/regisiter_".$tm.".php"));
//	
	//page_msg("导出成功",$isok=true,$url=$_SERVER['HTTP_REFERER'],0);
	}
	
	function print_1()
	{
		require_once('../../includes/phpexcel/PHPExcel.php');
		global $pdo;
		$where=$where1=" 1 ";
		$tim="时间:";
		if (!empty($_GET['create_at'])) {
			$start=strtotime($_GET['create_at']);
			$where .=" and create_at >= ".$start;
			$where1 .=" and b.addtime >= ".$start;					
		}
		if (!empty($_GET['create_at01'])){
			$end=strtotime($_GET['create_at01']);
			$where .=" and create_at <= ".$end;
			$where1 .=" and b.addtime <= ".$end;
		}
		if(empty($_GET['create_at'])&&empty($_GET['create_at01'])){
			$where .=" and DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(`create_at`,'%Y%m%d') =0";
			$where1 .=" and DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(b.addtime,'%Y%m%d')=0";
		}	
		if (!empty($_GET['create_at'])&&empty($_GET['create_at01'])) {
			$tim .=$_GET['create_at']."--今日|";
			$tm=$_GET['create_at'];
		}elseif (empty($_GET['create_at'])&&!empty($_GET['create_at01'])){
			$tim .=$_GET['create_at01']."--之前日期|";		
			$tm=$_GET['create_at01'];
		}elseif (!empty($_GET['create_at'])&&!empty($_GET['create_at01'])) {
			$tim .=$_GET['create_at']."--".$_GET['create_at01']."|";
			$tm=$_GET['create_at']."--".$_GET['create_at01'];
		}else {
			$tim="当前日期:".date("Y-m-d")."|";
			$tm=date("Y-m-d");
		}
	    //查询今日发布房源
		$sql="select id,title,district_id,user_id,create_at,user_name,telphone from home_esf where $where";
//		$sql="select id,title,district_id,user_id,create_at,user_name from home_esf where FROM_UNIXTIME(1336358798,'%Y%m%d')-FROM_UNIXTIME(`create_at`,'%Y%m%d') =0";
		$arry= $pdo->getAll($sql);
		$report=count($arry);
		foreach ($arry as $key1 => $house1){
			$sql="select * from home_user as a left join home_user_cons as b  on a.uid=b.uid  where b.esf_id=".$house1['id'];
			$report_user=$pdo->getAll($sql);
			if (count($report_user)!=0) {
				$res=$report_user;
				$arry[$key1]['customer_info']=$res;	
				$arry[$key1]['watched']=count($report_user);
			}				
		}
		
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
								 ->setLastModifiedBy("Maarten Balliauw")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");
	
	
	// Add some data, we will use printing features
	$objPHPExcel->getActiveSheet()->setCellValue('A1' , '编号');
	$objPHPExcel->getActiveSheet()->setCellValue('B1' , '房源名称');
	$objPHPExcel->getActiveSheet()->setCellValue('C1' ,'发布日期');
	$objPHPExcel->getActiveSheet()->setCellValue('D1' ,'发布人');
	$objPHPExcel->getActiveSheet()->setCellValue('E1' ,'被浏览次数');
	$objPHPExcel->getActiveSheet()->setCellValue('F1' ,'看房人员');
	$objPHPExcel->getActiveSheet()->setCellValue('G1' ,'联系电话');
	//print_r($arr);
	for ($i=2;$i<=count($arry)+1;$i++) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $arry[$i-2]['title']);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $i,date("Y-m-d",$arry[$i-2]['create_at']));
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $arry[$i-2]['user_name']);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, empty($arry[$i-2]['watched'])?0:$arry[$i-2]['watched']);
		$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $arry[$i-2]['telphone']);
	
		$title="";
		if (count($arry[$i-2]['customer_info'])>0) {
			foreach ($arry[$i-2]['customer_info'] as $j => $value){
				$title .=$value['username'].",".$value['telephone']."/";
			}
		}	
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $i,$title);
	}
	$objPHPExcel->getActiveSheet()->setCellValue('F' . (count($arry)+2),"查询时间:".$tim);
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
	
	// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	
	// Rename sheet
	$objPHPExcel->getActiveSheet()->setTitle("report_".$tm);
	
	
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
//	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//	$objWriter->save(str_replace('.php', '.xlsx', WEB_ROOT."data/excel/report_".$tm.".php"));
//	page_msg("导出成功",$isok=true,$url=$_SERVER['HTTP_REFERER'],0);
	}
	
	function print_2()
	{
		require_once('../../includes/phpexcel/PHPExcel.php');
		global $pdo;
		$where=$where1=" 1 and b.esf_id>0 ";
		$tim="时间:";
		if (!empty($_GET['create_at'])) {
			$start=strtotime($_GET['create_at']);
			$where .=" and create_at >= ".$start;
			$where1 .=" and b.addtime >= ".$start;					
		}
		if (!empty($_GET['create_at01'])){
			$end=strtotime($_GET['create_at01']);
			$where .=" and create_at <= ".$end;
			$where1 .=" and b.addtime <= ".$end;
		}
		if(empty($_GET['create_at'])&&empty($_GET['create_at01'])){
			$where .=" and DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(`create_at`,'%Y%m%d') =0";
			$where1 .=" and DATE_FORMAT(now(),'%Y%m%d')-FROM_UNIXTIME(b.addtime,'%Y%m%d')=0";
		}	
		if (!empty($_GET['create_at'])&&empty($_GET['create_at01'])) {
			$tim .=$_GET['create_at']."--今日|";
			$tm=$_GET['create_at'];
		}elseif (empty($_GET['create_at'])&&!empty($_GET['create_at01'])){
			$tim .=$_GET['create_at01']."--之前日期|";		
			$tm=$_GET['create_at01'];
		}elseif (!empty($_GET['create_at'])&&!empty($_GET['create_at01'])) {
			$tim .=$_GET['create_at']."--".$_GET['create_at01']."|";
			$tm=$_GET['create_at']."--".$_GET['create_at01'];
		}else {
			$tim="当前日期:".date("Y-m-d")."|";
			$tm=date("Y-m-d");
		}
		//查询今日查看房东信息记录
		$sql="select a.id,a.title,a.user_name,a.create_at,b.uid from  home_user_cons as b left join home_esf as a on a.id=b.esf_id where $where1 GROUP BY b.esf_id";		
//		$sql="select a.id,a.title,a.user_name,a.create_at,b.uid from  home_user_cons as b left join home_esf as a on a.id=b.esf_id where FROM_UNIXTIME(1341383685,'%Y%m%d')-FROM_UNIXTIME(b.addtime,'%Y%m%d') =0 GROUP BY b.esf_id";		
		$res=$pdo->getAll($sql);
		$watched=count($res);
		foreach ($res as $key2 =>$house2){
			$sql="select a.username,a.telephone,a.uid from home_user as a left join home_user_cons as b on a.uid=b.uid where b.esf_id=".$house2['id'];			
			$wat_count=$pdo->getAll($sql);
			$res[$key2]['watch_count']=count($wat_count);
			$res[$key2]['customer']=$wat_count;
		}
		
		// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	
	// Set properties
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
								 ->setLastModifiedBy("Maarten Balliauw")
								 ->setTitle("Office 2007 XLSX Test Document")
								 ->setSubject("Office 2007 XLSX Test Document")
								 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Test result file");
	
	// Add some data, we will use printing features
	$objPHPExcel->getActiveSheet()->setCellValue('A1' , '编号');
	$objPHPExcel->getActiveSheet()->setCellValue('B1' , '房源名称');
	$objPHPExcel->getActiveSheet()->setCellValue('C1' ,'发布日期');
	$objPHPExcel->getActiveSheet()->setCellValue('D1' ,'发布人');
	$objPHPExcel->getActiveSheet()->setCellValue('E1' ,'被浏览次数');
	$objPHPExcel->getActiveSheet()->setCellValue('F1' ,'看房人员');
	//print_r($arr);
	for ($i=2;$i<=count($res)+1;$i++) {
		$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1);
		$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $res[$i-2]['title']);
		$objPHPExcel->getActiveSheet()->setCellValue('C' . $i,date("Y-m-d",$res[$i-2]['create_at']));
		$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $res[$i-2]['user_name']);
		$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $res[$i-2]['watch_count']);
	
		$title="";
		foreach ($res[$i-2]['customer'] as $j => $value){
			$title .=$value['username'].",".$value['telephone']."/";
		}
		$objPHPExcel->getActiveSheet()->setCellValue('F' . $i,$title);
	}
	$objPHPExcel->getActiveSheet()->setCellValue('F' . (count($res)+2),"查询时间:".$tim);
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
	
	// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&G&C&HPlease treat this document as confidential!');
	$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
	
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	
	// Rename sheet
	$objPHPExcel->getActiveSheet()->setTitle("watched_".$tm);
	
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
//	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//	$objWriter->save(str_replace('.php', '.xlsx', WEB_ROOT."data/excel/watched_".$tm.".php"));
	
//	page_msg("导出成功",$isok=true,$url=$_SERVER['HTTP_REFERER'],0);
	}
?>