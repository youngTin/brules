<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LD-List</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/scripts/formValidator/jquery_last.js"></script>
<script src="{$smarty.const.URL}/scripts/admin.js"></script>
<script src="{$smarty.const.URL}/scripts/showDiv.js" type="text/javascript" language="javascript"></script>
</head>
{literal}
<style>
div#qTip {
 padding: 3px;
 border: 1px solid #8394a5;
 border-right-width: 2px;
 border-bottom-width: 2px;
 display: none;
 width:225px;
 background: #f0f4f8;
 color: #8394a5;
 font: 12px Verdana, Arial, Helvetica, sans-serif;
 line-height:22px;
 text-align: left;
 position: absolute;
 z-index: 1000;
}
</style>
<script>
var okimg = '/admin/images/star_ok.gif';
var noimg = '/admin/images/star_no.gif';
var cid = '{/literal}{$cid}{literal}';
var mid = '1';
//var url = '/admin.php?adminjob=content';
var current_key;
var current_tid;
var current_num;
//var tagsname = '装饰,别墅,';
var digestMsg = new Array(4);
digestMsg[0] = '您确认要取消此内容的精华推荐吗？';
digestMsg[1] = '您确认要将此内容设置为 栏目推荐 吗？';
digestMsg[2] = '您确认要将此内容设置为 站点推荐 吗？';
digestMsg[3] = '您确认要将此内容作为 头条内容 吗？';
function showStar(key,i){
	for(var s=1;s<=3;s++){
		var imgid = 'img'+key+'_'+s;
		if(s<=i){
		document.getElementById(imgid).src = okimg;
		}else{
		document.getElementById(imgid).src = noimg;
		}
	}
}

function reSet(key,num){
	for(var s=1;s<=3;s++){
		var imgid = 'img'+key+'_'+s;
		if(s<=num){
			document.getElementById(imgid).src = okimg;
		}else{
			document.getElementById(imgid).src = noimg;
		}
	}
}

function digest(id,key,num){
	var msg = confirm(digestMsg[num]);
	if(msg){
		current_num = num;
		current_tid = id;
		current_key = key;
		$.get(
			 "{/literal}{$smarty.const.URL}/admin/column/content.php{literal}",
			 { id: id, cid: cid, digest: num, action: 'ajaxDigest'},
			 function(data){
			   //window.location="{/literal}{$smarty.const.URL}/admin/column/content1.php?cid="+cid+"&mid"+mid+"{literal}";
			   reSet(key,num);
			   $('#digest_'+key).mouseout( function() {reSet(key,num);} );
			 }
		); 
	}else{
		return false;
	}
}

function digestOk(res){
	if(res=='100'){
		var divname = 'd_'+current_key;
		var divname2 = 'ss_'+current_key;
		document.getElementById(divname).innerHTML = "<div id='"+divname2+"' onmouseout=\"reSet('"+current_key+"','"+current_num+"')\"></div>";
		for(var i=1;i<=3;i++){
		if(i<=current_num){
			theimg = okimg;
		}else{
			theimg = noimg;
		}
		document.getElementById(divname2).innerHTML += "<img id='img"+current_key+"_"+i+"' class='st' src='"+theimg+"' onmouseover=\"showStar('"+current_key+"','"+i+"');\" onclick=\"digest('"+current_tid+"','"+current_key+"','"+i+"');\" />";
		}
	}
}
</script>
{/literal}

<base target="mainFrame">
<body>
<div class="t" style="margin-top:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td style="text-align:left">
	<form name="frm_search2" method="GET" action="content.php" id="frm_search2">
		标题关键字搜索: <input type="text" name="title" value="{$title}" id="title" />&nbsp;&nbsp;
		<input type="hidden" value="{$cid}" name="cid"  />
		<input type="hidden" value="{$mid}" name="mid"  />
	    <input type="submit" name="Submit" value="显示" class="btn" />
	</form>
	<input type="button" value="添加新内容" class="btn" onclick="self.location='content.php?action=add&cid={$cid}&mid={$mid}'" />
	<input type="button" name="Submit5" value="设置本栏目" class="btn" onclick="window.location='/admin/category.php?action=edit&cid={$cid}';"/>
	</td>
  </tr>
</table>
</div>

<form name="form1" id="form1" method="post" action="/admin/column/content.php?action=order&cid={$cid}&mid={$mid}">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="13">
	<div style="float:right">&nbsp;</div>
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;{$className}</td>
   </tr>
