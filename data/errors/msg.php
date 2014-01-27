<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>
<?php
	if($isok) echo "successful"; else "false";
?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php if($isok){ ?>
<meta http-equiv="refresh" content="<? echo $time; ?>;URL=<?php echo URL.$url; ?>" />
<?php } ?>
<style type="text/css">
td{font-size:12px;}a{color:#666666;}
</style>
</head>
<link href="/admin/images/admin.css" rel="stylesheet" type="text/css" />
<div style='font-size:12px;font-family:verdana;line-height:180%;color:#666;border:dashed 1px #ccc;padding:1px;margin:20px;'>
	<div style="background: #eeedea;padding-left:10px;font-weight:bold;height:25px;">提示信息</div>
	<div style='padding:20px;font-size:14px;'>
	<table>
		<tr>
		<td><img width="80px" src='/admin/images/<?php if($isok) echo "ok"; else echo "no"; ?>.gif' align='absmiddle' hspace=20 ></td>
		<td><?php echo $msg; ?></td>
		</tr>
	</table>
	</div>
	<div style="text-align:center;height:30px;">
		<?php 
		if($ajax==1)
		{
			echo "<a onclick='art.dialog.get(\"{$_GET['itemid']}\").close();'>返回继续操作</a>";
		}
		elseif($ajax==2)
		{
			echo "<a href='#' onclick='self.parent.tb_remove();'>返回继续操作</a>";
		}
		else 
		{
			if(empty($url)){
				echo "<div style='text-align:center;height:30px;'><input class=btn type=button onclick='window.history.go(-1)' value=' 返回继续操作 ' /></div>";
			}else{
				echo "<a href=".$url.">返回继续操作</a>";
			}
		}
		echo $other;
		?>
	</div>
</div>
<script>
var top=parent.topFrame;
if(typeof(top)=='object'){
	var loadMsg=top.document.getElementById('loadMsg');
	if(loadMsg!=undefined){
		loadMsg.style.display='none';
	}
}
</script>