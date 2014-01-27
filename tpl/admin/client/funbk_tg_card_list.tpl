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
	<form name="frm_search2" method="GET" action="funbk_tg_card.php" id="frm_search2">
搜索：
<!---搜索框添加--->
	  	  	 姓名:
	  	  <input type="text" name="name" value="{$name}" id="name" />&nbsp;&nbsp;
	   	    
	  	  	 身份证号:
	  	  <input type="text" name="identity" value="{$identity}" id="identity" />&nbsp;&nbsp;
	   	    
	  	  	 电话:
	  	  <input type="text" name="tel" value="{$tel}" id="tel" />&nbsp;&nbsp;
	   	    
	  	  	<!---结束--->
	 <input type="submit" name="Submit" value="显示" class="btn" />
	 </form>
		<!--a href="funbk_tg_card.php?action=add"><input type="button" value="添加新home_tg_card" class="btn" onclick="self.location='funbk_tg_card.php?action=add'" /></a--> 
	  </td>
  </tr>
</table>
</div>


<form name="form1" id="form1" method="post" action="?action=deleteall">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="9">
	<div style="float:right">内容合计 total，其中未发布内容 new 条</div>
    <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />置业卡客户信息</td>
   </tr>
   <tr class="tr2">
    <td>选择<input name="checkbox" type="checkbox" onclick="CheckAll(document.form1);" value="全选" ></td>
    <td>自增ID</td>
    <td>姓名</td>
    <td>身份证号</td>
    <td>电话</td>
    <td>地址</td>
    <td>登记时间</td>
    <td>登记ip</td>
      <td>操作</td>
  </tr>

{section name=s loop=$fc114tgcardList}  
  <tr class="tr3">
    <td><input name="ids[]" type="checkbox" id="sid_{$fc114tgcardList[s].id}" value="{$fc114tgcardList[s].id}"></td>
    <td>{$fc114tgcardList[s].id|default:"&nbsp;"}</td>
  <td>{$fc114tgcardList[s].name|default:"&nbsp;"}</td>
  <td>{$fc114tgcardList[s].identity|default:"&nbsp;"}</td>
  <td>{$fc114tgcardList[s].tel|default:"&nbsp;"}</td>
  <td>{$fc114tgcardList[s].add|default:"&nbsp;"}</td>
  <td>{$fc114tgcardList[s].input_time|date_format:'%Y-%m-%d %H:%M'}</td>
  <td>{$fc114tgcardList[s].input_ip|default:"&nbsp;"}</td>
  <td>
<a href="funbk_tg_card.php?action=edit&sp={fp id=$fc114tgcardList[s].id}"><img src="/admin/images/edit.gif" align="absmiddle" alt="编辑" /></a>
<a href="funbk_tg_card.php?action=delete&sp={fp id=$fc114tgcardList[s].id}" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a></td>
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
