<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.FC114_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/admin/javascript/jquery_last.js"></script>
<script src="{$smarty.const.URL}/admin/javascript/admin.js"></script>
<script type="text/javascript" src="{$smarty.const.URL}/ui/js/datepicker/WdatePicker.js"></script>
</head>
<base target="mainFrame">
<body>
<div class="t"  style="margin-top:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="seach_total" Method="GET" action="member_total.php" id="seach_total">
    <tr id="advanced_search" class="tr4">
    <td colspan="2">
    <!---搜索框添加--->
    查询时间：从<input type="text" name="create_at" value="{$create_at}" onclick="WdatePicker();" />
	      到<input type="text" name="create_at01" value="{$create_at01}" onclick="WdatePicker();" />
    <input type="submit" name="Submit" value="搜索" class="btn" />
    </td>
    </form>
    </tr>
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
	<td colspan="16">
	 <span style="text-align:left; float:left;">{$tim}注册会员：{$act_count}人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当前周注册人员：{$week_count}人</span>	 
	 <input style="float:right;" type="button" name="Submit1" value="导出数据" onclick="location.href='member_total.php?action=print&create_at={$create_at}&create_at01={$create_at01}';" class="btn1">
	</td>
  </tr>
  <tr class="tr2">
	<td >编号</td>
	<td>注册会员名</td>
	<td>发布房源</td>
	<td>查看房源</td>
	<td>查看房源详细</td>
  	<td>操作</td>
  </tr>
 {foreach from=$list item=item key=key}
	 <tr class="tr3 bgcolor">
		<td align="left">{$key+1}</td>
		<td align="left">{$item.username}<br />{$item.telephone}</td>
		<td align="left">{$item.act_count}套</td>
		<td align="left">{$item.watch_count}套</td>
		<td align="left">
			{foreach from=$item.house_info item=title}
			<p><a href="/house_item.php?sp={fp id=$title.id hosue_type=$title.house_type}" target="_blank">{$title.title|truncate:30:'...':true}&nbsp;</a></p>
			{foreachelse}
			<span style="text-align:left; float:left;">无</span>
			{/foreach}
			<td>无</td>
	 </tr>
 {/foreach}
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <form name="frm_search4" method="post" action="member_total.php?action=print_1&create_at={$create_at}&create_at01={$create_at01}" id="frm_search4">
	<td colspan="16">
	  <span style="text-align:left; float:left;">{$tim}发布房源：{$report}套</span>	 
	  <input style="float:right;" type="submit" name="Submit2" value="导出数据" class="btn2">
	</td>
    </form>
   </tr>
   <tr class="tr2">
	<td width='100'>编号</td>
	<td width='200'>房源名称</td>
	<td width='170'>发布日期</td>
	<td width='160'>发布人</td>
	<td width='160'>被浏览次数</td>
  	<td width='200'>看房人员</td>
	<td width='100'>联系电话</td>
   </tr>
   {foreach from=$house_list item=item key=key}
         <tr class="tr3 bgcolor">
		<td align="left">{$key+1}</td>
		<td align="left">{$item.title}</td>
		<td align="left">{$item.create_at|date_format:"%Y-%m-%d"}</td>
		<td align="left">{$item.user_name}</td>
		<td align="left">{$item.watched|default:"0"}</td>
		<td align="left">
			{foreach from=$item.customer_info item=customer}
			<p><a href="">{$customer.username}&nbsp;,&nbsp;{$customer.telephone|truncate:30:'...':true}</a></p>
			
			{/foreach}
		</td>
		<td align="left">{$item.telphone}</td>
	 </tr>
	 </tr>
   {/foreach}
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
      <form name="frm_search5" method="post" action="member_total.php?action=print_2&create_at={$create_at}&create_at01={$create_at01}" id="frm_search5">
	<td colspan="16">
	  <span style="text-align:left; float:left;">{$tim}查看房源：{$watched}套</span>
	   <input style="float:right;" type="submit" name="Submit3" value="导出数据" class="btn3">
	</td>
      </form>
   </tr>
    <tr class="tr2">
	<td width='100'>编号</td>
	<td width='200'>房源名称</td>
	<td width='170'>发布日期</td>
	<td width='160'>发布人</td>
	<td >被浏览次数</td>
  	<td width='200'>看房人员</td>
   </tr>
   {foreach from=$house item=item key=key}
	<tr class="tr3" bgcolor >
		<td align="left">{$key+1}</td>
		<td align="left">{$item.title}</td>
		<td align="left">{$item.create_at|date_format:"%Y-%m-%d"}</td>
		<td align="left">{$item.user_name}</td>
		<td align="left">{$item.watch_count|default:"0"}</td>
		<td align="left">
			{foreach from=$item.customer item=customer3}
			<p>{$customer3.username}&nbsp;&nbsp;{$customer3.telephone|truncate:30:'...':true}</p>
			{/foreach}
		</td>
	</tr>
   {/foreach}
</table>
</div>
{include file="../tpl/admin/footer.tpl"}