<?php 
/**
* 二手房房源图片上传
* @Created 2010-7-12上午10:29:19
* @name upfile.php
* @author 304260440@qq.com
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_upfile.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
require_once 'config.php'; //引入全局配置
check_login(); //检查是否登录
$img_array = array();
// 加载系统函数
require_once('../sys_load.php');
// 生成SecondHouse对象
$esf = new SecondHouse;
$resold	= new Resold;
$pdo=new MysqlPdo();
extract($_GET);
//新增上传图片开始
if ($_POST)
{
	extract($_POST);
    if (empty($esfid))
    {
	 	if ($type=='1')
		{
		 	$esfid = '100000';//由于采用flash组件上传 先上传图片在发布文 需临时交换设置文章ID 发布文章后会更新此id 也可以采用换session记录
		}
		else 
		{
			$esfid = '200000';
		}
    }
	$num = Count(countpic()); //统计图片张数

 	if ($num=='5') //最多只能上传5张图片
 	{
 		echo "<script>alert('最多只能上传5张图片')</script>";
 	}
 	else if ($_FILES['file1']['size']>226291) 
 	{
 		echo "<script>alert('图片最大只允许200K以内')</script>";
 	}
 	else 
 	{
		if ($_SESSION['send_img'])
		{
		
			if(!empty($_GET['sp'])){
		    $aPara = formatParameter($_GET['sp'], 'out');
		    $esfId = isset($aPara['esfId'])?$aPara['esfId']:'';
		    $type =  isset($aPara['type'])?$aPara['type']:'';
		    $atId =  isset($aPara['atid'])?$aPara['atid']:'';
			}
			
			
		}
	    $esf->addEsfAttach($esfid, uname, $_FILES['file1']);
 	}
 }
 //删除先有图片
 if ($_GET['action']=='del')
 {
 	
	extract($_POST);
	if ($s) //删除Session图片
	{
		if ($esfid!='100000' && $esfid!='200000') //编辑状态删除小区数据库图片
		{
			$p = $pdo->getRow("select * from home_esf where id='$esfid'");
 			$a =  str_replace($attach_id.',','',$p['attach_id']);
 			$pdo->execute("update home_esf set attach_id='$a' where id='$esfid'"); //更新home_esf 小区数据库自动attach_id
		}
		else 
		{
			$a = $_SESSION['do'];
			$a =  str_replace($attach_id.',','',$a);
			$_SESSION['do'] = $a;
		}
	}
	else //删除home_pic里图片 编辑状态 
	{
			 if ($type=='1')
			{
			 	$esfid = '100000';//由于采用flash组件上传 先上传图片在发布文 需临时交换设置文章ID 发布文章后会更新此id 也可以采用换session记录
			}
			else 
			{
				$esfid = '200000';
			}
			if (!is_numeric($attach_id) || !$attach_id)
			{
				echo '读取图片错误!';
				exit();
			}
			$pdo->execute("DELETE FROM `home_esf_attach` WHERE (`id`='$attach_id')"); 
			$pdo->execute("DELETE FROM `home_esf_pic` WHERE (`attach_id`='$attach_id')");
	}
	
 }
 //显示现有图片列表
 $num = Count(countpic());
 $_SESSION['num'] = $num; //记录图片总数 上传的图片+Session总合
 
$res = countpic();
for ($i=0;$i<Count(countpic());$i++)
{
// 	 $img_array = array('0'=>array('id'=>'222','img'=>'/ui/img/05043120.gif'),'1'=>array('id'=>'id','img'=>'b.jpg')); //返回数组
 	$img_array[$i]['id']=$res[$i]['attach_id'];
 	$img_array[$i]['img']=$res[$i]['url'];
 	$img_array[$i]['s'] = $res[$i]['s'];
}
//统计图片
function countpic()
{
	global $pdo,$esfid;
 	//if (!empty($_GET['esfid'])){$esfid=$_GET['esfid'];}
 	extract($_GET);
	if ($esfid=='undefined')
	{
 		if ($type=='1')
 		{
 			$esfid = '100000';
 		}
 		else 
 		{
 			$esfid = '200000';
 		}
	}
	//查询房源图片
	 $sql = "SELECT a.*,b.url FROM home_esf_pic as a
			left Join home_esf_attach as b ON a.attach_id = b.id WHERE a.esf_id =  '$esfid'";
 	$res = $pdo->getAll($sql);
 	$n =  Count($res);
 	//编辑房源 查询小区数据库图片
 	$p = $pdo->getRow("select * from home_esf where id='$esfid'");
 	$p_array = explode(',',$p['attach_id']);
 	$p_num = Count($p_array);
 	for ($j=0;$j<($p_num-1);$j++)
 	{
 		$result = $pdo->getRow("SELECT * FROM home_esf_attach where id=$p_array[$j]");
	    $res[$n+$j]['attach_id'] = $result['id'];
	    $res[$n+$j]['url'] = $result['url'];
	    $res[$n+$j]['s'] = 1; //用于判断是Sessiion图片还是房源自带图片
 	}
 	//新增房源 查询小区数据库图片
 	if (!empty($_SESSION['do']))
 	{
 		$picarray = explode(',',$_SESSION['do']);
	 	$num = count($picarray);
		for ($i=0;$i<($num-1);$i++)
		{
		// 	 $img_array = array('0'=>array('id'=>'222','img'=>'/ui/img/05043120.gif'),'1'=>array('id'=>'id','img'=>'b.jpg'));
			$result = $pdo->getRow("SELECT * FROM home_esf_attach where id=$picarray[$i]");
		    $res[$n+$i]['attach_id'] = $result['id'];
		    $res[$n+$i]['url'] = $result['url'];
		    $res[$n+$i]['s'] = 1; //用于判断是Sessiion图片还是房源自带图片
		}
 	}
 	return $res;
}

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
<form action="upfile.php" name="send_img" method="post" enctype="multipart/form-data">
<input type="hidden" name="type" value="<?php echo $type;?>">
<input type="hidden" name="esfid" value="<?php echo $esfid;?>">
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
      <a class="delete" href="?action=del&attach_id=<?php echo $img_array[$i]['id']?>&type=<?php echo $type;?>&esfid=<?php echo $esfid;?>&s=<?php echo $img_array[$i]['s']?>" title="删除该图片" 
>删
除该图片</a></li>
<?php
}
?>
</ul>
<div name="divUploader" class="cls_divUploader">
<div class="loadbutton">
<input id="fileUploadInput" name="file1" type="file" onChange="ajax_send(this.value);"></div>&nbsp;<span style="display: inline;" class="upload_ok"></span>
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
.loadbutton{width:74px;height:21px;background:url(/ui/img/loadbutton.gif);display:inline-block;position:relative;overflow:hidden;vertical-align:middle;float:left; margin-right:5px;cursor:pointer}
#fileUploadInput {position:absolute; top:-2px; right:-2px; font-size:36px; filter:alpha(opacity:0); opacity: 0; height:20px;}
.upload_ok{ font-family:Tahoma}
.delete{ display:block; width:13px; height:12px; background:url(/ui/img/closeyes.gif) no-repeat 0 0; line-height:100px; overflow:hidden; position:absolute; top:3px; right:3px; z-index:999}
.upload_maxnum {color:#F00}
.upload_ing {color:#F00}
</style>

</div>
</form>
</body>
</html>
