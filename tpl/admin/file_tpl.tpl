<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>模板选择</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="../../admin/css/admin.css" rel="stylesheet" type="text/css" />
{literal}
<script language="javascript">
function insertTpl(filename,type){
	if(window.dialogArguments){
		var win = window.dialogArguments;
	}else{
		var win = window.opener;
	}
	//var input = window.opener.document.getElementsByName(inputname);
	if(type=='list'){
		win.document.getElementById('tpl_index').value=filename;
	}else if(type=='content'){
		win.document.getElementById('tpl_content').value=filename;
	}else if(type=='index'){
		win.document.getElementById('config[template_index]').value=filename;
	}else if(type=='waterimg'){
		win.document.getElementById('config[waterimg]').value=filename;
	}else if(type=='watertextlib'){
		win.document.getElementById('config[watertextlib]').value=filename;
	}
	window.close();
}
</script>
{/literal}
<base target="_self">
<body>
<div class="t">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr class="head">
			<td colspan="5">模板管理</td>
		</tr>
		<tr class="tr2">
			<td>文件名</td>
			<td>描述</td>
			<td>插入</td>
		</tr>
		{foreach from=$file item=foo}
		<tr class="tr3">
			<td>
			{if $type=='waterimg'}
				<img src='/admin/images/file/gif.gif' width='16' height='16' hspace='5' align='absmiddle' />
			{elseif $type=='watertextlib'}
				<img src='/admin/images/file/tiff.gif' width='16' height='16' hspace='5' align='absmiddle' />
			{else}
				<img src='/admin/images/file/html.gif' width='16' height='16' hspace='5' align='absmiddle' />
			{/if}
			<a href="javascript:void(0);" img="{$smarty.const.URL}" >{$foo.name}</a></td>
			<td>&nbsp;
			{if $type=='waterimg'}
				<img src='/admin/images/water/{$foo.name}' height="60" />
			{/if}
			</td>
			<td><img src="/admin/images/insert.gif" style="cursor:pointer;" align="absmiddle" onClick="insertTpl('{$foo.name}','{$type}');" alt="插入此文件"></td>
		</tr>
		{/foreach}
	</table>
</div>
<iframe name="uploadFrame" style="display:''" width="0"></iframe>