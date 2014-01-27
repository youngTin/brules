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

#hottags span{float:left;font-weight:700;margin-left:5px;}
#hottags a{float:left;font-weight:500;margin-left:5px;}

</style>
{/literal}
<div class="menu" id="menu_editor" style="display:none;"></div>

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
<input type="hidden" name="cid" id="cid" value="{$result.cid}" />
<input type="hidden" name="mid" id="mid" value="{$result.mid}" />
<input type="hidden" name="id" id="id" value="{$result.id|default:0}" />
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="2">
	{$EditOption} Tourist Routes	</td>
    </tr>
  <tr class="tr2">
    <td width="15%" style="text-align:center">Fields</td>
    <td width="85%" style="text-align:center">Content</td>
  </tr>
  <tr class="line">
    <td>推荐</td>
    <td>
			<input type="radio" value="0" name="digest" {if $result.digest=='0'}checked="checked"{/if} /> 
			普通路线
			<input type="radio" value="1" name="digest" {if $result.digest=='1'}checked="checked"{/if} /> 栏目推荐
			<input type="radio" value="2" name="digest" {if $result.digest=='2'}checked="checked"{/if} /> 站点推荐
			<input type="radio" value="3" name="digest" {if $result.digest=='3'}checked="checked"{/if} /> 头条推荐		</td>
  </tr>

	<tr class="line">
    <td>标题</td>
    <td><input class="input" name="title" id="title" value="{$result.title}" size="70">  </td></tr>
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

  <tr class="line">
    <td>负责人</td>
    <td>
	<select name="uid">
	<option value="0">请选择路线负责人</option>
	{html_options options=$manager selected=$result.uid}
	</select></td>
  </tr>
  
  <tr class="line">
    <td>请选择所属相关类别</td>
    <td>
		<select name="relatedcid[]" size="5" multiple>
		{section name=s loop=$relatedcid}
			{if $cid!=$relatedcid[s].cid}
			<option value="{$relatedcid[s].cid}" {if @in_array($relatedcid[s].cid,$result.relatedcid)}selected="selected"{/if}>{$relatedcid[s].name}</option>
			{/if}
		{/section}
		</select>
	</td>
  </tr>
  <tr class="line">
    <td>destinations</td>
    <td><input class="input" name="destinations" id="destinations" value="{$result.destinations}" size="70"></td>
  </tr>

  <tr class="line">
    <td>departure dates</td>
    <td><input class="input" name="departuredates" id="departuredates" value="{$result.departuredates}" size="70"></td>
  </tr>

  <tr class="line">
    <td>路线景点</td>
    <td>
	<input class="input" name="sightspot" id="sightspot" value="{$result.sightspot}" size="70" onclick="showtag();" readonly>
	<fieldset id="spot_show" style="width:70%;display:none;">
		<legend class="fieldset-close">景点列表</legend>
		<div id="hottags" style="height:auto;overflow-Y:auto;">
			{foreach item=contact from=$allViewSpot}
				<span>{$contact.name}</span>
				{foreach item=item from=$contact.child}
					<a onclick="javascript:joinspot(this,{$item.id});" value='{$item.title}' {if $item.flag==1}style="background:red;"{/if}>{$item.title}</a>
				{/foreach}
				<br/>
			{/foreach}		</div>
	</fieldset>	</td>
  </tr>
  {literal}
  <script>
  	function joinspot(obj,viewspotId){
		var obj2 = document.getElementById('sightspot');
		if(obj.style.background=='red'){
			obj.style.background='';
			//alert("-->"+viewspotId+"."+obj.value);
			var ovalue = obj2.value;
			
			obj2.value = ovalue.replace(viewspotId+"."+obj.value+"-->","");
			
			if(obj2.value==ovalue){
				obj2.value = ovalue.replace("-->"+viewspotId+"."+obj.value,"");
			}
			
			if(obj2.value==ovalue){
				obj2.value = ovalue.replace(viewspotId+"."+obj.value,"");
			}
			
		}else{
			if(obj2.value==''){
				obj2.value = viewspotId+'.'+obj.value;
			}else{
				obj2.value = obj2.value+"-->"+viewspotId+"."+obj.value;
			}
			obj.style.background='red';
		}
	}
  </script>
  {/literal}
  <tr class="line">
    <td>Highlights</td>
    <td>
	<div><input type="hidden" id="highlights" name="highlights" style="display:none" value="{$result.highlights}" />
	<input type="hidden" id="highlights___Config" value="" style="display:none" /><iframe id="highlights___Frame" name="highlights___Frame" src="../../libs/fckeditor/editor/fckeditor.html?InstanceName=highlights&amp;Toolbar=Basic" width="650" height="150" frameborder="0" scrolling="no"></iframe></div>	</td>
  </tr>
  <tr class="line">
    <td>详细</td>
    <td>
	<div>
	<input name="content" id="content" style=" display:none" type="hidden" value='{$result.content}' /> 
	<input id="content___Config" style="display: none" type=hidden> 
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
	<!--<input type=button onclick="alert(getContentValue());"> -->	</td>
  </tr>
 
  <tr class="line">
    <td>价格</td>
    <td><input class="input" name="prices" id="prices" value="{$result.prices}" size="70"></td>
  </tr>
    
  <tr class="line">
    <td>价格说明 </td>
    <td>
	<textarea rows="5" name="cost" class="form-textarea">{$result.cost}</textarea>	</td>
  </tr>
  <tr class="line">
    <td>Photo</td>
    <td>
	  {if $EditOption=='New'}
	  <img src="../../../admin/images/null.gif" id="show_pic" height="96px" style="vertical-align:middle" />
	  {else}
	  <img src="{$result.photo|default:'../../../admin/images/null.gif'}" id="show_pic" height="96px" style="vertical-align:middle" />
	  {/if}
      <input type="button" class="btn" onclick="selectImg('photo');" value="Insert">
	  <input type="button" class="btn" onclick="removeImg('photo');" value="Remove">
	  <input type="hidden" class="input" name="photo" id="photo" value="{$result.photo}" size="70"></td>
  </tr>
  <tr class="line">
    <td>&nbsp;</td>
    <td>
	{literal}
	<script>
	function fieldset_open_close(obj){
		if($(obj).attr('class')=='fieldset-close'){
			$(obj).attr('class','fieldset-open');
			$(obj).parent().children('.form-item').css('display','none');
		}else{
			$(obj).attr('class','fieldset-close');
			$(obj).parent().children(".form-item").css('display','');
		}
	}
	</script>
	{/literal}
	<fieldset><legend class="fieldset-close" onclick="fieldset_open_close(this);">Meta tags</legend>
	<div class="form-item">
 <label for="edit-nodewords-description">Description: </label><br />
 <textarea rows="5" name="description" id="edit-nodewords-description"  class="form-textarea">{$result.description}</textarea>
 <div class="description">Enter a description for this page. Limit your description to about 20 words, with a maximum of <em>255</em> characters. It should not contain any HTML tags or other formatting. When you leave this field empty, the teaser will be used as description.</div>
