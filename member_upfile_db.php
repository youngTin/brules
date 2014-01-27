<?php
/**
* 小区数据库图片上传
* @Created 2010-7-7下午02:56:43
* @name upfile_db.php
* @author 304260440@qq.com
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_upfile_db.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
require_once 'config.php'; //引入全局配置
check_login(); //检查用户是否登录
$user_name = uname; //获取用户名
$img_array = array();
// 加载系统函数
require_once('../sys_load.php');
 // 生成SecondHouse对象
$esf = new SecondHouse;
$resold	= new Resold;
$pdo=new MysqlPdo();
extract($_GET);
//增加小区图片
 if ($_POST)
 {
	extract($_POST);
    if (empty($picid))
    {
	 	$picid = '100000';
    }
    $info = $pdo->getRow("select * from home_user_database where id='$dbid'");
	//$picarray = explode(',',$_SESSION['info']);
	$img = $info['attach_id'].$_SESSION['info'];
	$picarray = explode(',',$img);
	//$picarray = explode(',',$_SESSION[info]);
	$num = count($picarray);

 	if ($num>5)
 	{
 		echo "<script>alert('最多只能上传5张图片')</script>";
 	}
 	else if ($_FILES['file1']['size']>226291) 
 	{
 		echo "<script>alert('图片最大只允许200K以内')</script>";
 	}
 	else 
 	{		
 		
 		   $upload = new UploadFile( $_FILES['file1']);
           $iCount = $upload->upload();
           $aInfo = $upload->getSaveInfo();
           $time = time();
             for($i=0; $i<$iCount; $i++){
                $arrInfo = $aInfo[$i];
            // 加附件
                $pdo->add(array(
                    "name"=>$arrInfo['name'], 
                    "url"=>$arrInfo['url'], 
                    "type"=>$arrInfo['type'], 
                    "size"=>$arrInfo['size'], 
                    "checksum"=>$arrInfo['checksum'],
                    "update_at"=>$time), DB_PREFIX_HOME."esf_attach");
                $p =$pdo->getLastInsID();
                
             }
    	$_SESSION['info'] .= $p.',';
 	}

 }
 //删除指定图片
 if ($_GET['action']=='del')
 {
 	
		extract($_POST);
		//显示图片列表
	if (!empty($dbid)) //编辑状态
	{
		$pinfo = $pdo->getRow("select * from home_user_database where id='$dbid'");
		if (is_array($pinfo) && eregi($attach_id,$pinfo['attach_id'])) //删除数据库里的
		{
			$a =  str_replace($attach_id.',','',$pinfo['attach_id']);
			$pdo->execute("UPDATE home_user_database set attach_id='$a' where id='$dbid'"); //更新数据库 
			//图片文件一起删除
			$arrAttach = $pdo->getRow("select * from home_esf_attach where id='$attach_id'");
			$attach = realpath(WEB_ROOT . $arrAttach['url']);
			$m_pic = str_replace(strrchr($attach,'.'),'_m'.strrchr($attach,'.'),$attach);  
			$s_pic = str_replace(strrchr($attach,'.'),'_s'.strrchr($attach,'.'),$attach); 
			@unlink($s_pic);
			@unlink($m_pic);
			@unlink($attach);		
			$pdo->execute("DELETE FROM `home_esf_attach` WHERE (`id`='$attach_id')");
		}
		else //删除Session保存的图片 
		{
					//图片文件一起删除
			$arrAttach = $pdo->getRow("select * from home_esf_attach where id='$attach_id'");
			$attach = realpath(WEB_ROOT . $arrAttach['url']);
			$m_pic = str_replace(strrchr($attach,'.'),'_m'.strrchr($attach,'.'),$attach);  
			$s_pic = str_replace(strrchr($attach,'.'),'_s'.strrchr($attach,'.'),$attach); 
			@unlink($s_pic);
			@unlink($m_pic);
			@unlink($attach);		
			$pdo->execute("DELETE FROM `home_esf_attach` WHERE (`id`='$attach_id')");
			$a = $_SESSION['info'];
			$a =  str_replace($attach_id.',','',$a);
			$_SESSION['info'] = $a;
		}

	}
	else //新增状态 
	{
			//图片文件一起删除
		$arrAttach = $pdo->getRow("select * from home_esf_attach where id='$attach_id'");
		$attach = realpath(WEB_ROOT . $arrAttach['url']);
		$m_pic = str_replace(strrchr($attach,'.'),'_m'.strrchr($attach,'.'),$attach);  
		$s_pic = str_replace(strrchr($attach,'.'),'_s'.strrchr($attach,'.'),$attach); 
		@unlink($s_pic);
		@unlink($m_pic);
		@unlink($attach);		
		$pdo->execute("DELETE FROM `home_esf_attach` WHERE (`id`='$attach_id')");
		$a = $_SESSION['info'];
		$a =  str_replace($attach_id.',','',$a);
		$_SESSION['info'] = $a;
	}
	
 }
//显示图片列表
if (!empty($dbid)) //编辑状态
{
//	echo 'updata';
	$info = $pdo->getRow("select * from home_user_database where id='$dbid'");
	//$picarray = explode(',',$_SESSION['info']);
	$img = $info['attach_id'].$_SESSION['info'];
	$picarray = explode(',',$img);
	$num = count($picarray);
	for ($i=0;$i<($num-1);$i++)
	{
	// 	 $img_array = array('0'=>array('id'=>'222','img'=>'/ui/img/05043120.gif'),'1'=>array('id'=>'id','img'=>'b.jpg'));
		$res = $pdo->getRow("SELECT * FROM home_esf_attach where id=$picarray[$i]");
	    $img_array[$i]['id']=$res['id'];
	    $img_array[$i]['img']=$res['url'];
	}
}
else  //新增状态
{
//	echo 'add';
	$picarray = explode(',',$_SESSION['info']);
	$num = count($picarray);
	for ($i=0;$i<($num-1);$i++)
	{
	// 	 $img_array = array('0'=>array('id'=>'222','img'=>'/ui/img/05043120.gif'),'1'=>array('id'=>'id','img'=>'b.jpg'));
		$res = $pdo->getRow("SELECT * FROM home_esf_attach where id=$picarray[$i]");
	    $img_array[$i]['id']=$res['id'];
	    $img_array[$i]['img']=$res['url'];
	}
}

//	unset($_SESSION['info']);


?>
<html>
<head><title>upfile</title>
<link href="/ui/css/common.css" rel="stylesheet" type="text/css" >
<link href="/ui/member/css/htgl.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/ui/js/jquery_last.js"></script>
<script type="text/javascript" src="/ui/js/common.js"></script>
<script type="text/javascript" src="/scripts/jquery-lightbox-0.5/js/jquery.lightbox-0.5.min.js"></script>

<script type="text/javascript">
function ajax_send(img_url)
{
	
	$('#up').show();
	document.send_img.submit();
}
function deletePic(id)
{
		$.ajax({
	   type: "POST",
	   url: "upfile.php",
	   data: "action=ajax&attach_id="+id,
	   success: function(msg){
		   return true;
	   }
	});
}
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>
<form action="upfile_db.php" name="send_img" method="post" enctype="multipart/form-data">
<input type="hidden" name="dbid" value="<?php echo $dbid;?>">
<div id="uploadPic"  value="">
<ul>
<?php
for($i=0;$i<count($img_array);$i++)
{
?>
<li
 picurl="" id="up" ><div class="displayimg"><img 
src="<?php if(empty($img_array[$i]['img'])){
									   echo '/ui/img/05043120.gif';}
									   else
									   {
										   echo $img_array[$i]['img'];}
									  
								   ?>" /></div>
      <a class="delete" href="?action=del&attach_id=<?php echo $img_array[$i]['id']?>&dbid=<?php echo $dbid;?>" title="删除该图片" 
>删
除该图片</a></li>
<?php
}
?>
</ul>
<div name="divUploader" class="cls_divUploader">
<div class="loadbutton">
<input id="fileUploadInput" name="file1" type="file" onChange="ajax_send(this.value);"></div>&nbsp;<span style="display:inline;" class="upload_ok"></span>
<span class="upload_error" style="display: none;"></span>
<span class="upload_ing"  style="display:none">正在上传中，请稍等……</span>
<span class="upload_maxnum" style="display: none;">上传成功!</span>
</div>
<input id="backFunction" name="backFunction" value="$.c.Uploader.finish" type="hidden">
<input name="Pic" id="Pic" value="/p1/big/n_3592859281665.jpg|/p1/big/n_3592865323265.jpg|/p1/big/n_3592851524865.jpg" type="hidden"><input name="PicDesc" id="PicDesc" value="||" type="hidden">
<input name="PicPos" id="PicPos" value="2" type="hidden">

<style>
#uploadPic ul{list-style-type:none;margin:0px;padding:0px}
#uploadPic li{float:left;width:82px;height:108px;margin:0 5px 10px 0;padding-bottom:3px; overflow:hidden; background:#eee; position:relative}
#uploadPic .displayimg{width:80px;height:80px; display:table-cell; vertical-align:middle; text-align:center; *display:block; *font-size:72px; border:1px solid #ccc; overflow:hidden;background:#fff}
#uploadPic .displayimg img{vertical-align:middle}
 #uploadPic div{clear:both}
#uploadPic input.picDesc{width:80px; *width:78px; text-align:center; margin:0; border:1px solid #7F9DB9; margin-top:2px; display:none;}
#uploadPic span.upload_error{background-color:#FFD7D7; color:#000; padding:4px; font-family:Tahoma; line-height:24px;}
.cls_divUploader {height:150px; background-color:Transparent;}
.loadbutton{width:74px;height:21px;background:url(/ui/img/loadbutton.gif);display:inline-block;position:relative;overflow:hidden;vertical-align:middle;float:left;cursor:pointer}
#fileUploadInput {position:absolute; top:-2px; right:-2px; font-size:36px; filter:alpha(opacity:0); opacity: 0; height:20px;}
.upload_ok{font-family:Tahoma}
.delete{ display:block; width:13px; height:12px; background:url(/ui/img/closeyes.gif) no-repeat 0 0; line-height:100px; overflow:hidden; position:absolute; top:3px; right:3px; z-index:999}
.upload_maxnum {color:#F00}
.upload_ing {color:#F00}
</style>

</div>
</form>
</body>
</html>
