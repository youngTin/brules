<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LD-managerEdit</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script src="{$smarty.const.URL}/scripts/admin.js"></script>
<!--jquery-->
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/scripts/formValidator/jquery_last.js"></script>

</head>
{literal}
<script type="text/javascript" >
$(document).ready(function(){
	$.formValidator.initConfig({formid:"form1",onerror:function(){alert("校验没有通过，具体错误请看错误提示")}});
	});
</script>
{/literal}


<base target="mainFrame">
<body>
<div class="t" style="margin-top:5px">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td style="text-align:left">
	 <input type="submit" name="Submit" value="查看管理员" class="btn" onclick="self.location='manager.php'" />
	 <input type="button" value="添加管理员" class="btn" onclick="self.location='manager.php?action=add'" /></td>
  </tr>
</table>
</div>

<form name="form1" method="post" action="manager.php?action=save" onsubmit="return chkform();">
<input type="hidden" name="uid" value="{$managerInfo.uid}" class="input" >
<div class="t" style="width:50%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="2">
	{if $EditOption=="edit"}修改{else}新增{/if}管理员</td>
  </tr>
   <tr class="line">
	  <td width="25%">管理员账号:</td>
	  <td width="75%"><input type="text" name="username" value="{$managerInfo.username}" id="username" class="input" {if $EditOption=='edit'}disabled="disabled"{/if} /></td>
    </tr>
	 <tr class="line">
	  <td>{if $EditOption=='edit'}新密码{else}管理员密码:{/if}</td>
	  <td><input type="text" name="password" value="" id="re_password" class="input" >&nbsp;{if $EditOption=='edit'}不输入密码，表示不修改{/if}</td>
    </tr>
	 <tr class="line">
	  <td>密码确认:</td>
	  <td><input type="text" name="re_password" value="" id="re_password" class="input" ></td>
    </tr>
</table>
</div>

<div class="t" style="width:50%">
<table border="0" cellspacing="0" cellpadding="0">
<tr class="head">
  <td colspan="2">权限设置</td>
</tr>
{section name=a loop=$categoryInfo}
	<tr class="tr2">
	  <td colspan="2">{$categoryInfo[a].name}
	  <!--<input name='set_category[][{$categoryInfo[a].id}]' id="p_category{$categoryInfo[a].id}" type="checkbox" value="{$categoryInfo[a].id}" />-->
	  </td>
	</tr>
	{section name=b loop=$categoryInfo[a].child}
	<tr class="line">
	  <td>{$categoryInfo[a].child[b].name}</td>
	  <td><input name="set_category[]" type="checkbox" value="{$categoryInfo[a].child[b].id}" {if $categoryInfo[a].child[b].check=='true'}checked="checked"{/if} /></td>
	</tr>
	{/section}
{/section}


<tr class="tr2">
<td colspan="2">栏目权限</td>
</tr>
<tr class="line">
	<td>
      请选择栏目
    </td>
    <td>
      <select name="privcate[]" size="10" multiple id="privcate">
	  {foreach item=contact from=$columnInfo}
			<option value="{$contact.id}" {if $contact.check=='true'}selected="selected"{/if}>&raquo;{$contact.name}</option>
			{foreach item=item from=$contact.child}
				<option value="{$item.id}" {if $item.check=='true'}selected="selected"{/if}>|---{$item.name}</option>
				{foreach item=item2 from=$item.child}
				<option value="{$item2.id}" {if $item2.check=='true'}selected="selected"{/if}>|------{$item2.name}</option>
				{/foreach}
			{/foreach}
		{/foreach}
	  </select>
	  (按住Ctrl键进行多选操作)
    </td>
</tr>

</table>
</div>
<br /><br />
<center>
<input type="hidden" name="UrlReferer" value="{$UrlReferer|default:$smarty.const.URL}">
<input type="hidden" name="EditOption" value="{$EditOption}">
<input type="submit" name="Submit" value="{if $EditOption=="Edit"}修改{else}提交{/if}" class="btn">
<input type="reset" name="Submit2" value="重置" class="btn">
<input type="button" name="Submit3" value="返回"  class="btn" onClick="history.back(-1);">
</center>
<br /><br />
</form>
{include file="../tpl/admin/footer.tpl"}