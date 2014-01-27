<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.WEB_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<!--jquery-->
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/scripts/formValidator/jquery_last.js"></script>
<script src="{$smarty.const.URL}/scripts/admin.js"></script>
</head>
<base target="mainFrame">
<body style="margin-top:10px;">

<div class="t">
<table align=center cellspacing=0 cellpadding=0>
<tr class=tr2>
  <td>会员充值</td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr class="line">
  <td>用户名:{$fc114userInfo.username}</td>
  <td>会员类型：{$fc114userInfo.user_type}</td>
  <td rowspan="4"> <div style="height:135px; width:97%; background:#E6E6E6; border:1px #CCCCCC solid; padding:15px 0 0 15px;">
    {if $fc114userInfo.flag==0}
		<a href="fc114member.php?action=showMember&uid={$fc114userInfo.uid}" style="color:#FF0000; font-weight:bold">[该用户未通过审核不能进行充值,点击进入审核]。</a>
	{else}
		<form name="form1" method="post" action="fc114user.php?action=save">
		<input type="hidden" name="uid" value="{$fc114userInfo.uid}" class="input" >
		<span style="color:red">注意：充值金额不允许为负数！</span><br /><br />
		请输入充值金额：<input type="text" name="money" id="money" value=""/><br /><br />
		<input type="submit" name="Submit" value="{if $EditOption=="Edit"}修改{else}提交{/if}" class="btn">
		<input type="button" name="Submit3" value="返回"  class="btn" onClick="history.back(-1);">
		</form>
	{/if}
  </div></td>
</tr>
<tr class="line">
  <td>qq:{$fc114userInfo.qq}</td>
  <td>邮箱:{$fc114userInfo.email}</td>
  </tr>
<tr class="line">
  <td>电话:{$fc114userInfo.telephone}</td>
  <td>公司名:{$fc114userInfo.company_name}</td>
  </tr>
<tr class="line">
  <td>真实姓名:{$fc114userInfo.name}</td>
  <td>身份证号:{$fc114userInfo.card_num}</td>
  </tr>
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="99">
	<img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;会员充值记录</td>
  </tr>
  
  <tr class="tr2">
    <td>充值金额</td>
	<td>充值时间</td>
	<td>充值人</td>
	</tr>
</table>
</div>

{include file="../tpl/admin/footer.tpl"}