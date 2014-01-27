<?php /* Smarty version 2.6.22, created on 2013-07-16 09:56:18
         compiled from admin/member/member_total_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'fp', 'admin/member/member_total_list.tpl', 52, false),array('modifier', 'truncate', 'admin/member/member_total_list.tpl', 52, false),array('modifier', 'date_format', 'admin/member/member_total_list.tpl', 85, false),array('modifier', 'default', 'admin/member/member_total_list.tpl', 87, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo @FC114_TITLE; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo @URL; ?>
/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="<?php echo @URL; ?>
/admin/javascript/jquery_last.js"></script>
<script src="<?php echo @URL; ?>
/admin/javascript/admin.js"></script>
<script type="text/javascript" src="<?php echo @URL; ?>
/ui/js/datepicker/WdatePicker.js"></script>
</head>
<base target="mainFrame">
<body>
<div class="t"  style="margin-top:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="seach_total" Method="GET" action="member_total.php" id="seach_total">
    <tr id="advanced_search" class="tr4">
    <td colspan="2">
    <!---搜索框添加--->
    查询时间：从<input type="text" name="create_at" value="<?php echo $this->_tpl_vars['create_at']; ?>
" onclick="WdatePicker();" />
	      到<input type="text" name="create_at01" value="<?php echo $this->_tpl_vars['create_at01']; ?>
" onclick="WdatePicker();" />
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
	 <span style="text-align:left; float:left;"><?php echo $this->_tpl_vars['tim']; ?>
注册会员：<?php echo $this->_tpl_vars['act_count']; ?>
人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当前周注册人员：<?php echo $this->_tpl_vars['week_count']; ?>
人</span>	 
	 <input style="float:right;" type="button" name="Submit1" value="导出数据" onclick="location.href='member_total.php?action=print&create_at=<?php echo $this->_tpl_vars['create_at']; ?>
&create_at01=<?php echo $this->_tpl_vars['create_at01']; ?>
';" class="btn1">
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
 <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	 <tr class="tr3 bgcolor">
		<td align="left"><?php echo $this->_tpl_vars['key']+1; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['item']['username']; ?>
<br /><?php echo $this->_tpl_vars['item']['telephone']; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['item']['act_count']; ?>
套</td>
		<td align="left"><?php echo $this->_tpl_vars['item']['watch_count']; ?>
套</td>
		<td align="left">
			<?php $_from = $this->_tpl_vars['item']['house_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['title']):
?>
			<p><a href="/house_item.php?sp=<?php echo WebSmarty::_fp_(array('id' => $this->_tpl_vars['title']['id'],'hosue_type' => $this->_tpl_vars['title']['house_type']), $this);?>
" target="_blank"><?php echo ((is_array($_tmp=$this->_tpl_vars['title']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30, '...', true) : smarty_modifier_truncate($_tmp, 30, '...', true)); ?>
&nbsp;</a></p>
			<?php endforeach; else: ?>
			<span style="text-align:left; float:left;">无</span>
			<?php endif; unset($_from); ?>
			<td>无</td>
	 </tr>
 <?php endforeach; endif; unset($_from); ?>
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <form name="frm_search4" method="post" action="member_total.php?action=print_1&create_at=<?php echo $this->_tpl_vars['create_at']; ?>
&create_at01=<?php echo $this->_tpl_vars['create_at01']; ?>
" id="frm_search4">
	<td colspan="16">
	  <span style="text-align:left; float:left;"><?php echo $this->_tpl_vars['tim']; ?>
发布房源：<?php echo $this->_tpl_vars['report']; ?>
套</span>	 
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
   <?php $_from = $this->_tpl_vars['house_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
         <tr class="tr3 bgcolor">
		<td align="left"><?php echo $this->_tpl_vars['key']+1; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['item']['title']; ?>
</td>
		<td align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['create_at'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['item']['user_name']; ?>
</td>
		<td align="left"><?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['watched'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</td>
		<td align="left">
			<?php $_from = $this->_tpl_vars['item']['customer_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['customer']):
?>
			<p><a href=""><?php echo $this->_tpl_vars['customer']['username']; ?>
&nbsp;,&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['customer']['telephone'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30, '...', true) : smarty_modifier_truncate($_tmp, 30, '...', true)); ?>
</a></p>
			
			<?php endforeach; endif; unset($_from); ?>
		</td>
		<td align="left"><?php echo $this->_tpl_vars['item']['telphone']; ?>
</td>
	 </tr>
	 </tr>
   <?php endforeach; endif; unset($_from); ?>
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
      <form name="frm_search5" method="post" action="member_total.php?action=print_2&create_at=<?php echo $this->_tpl_vars['create_at']; ?>
&create_at01=<?php echo $this->_tpl_vars['create_at01']; ?>
" id="frm_search5">
	<td colspan="16">
	  <span style="text-align:left; float:left;"><?php echo $this->_tpl_vars['tim']; ?>
查看房源：<?php echo $this->_tpl_vars['watched']; ?>
套</span>
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
   <?php $_from = $this->_tpl_vars['house']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	<tr class="tr3" bgcolor >
		<td align="left"><?php echo $this->_tpl_vars['key']+1; ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['item']['title']; ?>
</td>
		<td align="left"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['create_at'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td>
		<td align="left"><?php echo $this->_tpl_vars['item']['user_name']; ?>
</td>
		<td align="left"><?php echo ((is_array($_tmp=@$this->_tpl_vars['item']['watch_count'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
</td>
		<td align="left">
			<?php $_from = $this->_tpl_vars['item']['customer']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['customer3']):
?>
			<p><?php echo $this->_tpl_vars['customer3']['username']; ?>
&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['customer3']['telephone'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30, '...', true) : smarty_modifier_truncate($_tmp, 30, '...', true)); ?>
</p>
			<?php endforeach; endif; unset($_from); ?>
		</td>
	</tr>
   <?php endforeach; endif; unset($_from); ?>
</table>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../tpl/admin/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>