<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.WEB_TITLE}</title>
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
	<form name="frm_search2" method="GET" action="paladinconsensus.php" id="frm_search2">
<!---搜索框添加--->
	  	  	 项目名称:
	  	  <select name="project_id" id="project_id">
		  <option value="">全部</option>
			{html_options options=$project_id_text selected=$project_id}
		  </select>&nbsp;&nbsp;
	  	  	<!---结束--->
	 <input type="submit" name="Submit" value="显示" class="btn" />
	 </form>
	<a href="paladinconsensus.php?action=add"><input type="button" value="添加新舆论" class="btn" onclick="self.location='paladinconsensus.php?action=add'" /></a></td>
  </tr>
</table>
</div>


<form name="form1" id="form1" method="post" action="?action=deleteall">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="16">
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;&nbsp;舆论管理</td>
   </tr>
   <tr class="tr2">
    <td>选择id
      <input name="checkbox" type="checkbox" onclick="CheckAll(document.form1);" value="全选" ></td>
    <td>&nbsp;</td>
    <td>项目名称</td>
    <td>舆论主题</td>
    <td>舆论标题</td>
    <td>舆论网址</td>
    <td>舆论网站</td>
    <td>舆论状态</td>
    <td>舆论处理方式</td>
    <td>创建时间</td>
    <td>&nbsp;</td>
      <td>操作</td>
  </tr>

{section name=s loop=$paladinconsensusList}  
  <tr class="tr3">
    <td><input name="ids[]" type="checkbox" id="sid_{$paladinconsensusList[s].id}" value="{$paladinconsensusList[s].id}">
      {$paladinconsensusList[s].id|default:"&nbsp;"}</td>
    <td>&nbsp;</td>
  <td>{$paladinconsensusList[s].project_name|default:"&nbsp;"}</td>
  <td>{$paladinconsensusList[s].consensus_theme|default:"&nbsp;"}</td>
  <td>{$paladinconsensusList[s].consensus_title|default:"&nbsp;"}</td>
  <td>{$paladinconsensusList[s].consensus_url|default:"&nbsp;"}</td>
  <td>{$paladinconsensusList[s].consensus_website|default:"&nbsp;"}</td>
  <td>{$paladinconsensusList[s].consensus_status|default:"&nbsp;"}</td>
  <td>{$paladinconsensusList[s].consensus_type|default:"&nbsp;"}</td>
  <td>{$paladinconsensusList[s].create_at|date_format:'%Y-%m-%d'|default:"&nbsp;"}</td>
  <td>{$paladinconsensusList[s].user_id|default:"&nbsp;"}</td>
  <td>
<a href="paladinconsensus.php?action=edit&sp={fp id=$paladinconsensusList[s].id}"><img src="/admin/images/edit.gif" align="absmiddle" alt="编辑" /></a>
<a href="paladinconsensus.php?action=delete&sp={fp id=$paladinconsensusList[s].id}" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a></td>
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
