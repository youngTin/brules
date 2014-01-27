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

optgroup { background-color:#eee; color:444; font-family:Arial, Helvetica, sans-serif} 
</style>
{/literal}
<body style="margin-top:10px;">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>栏目切换&nbsp;&nbsp;&nbsp;
         <select name="menu1" onchange="menu1(this.value,{$result.mid});">
		{foreach item=contact from=$result.menu}
			<option value="{$contact.id}" {if $contact.id==$result.cid}selected="selected"{/if}>&raquo;{$contact.name}</option>
			{foreach item=item from=$contact.child}
				<option value="{$item.id}" {if $item.id==$result.cid}selected="selected"{/if}>|---{$item.name}</option>
				{foreach item=item2 from=$item.child}
				<option value="{$item2.id}" {if $item2.id==$result.cid}selected="selected"{/if}>|------{$item2.name}</option>
				{/foreach}
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
	</script>
{/literal}
</div>
<form action="content.php?action=save" method="post" name="FORM">
<input type="hidden" name="cid" id="cid" value="{$result.cid}" />
<input type="hidden" name="mid" id="mid" value="{$result.mid}" />
<input type="hidden" name="id" id="id" value="{$result.id|default:0}" />
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="2">
	添加内容
	</td>
    </tr>
  <tr class="tr2">
    <td width="15%" style="text-align:center">字段名</td>
    <td width="85%" style="text-align:center">内容</td>
  </tr>
  <tr class="line">
    <td>推荐</td>
    <td>
			<input type="radio" value="0" name="digest" {if $result.digest=='0'}checked="checked"{/if} /> 普通主题
			<input type="radio" value="1" name="digest" {if $result.digest=='1'}checked="checked"{/if} /> 栏目推荐
			<input type="radio" value="2" name="digest" {if $result.digest=='2'}checked="checked"{/if} /> 站点推荐
			<input type="radio" value="3" name="digest" {if $result.digest=='3'}checked="checked"{/if} /> 头条推荐
		</td>
  </tr>

	<tr class="line">
    <td>标题</td>
    <td><input class="input" name="title" id="title" value="{$result.title}" size="70">  </td>
	</tr>
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
	    下划线
		</td>
  </tr>
  <tr class="line">
    <td>请选择所属相关类别</td>
    <td>
		<select name="relatedcid[]" size="7" multiple>
		{section name=s loop=$result.relatedCategory}
		    {if $result.cid!=$result.relatedCategory[s].id}
				<option value="{$result.relatedCategory[s].id}" {if @in_array($result.relatedCategory[s].id,$result.relatedcid)}selected="selected"{/if}>&raquo;{$result.relatedCategory[s].name}</option>     {else}
				<optgroup label="&raquo;{$result.relatedCategory[s].name}"></optgroup> 
			{/if}
			{section name=d loop=$result.relatedCategory[s].child}
				{if $result.cid!=$result.relatedCategory[s].child[d].id}
					<option value="{$result.relatedCategory[s].child[d].id}" {if @in_array($result.relatedCategory[s].child[d].id,$result.relatedcid)}selected="selected"{/if}>|---{$result.relatedCategory[s].child[d].name}</option>
				{else}
					<optgroup label="|---{$result.relatedCategory[s].child[d].name}"></optgroup> 
				{/if}
				
				{section name=g loop=$result.relatedCategory[s].child[d].child}
					{if $result.cid!=$result.relatedCategory[s].child[d].child[g].id}
						<option value="{$result.relatedCategory[s].child[d].child[g].id}" {if @in_array($result.relatedCategory[s].child[d].child[g].id,$result.relatedcid)}selected="selected"{/if}>|------{$result.relatedCategory[s].child[d].child[g].name}</option>
					{else}
						<optgroup label="|------{$result.relatedCategory[s].child[d].child[g].name}"></optgroup> 
					{/if}
				{/section}
			{/section}
		{/section}
		</select>
	</td>
  </tr>
    <tr class="line">
    <td>允许评论</td>
    <td>
	<select name="is_comment" id="is_comment" >
		<option value="1" {if $result.is_comment=="1"}selected="selected"{/if}>是</option>
		<option value="0" {if $result.is_comment=="0"}selected="selected"{/if}>否</option>
	</select>
	  </td>
  </tr>

  	<tr class="line">
    <td>详细</td>
    <td>
	<div>
	<input type="hidden" id="content" name="content" style="display: none" value="{$result.content}"> 
	<input type="hidden" id="content___Config" value="" style="display:none"/>
<iframe id="content___Frame" name="content___Frame" src="../../includes/fckeditor/editor/fckeditor.html?InstanceName=content&Toolbar=Default" width="650" height="420" frameborder="0" scrolling="no"></iframe></div>

<input type="checkbox" name="imagetolocal" value=1 /> 外部图片本地化 <br />
<input type="checkbox" name="selectimage" value=1 /> 自动提取第一张图片为新闻图片<br />
<input type="checkbox" name="autofpage" value=1 /> 自动分页处理<br />
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
<!--<input type=button onclick="alert(getContentValue());"> -->
</td>
  </tr>
  <tr class="line">
    <td>内容摘要</td>
    <td><div><input type="hidden" id="intro" name="intro" value="{$result.intro}" style="display:none" /><input type="hidden" id="intro___Config" value="" style="display:none" /><iframe id="intro___Frame" name="intro___Frame" src="../../includes/fckeditor/editor/fckeditor.html?InstanceName=intro&amp;Toolbar=Basic" width="450" height="150" frameborder="0" scrolling="no"></iframe></div></td>
  </tr>

  <tr class="line">
    <td>作者</td>
    <td><input class="input" name="author" id="author" value="{$result.author}" size="20">
	<select onchange="selectValue('author',this.options[this.selectedIndex].text);">
		<option value="">作者</option>
		{html_options options=$result.author_value selected=0}
	</select></td>
  </tr>

  <tr class="line">
    <td>新闻来源</td>
    <td><input class="input" name="fromsite" id="fromsite" value="{$result.fromsite}" size="20">
	<select onchange="selectValue('fromsite',this.options[this.selectedIndex].text);">
	<option value="">来源</option>
	{html_options options=$result.fromsite_value selected=0}
	</select></td>
  </tr>

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
	  <input type="hidden" class="input" name="photo" id="photo" value="{$result.photo}" size="70">该字段标志着主题是否属于图文主题
	  </td>
  </tr>
   
  <tr class="line">
    <td>外部链接</td>
    <td><input class="input" name="linkurl" id="linkurl" value="{$result.linkurl}" size="70">  </td>
  </tr>
  <tr class="line">
	  <td>自定义时间</td>
	  <td>
		<input type="text" name="postdate" value="{$result.postdate|date_format:'%Y-%m-%d'}"  class="input" id="postdate" onFocus="{literal}WdatePicker({startDate:'%y-%M-%d',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true}){/literal}" size="70" /></td>
  </tr>
  <tr class="line">
		<td>当前Tags</td>
		<td><input id="tags" class="input" name="tags" size="70" value=""  onfocus="showtag();" />
		标签之间请使用逗号,最多5个<br />
		<fieldset id="tags_show" style="width:70%;display:none;"><legend>热门标签</legend><div id="hottags" style="height:80px;overflow-Y:auto;"></div></fieldset></td>
  </tr>
</table>
</div>
<div class="sub">
<input type="hidden" name="UrlReferer" value="{$result.url}">
<input type="hidden" name="EditOption" value="{$result.EditOption}">
<input type="hidden" name="aid" id="aid" value="{$result.aid|default:'0'}" />
<input type="submit" name="Submit" value="提交" class="btn" onclick="setselectvalue()" />
<input type="reset" name="Submit2" value="重置" class="btn" />
</div>
</form>

{include file="../tpl/admin/footer.tpl"}
</body>
</html>
{literal}
<script language="javascript">
var tagsname = '';
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

function add(inputname, tid, title){
	var obj = document.getElementById(inputname);
	if (optionExist(obj,tid)) {
		alert("该文章已添加");
		return false;
	}
	var length=obj.length;
	obj.options[length]=new Option(title,tid);

}

function optionExist(obj,tid){
	var isexit = false;
	for(var i=0;i<obj.options.length;i++){
		if(obj.options[i].value == tid){
			isexit = true;
			break;
		}
	}
	return isexit;
}

function moveUp(inputname){
	var obj = document.getElementById(inputname);
	with (obj){
		try {
			if(selectedIndex==0){
				options[length]=new Option(options[0].text,options[0].value);
				options[0]=null;
				selectedIndex=length-1;
			}else if(selectedIndex>0) moveG(obj,-1);
		}catch(e){}

	}
}

function moveDown(inputname){
	var obj = document.getElementById(inputname);
	with (obj){
		try {
			if(selectedIndex==length-1){
				var otext=options[selectedIndex].text;
				var ovalue=options[selectedIndex].value;
				for(i=selectedIndex; i>0; i--){
					options[i].text=options[i-1].text;
					options[i].value=options[i-1].value;
				}
				options[i].text=otext;
				options[i].value=ovalue;
				selectedIndex=0;
			}else if(selectedIndex<length-1){
				moveG(obj,+1);
			}
		} catch(e) {}
	}
}
function moveG(obj,offset){
	with (obj){
		desIndex=selectedIndex+offset;
		var otext=options[desIndex].text;
		var ovalue=options[desIndex].value;
		options[desIndex].text=options[selectedIndex].text;
		options[desIndex].value=options[selectedIndex].value;
		options[selectedIndex].text=otext;
		options[selectedIndex].value=ovalue;
		selectedIndex=desIndex;
	}
}
function del(inputname){
	var obj = document.getElementById(inputname);
	with(obj) {
		try {
			options[selectedIndex]=null;
			selectedIndex=length-1;
		}catch(e){}
	}
}

function setContentLinkValue(inputname){
	var obj = document.getElementById(inputname);
 	var returnValue = '';

	with(obj){
 		for(i=0; i <  obj.length ; i++){
			if(i==0){
				returnValue = options[i].value;
			}else{
				returnValue = returnValue + ',' + options[i].value;
			}
 		}
	}
	if(returnValue == 'undefined'){
		returnValue = '';
	}
 	return returnValue;
}
function setselectvalue(){
	var selectList =document.getElementsByTagName('select');
	var selectname;
	for(var i=0; i<selectList.length; i++){
		selectname = selectList[i]['id'];
		if(selectname !=false){
			try {
				var obj = document.getElementById(selectname+'_value');
			}catch(e){
				continue;
			}
			try {
				obj.value = setContentLinkValue(selectname);
				document.getElementById(selectname).value='';
			}catch (e) {
			}

		}
	}
}

function showtag(){
	var str='';
	tn = tagsname.split(',');
	for(i=0;i<tn.length;i++){
		str +='<a href="javascript:void(0)" onclick="SelectTag('+i+');">'+tn[i]+'</a>&nbsp;&nbsp;&nbsp;';
	}
	document.getElementById('hottags').innerHTML=str;
	document.getElementById('tags_show').style.display = '';
}

function SelectTag(id){
	tn = tagsname.split(',');
	tags = document.FORM.tags.value;
	if(tags.indexOf(tn[id])==-1 && tags.split(',').length<5){
		document.FORM.tags.value += document.FORM.tags.value ? ' , '+tn[id] : tn[id];
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

function selectTpl(name){
	window.open('/admin.php?adminjob=edit&action=selectTpl&inputname='+name,"selecttpl","width=840,height=500,resizable=no,z-look=yes,alwaysRaised=yes,depended=yes,scrollbars=yes,left=" + (window.screen.width-840)/2 + ",top=" + (window.screen.height-500)/2);
	return;
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

function CheckAll(form){
	for (var i=0;i<form.elements.length-2;i++){
		var e = form.elements[i];
		if(e.type=='checkbox') e.checked = ifcheck;
	}
	ifcheck = ifcheck == true ? false : true;
}

var selectCheck = 0;
function whole(form){
	for (var i=0;i<form.elements.length-2;i++){
		var e = form.elements[i];
		if(e.type=='checkbox'){
			if(e.checked==true) selectCheck++;
		}
	}
	if(selectCheck<=0){
		alert("请选择操作对象");
		return false;
	}
}

function GetCookie(name){
	var searchname=name+"=";
	var offset=document.cookie.indexOf(searchname);
	if(offset==-1) return false;
	var start=offset+searchname.length;
	var end=document.cookie.indexOf(";",start);
	if(end==-1) end=document.cookie.length;
	var value=unescape(document.cookie.substring(start,end));
	return value;
}

function SetCookie(name,value,Minutes){
	var exp = new Date();
	exp.setTime(exp.getTime() + Minutes*60000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

function ietruebody(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
}
function  randomvalue(low,high){
	return Math.floor(Math.random()*(1 + high -low) + low);
}
</script>
{/literal}
