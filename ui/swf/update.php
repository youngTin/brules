<?php
/**
* Flash上传处理文件
* @name	 	update.php
* @param	$atId	文章数组
* @param	$esfId	临时交换文章ID
* @param	$_GET['type']==1 || $_GET['type']==2	出租和出售
* @author 304260440@qq.com
* @version 1.0
* @version $Id: update.php,v 1.1 2012/02/07 09:00:58 gfl Exp $
*/
// 加载系统函数
require_once('../../../includes/functions.php');
// 生成SecondHouse对象
$smarty = new WebSmarty();
$esf = new SecondHouse;
$resold	= new Resold;
$pdo=new MysqlPdo();
$aPara = array();
$type  = $atId  = $esfId  = 0;

if(!empty($_GET['sp'])){
    $aPara = formatParameter($_GET['sp'], 'out');
    $esfId = isset($aPara['esfId'])?$aPara['esfId']:'';
    $type =  isset($aPara['type'])?$aPara['type']:'';
    $atId =  isset($aPara['atid'])?$aPara['atid']:'';
}
// 注意：使用组件上传，不可以使用 $_FILES["Filedata"]["type"] 来判断文件类型
mb_http_input("utf-8");
mb_http_output("utf-8");
$type=filekzm($_FILES["file1"]["name"]);
if ((($type == ".gif")
|| ($type == ".png")
|| ($type == ".jpeg")
|| ($type == ".jpg")
|| ($type == ".bmp"))
&& ($_FILES["file1"]["size"] < 200000))
  {
  if ($_FILES["file1"]["error"] > 0)
    {
    echo "返回错误: " . $_FILES["Filedata"]["error"] . "<br />";
    }
  else
    {
       if ($_GET['type'] == '2') //出售
       {
            $atId = array();
            $esfId = '200000';//由于采用flash组件上传 先上传图片在发布文 需临时交换设置文章ID 发布文章后会更新此id 也可以采用换session记录
            
            //先删除图片
            $sql = "SELECT * FROM `home_esf_pic` WHERE `esf_id` =$esfId";
            $atId = $pdo->getAll($sql);
            if (Count($atId)>5)
            {
                for ($i=0;$i<Count($atId);$i++)
                {
                   $resold->removePic($atId[$i]['attach_id']);
                   $resold->countImages($atId[$i]['attach_id']); 
                }
            }
            if($esf->countEsfAttach($esfId)<= 5 )
            {
                $resold->appendAttach($esfId);
        	            $resold->countImages($esfId);
            }
       }
       else if ($_GET['type'] == '1') //出租
       {
            $atId = array();
            $esfId = '100000';//由于采用flash组件上传 先上传图片在发布文 需临时交换设置文章ID 发布文章后会更新此id 也可以采用换session记录
                
                //先删除图片
                $sql = "SELECT * FROM `home_esf_pic` WHERE `esf_id` =$esfId";
                $atId = $pdo->getAll($sql);
                if (Count($atId)>5)
                {
                    for ($i=0;$i<Count($atId);$i++)
                    {
                       $resold->removePic($atId[$i]['attach_id']);
                           $resold->countImages($atId[$i]['attach_id']); 
                    }
                }
                 $esf->addEsfAttach($esfId, NULL, $_FILES['file1']);
                 
       }
	//print_r($_GET['type']);//出租为:1 出售为:2
    
   /* echo "上传的文件: " . $_FILES["Filedata"]["name"] . "<br />";
    echo "文件类型: " . $type . "<br />";
    echo "文件大小: " . ($_FILES["Filedata"]["size"] / 1024) . " Kb<br />";
    echo "临时文件: " . $_FILES["Filedata"]["tmp_name"] . "<br />";
	print_r($_GET['id']);
    if (file_exists( $_FILES["Filedata"]["name"]))
      {
      echo $_FILES["Filedata"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["Filedata"]["tmp_name"],
      $_FILES["Filedata"]["name"]);
      echo "Stored in: " . $_FILES["Filedata"]["name"];
      }*/
        
    }
  }
else
  {
  echo "上传失败，请检查文件类型和文件大小是否符合标准<br />文件类型：".$type.'<br />文件大小:'.($_FILES["Filedata"]["size"] / 1024) . " Kb";
  }
  

function filekzm($a)
{
	$c=strrchr($a,'.');
	if($c)
	{
		return $c;
	}else{
		return '';
	}
}
?>