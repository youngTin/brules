<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>楼盘管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/scripts/formValidator/jquery_last.js"></script>
<script src="{$smarty.const.URL}/scripts/admin.js"></script>
</head>
<base target="mainFrame">
<body style="margin-top:5px;">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td style="text-align:left">
	<form name="frm_search2" method="GET" action="paladinproject.php" id="frm_search2">	    
	 项目名称:<input type="text" name="project_name" value="{$project_name}" id="project_name" />&nbsp;&nbsp;
	 所在城区:<select name="borough" id="borough">
	          <option value="">全部</option>
		     {html_options options=$borough_text selected=$borough}
	         </select>&nbsp;&nbsp;
	 <input type="submit" name="Submit" value="显示" class="btn" />
	 </form>
     <!--input type="button" value="新添楼盘" class="btn" onclick="self.location='layout.php?action=add'" /--></td>
  </tr>
</table>
</div>

<form name="form1" id="form1" method="post" action="?action=order">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="5"><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />楼盘中心</td>
   </tr>
   <tr class="tr2">
    <td width="10%">选择<input name="checkbox" type=checkbox onClick="CheckAll(document.form1);" value="全选" /></td>
    <td width="25%">项目名称</td>
	<td width="10%">项目负责人</td>
	<td width="10%">项目电话</td>
    <td width="45%">操作</td>
  </tr>

{section name=s loop=$projectList}  
  <tr class="tr3 bgcolor">
  <td><input name="ids[]" type="checkbox" id="sid_{$projectList[s].id}" value="{$projectList[s].id}">
      {$projectList[s].id|default:"&nbsp;"}</td>
  <td align="left">
   {$projectList[s].project_name|default:"&nbsp;"}
	<br /><span style="color:#999999" title="{$projectList[s].project_address}">地址：{$projectList[s].project_address|default:"&nbsp;"|truncate_utf8:"34"}</span>  </td>
  <td>{$projectList[s].project_person|default:"&nbsp;"|truncate_utf8:"34"}</td>
  <td>{$projectList[s].project_person_tel|default:"&nbsp;"|truncate_utf8:"34"}</td>
  <td>
<a href="paladinprojectnews.php?action=index&project_id={$projectList[s].id}">查看新闻</a> | 
<a href="paladinposts.php?action=index&project_id={$projectList[s].id}">查看帖子</a> | 
<a href="paladinconsensus.php?action=index&project_id={$projectList[s].id}">舆论监测</a> | 
<a href="/admin/member/paladinproject.php?action=edit&id={$projectList[s].id}">查看项目信息</a> 
</td>
  </tr>
{/section} 
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td><input type="submit" name="Submit" value="提交" class="btn"></td>
    <td style="text-align:right">{$splitPageStr|default:"&nbsp;"}</td>
  </tr>
</table>
</div>
</form>
{include file="../tpl/admin/footer.tpl"}

</body>
</html>