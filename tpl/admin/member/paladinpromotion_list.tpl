<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>推广思路</title>
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
	<form name="frm_search2" method="GET" action="paladinpromotion.php" id="frm_search2">
搜索：
<!---搜索框添加--->
	  	  	 项目id:
	  	  <input type="text" name="project_id" value="{$project_id}" id="project_id" />&nbsp;&nbsp;
	  	  	<!---结束--->
	 <input type="submit" name="Submit" value="显示" class="btn" />
	 </form>
		<a href="paladinpromotion.php?action=add"><input type="button" value="添加项目推广思路" class="btn" onclick="self.location='paladinpromotion.php?action=add'" /></a></td>
  </tr>
</table>
</div>


<form name="form1" id="form1" method="post" action="?action=deleteall">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="16">
	<div style="float:right"></div>
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;项目推广思路</td>
   </tr>
   <tr class="tr2">
    <td>选择<input name="checkbox" type="checkbox" onclick="CheckAll(document.form1);" value="全选" ></td>
	<td>项目名称</td>
    <td>推广类型</td>
    <td>推广思路</td>
    <td>推广时间</td>
    <td>最后修改时间</td>
    <td>发布人</td>
      <td>操作</td>
  </tr>

{section name=s loop=$paladinpromotionList}  
  <tr class="tr3">
  <td><input name="ids[]" type="checkbox" id="sid_{$paladinpromotionList[s].id}" value="{$paladinpromotionList[s].id}">
      {$paladinpromotionList[s].id|default:"&nbsp;"}</td>
  <td>{$paladinpromotionList[s].project_name|default:"&nbsp;"}</td>
  <td>{$paladinpromotionList[s].promotion_type|default:"&nbsp;"}</td>
  <td>{$paladinpromotionList[s].promotion_info|default:"&nbsp;"}</td>
  <td>{$paladinpromotionList[s].promotion_time|default:"&nbsp;"}</td>
  <td>{$paladinpromotionList[s].edit_at|date_format:'%Y-%m-%d'|default:"&nbsp;"}</td>
  <td>{$paladinpromotionList[s].user_name|default:"&nbsp;"}</td>
  <td>
<a href="paladinpromotion.php?action=edit&sp={fp id=$paladinpromotionList[s].id}"><img src="/admin/images/edit.gif" align="absmiddle" alt="编辑" /></a>
<a href="paladinpromotion.php?action=delete&sp={fp id=$paladinpromotionList[s].id}" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a>
<a href="#"></a>
<a href="#"></a>
<a href="#"></a></td>
  </tr>
{/section} 
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>
    <input name="action" type="hidden" id="action" value="deleteall" />
    <input type="button" name="Submit3" value="全选" class="btn" onclick="CheckAll(document.form1);" />
	<input type="submit" name="btn_del" value="全部删除" class="btn" onclick='return window.confirm("您确认要删除!");'>
	<input type="hidden" name="EditOption" value="{$EditOption}">
	</td>
    <td style="text-align:right">{$splitPageStr|default:"&nbsp;"}</td>
  </tr>
</table>
</div>
</form>
{literal}
<script>
function check(obj) {
	if($(obj).attr("checked")==true){
		$("#form1 input").attr("checked","checked");
	}else{
		$("#form1 input").attr("checked","");
	}
}
</script>
{/literal}
