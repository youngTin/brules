<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.WEB_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<base target="mainFrame">
<body>
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td style="text-align:left">
	<form name="frm_search2" method="GET" action="manager.php" id="frm_search2">
搜索：
<!---搜索框添加--->
	  	  	 管理员:
	  	  <input type="text" name="username" value="{$username}" id="username" />&nbsp;&nbsp;
	   	  <!---结束--->
	 <input type="submit" name="Submit" value="查看管理员" class="btn" />
	 </form>
		<input type="button" value="添加管理员" class="btn" onclick="self.location='manager.php?action=add'" /></td>
  </tr>
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="16">
	<div style="float:right"></div>
    <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;
	编辑管理员
	</td>
   </tr>
   <tr class="tr2">
    <td width="5%">&nbsp;</td>
	<td>UID</td>
    <td>管理员</td>
    <td>ip</td>
    <td>上次登录时间</td>
      <td>操作</td>
  </tr>

{section name=s loop=$List}  
  <tr class="tr3 bgcolor">
  <td><img src="/admin/images/admin.gif" align="absmiddle" /></td>
  <td>{$List[s].uid}</td>
  <td>{$List[s].username|default:"&nbsp;"}{if $List[s].isadmin == 1}<span style="color:#00CCCC">&nbsp;最高管理员</span>{/if}</td>
  <td>{$List[s].ip|default:"&nbsp;"}</td>
  <td>{$List[s].logintime|date_format:'%Y-%m-%d %H:%M:%S'|default:"&nbsp;"}</td>
  <td>
<a href="manager.php?action=edit&sp={fp uid=$List[s].uid username=$List[s].username}"><img src="/admin/images/edit.gif" align="absmiddle" alt="编辑" /></a>
{if $List[s].isadmin != 1}
<a href="manager.php?action=del&sp={fp uid=$List[s].uid}" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a>
{/if}
  </td>
  </tr>
{/section} 
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>&nbsp;</td>
    <td style="text-align:right">{$splitPageStr|default:"&nbsp;"}</td>
  </tr>
</table>
</div>
{include file="../tpl/admin/footer.tpl"}