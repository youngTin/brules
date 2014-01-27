<?php /* Smarty version 2.6.22, created on 2013-07-16 10:08:46
         compiled from admin/system/manager_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'admin/system/manager_list.tpl', 49, false),array('modifier', 'date_format', 'admin/system/manager_list.tpl', 51, false),array('function', 'fp', 'admin/system/manager_list.tpl', 53, false),)), $this); ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo @WEB_TITLE; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo @URL; ?>
/admin/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<base target="mainFrame">
<body>
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td style="text-align:left">
	<form name="frm_search2" method="GET" action="manager.php" id="frm_search2">
搜索：
<!---搜索框添加--->
	  	  	 管理员:
	  	  <input type="text" name="username" value="<?php echo $this->_tpl_vars['username']; ?>
" id="username" />&nbsp;&nbsp;
	   	  <!---结束--->
	 <input type="submit" name="Submit" value="查看管理员" class="btn" />
	 </form>
		<input type="button" value="添加管理员" class="btn" onclick="self.location='manager.php?action=add'" /></td>
  </tr>
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr class="head">
    <td colspan="16">
	<div style="float:right"></div>
    <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />&nbsp;
	编辑管理员
	</td>
   </tr>
   <tr class="tr2">
    <td width="5%">&nbsp;</td>
	<td>UID</td>
    <td>管理员</td>
    <td>ip</td>
    <td>上次登录时间</td>
      <td>操作</td>
  </tr>

<?php unset($this->_sections['s']);
$this->_sections['s']['name'] = 's';
$this->_sections['s']['loop'] = is_array($_loop=$this->_tpl_vars['List']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
  <td><img src="/admin/images/admin.gif" align="absmiddle" /></td>
  <td><?php echo $this->_tpl_vars['List'][$this->_sections['s']['index']]['uid']; ?>
</td>
  <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['List'][$this->_sections['s']['index']]['username'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
<?php if ($this->_tpl_vars['List'][$this->_sections['s']['index']]['isadmin'] == 1): ?><span style="color:#00CCCC">&nbsp;最高管理员</span><?php endif; ?></td>
  <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['List'][$this->_sections['s']['index']]['ip'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
  <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['List'][$this->_sections['s']['index']]['logintime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')))) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
  <td>
<a href="manager.php?action=edit&sp=<?php echo WebSmarty::_fp_(array('uid' => $this->_tpl_vars['List'][$this->_sections['s']['index']]['uid'],'username' => $this->_tpl_vars['List'][$this->_sections['s']['index']]['username']), $this);?>
"><img src="/admin/images/edit.gif" align="absmiddle" alt="编辑" /></a>
<?php if ($this->_tpl_vars['List'][$this->_sections['s']['index']]['isadmin'] != 1): ?>
<a href="manager.php?action=del&sp=<?php echo WebSmarty::_fp_(array('uid' => $this->_tpl_vars['List'][$this->_sections['s']['index']]['uid']), $this);?>
" onclick='return window.confirm("您确认要删除!");'><img src="/admin/images/del.gif" align="absmiddle" alt="删除" /></a>
<?php endif; ?>
  </td>
  </tr>
<?php endfor; endif; ?> 
</table>
</div>

<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>&nbsp;</td>
    <td style="text-align:right"><?php echo ((is_array($_tmp=@$this->_tpl_vars['splitPageStr'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
  </tr>
</table>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../tpl/admin/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>