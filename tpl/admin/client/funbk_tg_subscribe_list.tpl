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
<body>
<div class="t" style="margin-top:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td style="text-align:left">
	<form name="frm_search2" method="GET" action="/admin/client/funbk_tg_subscribe.php" id="frm_search2">
搜索：
<!---搜索框添加--->
	  	  	 态状 0为意向 1为订阅:
	  	  	  <select name="state" id="state">
	  <option value="">全部</option>
		{html_options options=$state_text selected=$state}
	  </select>&nbsp;&nbsp;
项目名称: <input type="text" name="layout_name" value="{$layout_name}" id="layout_name" />&nbsp;&nbsp;
	  	  	<!---结束--->
	 <input type="submit" name="Submit" value="显示" class="btn" />
	 </form>
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
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />团购客户信息</td>
   </tr>
   <tr class="tr2">
    <td>选择<input name="checkbox" type="checkbox" onclick="CheckAll(document.form1);" value="全选" ></td>
    <td>项目名称</td>
    <td>态状</td>
    <td>手机</td>
    <td>提交时间</td>
    <td>客户ip</td>
    <td>购买时间</td>
    <td>客户姓名</td>
    <td>电话</td>
      <td>操作</td>
  </tr>

{section name=s loop=$fc114tgsubscribeList}  
  <tr class="tr3">
    <td><input name="ids[]" type="checkbox" id="sid_{$fc114tgsubscribeList[s].id}" value="{$fc114tgsubscribeList[s].id}">
      {$fc114tgsubscribeList[s].id|default:"&nbsp;"}</td>
    <td>{$fc114tgsubscribeList[s].layout_name|default:"&nbsp;"}</td>
  <td>{$fc114tgsubscribeList[s].state_text|default:"&nbsp;"}</td>
  <td>{$fc114tgsubscribeList[s].mobile|default:"&nbsp;"}</td>
  <td>{$fc114tgsubscribeList[s].create_at|default:"&nbsp;"}</td>
  <td>{$fc114tgsubscribeList[s].input_ip|default:"&nbsp;"}</td>
  <td>{$fc114tgsubscribeList[s].buy_time|default:"&nbsp;"}</td>
  <td>{$fc114tgsubscribeList[s].name|default:"&nbsp;"}</td>
  <td>{$fc114tgsubscribeList[s].tel|default:"&nbsp;"}</td>
  <td>
<a href="/admin/client/funbk_tg_subscribe.php?action=edit&sp={fp id=$fc114tgsubscribeList[s].id}"><img src="/admin/images/edit.gif" align="absmiddle" alt="编辑" /></a>
<a href="/admin/client/funbk_tg_subscribe.php?action=delete&sp={fp id=$fc114tgsubscribeList[s].id}" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a></td>
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
