<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>web site config</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="/admin/css/admin.css" rel="stylesheet" type="text/css" />

<div class="m"></div>
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="2">更新站点缓存</td>
    </tr>
  <tr class="tr2">
    <td colspan="2">&nbsp;</td>
    </tr>
<form action="/admin/set_cache.php?action=save" method="post">
  <tr class="line">
    <td>站点配置缓存
	<input name="action" type="hidden" id="action" value="web_config"></td>
    <td><input type="submit" name="Submit3" value="点击更新" class="btn" /></td>
  </tr>
</form>
<form action="/admin/set_cache.php?action=save" method="post">
</form>
<!--
<form action="/admin/set_cache.php?action=save" method="post">
  <tr class="line">
    <td width="25%">更新首页
      <input name="action" type="hidden" id="action" value="homepage"></td>
    <td width="75%"><input type="submit" name="Submit" value="点击更新" class="btn" /></td>
  </tr>
</form>
<form action="/admin/set_cache.php?action=save" method="post">
  <tr class="line">
    <td width="25%">更新栏目缓存
      <input name="action" type="hidden" id="action" value="cate"></td>
    <td width="75%"><input type="submit" name="Submit" value="点击更新" class="btn" /></td>
  </tr>
</form>
<form action="/admin/set_cache.php?action=save" method="post">
  <tr class="line">
    <td width="25%">更新模板缓存
      <input name="action" type="hidden" id="action" value="template"></td>
    <td width="75%"><input type="submit" name="Submit" value="点击更新" class="btn" /></td>
  </tr>
</form>
<form action="/admin/set_cache.php?action=save" method="post">
  <tr class="line">
    <td>更新模型缓存
      <input name="action" type="hidden" id="action" value="mod" /></td>
    <td><input type="submit" name="Submit2" value="点击更新" class="btn" /></td>
  </tr>
</form>
<form action="/admin/set_cache.php?action=save" method="post">
  <tr class="line">
    <td>更新数据库查询缓存
      <input name="action" type="hidden" id="action" value="sql" /></td>
    <td><input type="submit" name="Submit2" value="点击更新" class="btn" /></td>
  </tr>
</form>
<form action="/admin/set_cache.php?action=save" method="post">
  <tr class="line">
    <td>更新站点评论缓存
      <input name="action" type="hidden" id="action" value="comment" /></td>
    <td><input type="submit" name="Submit2" value="点击更新" class="btn" /></td>
  </tr>
</form>
<form action="/admin/set_cache.php?action=save" method="post">
  <tr class="line">
    <td>更新整合数据缓存
		<input name="action" type="hidden" id="action" value="modconfig" /></td>
    <td><input type="submit" name="Submit2" value="点击更新" class="btn" /></td>
  </tr>
</form>
-->
<form action="/admin/set_cache.php?action=save" method="post">
  <tr class="line">
    <td width="25%">更新所有缓存
      <input name="action" type="hidden" id="action" value="all"></td>
    <td width="75%"><input type="submit" name="Submit" value="点击更新" class="btn" /></td>
  </tr>
</form>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</div>

<div style="margin:10px; line-height:150%; text-align:center">
FDKL v3.3 Code &copy; FDKL.CN<br />
Total {$time}(s) query 1 , Gzip disabled <br />
<br />
</div>

{literal}
<script language="javascript">
var agt = navigator.userAgent.toLowerCase();
var is_ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
var is_gecko= (navigator.product == "Gecko");
var top=parent.topFrame;
if(typeof(top)=='object'){
	var loadMsg=top.document.getElementById('loadMsg');
	if(loadMsg!=undefined){
		loadMsg.style.display='none';
	}
}

function selectTpl(name){
	window.open('/admin.php?adminjob=category&action=selectTpl&inputname='+name);
	return ;
}
</script>
{/literal}

