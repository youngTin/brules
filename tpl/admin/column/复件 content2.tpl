<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="../../admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/scripts/jquery_last.js"></script>
<!--日期控件-->
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/scripts/datepicker/WdatePicker.js"></script>
{literal}
<style>
.menu{position:absolute;background:#fff;border:1px solid #69788c;}
.menu td, .menu li{background:#e6f5ff;}
.menu li{list-style:none;padding:0;}
.menu a{display:block;padding:3px 15px 3px 15px}
.menu a:hover{background:#e6f5ff;text-decoration:none;color:#fff;}
.menu ul.ul1 li a{display:inline;padding:0}
#colorbox{width:91px;height:78px;padding:3px 0 0 3px;overflow:hidden;}
#colorbox div{cursor:pointer;width:8px;height:8px;float:left;margin:0 3px 3px 0;border:1px #000 solid;font:0/8px arial}

.divtitle{width:15%;margin-top:5px;float:left;margin-top:10px;}
.divcontent{width:85%;float:left;margin-top:10px;}
</style>
{/literal}
<div class="menu" id="menu_editor" style="display:none;"></div>
<div id="showmenu" style="z-index:100;display:none;"></div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>栏目切换&nbsp;&nbsp;&nbsp;
         <select name="menu1" onchange="menu1(this.value,{$result.mid});">
		{foreach item=contact from=$result.menu}
			<option value="{$contact.cid}" {if $contact.cid==$result.cid}selected="selected"{/if}>&raquo;{$contact.pname}</option>
			{foreach item=item from=$contact.child}
			<option value="{$item.cid}" {if $item.cid==$result.cid}selected="selected"{/if}>|---{$item.name}</option>
			{/foreach}
		{/foreach}
	    </select>
		<!--<input type="button" name="Submit5" value="设置本栏目" class="btn" onclick="window.location='?adminjob=category&action=edit&action=edit&cid=14';"/>-->
		<input type="button" value="查看栏目下所有内容" class="btn" onclick="window.location='content.php?action=index&cid={$result.cid}&mid={$result.mid}';" />
      </td>
  </tr>
</table>
{literal}
	<script>
		function menu1(obj_value,mid){
			$.get("content.php", { action: "ajaxMid", cid: obj_value, mid:mid },
			   function(data){
				window.location='content.php?action=add&cid='+obj_value+'&mid='+data;
			   }
			); 
			//window.location='content.php?action=add&cid='+obj_value;
		}
		
		function validate(){
			if(document.getElementById('photo').value==''){
				//document.getElementById('aid').value=0;
				return true;
			}
			return true;
		}
	</script>
{/literal}
</div>
<form action="content.php?action=save" method="post" name="FORM" onsubmit="return validate();">
<input type="hidden" name="cid" id="cid" value="{$cid}" />
<input type="hidden" name="mid" id="mid" value="{$mid}" />
<input type="hidden" name="id" id="id" value="{$result.id|default:0}" />
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="2">
	{$EditOption} view spot	</td>
    </tr>
 
  <tr class="tr2">
    <td width="15%" style="text-align:center">Fields</td>
    <td width="85%" style="text-align:center">Content</td>
  </tr>
    <!--<tr class="tr2">
    <td width="15%" align="left" style="font-weight:700;font-size:14px;color:#000000">Base Info</td>
    <td width="15%" align="left">&nbsp;</td>
  </tr>-->
  
  <tr class="line">
    <td>推荐</td>
    <td>
		<input type="radio" value="0" name="digest" {if $result.digest=='0'}checked="checked"{/if} /> 普通景点
		<input type="radio" value="1" name="digest" {if $result.digest=='1'}checked="checked"{/if} /> 栏目推荐
		<input type="radio" value="2" name="digest" {if $result.digest=='2'}checked="checked"{/if} /> 站点推荐
		<input type="radio" value="3" name="digest" {if $result.digest=='3'}checked="checked"{/if} /> 头条推荐</td>
   </tr>

	<tr class="line">
    <td>景点名称 </td>
    <td><input class="input" name="title" id="title" value="{$result.title}" size="70"></td></tr>
	<tr class="line">
    <td>alias</td>
    <td><input class="input" name="alias" id="alias" value="{$result.alias}" size="70">
      字母开头，包括a-z,A-Z，中划线，数字</td>
	</tr>
	<tr class="line">
    <td>标题字体</td>
    <td><select name="titlecolor" id="titlecolor">
	    <option value="">标题颜色</option>
<option value="skyblue" style="background-color:skyblue;color:skyblue" {if $result.titlecolor=='skyblue'}selected="selected"{/if}>skyblue</option>
<option value="royalblue" style="background-color:royalblue;color:royalblue" {if $result.titlecolor=='royalblue'}selected="selected"{/if}>royalblue</option>
<option value="blue" style="background-color:blue;color:blue" {if $result.titlecolor=='blue'}selected="selected"{/if}>blue</option>
<option value="darkblue" style="background-color:darkblue;color:darkblue" {if $result.titlecolor=='darkblue'}selected="selected"{/if}>darkblue</option>
<option value="orange" style="background-color:orange;color:orange" {if $result.titlecolor=='orange'}selected="selected"{/if}>orange</option>
<option value="orangered" style="background-color:orangered;color:orangered" {if $result.titlecolor=='orangered'}selected="selected"{/if}>orangered</option>
<option value="crimson" style="background-color:crimson;color:crimson" {if $result.titlecolor=='crimson'}selected="selected"{/if}>crimson</option>
<option value="red" style="background-color:red;color:red" {if $result.titlecolor=='red'}selected="selected"{/if}>red</option>
<option value="firebrick" style="background-color:firebrick;color:firebrick" {if $result.titlecolor=='firebrick'}selected="selected"{/if}>firebrick</option>
<option value="darkred" style="background-color:darkred;color:darkred" {if $result.titlecolor=='darkred'}selected="selected"{/if}>darkred</option>
<option value="green" style="background-color:green;color:green" {if $result.titlecolor=='green'}selected="selected"{/if}>green</option>
<option value="limegreen" style="background-color:limegreen;color:limegreen" {if $result.titlecolor=='limegreen'}selected="selected"{/if}>limegreen</option>
<option value="seagreen" style="background-color:seagreen;color:seagreen" {if $result.titlecolor=='seagreen'}selected="selected"{/if}>seagreen</option>
<option value="teal" style="background-color:teal;color:teal" {if $result.titlecolor=='teal'}selected="selected"{/if}>teal</option>
<option value="deeppink" style="background-color:deeppink;color:deeppink" {if $result.titlecolor=='deeppink'}selected="selected"{/if}>deeppink</option>
<option value="tomato" style="background-color:tomato;color:tomato" {if $result.titlecolor=='tomato'}selected="selected"{/if}>tomato</option>
<option value="coral" style="background-color:coral;color:coral" {if $result.titlecolor=='coral'}selected="selected"{/if}>coral</option>
<option value="purple" style="background-color:purple;color:purple" {if $result.titlecolor=='purple'}selected="selected"{/if}>purple</option>
<option value="indigo" style="background-color:indigo;color:indigo" {if $result.titlecolor=='indigo'}selected="selected"{/if}>indigo</option>
<option value="burlywood" style="background-color:burlywood;color:burlywood" {if $result.titlecolor=='burlywood'}selected="selected"{/if}>burlywood</option>
<option value="sandybrown" style="background-color:sandybrown;color:sandybrown" {if $result.titlecolor=='sandybrown'}selected="selected"{/if}>sandybrown</option>
<option value="sienna" style="background-color:sienna;color:sienna" {if $result.titlecolor=='sienna'}selected="selected"{/if}>sienna</option>
<option value="chocolate" style="background-color:chocolate;color:chocolate"{if $result.titlecolor=='chocolate'}selected="selected"{/if}>chocolate</option>
<option value="silver" style="background-color:silver;color:silver" {if $result.titlecolor=='silver'}selected="selected"{/if}>silver</option>
</select>
	    <input name="titleb" type="checkbox" id="titleb" value="1" {if $result.titleb=="1"}checked="checked"{/if}>
	    粗体
	    <input name="titleii" type="checkbox" id="titleii" value="1" {if $result.titleii=="1"}checked="checked"{/if}>
	    斜体
	    <input name="titleu" type="checkbox" id="titleu" value="1" {if $result.titleu=="1"}checked="checked"{/if}>
	    下划线		</td>
  </tr>
<!----------------------模型信息开始--------------------------------->
  <tr class="line">
    <td>详细</td>
    <td>
	<div>
	<input name="content" id="content" style="DISPLAY: none" type="hidden" value='{$result.content}'> 
	<input id="content___Config" style="DISPLAY: none" type=hidden> 
<iframe id="content___Frame" src="../../libs/fckeditor/editor/fckeditor.html?InstanceName=content&Toolbar=Default" width="650" height="420" frameborder="0" scrolling="no"></iframe></div>
{literal}
<script>
//查看内容
function getContentValue() 
{ 
var oEditor = FCKeditorAPI.GetInstance('content'); 
var acontent = oEditor.GetXHTML(); 
return acontent; 
} 
function setContentValue(content) 
{ 
var oEditor = FCKeditorAPI.GetInstance('content');  

  if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG )

  { 
  oEditor.InsertHtml(content); 
}else{ 
  alert(请切换到HTML编辑模式进行操作！); 
} 
} 
</script> 
{/literal}
<!--<input type=button onclick="alert(getContentValue());"> --></td>
  </tr>
    
  <tr class="line">
    <td>内容摘要</td>
    <td><div><input type="hidden" id="intro" name="intro" value='{$result.intro}' style="display:none" /><input type="hidden" id="intro___Config" value="" style="display:none" /><iframe id="intro___Frame" name="intro___Frame" src="../../libs/fckeditor/editor/fckeditor.html?InstanceName=intro&amp;Toolbar=Basic" width="450" height="150" frameborder="0" scrolling="no"></iframe></div></td>
  </tr>

  <tr class="line">
    <td>景点地址</td>
    <td><input name="address" class="input" id="address" value="{$result.address}" size="70"></td>
  </tr>

  <tr class="line">
    <td>景点地区</td>
    <td><input class="input" name="region" id="region" value="{$result.region}" size="20">
	<select onchange="selectValue('region',this.options[this.selectedIndex].text);">
	<option value="">选择地区</option>
	{html_options options=$result.region_value selected=0}
	</select></td>
  </tr>

  <tr class="line">
    <td>景点类型</td>
    <td><input class="input" name="type" id="type" value="{$result.type}" size="20">
	<select onchange="selectValue('type',this.options[this.selectedIndex].text);">
	<option value="">选择类型</option>
	{html_options options=$result.type_value selected=0}
	</select></td>
  </tr>
<!----------------------模型信息结束--------------------------------->
  <tr class="line">
    <td>相关图片</td>
    <td>
	  {if $EditOption=='New'}
	  <img src="../../../admin/images/null.gif" id="show_pic" height="96px" style="vertical-align:middle" />
	  {else}
	  <img src="{$result.photo|default:'../../../admin/images/null.gif'}" id="show_pic" height="96px" style="vertical-align:middle" />
	  {/if}
      <input type="button" class="btn" onclick="selectImg('photo');" value="Insert">
	  <input type="button" class="btn" onclick="removeImg('photo');" value="Remove">
	  <input type="hidden" class="input" name="photo" id="photo" value="{$result.photo}" size="70">
	  </td>
  </tr>

  <tr class="line">
		<td>其他信息</td>
		<td><input id="showother" type="checkbox" value="" onclick="show(this);" /><span id='showname'>显示</span></td>
  </tr>

    <tr class="line" id="tags_show" style="width:70%; display:none">
		<td colspan="2">
		  <div style="width:100%;">
			<div class="divtitle">季节特色</div>
			<div class="divcontent"><textarea name="feature" cols="70" rows="4">{$result.feature}</textarea>
			</div>
			
			<div class="divtitle">景点提示</div>
			<div class="divcontent"><textarea name="prompt" cols="70" rows="4">{$result.prompt}</textarea>
			</div>
			
			<div class="divtitle">景点交通</div>
			<div class="divcontent"><textarea name="traffic_info" cols="70" rows="4">{$result.traffic_info}</textarea>
			</div>
			
			<div class="divtitle">餐饮场所</div>
			<div class="divcontent"><textarea name="rim_repast" cols="70" rows="4">{$result.rim_repast}</textarea>
			</div>
			
			<div class="divtitle">住宿场所</div>
			<div class="divcontent"><textarea name="rim_lodging" cols="70" rows="4">{$result.rim_lodging}</textarea>
			</div>
			
			<div class="divtitle">外部链接</div>
			<div class="divcontent"><input class="input" name="linkurl" id="linkurl" value="{$result.linkurl}" size="70"></div>
			
			<div class="divtitle">自定义时间</div>
			<div class="divcontent"><input type="text" name="postdate" value="{$result.postdate|date_format:"%Y-%m-%d"}"  class="input" id="postdate" onFocus="{literal}WdatePicker({startDate:'%y-%M-%d',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true}){/literal}" size="70" /></div>
			
		  </div></td>
	  </tr>
</table>
</div>
<div class="sub">
<input type="hidden" name="UrlReferer" value="{$result.url}">
<input type="hidden" name="EditOption" value="{$result.EditOption}">
<input type="hidden" name="aid" id="aid" value="{$result.aid|default:'0'}" />
<input type="submit" name="Submit" value="提交" class="btn"  />
<input type="reset" name="Submit2" value="重置" class="btn" />
</div>
</form>

{include file="../tpl/admin/footer.tpl"}

{literal}
<script language="javascript">
var objts;
function IsBrowser(){
	var sAgent = navigator.userAgent.toLowerCase() ;
	if ( sAgent.indexOf("msie") != -1 && sAgent.indexOf("mac") == -1 && sAgent.indexOf("opera") == -1 )
		return "msie" ;
	if ( navigator.product == "Gecko" && !( typeof(opera) == 'object' && opera.postError ) )
		return "gecko";
	if ( navigator.appName == 'Opera')
		return "opera" ;
	if ( sAgent.indexOf( 'safari' ) != -1 )
		return "safari";
	return false ;
}

function selectImg(inputname){
	var time = new Date();
	var timestamp = time.valueOf();
	if(IsBrowser()=='msie'){
		objts=showModalDialog("/admin/file_attach.php?action=index&type=image&inputtype=input&inputname="+inputname,window,'dialogWidth=650px;dialogHeight=500px;help:no;status:no;');
	}else{
		window.open("/admin/file_attach.php?action=index&type=image&inputtype=input&inputname="+inputname,"selectimg","width=840,height=500,resizable=no,z-look=yes,alwaysRaised=yes,depended=yes,scrollbars=yes,left=" + (window.screen.width-840)/2 + ",top=" + (window.screen.height-500)/2);
	}
}

function removeImg(inputname){
	var obj_photo = document.getElementById(inputname);
	var obj_aid = document.getElementById('aid');
	var obj_show = document.getElementById('show_pic');
	obj_photo.value='';
	obj_aid.value='0';
	obj_show.src='/admin/images/null.gif';
}

function selectAttach(inputname){
	var time = new Date();
	var timestamp = time.valueOf();
	if(IsBrowser()=='msie'){
		objts=showModalDialog("/admin.php?adminjob=edit&action=addattach&type=attach&inputtype=input&inputname="+inputname+"&time="+timestamp,window,'dialogWidth=650px;dialogHeight=500px;help:no;status:no;');
	}else{
		window.open("/admin.php?adminjob=edit&action=addattach&type=attach&inputtype=input&inputname="+inputname+"&time="+timestamp,"selectimg","width=840,height=500,resizable=no,z-look=yes,alwaysRaised=yes,depended=yes,scrollbars=yes,left=" + (window.screen.width-840)/2 + ",top=" + (window.screen.height-500)/2);
	}
}

function selectTids(inputname,inputtype){
	var time = new Date();
	var timestamp = time.valueOf();	window.open("/admin.php?adminjob=edit&action=selecttids&inputtype="+inputtype+"&inputname="+inputname+"&time="+timestamp,"sinavblogupload","width=840,height=500,resizable=no,z-look=yes,alwaysRaised=yes,depended=yes,scrollbars=yes,left=" + (window.screen.width-840)/2 + ",top=" + (window.screen.height-500)/2);

}


function show(obj){
	if(obj.checked){
		document.getElementById('tags_show').style.display = '';
	}else{
		document.getElementById('tags_show').style.display = 'none';
	}
}

function selectValue(inputname,value){
	if(value!=''){
		document.getElementById(inputname).value=value;
	}
}

function showColor(showName,inputName){
	var menu_editor = getObj("menu_editor");
	var colors = [
		'000000','660000','663300','666600','669900','66CC00','66FF00','666666','660066','663366','666666',
		'669966','66CC66','66FF66','CCCCCC','6600CC','6633CC','6666CC','6699CC','66CCCC','66FFCC','FF0000',
		'FF0000','FF3300','FF6600','FF9900','FFCC00','FFFF00','0000FF','FF0066','FF3366','FF6666','FF9966',
		'FFCC66','FFFF66','00FFFF','FF00CC','FF33CC','FF66CC','FF99CC','FFCCCC','FFFFCC'
	];
	var html = '<div id="colorbox">';
	for(i in colors){
		html += "<div unselectable=\"on\" style=\"background:#" + colors[i] + "\" onClick=\"SetC('" + colors[i] + "','" + inputName + "')\"></div>";
	}
	html += '</div>';
	menu_editor.innerHTML = html;
	if(typeof type == 'undefined'){
		click_open('menu_editor',showName,'2');
	} else{
		mouseover_open('menu_editor',showName,'2');
	}
}
function SetC(color,inputName){
	//var textValue = document.getElementById(inputName).value;
	//document.getElementById(inputName).value = "<span style=\"color:#"+color+";\">"+textValue+"</span>";
	document.getElementById(inputName).value = "#"+color;
	closep();
}

</script>

<script language="javascript">
var agt = navigator.userAgent.toLowerCase();
var is_ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
var is_gecko= (navigator.product == "Gecko");
var top=parent.topFrame;
if(typeof(top)=='object'){
	var loadMsg=top.document.getElementById('loadMsg');
	if(loadMsg!=undefined){
		loadMsg.style.display='none';
	}
}
ifcheck = true;

function getObj(id){
	return document.getElementById(id);
}

function window_open(url){
	if(is_ie){
		showModalDialog(url,window,'dialogWidth=650px;dialogHeight=500px;help:no;status:no;');
	}else{
		window.open(url,'','width=650,height=500,status=no');
	}
}

</script>
{/literal}
