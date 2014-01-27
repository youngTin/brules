<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Layout licence</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<!--jquery-->
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/ui/js/jquery_last.js"></script>
<!--日期控件-->
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/ui/js/datepicker/WdatePicker.js"></script>
</head>
<base target="mainFrame">
<body>
<div class="t" style="margin-top:5px;">
<table  width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr  class="head"><td align="left" colspan="4"><a href="member.php">用户管理列表</a> >> {if $EditOption=="Edit"}修改{else}新增{/if}用户管理信息</td></tr>
<form name="form1" method="post" action="member.php?action=save" onsubmit="return chkform();"> 

  <tr  class="tr2">
	<td width="15%" align="left">个人用户基本信息</td>
    <td width="35%" align="left">&nbsp;</td>
	<td width="15%" align="left">&nbsp;</td>
	<td width="35%" align="left">&nbsp;</td>
  </tr>


	<input type="hidden" name="uid" value="{$userInfo.uid}">
	 <tr  class="line">
	  <td align="right">登录名:</td>
	  <td>
	  	 <input type="text" name="username" value="{$userInfo.username}" id="username">
	 </td>
	  <td align="right">真实姓名:</td>
	  <td><input type="text" name="name" value="{$drInfo.linkman}" id="name"></td>
	</tr>
	 <tr class="line">
	  <td align="right">证件类型:</td>
	  <td>
	  	<select  name="card_type" value="{$userInfo.card_type}">
			<option value="身份证" {if $userInfo.card_type=='身份证'} selected="selected" {/if}>身份证</option>
			<option value="工作证" {if $userInfo.card_type=='工作证'} selected="selected" {/if}>工作证</option>
			<option value="护照" {if $userInfo.card_type=='护照'} selected="selected" {/if}>护照</option>
			<option value="经纪人证" {if $userInfo.card_type=='经纪人证'} selected="selected" {/if}>经纪人证</option>
			<option value="驾驶证" {if $userInfo.card_type=='驾驶证'} selected="selected" {/if}>驾驶证</option>
			<option value="其他" {if $userInfo.card_type=='其他'} selected="selected" {/if}>其他</option>
		</select>
	   <td align="right">身份证:</td>
		<td><input type="text" name="card_num" value="{$userInfo.card_num}" id="card_num" size="20" maxlength="18">	
		</td></td>
    </tr>
	<tr class="line">
	  <td align="right">性别:</td>
	  <td><select name="sex" id="sex">
		{html_options options=$userInfo.sex_text selected=$drInfo.sex}
	  </select>	</td>  	  	  	
	  <td align="right"></td>
	  <td>&nbsp; </td> 	  	
    </tr>

   <tr class="line">
      <td align="right">联系电话:</td>
      <td>
      <input type="text" name="tel" value="{$drInfo.tel}" id="tel">                 
     </td>
    <td align="right">电子邮箱:</td>
    <td><input type="text" name="email" value="{$drInfo.email}" id="email">    </td>
  </tr> <tr class="line">
      <td align="right">领证日期：</td>
      <td>
      <input type="text" name="licensdate" value="{$drInfo.licensdate}" id="licensdate">                 
     </td>
    <td align="right">证件类型:</td>
    <td>{html_radios radios=$crecate_radio name=crecate selected=$drInfo.crecate|default:1}    </td>
  </tr><tr class="line">
	  <td align="right">驾驶证号：</td>
	  <td>
	  <input type="text" name="licensid" value="{$drInfo.licensid}" id="licensid">	  	  	 
	 </td>
	<td align="right">档案编号：:</td>
	<td> <input type="text" name="fileno" value="{$drInfo.fileno}" id="fileno">	</td>
  </tr>
	<tr class="line">
	  <td align="right">联系地址:</td>
	  <td>
	  	  	  <input type="text" name="address" value="{$userInfo.address}" id="address">	  	  
	  </td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr class="line">
	  <td align="right">个人简介:</td>
	  <td colspan="10">
	  	  <textarea name="description" id="description" style="width:350px; height:100px;">{$userInfo.description}</textarea>
	  </td>

    </tr>

  <tr class="tr2">
	  <th colspan="1000" align="left">&nbsp;密码修改:</th>
  </tr>
  <tr class="line">
		<td align="right">&nbsp;初始密码:</td>
	  <td colspan="10">&nbsp;
	  	  <input type="password" name="password1" id="password1">	  	</td>

  </tr>
  	<tr class="line">
		<td align="right">&nbsp;确认密码:</td>
	  <td colspan="10">&nbsp;<input type="password" name="password2" id="password2" ></td>

	</tr>

  <tr class="tr2">
	  <td colspan="1000" align="left">&nbsp;权限修改信息</td>
  </tr>

	<input type="hidden" name="member_id" value="{$memberInfo.member_id}">
	<input type="hidden" name="uid" value="{$userInfo.uid}">
	<!--<input type="hidden" name="company_id" value="{$memberInfo.company_id}" >-->
	<tr class="line">
	  <td  align="right">&nbsp;会员类别:</td>
	  <td width="485" colspan="10">&nbsp;
	   <select name="user_type" id="user_type">
		{html_options options=$memberInfo.user_type_text selected=$userInfo.user_type}
	  </select>   	    
      </td>
    </tr>
	<tr class="line">
	  <td align="right">&nbsp;有效标志:</td>
	  <td colspan="10">&nbsp;
	  		{html_radios name="flag" options=$memberInfo.flag_text checked=$memberInfo.flag separator="&nbsp;"}	  	 </td>
    </tr>	
	<tr class="line">
	  <td align="right">&nbsp;注册时间:</td>
	  <td colspan="10">&nbsp;
	  	  		<input type="text" name="create_at" value="{$memberInfo.create_at|date_format:"%Y-%m-%d"}"  class="Wdate" id="create_at" disabled="disabled" >	  	  	  </td>
    </tr>
  <tr class="tr2">
      <td colspan="1000" align="left">&nbsp;积分信息</td>
  </tr>
    <tr class="line">
      <td align="right">&nbsp;个人积分:</td>
      <td colspan="10">&nbsp;<input type="text" name="total_integral" id="total_integral" value="{$memberInfo.total_integral}" /></td>
    </tr>
    
	  <tr>
          <td height="30" colspan="40" align="center">
	    <input type="hidden" name="UrlReferer" value="{$UrlReferer}">
	    <input type="hidden" name="EditOption" value="{$EditOption}">
	    <input type="submit" name="Submit" class="btn" value="{if $EditOption=="Edit"}修改{else}新增{/if}">
            <input type="reset" name="Submit2" class="btn" value=" 重添 ">
            <input type="button" name="Submit3" class="btn" value=" 返回 " onClick="history.back(-1);"></td>
  </tr>
</table>
</form>
{include file="../tpl/admin/footer.tpl"}