<tr class="tr2">
    <td><span id="ordertid" class="st" onmouseover="orderstyle(this.id,1);" onmouseout="orderstyle(this.id,0);" onclick="window.location='/admin.php?adminjob=content&action=view&cid=14&displaynum=4&&&order=tid&orderby=ASC&'">序号</span></td>
    <td>景点</td>
    <td><span id="orderpublisher" class="st" onmouseover="orderstyle(this.id,1);" onmouseout="orderstyle(this.id,0);" onclick="window.location='/admin.php?adminjob=content&action=view&cid=14&displaynum=4&&&order=publisher&orderby=ASC&'">发布者</span></td>
    <td><span id="orderdigest" class="st" onmouseover="orderstyle(this.id,1);" onmouseout="orderstyle(this.id,0);" onclick="window.location='/admin.php?adminjob=content&action=view&cid=14&displaynum=4&&&order=digest&orderby=ASC&'">推荐</span></td>
	<td><span id="orderhits" class="st">Order</span></td>
    <td><span id="orderhits" class="st" onmouseover="orderstyle(this.id,1);" onmouseout="orderstyle(this.id,0);" onclick="window.location='/admin.php?adminjob=content&action=view&cid=14&displaynum=4&&&order=hits&orderby=ASC&'">浏览</span></td>
    <td><span id="orderifpub" class="st" onmouseover="orderstyle(this.id,1);" onmouseout="orderstyle(this.id,0);" onclick="window.location='/admin.php?adminjob=content&action=view&cid=14&displaynum=4&&&order=ifpub&orderby=ASC&'">Photo</span></td>
    <td><span id="orderpostdate" class="st" onmouseover="orderstyle(this.id,1);" onmouseout="orderstyle(this.id,0);" onclick="window.location='/admin.php?adminjob=content&action=view&cid=14&displaynum=4&&&order=postdate&orderby=ASC&'">添加时间<img src="/admin/images/order_DESC.gif" /></span></td>
    <td>操作</td>
  </tr>

{section name=s loop=$contentindexList}
  <tr class="tr3">
    <td><input name="ids[]" type="checkbox" id="sid_{$contentindexList[s].id}" value="{$contentindexList[s].id}">
      {$contentindexList[s].id|default:"&nbsp;"}</td>
    <td>{$contentindexList[s].title|default:"&nbsp;"}
	{if $contentindexList[s].photo!=''}<a href="javascript:void(0);" img="{$contentindexList[s].photo}"><img src="/admin/images/img.gif" /></a>{/if}
	</td>
  <td>{$contentindexList[s].publisher|default:"&nbsp;"}</td>
  <td>
  <div id='d_{$smarty.section.s.index}' oncontextmenu="digest('{$contentindexList[s].id}','{$smarty.section.s.index}','0');return false;">
  <div onmouseout="reSet('{$smarty.section.s.index}','{$contentindexList[s].digest}');" id="digest_{$smarty.section.s.index}">
  <img id='img{$smarty.section.s.index}_1' class='st' src='/admin/images/star_no.gif' onmouseover="showStar('{$smarty.section.s.index}','1');" onclick="digest('{$contentindexList[s].id}','{$smarty.section.s.index}','1');" />
  <img id='img{$smarty.section.s.index}_2' class='st' src='/admin/images/star_no.gif' onmouseover="showStar('{$smarty.section.s.index}','2');" onclick="digest('{$contentindexList[s].id}','{$smarty.section.s.index}','2');" />
  <img id='img{$smarty.section.s.index}_3' class='st' src='/admin/images/star_no.gif' onmouseover="showStar('{$smarty.section.s.index}','3');" onclick="digest('{$contentindexList[s].id}','{$smarty.section.s.index}','3');" />
  </div>
  </div>
  <script>reSet('{$smarty.section.s.index}','{$contentindexList[s].digest}');</script>
  <td><input name="taxis[{$contentindexList[s].id}]" type="text" class="input" id="taxis[{$contentindexList[s].id}]" value="{$contentindexList[s].comnum}" size="3" maxlength="3"></td>
  </td>
  <td>{$contentindexList[s].hits|default:"0"}</td>
  <td><a href="/admin/column/photo.php?action=index&tid={$contentindexList[s].id}&cid={$contentindexList[s].cid}">Photo Gallery({$contentindexList[s].photoNum|default:'0'})</a></td>
  <td>{$contentindexList[s].postdate|date_format:"%Y-%m-%d"|default:"&nbsp;"}</td>
  <td>
<a href="content.php?action=edit&id={$contentindexList[s].id}&cid={$contentindexList[s].cid}&mid={$mid}"><img src="/admin/images/edit.gif" align="absmiddle" alt="编辑" /></a>
<a href="content.php?action=delete&id={$contentindexList[s].id}&cid={$contentindexList[s].cid}&mid={$mid}" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a>
<a href="#"><img src="/admin/images/update.gif" align="absmiddle" alt="更新静态页" /></a>
</td>
  </tr>
{/section}
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>
    <input type="submit" name="Submit" value="提交排序" class="btn">
    <!--
	<input type="button" name="Submit3" value="全选" class="btn" onclick="CheckAll(document.form1);" />
	<input type="submit" name="btn_del" value="全部删除" class="btn" onclick='return window.confirm("您确认要删除!");'>
	-->
	</td>
    <td style="text-align:right">{$splitPageStr|default:"&nbsp;"}</td>
  </tr>
</table>
</div>
</form>
{include file="../tpl/admin/footer.tpl"}
{literal}
<script>
var top=parent.topFrame;
if(typeof(top)=='object'){
	var loadMsg=top.document.getElementById('loadMsg');
	if(loadMsg!=undefined){
		loadMsg.style.display='none';
	}
}
</script>
{/literal}
