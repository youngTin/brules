<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>项目新闻</title>
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
	<form name="frm_search2" method="GET" action="paladinprojectnews.php" id="frm_search2">
<!---搜索框添加--->
	  	  	 项目名称:
	  	  	  <select name="project_id" id="project_id">
	  <option value="">全部</option>
		{html_options options=$project_id_text selected=$project_id}
	  </select>&nbsp;&nbsp;
	    
	  	  	 新闻标题:
	  	  <input type="text" name="news_title" value="{$news_title}" id="news_title" />&nbsp;&nbsp;
	   	    
	  	  	 新闻类型:
	  	  	  <select name="news_type" id="news_type">
	  <option value="">全部</option>
		{html_options options=$news_type_text selected=$news_type}
	  </select>&nbsp;&nbsp;
	  	  	<!---结束--->
	 <input type="submit" name="Submit" value="显示" class="btn" />
	 </form>
		<!--a href="paladinprojectnews.php?action=add"><input type="button" value="添加新paladin_project_news" class="btn" onclick="self.location='paladinprojectnews.php?action=add'" /></a--></td>
  </tr>
</table>
</div>


<form name="form1" id="form1" method="post" action="?action=deleteall">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="16">
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;&nbsp;新闻管理</td>
   </tr>
   <tr class="tr2">
    <td>选择id 
      <input name="checkbox" type="checkbox" onclick="CheckAll(document.form1);" value="全选" ></td>
    <td>项目</td>
    <td>新闻标题</td>
    <td>新闻类型</td>
    <td>新闻副标题</td>
    <td>新闻简介</td>
    <td>新闻内容</td>
    <td>备注</td>
    <td>录入人员</td>
    <td>录入时间</td>
      <td>操作</td>
  </tr>

{section name=s loop=$paladinprojectnewsList}  
  <tr class="tr3">
    <td><input name="ids[]" type="checkbox" id="sid_{$paladinprojectnewsList[s].id}" value="{$paladinprojectnewsList[s].id}">
      {$paladinprojectnewsList[s].id|default:"&nbsp;"}</td>
  <td>{$paladinprojectnewsList[s].project_name|default:"&nbsp;"}</td>
  <td>{$paladinprojectnewsList[s].news_title|default:"&nbsp;"}</td>
  <td>{$paladinprojectnewsList[s].news_type_text|default:"&nbsp;"}</td>
  <td>{$paladinprojectnewsList[s].news_subhead|default:"&nbsp;"}</td>
  <td>{$paladinprojectnewsList[s].news_brief|default:"&nbsp;"}</td>
  <td>{$paladinprojectnewsList[s].news_content|default:"&nbsp;"}</td>
  <td>{$paladinprojectnewsList[s].remark|default:"&nbsp;"}</td>
  <td>{$paladinprojectnewsList[s].user_id|default:"&nbsp;"}</td>
  <td>{$paladinprojectnewsList[s].create_at|date_format:'%Y-%m-%d'|default:"&nbsp;"}</td>
  <td>
<a href="paladinprojectnews.php?action=edit&sp={fp id=$paladinprojectnewsList[s].id}">编辑</a>&nbsp;|
<a href="#">发送email</a></td>
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
