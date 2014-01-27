<?php
set_time_limit(0);
header('Content-Type:text/html;Charset=utf-8');

require_once 'includes/phpexcel/PHPExcel.php';
require_once 'includes/phpexcel/PHPExcel/IOFactory.php';

$objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format 
$objPHPExcel = $objReader->load('tel.xls');   //$filename可以是上传的文件，或者是指定的文件
$sheet = $objPHPExcel->getActiveSheet(); 
echo $highestRow = $sheet->getHighestRow(); // 取得总行数 
$highestColumn = $sheet->getHighestColumn(); // 取得总列数
$k = 0;   
require_once 'sys_load.php'; 
require_once 'includes/MysqlPdo.class.php';
$pdo = new MysqlPdo();
//循环读取excel文件,读取一条,插入一条
   for($j=0;$j<=$highestRow;$j++)
   {
        $a = $objPHPExcel->getActiveSheet()->getCell("A".$j)->getValue();//获取A列的值
        //$b = $objPHPExcel->getActiveSheet()->getCell("B".$j)->getValue();//获取B列的值
        // echo iconv('GB2312','UTF-8',$a);
        $a = preg_replace("/(\s|( )+|\xc2\xa0)/","",$a); //去掉空格
        echo $a.'正在执行第-'.$j.'-行<br />';
        if(is_numeric($a))insertRei($a);
        if($j==150)usleep(200000);
   }
   
function insertRei($tel,$name='anonymous')
{
    global $pdo;
    if(!isExeistTelName($tel,$name))
    {
        $time = time();
        $sql = " insert into  ".DB_PREFIX_HOME."rei set name = '$name' , telephone = '$tel' , addtime = '$time' ";
        return $pdo->execute($sql);
    }
    else {
        echo '已存在';
    }
    
}
function isExeistTelName($tel,$name)
{
    global $pdo;
    return $pdo->find(DB_PREFIX_HOME.'rei'," telephone='$tel' and name='$name' ");
}
?>