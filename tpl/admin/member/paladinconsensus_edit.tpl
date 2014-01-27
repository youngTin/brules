<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.WEB_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<base target="mainFrame">
<body style="margin-top:5px;">
<form name="form1" method="post" action="paladinconsensus.php?action=save" onsubmit="return chkform();">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="99">
	<img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />{if $EditOption=="Edit"}修改{else}新增{/if}paladin_consensus信息
	</td>
  </tr>
  
  <tr class="tr2">
    <td width="20%" style="text-align:center">字段名</td>
    <td width="60%" style="text-align:center">内容</td>
	<td width="20%" style="text-align:center">&nbsp;</td>
  </tr>
  
  			<input type="hidden" name="id" value="{$paladinconsensusInfo.id}" class="input" >
	  		<tr class="line">
	  <td>选择项目:</td>
	  <td>
	   <select name="project_id" id="project_id" class="input" >
		{html_options options=$paladinconsensusInfo.project_text selected=$paladinconsensusInfo.project_id}
	  </select>	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>舆论主题:</td>
	  <td>
	  	  	  <input type="text" name="consensus_theme" value="{$paladinconsensusInfo.consensus_theme}" id="consensus_theme" class="input" style="width:270px" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>舆论标题:</td>
	  <td>
	  	  	  <input type="text" name="consensus_title" value="{$paladinconsensusInfo.consensus_title}" id="consensus_title" class="input" style="width:270px" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>舆论网址:</td>
	  <td>
	  	  	  <input type="text" name="consensus_url" value="{$paladinconsensusInfo.consensus_url}" id="consensus_url" class="input" style="width:270px" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>舆论网站:</td>
	  <td>
	  	  	  <input type="text" name="consensus_website" value="{$paladinconsensusInfo.consensus_website}" id="consensus_website" class="input" style="width:270px" >
	  	   	    
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>舆论状态:</td>
	  <td>
	  	  	  <input type="text" name="consensus_status" value="{$paladinconsensusInfo.consensus_status}" id="consensus_status" class="input" style="width:270px" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>舆论处理方式:</td>
	  <td>
	  	  	  <input type="text" name="consensus_type" value="{$paladinconsensusInfo.consensus_type}" id="consensus_type" class="input" style="width:270px" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	{if $EditOption=='Edit'}
	  		<tr class="line">
	  <td>录入时间:</td>
	  <td>
	  	  	  <input type="text" name="create_at" value="{$paladinconsensusInfo.create_at|date_format:'%Y-%m-%d'}" id="create_at" class="input" disabled="disabled" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>录入人员:</td>
	  <td>
	  	  	  <input type="text" name="user_id" value="{$paladinconsensusInfo.user_id}" id="user_id" class="input" disabled="disabled" >
	  	   	    
	   
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