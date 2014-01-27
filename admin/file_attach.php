<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>上传下载文件</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<script src="/admin/javascript/showDiv.js" type="text/javascript" language="javascript"></script>
<link href="/admin/css/admin.css" rel="stylesheet" type="text/css" />
<style>
div#qTip {
 padding: 3px;
 border: 1px solid #8394a5;
 border-right-width: 2px;
 border-bottom-width: 2px;
 display: none;
 background: #f0f4f8;
 color: #8394a5;
 font: 12px Verdana, Arial, Helvetica, sans-serif;
 line-height:22px;
 text-align: left;
 position: absolute;
 z-index: 1000;
}
a{cursor:pointer}
</style>
<?php
	require_once('../sys_load.php');
	
	$verify = new Verify();
	$verify->validate_file_attach();

	$pdo = new MysqlPdo();
	
	switch(@isset($_GET['action'])?$_GET['action']:@$_POST['action'])
	{
		case 'save':save(); //修改或添加后的保存方法
			break;
		default:index();
			break;
	}
	/**
	 * attachment files list
	 */
	function index()
	{	
		if(!$_SESSION['index'])page_msg('你没有权限访问',$isok=false);
		global $pdo,$attach,$splitPageStr,$filetype,$inputname,$type;
		$type=isset($_GET['type'])?$_GET['type']:'image';
		$inputname=isset($_GET['inputname'])?$_GET['inputname']:'photo';
		if($type=='image'){
			$ext_type="('jpg','gif','png')";
			$filetype=0;
		}else{
			$ext_type="('zip','rar','txt','xls','doc','pdf')";
			$filetype=1;
		}
		
		$page_info = "type=".$type."&inputype=input&inputname=".$inputname."&";
		$pageSize = 15;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;

		$attach=$pdo->getAll("select * from ".DB_PREFIX."attach where type in ".$ext_type." order by aid desc limit ".$offset.",".$pageSize);
		$Count = $pdo->getRow("select count(aid) as count from ".DB_PREFIX."attach where type in ".$ext_type);
		$recordCount = $Count['count'];
		$page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();
	}
	
	/**
	 * upload file
	 */
	function save()
	{
		if(!$_SESSION['save']){
			echo "<script>parent.notice_false();</script>"; exit;
		}
		global $pdo;
		$path=isset($_POST['type'])?$_POST['type']:"file";
		$uptool = new UploadFile($_FILES['file'],$path);
		$upsize = $uptool->upload();
		$upinfo = $uptool->getSaveInfo();
		$ras = array();
		$ras['filename']   = $upinfo[0]['name'];
		$ras['filepath']   = $upinfo[0]['url'];
		$ras['type']       = $upinfo[0]['type'];
		$ras['size']       = $upinfo[0]['size'];
		$ras['filesrc']    = $upinfo[0]['checksum'];
		$ras['uploadtime'] = $_SERVER['REQUEST_TIME'];
		$pdo->add($ras, DB_PREFIX."attach");
		if($pdo->getLastInsID()){
			echo "<script>parent.notice();</script>"; exit;
		}
	}
	

?>
<base target="_self">
<script language="javascript">
var	ftpweb = '';
var weburl ="<?php echo URL; ?>";
var inputname = "<?php echo isset($_GET['inputname'])?$_GET['inputname']:'photo'; ?>";
var inputtype = "<?php echo isset($_GET['inputtype'])?$_GET['inputtype']:'input'; ?>";
var attach_id = 'aid';


function insertImg(aid,filename,type,imgtype){
	var imgsrc;
	if (type) {
		//imgsrc = ftpweb+"/"+filename;
		imgsrc = "download.php?id=" + aid;
	}else {
		filename = filename.replace(".",imgtype);
		imgsrc = filename;
	}
	
	if(window.dialogArguments){
		var win = window.dialogArguments;
	}else{
		var win = window.opener;
	}
	//var input = window.opener.document.getElementsByName(inputname);
	if(inputtype=='editor'){
		win.document.getElementById(inputname).value=imgsrc;
		//win.parent.dialogArguments.document.getElementById('aid').value+=','+aid;
	}else if(inputtype=='input'){
		win.document.getElementById(inputname).value=imgsrc;
		win.document.getElementById(attach_id).value=aid;
		win.document.getElementById('show_pic').src=imgsrc;
	}
	window.close();
}

