<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<link href="/ui/css/common.css" rel="stylesheet" type="text/css" >
<link href="/css/thickbox.css" rel="stylesheet" type="text/css" >
<link href="/ui/paladin/css/style.css" rel="stylesheet" type="text/css" >
<!--jquery-->
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/scripts/jquery_last.js"></script>
<script src="{$smarty.const.URL}/scripts/admin.js"></script>
</head>
<script type="text/javascript">
var tel=new Array(); 
var mail = new Array();
{section name=s loop=$media_name_info}
 	tel[{$media_name_info[s].id}]='{$media_name_info[s].mediaperson_telephone}';
	mail[{$media_name_info[s].id}]='{$media_name_info[s].mediaperson_mail}';	
{/section}
</script>
{literal}
<script type="text/javascript" language="javascript">
$(document).ready(function(){
<!--推广网站全选-->
	$("p").click(function(){
		$(".check>input").each(function(){
			$(this).attr("checked",!this.checked);
		});
	});
	$(".mediaperson1").change(function(){
		var value=$(this).val();
		$("#telephone"+$(this).attr('item')).html(tel[value]);
		$("#mail"+$(this).attr('item')).html(mail[value]);
	});
	$(".mediaperson2").change(function(){
		var value=$(this).val();
		$("#telephone"+$(this).attr('item')).html(tel[value]);
		$("#mail"+$(this).attr('item')).html(mail[value]);
	});
	$(".mediaperson3").change(function(){
		var value=$(this).val();
		$("#telephone"+$(this).attr('item')).html(tel[value]);
		$("#mail"+$(this).attr('item')).html(mail[value]);
	});
});
</script>
{/literal}
{literal}
<style type="text/css">
.input{width:200px;}
.description{ color:#666666; font-size:12px}
</style>
{/literal}
<base target="mainFrame">
<body style="margin-top:5px">
<form name="form1" id="form1" method="post" action="/admin/member/paladinproject.php?action=save">
<input type="hidden" name="id" value="{$projectInfo.id}" class="input" >
<div class="fb_pro_box">
            <table width="775" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="5" bgcolor="#f7fbef"><b class="main_tit">项目基础信息</b></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff"><span class="xmmc">项目名称：</span></td>
                <td colspan="2"><span class="srkd"><input type="text" name="project_name" id="project_name" value="{$projectInfo.project_name}" /></span></td>
                <td align="right" bgcolor="#edfcff"><span class="xmmc">项目地址：</span></td>
                <td width="372"><input type="text" name="project_address" value="{$projectInfo.project_address}" id="project_address" class="input" /></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">项目宣传口号：</td>
                <td colspan="2"><input type="text" name="slogan" value="{$projectInfo.slogan}" id="slogan" class="input" /></td>
                <td align="right" bgcolor="#edfcff">项目网站：</td>
                <td><input type="text" name="project_website" id="project_website" /></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">项目负责人</b></td>
                    <td colspan="2">
                        <input type="text" name="project_person" id="project_person" value="{$projectInfo.project_person}"/>
                    </td>
                	<td align="right" bgcolor="#edfcff">项目负责人电话</td>
                    <td colspan="2" bgcolor="#f7fbef">
                    <input type="text" name="project_person_tel" id="project_person_tel" value="{$projectInfo.project_person_tel}" />
                    </td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">物业类型：</td>
                <td colspan="4" class="sel_box">
                {foreach key=key item=item from=$projectInfo.pm_type_text}
					{if $key=='22302'}<span id='child_pmtype' style="color:#666666">({/if}
					<label><input type="checkbox" name="pm_type[]" class="pm_type" value="{$key}" {if @in_array($key, $projectInfo.pm_type_selected)} checked="checked" {/if} />{$item}</label>&nbsp;
				{/foreach})</span>
                </td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">售楼处：</td>
                <td colspan="2"><input type="text" name="sale_address" value="{$projectInfo.sale_address}" id="sale_address" class="input" ></td>
                <td align="right" bgcolor="#edfcff">售楼处电话：</td>
                <td><input type="text" name="telephone" value="{$projectInfo.telephone}" id="telephone" class="input" /></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">地区：</td>
                <td colspan="2"><select name="district" id="district" class="input" >
         <option value="1" {if $projectInfo.district=="1"} selected="selected" {/if}>市区</option>
         <option value="2" {if $projectInfo.district=="2"} selected="selected" {/if}>郊县</option>
         <option value="3" {if $projectInfo.district=="3"} selected="selected" {/if}>其他</option>
       </select></td>
                <td align="right" bgcolor="#edfcff">行政区域：</td>
                <td><select name="borough" id="borough" class="input" >
		{html_options options=$projectInfo.borough_text selected=$projectInfo.borough}
	  </select></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">环线：</td>
                <td colspan="2"><select name="circle" id="circle" class="input" >
		{html_options options=$projectInfo.circle_text selected=$projectInfo.circle}
	  </select></td>
                <td align="right" bgcolor="#edfcff">方位：</td>
                <td><select name="direction" id="direction" class="input" >
		{html_options options=$projectInfo.direction_text selected=$projectInfo.direction}
	  </select></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">地铁线：</td>
                <td colspan="4" class="sel_box">
                <input type="radio" name="tube" value="0" {if $projectInfo.tube==0}checked="checked"{/if} />其他&nbsp;
		<input type="radio" name="tube" value="1" {if $projectInfo.tube==1}checked="checked"{/if} />一号线&nbsp;
	    <input type="radio" name="tube" value="2" {if $projectInfo.tube==2}checked="checked"{/if} />二号线&nbsp;
		<input type="radio" name="tube" value="3" {if $projectInfo.tube==3}checked="checked"{/if} />成灌高铁&nbsp;</td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">开发商：</td>
                <td colspan="2"><input type="text" name="developer" value="{$projectInfo.developer}" id="developer" class="input" ></td>
                <td align="right" bgcolor="#edfcff">车位：</td>
                <td><input type="text" name="parking" value="{$projectInfo.parking}" id="parking" class="input"></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">建筑结构：</td>
                <td colspan="2"><input type="text" name="build_struct" value="{$projectInfo.build_struct}" id="build_struct" class="input" /></td>
                <td align="right" bgcolor="#edfcff">项目状态：</td>
                <td><select name="project_status" id="project_status" class="input" >
		{html_options options=$projectInfo.project_status_value selected=$projectInfo.project_status}
	  </select></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">占地面积：</td>
                <td colspan="2"><input type="text" name="total_occupy" value="{$projectInfo.total_occupy}" id="total_occupy" class="input" />亩</td>
                <td align="right" bgcolor="#edfcff">建筑密度：</td>
                <td><input type="text" name="project_build_density" value="{$projectInfo.project_build_density}" id="project_build_density" class="input" /></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">总建筑面积：</td>
                <td colspan="2"><input type="text" name="project_total_area" value="{$projectInfo.project_total_area}" id="project_total_area" class="input" />万平方米</td>
                <td align="right" bgcolor="#edfcff">绿地率：</td>
                <td><input type="text" name="project_greenbelt" value="{$projectInfo.project_greenbelt}" id="project_greenbelt" class="input" /></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">容积率：</td>
                <td colspan="2"><input type="text" name="project_cubage" value="{$projectInfo.project_cubage}" id="project_cubage" class="input" /></td>
                <td align="right" bgcolor="#edfcff">物业管理费：</td>
                <td><input type="text" name="manage_price" value="{$projectInfo.manage_price}" id="manage_price" class="input" ></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">物业公司：</td>
                <td colspan="2"><input type="text" name="manage_company" value="{$projectInfo.manage_company}" id="manage_company" class="input" ></td>
                <td align="right" bgcolor="#edfcff">施工单位：</td>
                <td><input type="text" name="construct_company" value="{$projectInfo.construct_company}" id="construct_company" class="input" ></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">(住)设计单位：</td>
                <td colspan="2"><input type="text" name="design_company" value="{$projectInfo.design_company}" id="design_company" class="input" ></td>
                <td align="right" bgcolor="#edfcff">其他合作单位：</td>
                <td><input type="text" name="other_company" value="{$projectInfo.other_company}" id="other_company" class="input" /></td>
              </tr>
              <tr>
                <td colspan="5" bgcolor="#f7fbef"><b class="main_tit">项目简介</b></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">项目简介：</td>
                <td colspan="4"><textarea name="description" id="description" class="input" style="width: 500px; height: 150px;">{$projectInfo.description}</textarea></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">小区配套：</td>
                <td colspan="4"><textarea name="project_equipment" id="project_equipment" cols="45" rows="5">{$projectInfo.project_equipment}</textarea></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">其他：</td>
                <td colspan="4"><textarea name="other_info" id="other_info" class="input" style="width: 500px; height: 150px;">{$projectInfo.other_info}</textarea></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff">上传图片压缩包：</td>
                <td colspan="4"><input type="file" name="pic_packageurl" id="pic_packageurl" class="input"  style="height:20px"/></td>
              </tr>
              <tr>
                <td colspan="5" bgcolor="#f7fbef"><b class="main_tit">媒体对接人</b></td>
              </tr>
              <tr>
                <td colspan="5">
                    <table width="775" border="0" cellspacing="0" cellpadding="0" style="border:none" class="sel_box">
                      <tr>
                        <td width="46" align="center" valign="middle" bgcolor="#edfcff">
			<p style="color:blue;">【全选】</p></td>
                        <td width="112" align="center" valign="middle" bgcolor="#edfcff">媒体名称</td>
                        <td width="129" align="center" valign="middle" bgcolor="#edfcff">联系人</td>
                        <td width="132" align="center" valign="middle" bgcolor="#edfcff">联系电话</td>
                        <td width="356" align="center" valign="middle" bgcolor="#edfcff">邮箱</td>
                      </tr>
                      <div id="div_media">
		    {foreach from=$house_media_text item=house_text key=k}
                      <tr>
                        <td align="center" valign="middle">
				<div class="check">
				<input type="checkbox" name="media[]" id="checkbox2" {if @in_array($k, $projectInfo.pm_media_selected)} checked="checked" {/if} value="{$k}" />
				</div>
			</td>
                        <td align="center" valign="middle">{$house_text}</td>
                        <td align="center" valign="middle">
			<select name="mediaperson[]" item="{$k}" class="mediaperson{$k}">
				{foreach from=$media_name_info item=media_info key=key}
					{if $k == $media_info.media_name}
					<option value="{$media_info.id}" {if @in_array($media_info.id, $projectInfo.pm_media_person)} selected="selected" {/if}>
						{$media_info.mediaperson_name}
					</option>
					{/if}
				{/foreach}
			</select>
            <!--&KeepThis=true&TB_iframe=true&height=300&width=500 class="thickbox"-->
            <a href="/paladin/media.php?action=add">添加</a> 
			</td>
                        <td align="center" valign="middle">
			<p id="telephone{$k}">
            {assign var="q" value=$k}
			{foreach from=$media_name_info item=media_info}
				{if $q==$media_info.media_name}
                	{assign var="q" value=5}
					{$media_info.mediaperson_telephone}
				{/if}
			{/foreach}
			</p>
			</td>
                        <td align="center" valign="middle">
			<p id="mail{$k}">
            {assign var="q" value=$k}
			{foreach from=$media_name_info item=media_info}
				{if $q==$media_info.media_name}
                	{assign var="q" value=5}
					{$media_info.mediaperson_mail}
				{/if}
			{/foreach}
			</p>
			</td>
                      </tr>
		      {/foreach}
             </div>
			 {if $smarty.session.isAdmin>=0}
			   <tr>
                <td colspan="5" bgcolor="#f7fbef"><b class="main_tit">项目推广链接</b></td>
              </tr>
              <tr>
                <td align="right" bgcolor="#edfcff" width="100">项目所在网站：</td>
                <td colspan="4"><textarea name="project_mediawebsite" id="project_mediawebsite" cols="45" rows="5">{$projectInfo.project_mediawebsite}</textarea></td>
              </tr>
			  {/if}
                      <tr>
                        <td align="center" valign="middle">&nbsp;</td>
                        <td colspan="4" align="center" valign="middle">
				<input type="hidden" name="EditOption" value="{$EditOption}">
				<input type="submit" name="Submit" value="{if $EditOption=="edit"}修改{else}确认发布{/if}" class="btn_queren">
				<input type="button" name="Submit3" value="返回"  class="btn" onClick="history.back(-1);">
				</td>
                      </tr>
                    </table>
                </td>
              </tr>
            </table>
</div>
</form>

{include file="../tpl/admin/footer.tpl"}

</body>
</html>