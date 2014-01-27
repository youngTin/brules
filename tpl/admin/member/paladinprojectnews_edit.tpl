<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>新增新闻</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<base target="mainFrame">
<body style="margin-top:5px;">
<form name="form1" method="post" action="paladinprojectnews.php?action=save" onsubmit="return chkform();">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="99">
	<img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />{if $EditOption=="Edit"}修改{else}新增{/if}paladin_project_news信息
	</td>
  </tr>
  
  <tr class="tr2">
    <td width="20%" style="text-align:center">字段名</td>
    <td width="60%" style="text-align:center">内容</td>
	<td width="20%" style="text-align:center">&nbsp;</td>
  </tr>
  
  			<input type="hidden" name="id" value="{$paladinprojectnewsInfo.id}" class="input" >
	  		<tr class="line">
	  <td>项目id:</td>
	  <td>
	  	  	  	  <select name="project_id" id="project_id" class="input" >
		{html_options options=$paladinprojectnewsInfo.project_text selected=$paladinprojectnewsInfo.project_id}
	  </select>
	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>新闻标题:</td>
	  <td>
	  	  	  <input type="text" name="news_title" value="{$paladinprojectnewsInfo.news_title}" id="news_title" class="input" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>新闻类型:</td>
	  <td>
	  	  	  	  <select name="news_type" id="news_type" class="input" >
		{html_options options=$paladinprojectnewsInfo.news_type_text selected=$paladinprojectnewsInfo.news_type}
	  </select>
	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>新闻副标题:</td>
	  <td>
	  	  	  <input type="text" name="news_subhead" value="{$paladinprojectnewsInfo.news_subhead}" id="news_subhead" class="input" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>新闻简介:</td>
	  <td>
	  	  	  <input type="text" name="news_brief" value="{$paladinprojectnewsInfo.news_brief}" id="news_brief" class="input" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>新闻内容:</td>
	  <td>
	  	  	  <input type="text" name="news_content" value="{$paladinprojectnewsInfo.news_content}" id="news_content" class="input" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	{if $EditOption=='Edit'}
	  		<tr class="line">
	  <td>录入人员:</td>
	  <td>
	  	  	  <input type="text" name="user_id" value="{$paladinprojectnewsInfo.user_id}" id="user_id" class="input" disabled="disabled" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>录入时间:</td>
	  <td>
	  	  	  <input type="text" name="create_at" value="{$paladinprojectnewsInfo.create_at}" id="create_at" class="input" disabled="disabled" >
	   <font color=red>*</font> 	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>修改时间:</td>
	  <td>
	  	  	  <input type="text" name="edit_at" value="{$paladinprojectnewsInfo.edit_at}" id="edit_at" class="input" disabled="disabled" >
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	{/if}
	{if $smarty.session.isadmin>=0}
		  		<tr class="line">
	  <td>新闻所发布的网站:</td>
	  <td>
	  	   	    <textarea name="news_mediawebsite" id="news_mediawebsite" cols="45" rows="5">{$paladinprojectnewsInfo.news_mediawebsite}</textarea>
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	{/if}
		  		<tr class="line">
	  <td>备注:</td>
	  <td>
	  	   	  <textarea name="remark" id="remark" cols="45" rows="5">{$paladinprojectnewsInfo.remark}</textarea>  
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>有效标志[0:无效 1:有效]:</td>
	  <td>
	  	  	    
	  		{html_radios name="flag" options=$paladinprojectnewsInfo.flag_text checked=$paladinprojectnewsInfo.flag separator="&nbsp;"}
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  </table>
</div>

<div class="sub">
<input type="hidden" name="EditOption" value="{$EditOption}">
<input type="submit" name="Submit" value="{if $EditOption=="Edit"}修改{else}提交{/if}" class="btn">
<input type="button" name="Submit3" value="返回"  class="btn" onClick="history.back(-1);">
</div>
</form>

{include file="../tpl/admin/footer.tpl"}

</body>
</html>