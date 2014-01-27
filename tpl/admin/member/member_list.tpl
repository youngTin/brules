<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.FC114_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/admin/javascript/jquery_last.js"></script>
<script src="{$smarty.const.URL}/admin/javascript/admin.js"></script>
<script type="text/javascript" src="{$smarty.const.URL}/ui/js/datepicker/WdatePicker.js"></script>
</head>
<base target="mainFrame">
<body>
<div class="t" style="margin-top:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="frm_search2" method="GET" action="member.php" id="frm_search2">
    <tr id="advanced_search" class="tr4">
    <td colspan="2">
    <!---搜索框添加--->
    人员名称:<input type="text" name="username" value="{$username}" id="username" size="10" />&nbsp;&nbsp;
    电话:<input type="text" name="telephone" value="{$telephone}" size="10"  />&nbsp;&nbsp;
    状态标志:<select name="flag" id="flag">
          <option value="">全部</option>
            {html_options options=$flag_text selected=$flag}
          </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    注册时间：<input type="text" name="create_at" value="{$create_at}" onclick="WdatePicker();" />
    <input type="submit" name="Submit" value="搜索" class="btn" />
    </td>
    </form>
    </tr>
</table>
</div>
<form name="form1" id="form1" method="post" action="?action=deleteall">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="16">
      <span style="text-align:right; float:right;">今日登陆后台操作人数：{$act_count.cnt}人</span>    
      <div><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />会员信息</div></td>
  </tr>
  <tr class="tr2">
  	<td width='80px'>选择</td>
    <td width='200px'>用户名</td>
	<td width='100'>发布数量</td>
    <td width='220'>注册时间/最后登陆</td>
  	<td>操作</td>
  </tr>
{section name=s loop=$memberList}
<tr class="tr3 bgcolor">
  <td align="left"><input name="ids[]" type="checkbox" id="sid_{$memberList[s].uid}" value="{$memberList[s].uid}"></td>
  <td align="left" style="width:115px;">
  {$memberList[s].username}
  <br />{$memberList[s].tel}
  </td>
  <td align="left">{$memberList[s].taskcount|default:"0"}个</td>
  <td align="left">注:{$memberList[s].create_at|date_format:"%Y-%m-%d"|default:"0000-00-00"}<br>
  	登:{$memberList[s].logintime|date_format:"%Y-%m-%d %H:%I:%S"|default:"0000-00-00"}  </td>
  <td align="left">
      <a href="member.php?action=edit&member_id={$memberList[s].uid}&uid={$memberList[s].uid}" target="_self">修改</a>&nbsp;
      <a href="member.php?action=delete&member_id={$memberList[s].uid}&uid={$memberList[s].uid}" onclick='return window.confirm("您确认要删除!");'>删除</a>
  </td>
</tr>
{/section}
  {if $company_count}
  <tr>
  	<td colspan="6" align="right" class="tr4">该公司发布房源总量为：{$company_count.cnt}套</td>
  </tr>
  {/if}
</table>
</div>
<div class="t">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="tr4">
        <td>
        <input type="submit" value="全部删除" name="btn_del" onclick='return window.confirm("您确认要删除!");' class="btn">
        <input type="hidden" name="EditOption" value="{$EditOption}">
        </td>
        <td style="text-align:right">{$splitPageStr|default:"&nbsp;"}</td>
      </tr>
    </table>
</div>
</form>
{include file="../tpl/admin/footer.tpl"}