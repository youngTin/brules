<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.WEB_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/scripts/jquery_last.js"></script>
</head>
<base target="mainFrame">
<body style="margin-top:5px;">
<form name="form1" method="post" action="fc114tgsubscribe.php?action=save" onsubmit="return chkform();">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="99">
	<img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />{if $EditOption=="Edit"}修改{else}新增{/if}home_tg_subscribe信息
	</td>
  </tr>
  
  <tr class="tr2">
    <td width="20%" style="text-align:center">字段名</td>
    <td width="60%" style="text-align:center">内容</td>
	<td width="20%" style="text-align:center">&nbsp;</td>
  </tr>
  
  			<input type="hidden" name="id" value="{$fc114tgsubscribeInfo.id}" class="input" >
	  		<tr class="line">
	  <td>态状 0为意向 1为订阅:</td>
	  <td>
	  		{html_radios name="state" options=$fc114tgsubscribeInfo.state_text checked=$fc114tgsubscribeInfo.state separator="&nbsp;"}
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>手机：</td>
	  <td>
	  	  	  <input type="text" name="mobile" value="{$fc114tgsubscribeInfo.mobile}" id="mobile" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>提交时间：</td>
	  <td>
	  	  	  <input type="text" name="create_at" value="{$fc114tgsubscribeInfo.create_at}" id="create_at" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>客户ip：</td>
	  <td>
	  	  	  <input type="text" name="input_ip" value="{$fc114tgsubscribeInfo.input_ip}" id="input_ip" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>项目名称：</td>
	  <td>
	  	  	  <input type="text" name="layout_name" value="{$fc114tgsubscribeInfo.layout_name}" id="layout_name" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>购买时间：</td>
	  <td>
	  	  	  <input type="text" name="buy_time" value="{$fc114tgsubscribeInfo.buy_time}" id="buy_time" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>客户姓名：</td>
	  <td>
	  	  	  <input type="text" name="name" value="{$fc114tgsubscribeInfo.name}" id="name" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>客户电话：</td>
	  <td>
	  	  	  <input type="text" name="tel" value="{$fc114tgsubscribeInfo.tel}" id="tel" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  </table>
</div>

<div class="sub">
<input type="hidden" name="UrlReferer" value="{$UrlReferer|default:$smarty.const.URL}">
<input type="hidden" name="EditOption" value="{$EditOption}">
<!--input type="submit" name="Submit" value="{if $EditOption=="Edit"}修改{else}提交{/if}" class="btn">
<input type="reset" name="Submit2" value="重置" class="btn"-->
<input type="button" name="Submit3" value="返回"  class="btn" onClick="history.back(-1);">
</div>
</form>