<?php /* Smarty version 2.6.22, created on 2013-07-16 09:56:20
         compiled from admin/member/member_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/member/member_list.tpl', 23, false),array('modifier', 'default', 'admin/member/member_list.tpl', 54, false),array('modifier', 'date_format', 'admin/member/member_list.tpl', 55, false),)), $this); ?>
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
<div class="t" style="margin-top:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <form name="frm_search2" method="GET" action="member.php" id="frm_search2">
    <tr id="advanced_search" class="tr4">
    <td colspan="2">
    <!---搜索框添加--->
    人员名称:<input type="text" name="username" value="<?php echo $this->_tpl_vars['username']; ?>
" id="username" size="10" />&nbsp;&nbsp;
    电话:<input type="text" name="telephone" value="<?php echo $this->_tpl_vars['telephone']; ?>
" size="10"  />&nbsp;&nbsp;
    状态标志:<select name="flag" id="flag">
          <option value="">全部</option>
            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['flag_text'],'selected' => $this->_tpl_vars['flag']), $this);?>

          </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    注册时间：<input type="text" name="create_at" value="<?php echo $this->_tpl_vars['create_at']; ?>
" onclick="WdatePicker();" />
    <input type="submit" name="Submit" value="搜索" class="btn" />
    </td>
    </form>
    </tr>
</table>
</div>
<form name="form1" id="form1" method="post" action="?action=deleteall">
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="16">
      <span style="text-align:right; float:right;">今日登陆后台操作人数：<?php echo $this->_tpl_vars['act_count']['cnt']; ?>
人</span>    
      <div><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />会员信息</div></td>
  </tr>
  <tr class="tr2">
  	<td width='80px'>选择</td>
    <td width='200px'>用户名</td>
	<td width='100'>发布数量</td>
    <td width='220'>注册时间/最后登陆</td>
  	<td>操作</td>
  </tr>
<?php unset($this->_sections['s']);
$this->_sections['s']['name'] = 's';
$this->_sections['s']['loop'] = is_array($_loop=$this->_tpl_vars['memberList']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s']['show'] = true;
$this->_sections['s']['max'] = $this->_sections['s']['loop'];
$this->_sections['s']['step'] = 1;
$this->_sections['s']['start'] = $this->_sections['s']['step'] > 0 ? 0 : $this->_sections['s']['loop']-1;
if ($this->_sections['s']['show']) {
    $this->_sections['s']['total'] = $this->_sections['s']['loop'];
    if ($this->_sections['s']['total'] == 0)
        $this->_sections['s']['show'] = false;
} else
    $this->_sections['s']['total'] = 0;
if ($this->_sections['s']['show']):

            for ($this->_sections['s']['index'] = $this->_sections['s']['start'], $this->_sections['s']['iteration'] = 1;
                 $this->_sections['s']['iteration'] <= $this->_sections['s']['total'];
                 $this->_sections['s']['index'] += $this->_sections['s']['step'], $this->_sections['s']['iteration']++):
$this->_sections['s']['rownum'] = $this->_sections['s']['iteration'];
$this->_sections['s']['index_prev'] = $this->_sections['s']['index'] - $this->_sections['s']['step'];
$this->_sections['s']['index_next'] = $this->_sections['s']['index'] + $this->_sections['s']['step'];
$this->_sections['s']['first']      = ($this->_sections['s']['iteration'] == 1);
$this->_sections['s']['last']       = ($this->_sections['s']['iteration'] == $this->_sections['s']['total']);
?>
<tr class="tr3 bgcolor">
  <td align="left"><input name="ids[]" type="checkbox" id="sid_<?php echo $this->_tpl_vars['memberList'][$this->_sections['s']['index']]['uid']; ?>
" value="<?php echo $this->_tpl_vars['memberList'][$this->_sections['s']['index']]['uid']; ?>
"></td>
  <td align="left" style="width:115px;">
  <?php echo $this->_tpl_vars['memberList'][$this->_sections['s']['index']]['username']; ?>

  <br /><?php echo $this->_tpl_vars['memberList'][$this->_sections['s']['index']]['tel']; ?>

  </td>
  <td align="left"><?php echo ((is_array($_tmp=@$this->_tpl_vars['memberList'][$this->_sections['s']['index']]['taskcount'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
个</td>
  <td align="left">注:<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['memberList'][$this->_sections['s']['index']]['create_at'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")))) ? $this->_run_mod_handler('default', true, $_tmp, "0000-00-00") : smarty_modifier_default($_tmp, "0000-00-00")); ?>
<br>
  	登:<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['memberList'][$this->_sections['s']['index']]['logintime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%I:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%I:%S")))) ? $this->_run_mod_handler('default', true, $_tmp, "0000-00-00") : smarty_modifier_default($_tmp, "0000-00-00")); ?>
  </td>
  <td align="left">
      <a href="member.php?action=edit&member_id=<?php echo $this->_tpl_vars['memberList'][$this->_sections['s']['index']]['uid']; ?>
&uid=<?php echo $this->_tpl_vars['memberList'][$this->_sections['s']['index']]['uid']; ?>
" target="_self">修改</a>&nbsp;
      <a href="member.php?action=delete&member_id=<?php echo $this->_tpl_vars['memberList'][$this->_sections['s']['index']]['uid']; ?>
&uid=<?php echo $this->_tpl_vars['memberList'][$this->_sections['s']['index']]['uid']; ?>
" onclick='return window.confirm("您确认要删除!");'>删除</a>
  </td>
</tr>
<?php endfor; endif; ?>
  <?php if ($this->_tpl_vars['company_count']): ?>
  <tr>
  	<td colspan="6" align="right" class="tr4">该公司发布房源总量为：<?php echo $this->_tpl_vars['company_count']['cnt']; ?>
套</td>
  </tr>
  <?php endif; ?>
</table>
</div>
<div class="t">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="tr4">
        <td>
        <input type="submit" value="全部删除" name="btn_del" onclick='return window.confirm("您确认要删除!");' class="btn">
        <input type="hidden" name="EditOption" value="<?php echo $this->_tpl_vars['EditOption']; ?>
">
        </td>
        <td style="text-align:right"><?php echo ((is_array($_tmp=@$this->_tpl_vars['splitPageStr'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
      </tr>
    </table>
</div>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../tpl/admin/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>