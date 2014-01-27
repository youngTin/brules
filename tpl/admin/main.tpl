<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.WEB_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<body>
<base target="mainFrame">
<!--
<div class="t" style="margin-top:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="tr4">
		<td>快捷操作</td>
		<td><input type="button" name="Submit" value="首页更新" onclick="window.location='http://www.tibettreks.com';" class="btn" />
			&nbsp;&nbsp;
			<input type="button" name="Submit3" value="更新所有详细页面" onclick="window.location='http://www.tibettreks.com';" class="btn" />
			&nbsp;&nbsp;</td>
	</tr>
</table>
</div>
-->
<div class="m"></div>
<div class="t">
<table align=center cellspacing=0 cellpadding=0>
<tr class=head>
  <td>System helps</td>
</tr>
<tr class=line>
  <td> 1.您当前使用的新的后台管理系统，我们等待您的建议来让系统更完美。<br />
2.部分功能在当前版本中尚未完全开放，在后续将会推出。<br />
3.所有对栏目操作均在右边树形列表里进行，当前后台必须用IE操作。<br />
4.点击此处更新首页[<a href="#" style="color:#FF0000; font-weight:bold">更新首页</a>] 因为首页是纯静态生成，故而如果需要更新需要更新一次。</td>
</tr></table>
</div>
<div class="t">
<table align=center cellspacing=0 cellpadding=0>
<tr class=head><td colspan="2">
系统信息</td></tr>
<tr class=line>
  <td>程序路径：</td>
  <td>{$filepath}</td>
</tr>
<tr class=line>
  <td width="20%">PHP版本：</td>
  <td>{$sysversion}</td>
</tr>
<tr class=line>
  <td>GD库版本：</td>
  <td>{$gdinfo}</td>
</tr>
<tr class=line>
  <td>FreeType：</td>
  <td>{$freetype}</td>
</tr>
<tr class=line>
  <td>MySQL版本：</td>
  <td>{$dbversion}</td>
</tr>
<tr class=line>
  <td>Web服务器：</td>
  <td>{$sysos}</td>
</tr>
<tr class=line>
	<td>远程文件获取：</td>
	<td>$allowurl</td>
</tr>
<tr class=line>
  <td>最大上传限制：</td>
  <td>$max_upload</td>
</tr>
<tr class=line>
  <td>最大执行时间：</td>
  <td>$max_ex_time</td>
</tr>
<tr class=line>
  <td>服务器时间：</td>
  <td>$systemtime</td>
</tr>
<tr class=line>
  <td>数据库占用：</td>
  <td>$pw_size M</td>
</tr>
<tr class=line>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
</div>
{include file="../tpl/admin/footer.tpl"}
</body>
</html>
{literal}
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