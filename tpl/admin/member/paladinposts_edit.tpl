<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.WEB_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<base target="mainFrame">
<body style="margin-top:5px;">
<form name="form1" method="post" action="paladinposts.php?action=save" onsubmit="return chkform();">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="99">
	<img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />{if $EditOption=="Edit"}修改{else}新增{/if}论坛帖子信息
	</td>
  </tr>
  
  <tr class="tr2">
    <td width="20%" style="text-align:center">字段名</td>
    <td width="60%" style="text-align:center">内容</td>
	<td width="20%" style="text-align:center">&nbsp;</td>
  </tr>
  
  			<input type="hidden" name="id" value="{$paladinpostsInfo.id}" class="input" >
	  		<tr class="line">
	  <td>帖子名称:</td>
	  <td>
	  	  	  <input type="text" name="posts_name" value="{$paladinpostsInfo.posts_name}" id="posts_name" class="input" style="width:300px" />
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>帖子地址:</td>
	  <td>
	  	  	  <input type="text" name="posts_url" value="{$paladinpostsInfo.posts_url}" id="posts_url" class="input"  style="width:300px" />
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>帖子所属网站:</td>
	  <td>
	  	   	    
	   <select name="posts_website" id="posts_website" class="input" >
		{html_options options=$paladinpostsInfo.house_media_text selected=$paladinpostsInfo.posts_website}
	  </select>
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>帖子所属项目:</td>
	  <td>
	  	   	    
	   <select name="project_id" id="project_id" class="input" >
		{html_options options=$paladinpostsInfo.project_id_text selected=$paladinpostsInfo.project_id}
	  </select>
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>帖子点击量:</td>
	  <td>
	  	  	  <input type="text" name="posts_hit" value="{$paladinpostsInfo.posts_hit}" id="posts_hit" class="input" />
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>帖子回复数:</td>
	  <td>
	  	  	  <input type="text" name="posts_num" value="{$paladinpostsInfo.posts_num}" id="posts_num" class="input" />
	  	   	    
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>帖子是否精华:</td>
	  <td>
	  	   	    {html_radios name="posts_top" options=$paladinpostsInfo.top_text checked=$paladinpostsInfo.posts_top separator="&nbsp;"}	
	   
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>

	{if $EditOption=='Edit'}
	<tr class="line">
	  <td>录入人员:</td>
	  <td><input type="text" name="user_id" value="{$paladinpostsInfo.user_id}" id="user_id" class="input" disabled="disabled" ></td>
	  <td>&nbsp;</td>
    </tr>
	  		<tr class="line">
	  <td>录入时间:</td>
	  <td>
	  	  	  <input type="text" name="create_at" value="{$paladinpostsInfo.create_at|date_format:'%Y-%m-%d'}" id="create_at" class="input" disabled="disabled" >
	   <font color=red>*</font> 	   	    
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	<tr class="line">
	  <td>修改时间:</td>
	  <td>
	  	  	  <input type="text" name="edit_at" value="{$paladinpostsInfo.edit_at|date_format:'%Y-%m-%d'}" id="edit_at" class="input" disabled="disabled" >
	  	  	  	  </td>
	  <td>&nbsp;</td>
    </tr>
	{/if}
	  		<tr class="line">
	  <td>有效标志[0:无效 1:有效]:</td>
	  <td>{html_radios name="flag" options=$paladinpostsInfo.flag_text checked=$paladinpostsInfo.flag separator="&nbsp;"}</td>
	  <td>&nbsp;</td>
    </tr>
		  		<tr class="line">
	  <td>效果说明:</td>
	  <td>
	  		<input type="hidden" id="remark" name="remark" style="display: none" value="{$paladinpostsInfo.remark}"> 
	<input type="hidden" id="remark___Config" value="" style="display:none"/>
<iframe id="remark___Frame" name="remark___Frame" src="../../libs/fckeditor/editor/fckeditor.html?InstanceName=remark&Toolbar=Default" width="650" height="420" frameborder="0" scrolling="no"></iframe>
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