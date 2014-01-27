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
<form name="form1" method="post" action="fc114tgcard.php?action=save" onsubmit="return chkform();">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="99">
	<img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />{if $EditOption=="Edit"}修改{else}新增{/if}home_tg_card信息
	</td>
  </tr>
  
  <tr class="tr2">
    <td width="20%" style="text-align:center">字段名</td>
    <td width="60%" style="text-align:center">内容</td>
	<td width="20%" style="text-align:center">&nbsp;</td>
  </tr>
  
  			<input type="hidden" name="id" value="{$fc114tgcardInfo.id}" class="input" >
	  		<tr class="line">
	  <td>扩展会员ID(暂未使用):</td>
	  <td>
	  	  	  <input type="text" name="userid" value="{$fc114tgcardInfo.userid}" id="userid" class="input" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>姓名:</td>
	  <td>
	  	  	  <input type="text" name="name" value="{$fc114tgcardInfo.name}" id="name" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>身份证号:</td>
	  <td>
	  	  	  <input type="text" name="identity" value="{$fc114tgcardInfo.identity}" id="identity" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>电话:</td>
	  <td>
	  	  	  <input type="text" name="tel" value="{$fc114tgcardInfo.tel}" id="tel" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>地址:</td>
	  <td>
	  	  	  <input type="text" name="add" value="{$fc114tgcardInfo.add}" id="add" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>登记时间:</td>
	  <td>
	  	  	  <input type="text" name="input_time" value="{$fc114tgcardInfo.input_time}" id="input_time" class="input" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>登记ip:</td>
	  <td>
	  	  	  <input type="text" name="input_ip" value="{$fc114tgcardInfo.input_ip}" id="input_ip" class="input" >
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