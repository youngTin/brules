<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.WEB_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="/scripts/formValidator/jquery_last.js"></script>
<script src="/scripts/admin.js"></script>
</head>
<base target="mainFrame">
<body style="margin-top:5px;">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td style="text-align:left">
	<form name="frm_search2" method="GET" action="paladinposts.php" id="frm_search2">
搜索：
<!---搜索框添加--->
	  	  	 帖子名称:
	  	  <input type="text" name="posts_name" value="{$posts_name}" id="posts_name" />&nbsp;&nbsp;
	  	  	 帖子所属网站
			  <select name="posts_website" id="posts_website">
			  <option value="">全部</option>
				{html_options options=$house_media_text selected=$posts_website}
			  </select>&nbsp;&nbsp;
			  项目名称:
			  <select name="project_id" id="project_id">
			  <option value="">全部</option>
				{html_options options=$project_id_text selected=$project_id}
			  </select>&nbsp;&nbsp;
	  	  	 有效标志:
			  <select name="flag" id="flag">
			  <option value="">全部</option>
				{html_options options=$flag_text selected=$flag}
			  </select>&nbsp;&nbsp;
	  	  	<!---结束--->
	 <input type="submit" name="Submit" value="显示" class="btn" />
	 </form>
		<a href="paladinposts.php?action=add"><input type="button" value="添加帖子" class="btn" onclick="self.location='paladinposts.php?action=add'" /></a> 
	  </td>
  </tr>
</table>
</div>


<form name="form1" id="form1" method="post" action="?action=deleteall">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="16">
	<div style="float:right">内容合计 total，其中未发布内容 new 条</div>
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" /></td>
   </tr>
   <tr class="tr2">
    <td>选择<input name="checkbox" type="checkbox" onclick="CheckAll(document.form1);" value="全选" >id</td>
    <td>帖子名称</td>
    <td>帖子所属网站</td>
    <td>帖子点击量</td>
    <td>帖子是否置顶</td>
    <td>录入人员</td>
    <td>有效标志</td>
	<td>录入时间</td>
    <td>操作</td>
  </tr>

{section name=s loop=$paladinpostsList}  
  <tr class="tr3">
    <td><input name="ids[]" type="checkbox" id="sid_{$paladinpostsList[s].id}" value="{$paladinpostsList[s].id}">{$paladinpostsList[s].id|default:"&nbsp;"}</td>
  <td><a href='{$paladinpostsList[s].posts_url|default:"&nbsp;"}' target="_blank" title="点击进入帖子">{$paladinpostsList[s].posts_name|default:"&nbsp;"}</a></td>
  <td>{$paladinpostsList[s].posts_website|default:"&nbsp;"}</td>
  <td>{$paladinpostsList[s].posts_hit|default:"&nbsp;"}</td>
  <td>{$paladinpostsList[s].posts_top|default:"&nbsp;"}</td>
  <td>{$paladinpostsList[s].user_id|default:"&nbsp;"}</td>
  <td>{$paladinpostsList[s].flag|default:"&nbsp;"}</td>
  <td>{$paladinpostsList[s].create_at|date_format:"%Y-%m-%d"|default:"&nbsp;"}</td>
  <td>
<a href="paladinposts.php?action=edit&sp={fp id=$paladinpostsList[s].id}"><img src="/admin/images/edit.gif" align="absmiddle" alt="编辑" /></a>
<a href="paladinposts.php?action=delete&sp={fp id=$paladinpostsList[s].id}" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a>
</td>
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
