<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Photo-List</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script src="{$smarty.const.URL}/scripts/admin.js"></script>
</head>
{literal}
<script type="text/javascript">
$(document).ready(function(){
$("tr:even").addClass("tr3 t_two"); //给class为stripe_tb的表格的偶数行添加class值为t_two
});
</script>
{/literal}
<base target="mainFrame">
<body style="font-size:12px; margin-left:5px;">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px">
  <tr class="tr4">
    <td style="text-align:left">
	相关路线：<input type="text" name="title" value="{$title}" id="title" />
	<input type="hidden" value="{$cid}" name="cid"  />
	<input type="hidden" value="{$mid}" name="mid"  />
	<input type="button" value="Upload Photo" class="btn" onclick="window.location='/admin/column/photo.php?action=add&routeId={$routeId}&cid={$cid}';"/>
	</td>
  </tr>
</table>
</div>

<form name="form1" id="form1" method="post" action="?action=deleteall">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px">
   <tr class="head">
    <td colspan="6">
	<div style="float:right">{$recordCount}</div>
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;<a href="/admin/column/content3.php?action=index&cid={$cid}">{$className}</a> &gt;&gt; {$routeName}</td>
   </tr>
<tr class="tr2">
    <td><span id="ordertid" class="st">ID<span id="orderpostdate" class="st"><img src="/admin/images/order_DESC.gif" /></span></span></td>
    <td>Photo</td>
    <td><span id="ordertitle" class="st">Describe</span></td>
    <td><span id="orderdigest" class="st">推荐</span></td>
    <td><span id="orderpostdate" class="st">添加时间</span></td>
    <td>操作</td>
  </tr>

{section name=s loop=$photoList}
  <tr class="tr3">
    <td><input name="ids[]" type="checkbox" id="sid_{$photoList[s].id}" value="{$photoList[s].id}">
      {$photoList[s].id|default:"&nbsp;"}</td>
    <td><img src="{$photoList[s].filepath}"/></td>
    <td>{$photoList[s].fileintro|default:"&nbsp;"}
	{if $photoList[s].photo!=''}<a href="javascript:void(0);" img="{$photoList[s].photo}"><img src="/admin/images/img.gif" /></a>{/if}	</td>
    <td>
	{if $photoList[s].pic_type =='Relevant pictures' }
		<img src="{$smarty.const.URL}/admin/images/pub.gif" />
	{else}
		<img src="{$smarty.const.URL}/admin/images/no_pub.gif" />
	{/if}		
	</td>
    <td>{$photoList[s].uploadtime|date_format:"%Y-%m-%d"|default:"&nbsp;"}</td>
    <td>
<a href="content{$mid}.php?action=edit&sp={fp id=$photoList[s].id cid=$photoList[s].cid}"><img src="/admin/images/edit.gif" align="absmiddle" alt="编辑" /></a>
<a href="content{$mid}.php?action=delete&sp={fp id=$photoList[s].id cid=$photoList[s].cid}" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a>
<a href="#"><img src="/admin/images/update.gif" align="absmiddle" alt="更新静态页" /></a></td>
  </tr>
{/section}
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>
    <input name="action" type="hidden" id="action" value="deleteall" />
    <!--
	<input type="button" name="Submit3" value="全选" class="btn" onclick="CheckAll(document.form1);" />
	<input type="submit" name="btn_del" value="全部删除" class="btn" onclick='return window.confirm("您确认要删除!");'>
	-->
	</td>
    <td style="text-align:right; font-size:12px;">{$splitPageStr|default:"&nbsp;"}</td>
  </tr>
</table>
</div>
</form>
{include file="../tpl/admin/footer.tpl"}
</body>
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
