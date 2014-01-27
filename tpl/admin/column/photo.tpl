<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Photo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="/admin/css/admin.css" rel="stylesheet" type="text/css" />
<base target="mainFrame">
<body style="margin-left:5px; margin-top:0px;padding:0;">
<form action="/admin/column/photo.php?action=save" method="post" name="upload" enctype="multipart/form-data">
<input type="hidden" name="tid" value="{$tid}" />
<input type="hidden" name="mid" value="{$mid}" />
<div class="t" style="margin-top:-10px">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px">
  <tr class="head">
    <td colspan="2">Upload Photo&nbsp;&nbsp;&nbsp;<a href="/admin/column/content3.php?action=index&cid={$cid}">{$className}</a> &gt;&gt; <a href="/admin/column/photo.php?action=index&tid={$tid}&cid={$cid}">{$contentName}</a></td>
    </tr>
  <tr class="line">
    <td width="25%">上传文件数量</td>
    <td width="75%"><input name="uploadnum" type="text" class="input" id="uploadnum" size="10">
      <input type="button" name="Submit" value="增加" class="btn" onClick="MakeUpload();">
      <input type="button" name="Submit2" value="恢复" class="btn" onClick="ResetUpload();"></td>
  </tr>
  <tr class="line">
    <td>自动缩略图片文件</td>
    <td><input name="automini" type="checkbox" id="automini" value="1" checked="checked" />
      自动缩略 
        </td>
  </tr>
  <tr class="line">
    <td>缩略标准</td>
    <td>宽度 <input name="width" type="text" class="input" id="width" size="5" disabled="disabled" /> 
      像素&nbsp;&nbsp;&nbsp;
        高度 <input name="height" type="text" class="input" id="height" size="5" disabled="disabled" /> 
        像素 <!--质量<input name="quality" type="text" class="input" id="quality" size="5" maxlength="2" />%-->
     </td>
  </tr>
  <tr class="line">
    <td colspan="2">最多可一次性上传8个附件,系统每次最大上传文件限制<span class="s3">8M </span></td>
    </tr>
  <tr class="line">
    <td colspan="2">
	上传文件1:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="file" name="file1" class="input" size="50"> <input type="text" name="fileintro1" class="input" />
	文件描述<br>
	上传文件2:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="file" name="file2" class="input" size="50">
	<input type="text" name="fileintro2" class="input" />
文件描述<br>
	上传文件3:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="file" name="file3" class="input" size="50">
	<input type="text" name="fileintro3" class="input" />
文件描述<br>
	<span id='uploadfield'></span>	</td>
    </tr>
  <tr class="line">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>
</div>
<div class="sub">
  <input name="step" type="hidden" id="step" value="2">
  <input type="submit" name="Submit3" value="提交" class="btn">&nbsp;&nbsp;&nbsp;&nbsp;
  <input class="btn" type="button" onclick='window.history.go(-1)' value='返回' />
</div>
</form>
{include file="../tpl/admin/footer.tpl"}
</body>
{literal}
<script language='javascript'>
var startNum = 4;
function MakeUpload()
{
   var upfield = document.getElementById("uploadfield");
   var addNum = document.upload.uploadnum.value;
   if(addNum=='') addNum=1;
   addNum = parseInt(addNum);
   var endNum =  addNum+startNum;
   if(endNum>9) endNum = 9;
   for(startNum;startNum<endNum;startNum++){
	   upfield.innerHTML += "上传文件"+startNum+":&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type='file' name='file"+startNum+"' class='input' size='50' /> <input type='text' class='input' name='fileintro"+startNum+"' /> 文件描述<br/>";
   }
}
function ResetUpload()
{
   var upfield = document.getElementById("uploadfield");
   upfield.innerHTML = "";
   startNum = 4;
}
</script>
<script language="javascript">
var top=parent.topFrame;
if(typeof(top)=='object'){
	var loadMsg=top.document.getElementById('loadMsg');
	if(loadMsg!=undefined){
		loadMsg.style.display='none';
	}
}
</script>
{/literal}

