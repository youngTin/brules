<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>文件管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/scripts/formValidator/jquery_last.js"></script>
<script src="{$smarty.const.URL}/scripts/admin.js"></script>
</head>
{literal}
<style>
table{font-size:12px;}
.t{margin-left:7px;}
</style>
{/literal}
<body>
<div class="t" style="margin-top:-10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td style="text-align:left">
文件类型：<select name="menu1" onchange="window.location='/admin/system/attach.php?action=index&type='+this.value;">
		<option value="pic" {if $type=='pic'}selected="selected"{/if}>Picture</option>
		<option value="file" {if $type=='file'}selected="selected"{/if}>File</option>
	</select>&nbsp;&nbsp;
	</td>
  </tr>
</table>
</div>

<form name="form1" id="form1" method="post" action="/admin/column/photo.php?action=order">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="5">
	<div style="float:right">total {$count} &nbsp;&nbsp;</div>
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />
	  网站{if $type=='pic'}图片{else}文件{/if}信息</td>
   </tr>
<tr class="tr2">
    <td><span id="ordertid" class="st">AID<span id="orderpostdate" class="st"><img src="/admin/images/order_DESC.gif" /></span></span></td>
    <td>{if $type=='pic'}Photo{else}File{/if}</td>
    <td><span id="ordertitle" class="st">Quote Info</span></td>
    <td><span id="orderpostdate" class="st">添加时间</span></td>
    <td>操作</td>
  </tr>

{section name=s loop=$photoList}
  <tr class="tr3">
    <td><input name="ids[]" type="checkbox" id="sid_{$photoList[s].id}" value="{$photoList[s].id}">
      {$photoList[s].aid|default:"&nbsp;"}</td>
    <td>
	{if $type=='pic'}<img src="{$photoList[s].filepath}" width="100"/>{else}
	<a href="/download.php?id={$photoList[s].aid}">{$photoList[s].filepath}</a>{/if}
	</td>
    <td>&nbsp;
	{if $type=='pic'}
		{section name=b loop=$photoList[s].quote}
			<div>
			<a href="/admin/column/photo.php?action=index&tid={$photoList[s].quote[b].tid}&cid={$photoList[s].quote[b].cid}">{$photoList[s].quote[b].title}</a><br />
			</div>
		{/section}
	{else}
			{$photoList[s].fileintro|default:"&nbsp;"}
	{/if}
	</td>
    <td>{$photoList[s].uploadtime|date_format:"%Y-%m-%d"|default:"&nbsp;"}</td>
    <td>
	{if $photoList[s].quotecount==0}
<a href="/admin/system/attach.php?action=del&sp={fp aid=$photoList[s].aid filepath=$photoList[s].filepath}" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a>
	{/if}&nbsp;
	</td>
  </tr>
{/section}
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>
    <input type="submit" name="Submit" value="提交" class="btn">
    <!--
	<input type="button" name="Submit3" value="全选" class="btn" onclick="CheckAll(document.form1);" />
	<input type="submit" name="btn_del" value="全部删除" class="btn" onclick='return window.confirm("您确认要删除!");'>
	-->
	</td>
    <td style="text-align:right">{$splitPageStr|default:"&nbsp;"}</td>
  </tr>
</table>
</div>
</form>
{include file="../tpl/admin/footer.tpl"}
</body></html>
{literal}
<script>
var top=parent.topFrame;
if(typeof(top)=='object'){
	var loadMsg=top.document.getElementById('loadMsg');
	if(loadMsg!=undefined){
		loadMsg.style.display='none';
	}
}
</script>
{/literal}