</div>
<div class="form-item">
 <label for="edit-nodewords-keywords">Keywords: </label><br />
 <input type="text" maxlength="255" name="keywords" id="edit-nodewords-keywords" size="60" value="{$result.keywords}" class="form-text" />
 <div class="description">Enter a comma separated list of keywords for this page. Avoid duplication of words as this will lower your search engine ranking.</div>
</div>
</fieldset>	</td>
  </tr>
  <tr class="line">
	  <td>&nbsp;</td>
	  <td>
		<fieldset><legend class="fieldset-close" onclick="fieldset_open_close(this);">Node Weight</legend><div class="form-item">
 <label for="edit-node-weight">Weight: </label>
 <select name="weight" class="form-select" id="edit-node-weight" ><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option><option value="61">61</option><option value="62">62</option><option value="63">63</option><option value="64">64</option><option value="65">65</option><option value="66">66</option><option value="67">67</option><option value="68">68</option><option value="69">69</option><option value="70">70</option><option value="71">71</option><option value="72">72</option><option value="73">73</option><option value="74">74</option><option value="75">75</option><option value="76">76</option><option value="77">77</option><option value="78">78</option><option value="79">79</option><option value="80">80</option><option value="81">81</option><option value="82">82</option><option value="83">83</option><option value="84">84</option><option value="85">85</option><option value="86">86</option><option value="87">87</option><option value="88">88</option><option value="89">89</option><option value="90">90</option></select>
 <div class="description">In a node list context (such as the front page or term pages), list items (e.g. "teasers") will be ordered by "stickiness" then by "node weight" then by "authored on" datestamp. Items with a lower (lighter) node weight value will appear above those with a higher (heavier) value.</div>
</div>
</fieldset></td>
  </tr>
  <tr class="line">
	  <td>自定义时间</td>
	  <td>
		<input type="text" name="postdate" value="{$result.postdate|date_format:"%Y-%m-%d"}"  class="input" id="postdate" onFocus="{literal}WdatePicker({startDate:'%y-%M-%d',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true}){/literal}" size="70" /></td>
  </tr>
</table>
</div>
<div class="sub">
<input type="hidden" name="UrlReferer" value="{$result.url}">
<input type="hidden" name="EditOption" value="{$result.EditOption}">
<input type="hidden" name="aid" id="aid" value="{$result.aid|default:'0'}" />
<input type="submit" name="Submit" value="提交" class="btn" />
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

function showtag(){
	if(document.getElementById('spot_show').style.display == ''){
		document.getElementById('spot_show').style.display = 'none';
	}else{
		document.getElementById('spot_show').style.display = '';
	}
}

function selectValue(inputname,value){
	if(value!=''){
		document.getElementById(inputname).value=value;
	}
}
</script>

<script language="javascript">
var agt = navigator.userAgent.toLowerCase();
var is_ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
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

function ietruebody(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
}
function  randomvalue(low,high){
	return Math.floor(Math.random()*(1 + high -low) + low);
}
</script>
{/literal}