function goclick(element){
	if(document.all){
		parent.document.getElementById(element).click();
	}else{
		var evt = parent.document.createEvent("MouseEvents");
		evt.initEvent("click",true,true);
		parent.document.getElementById(element).dispatchEvent(evt);
	}
}

function notice() {//通知用户文件上传成功 
		document.getElementById('msg').style.display = 'none';
		goclick("reload");
		alert('文件上传成功！');
}

function notice_false() {//通知用户文件上传失败
		document.getElementById('msg').style.display = 'none';
		goclick("reload");
		alert('你没有上传权限！');
} 

</script>
<body onkeydown="if (event.keyCode==116){reload.click();}">
<a id="reload" href="file_attach.php?action=index&type=<?php echo $_GET['type']; ?>&inputtype=<?php echo $_GET['inputtype']; ?>&inputname=<?php echo $inputname; ?>" style="display:none">reload...</a>
<div id="msg" style="border:#69788c 1px solid; background-color:#fdfdfd;padding:3px; width:300px;position:absolute; top:100px; left:150px; display:none;">

<div style="height:20px; padding:3px;"><img src="/admin/images/ing.gif" align="absmiddle" /> 上传中，请耐心等待.....</div></div>
<div class="t">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr class="head">
			<td colspan="5">附件管理
				<form action="file_attach.php?action=save" method="post" name="upload" target="uploadFrame" enctype="multipart/form-data">
					上传
					<input name="file" type="file" class="input" />
					描述：
					<input type="text" name="fileintro1" class="input" />
					<input name="type" type="hidden" id="type" value="<?php echo $_GET['type']; ?>" />
					<input type="submit" name="Submit" value=" 上传 " class="btn" onclick="javascript:document.getElementById('msg').style.display = '';" />
				</form></td>
		</tr>
		<tr class="tr2">
			<td>文件名</td>
			<td>描述</td>
			<td>插入</td>
			<td>文件大小</td>
			<td>上传时间</td>
		</tr>
		<?php 
			foreach($attach as $item){
		?>
		<tr class="tr3">
			<td>
			<?php 
				if($type=='image'){
				    echo "<img src='/admin/images/img.gif' width='16' height='16' hspace='5' align='absmiddle' />";
				}else{
					echo "<img src='/admin/images/file/doc.gif' width='16' height='16' hspace='5' align='absmiddle' />";
				} 
			?>
			
			<a href="javascript:void(0);" img="<?php echo URL.'/'.$item['filepath']; ?>" ><?php echo $item['filename']; ?></a>
			</td>
			<td>&nbsp;</td>
			<td>
            <?php if($filetype=='pic'){ ?>
			<a herf="javascript:void(0);" onClick="insertImg(<?php echo $item['aid']; ?>,'<?php echo $item['filepath']; ?>',<?php echo $filetype; ?>,'.');">原图</a>
			&nbsp;<a herf="javascript:void(0);" onClick="insertImg(<?php echo $item['aid']; ?>,'<?php echo $item['filepath']; ?>',<?php echo $filetype; ?>,'_m.');">中图</a>
			&nbsp;<a herf="javascript:void(0);" onClick="insertImg(<?php echo $item['aid']; ?>,'<?php echo $item['filepath']; ?>',<?php echo $filetype; ?>,'_s.');">小图</a>
            <?php }else{ ?>
            <a herf="javascript:void(0);" onClick="insertImg(<?php echo $item['aid']; ?>,'<?php echo $item['filepath']; ?>',<?php echo $filetype; ?>,'.');">插入</a>
            <?php } ?>
			</td>
			<td><?php echo $item['size']; ?> KB<br /></td>
			<td><?php echo date('Y-m-d H:i:s',$item['uploadtime']); ?><br /></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="5"><?php echo $splitPageStr; ?></td>
		</tr>
	</table>
</div>
<iframe name="uploadFrame" style="display:''" width="0"></iframe>