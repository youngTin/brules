<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>新增推广思路</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<base target="mainFrame">
<body style="margin-top:5px;">
<form name="form1" method="post" action="paladinpromotion.php?action=save" onsubmit="return chkform();">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="99">
	<img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;{if $EditOption=="Edit"}修改{else}新增{/if}项目推广思路信息
	</td>
  </tr>
  
  <tr class="tr2">
    <td width="20%" style="text-align:center">字段名</td>
    <td width="60%" style="text-align:center">内容</td>
	<td width="20%" style="text-align:center">&nbsp;</td>
  </tr>
  
  			<input type="hidden" name="id" value="{$paladinpromotionInfo.id}" class="input" >
	  		<tr class="line">
	  <td>项目:</td>
	  <td>
			  <select name="project_id" id="project_id" class="input" >
		{html_options options=$paladinpromotionInfo.project_text selected=$paladinpromotionInfo.project_id}
	  </select>   	    
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>推广思路:</td>
	  <td>
	  	   	  <textarea name="promotion_info" id="promotion_info" cols="75" rows="12">{$paladinpromotionInfo.promotion_info}</textarea>
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>推广时间:</td>
	  <td>
	  	  	  <input type="text" name="promotion_time" value="{$paladinpromotionInfo.promotion_time}" id="promotion_time" class="input" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>推广形式:</td>
	  <td>
	  	  	  <input type="text" name="promotion_type" value="{$paladinpromotionInfo.promotion_type}" id="promotion_type" class="input" >   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	{if $EditOption=='Edit'}
	  		<tr class="line">
	  <td>创建时间:</td>
	  <td>
	  	  	  <input type="text" name="create_at" value="{$paladinpromotionInfo.create_at|date_format:'%Y-%m-%d'}" id="create_at" class="input" disabled="disabled" >   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>修改时间:</td>
	  <td>
	  	  	  <input type="text" name="edit_at" value="{$paladinpromotionInfo.edit_at|date_format:'%Y-%m-%d'}" id="edit_at" class="input" disabled="disabled" >
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>发布人:</td>
	  <td>
	  	  	  <input type="text" name="user_name" value="{$paladinpromotionInfo.user_name}" id="user_name" class="input" disabled="disabled"  >
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	{/if}
	  </table>
</div>

<div class="sub">
<input type="hidden" name="UrlReferer" value="{$UrlReferer|default:$smarty.const.URL}">
<input type="hidden" name="EditOption" value="{$EditOption}">
<input type="submit" name="Submit" value="{if $EditOption=="Edit"}修改{else}提交{/if}" class="btn">
<input type="reset" name="Submit2" value="重置" class="btn">
<input type="button" name="Submit3" value="返回"  class="btn" onClick="history.back(-1);">
</div>
</form>