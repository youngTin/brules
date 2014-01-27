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
<div class="t" style="margin-top:-10px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px">
  <tr class="tr4">
    <td style="text-align:left">
	Relevant photo：
	<select name="menu1" onchange="window.location='/admin/column/photo.php?action=index&cid={$cid}&tid='+this.value;">
		{foreach item=contact from=$allInfo}
			<option value="{$contact.id}" {if $contact.id==$tid}selected="selected"{/if}>&raquo;{$contact.title}</option>
		{/foreach}
	</select>&nbsp;&nbsp;
	<input type="button" value="Upload Photo" class="btn" onclick="window.location='/admin/column/photo.php?action=add&tid={$tid}&cid={$cid}';"/>
	</td>
  </tr>
</table>
</div>

<form name="form1" id="form1" method="post" action="/admin/column/photo.php?action=order">
<input type="hidden" name="cid" value="{$cid}" />
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px">
   <tr class="head">
    <td colspan="7">
	<div style="float:right">total {$count} &nbsp;&nbsp;</div>
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;<a href="/admin/column/content3.php?action=index&cid={$cid}">{$className}</a> &gt;&gt; {$contentName}</td>
   </tr>
<tr class="tr2">
    <td><span id="ordertid" class="st">ID<span id="orderpostdate" class="st"><img src="/admin/images/order_DESC.gif" /></span></span></td>
    <td>Photo</td>
    <td>Order</td>
    <td><span id="ordertitle" class="st">Describe</span></td>
    <td><span id="orderdigest" class="st">推荐</span></td>
    <td><span id="orderpostdate" class="st">添加时间</span></td>
    <td>操作</td>
  </tr>

{section name=s loop=$photoList}
  <tr class="tr3">
    <td><input name="ids[]" type="checkbox" id="sid_{$photoList[s].id}" value="{$photoList[s].id}">
      {$photoList[s].id|default:"&nbsp;"}</td>
    <td><img src="{$photoList[s].filepath}" width="100"/></td>
    <td><input name="taxis[{$photoList[s].id}]" type="text" class="input" id="taxis[{$photoList[s].id}]" value="{$photoList[s].order_list}" size="5" maxlength="2"></td>
    <td>
	<textarea name="describe[{$photoList[s].aid}]" cols="60" rows="3">{$photoList[s].fileintro}</textarea>
	</td>
    <td>
	{if $photoList[s].pic_type =='Relevant pictures' }
		<img src="{$smarty.const.URL}/admin/images/pub.gif" />
	{else}
		<a href="/admin/column/photo.php?action=edit&sp={fp id=$photoList[s].id tid=$photoList[s].tid mid=$photoList[s].mid filepath=$photoList[s].filepath}"><img src="{$smarty.const.URL}/admin/images/no_pub.gif" /></a>
	{/if}	</td>
    <td>{$photoList[s].uploadtime|date_format:"%Y-%m-%d"|default:"&nbsp;"}</td>
    <td>
<a href="/admin/column/photo.php?action=del&sp={fp id=$photoList[s].id aid=$photoList[s].aid filepath=$photoList[s].filepath}" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a></td>
  </tr>
{/section}
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>
    操作 : 
      <select name="option">
		<option value="order" >&raquo;Order</option>
		<option value="describe" >&raquo;Describe</option>
	</select>&nbsp;&nbsp;<input type="submit" name="Submit" value="提交" class="btn">
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
