<?php /* Smarty version 2.6.22, created on 2013-07-20 13:43:16
         compiled from admin/system/manager_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'admin/system/manager_edit.tpl', 103, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LD-managerEdit</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo @URL; ?>
/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo @URL; ?>
/scripts/admin.js"></script>
<!--jquery-->
<script type="text/javascript" charset="UTF-8" src="<?php echo @URL; ?>
/scripts/formValidator/jquery_last.js"></script>

</head>
<?php echo '
<script type="text/javascript" >
$(document).ready(function(){
	$.formValidator.initConfig({formid:"form1",onerror:function(){alert("校验没有通过，具体错误请看错误提示")}});
	});
</script>
'; ?>



<base target="mainFrame">
<body>
<div class="t" style="margin-top:5px">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td style="text-align:left">
	 <input type="submit" name="Submit" value="查看管理员" class="btn" onclick="self.location='manager.php'" />
	 <input type="button" value="添加管理员" class="btn" onclick="self.location='manager.php?action=add'" /></td>
  </tr>
</table>
</div>

<form name="form1" method="post" action="manager.php?action=save" onsubmit="return chkform();">
<input type="hidden" name="uid" value="<?php echo $this->_tpl_vars['managerInfo']['uid']; ?>
" class="input" >
<div class="t" style="width:50%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="head">
    <td colspan="2">
	<?php if ($this->_tpl_vars['EditOption'] == 'edit'): ?>修改<?php else: ?>新增<?php endif; ?>管理员</td>
  </tr>
   <tr class="line">
	  <td width="25%">管理员账号:</td>
	  <td width="75%"><input type="text" name="username" value="<?php echo $this->_tpl_vars['managerInfo']['username']; ?>
" id="username" class="input" <?php if ($this->_tpl_vars['EditOption'] == 'edit'): ?>disabled="disabled"<?php endif; ?> /></td>
    </tr>
	 <tr class="line">
	  <td><?php if ($this->_tpl_vars['EditOption'] == 'edit'): ?>新密码<?php else: ?>管理员密码:<?php endif; ?></td>
	  <td><input type="text" name="password" value="" id="re_password" class="input" >&nbsp;<?php if ($this->_tpl_vars['EditOption'] == 'edit'): ?>不输入密码，表示不修改<?php endif; ?></td>
    </tr>
	 <tr class="line">
	  <td>密码确认:</td>
	  <td><input type="text" name="re_password" value="" id="re_password" class="input" ></td>
    </tr>
</table>
</div>

<div class="t" style="width:50%">
<table border="0" cellspacing="0" cellpadding="0">
<tr class="head">
  <td colspan="2">权限设置</td>
</tr>
<?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['categoryInfo']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['a']['show'] = true;
$this->_sections['a']['max'] = $this->_sections['a']['loop'];
$this->_sections['a']['step'] = 1;
$this->_sections['a']['start'] = $this->_sections['a']['step'] > 0 ? 0 : $this->_sections['a']['loop']-1;
if ($this->_sections['a']['show']) {
    $this->_sections['a']['total'] = $this->_sections['a']['loop'];
    if ($this->_sections['a']['total'] == 0)
        $this->_sections['a']['show'] = false;
} else
    $this->_sections['a']['total'] = 0;
if ($this->_sections['a']['show']):

            for ($this->_sections['a']['index'] = $this->_sections['a']['start'], $this->_sections['a']['iteration'] = 1;
                 $this->_sections['a']['iteration'] <= $this->_sections['a']['total'];
                 $this->_sections['a']['index'] += $this->_sections['a']['step'], $this->_sections['a']['iteration']++):
$this->_sections['a']['rownum'] = $this->_sections['a']['iteration'];
$this->_sections['a']['index_prev'] = $this->_sections['a']['index'] - $this->_sections['a']['step'];
$this->_sections['a']['index_next'] = $this->_sections['a']['index'] + $this->_sections['a']['step'];
$this->_sections['a']['first']      = ($this->_sections['a']['iteration'] == 1);
$this->_sections['a']['last']       = ($this->_sections['a']['iteration'] == $this->_sections['a']['total']);
?>
	<tr class="tr2">
	  <td colspan="2"><?php echo $this->_tpl_vars['categoryInfo'][$this->_sections['a']['index']]['name']; ?>

	  <!--<input name='set_category[][<?php echo $this->_tpl_vars['categoryInfo'][$this->_sections['a']['index']]['id']; ?>
]' id="p_category<?php echo $this->_tpl_vars['categoryInfo'][$this->_sections['a']['index']]['id']; ?>
" type="checkbox" value="<?php echo $this->_tpl_vars['categoryInfo'][$this->_sections['a']['index']]['id']; ?>
" />-->
	  </td>
	</tr>
	<?php unset($this->_sections['b']);
$this->_sections['b']['name'] = 'b';
$this->_sections['b']['loop'] = is_array($_loop=$this->_tpl_vars['categoryInfo'][$this->_sections['a']['index']]['child']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['b']['show'] = true;
$this->_sections['b']['max'] = $this->_sections['b']['loop'];
$this->_sections['b']['step'] = 1;
$this->_sections['b']['start'] = $this->_sections['b']['step'] > 0 ? 0 : $this->_sections['b']['loop']-1;
if ($this->_sections['b']['show']) {
    $this->_sections['b']['total'] = $this->_sections['b']['loop'];
    if ($this->_sections['b']['total'] == 0)
        $this->_sections['b']['show'] = false;
} else
    $this->_sections['b']['total'] = 0;
if ($this->_sections['b']['show']):

            for ($this->_sections['b']['index'] = $this->_sections['b']['start'], $this->_sections['b']['iteration'] = 1;
                 $this->_sections['b']['iteration'] <= $this->_sections['b']['total'];
                 $this->_sections['b']['index'] += $this->_sections['b']['step'], $this->_sections['b']['iteration']++):
$this->_sections['b']['rownum'] = $this->_sections['b']['iteration'];
$this->_sections['b']['index_prev'] = $this->_sections['b']['index'] - $this->_sections['b']['step'];
$this->_sections['b']['index_next'] = $this->_sections['b']['index'] + $this->_sections['b']['step'];
$this->_sections['b']['first']      = ($this->_sections['b']['iteration'] == 1);
$this->_sections['b']['last']       = ($this->_sections['b']['iteration'] == $this->_sections['b']['total']);
?>
	<tr class="line">
	  <td><?php echo $this->_tpl_vars['categoryInfo'][$this->_sections['a']['index']]['child'][$this->_sections['b']['index']]['name']; ?>
</td>
	  <td><input name="set_category[]" type="checkbox" value="<?php echo $this->_tpl_vars['categoryInfo'][$this->_sections['a']['index']]['child'][$this->_sections['b']['index']]['id']; ?>
" <?php if ($this->_tpl_vars['categoryInfo'][$this->_sections['a']['index']]['child'][$this->_sections['b']['index']]['check'] == 'true'): ?>checked="checked"<?php endif; ?> /></td>
	</tr>
	<?php endfor; endif; ?>
<?php endfor; endif; ?>


<tr class="tr2">
<td colspan="2">栏目权限</td>
</tr>
<tr class="line">
	<td>
      请选择栏目
    </td>
    <td>
      <select name="privcate[]" size="10" multiple id="privcate">
	  <?php $_from = $this->_tpl_vars['columnInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['contact']):
?>
			<option value="<?php echo $this->_tpl_vars['contact']['id']; ?>
" <?php if ($this->_tpl_vars['contact']['check'] == 'true'): ?>selected="selected"<?php endif; ?>>&raquo;<?php echo $this->_tpl_vars['contact']['name']; ?>
</option>
			<?php $_from = $this->_tpl_vars['contact']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<option value="<?php echo $this->_tpl_vars['item']['id']; ?>
" <?php if ($this->_tpl_vars['item']['check'] == 'true'): ?>selected="selected"<?php endif; ?>>|---<?php echo $this->_tpl_vars['item']['name']; ?>
</option>
				<?php $_from = $this->_tpl_vars['item']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item2']):
?>
				<option value="<?php echo $this->_tpl_vars['item2']['id']; ?>
" <?php if ($this->_tpl_vars['item2']['check'] == 'true'): ?>selected="selected"<?php endif; ?>>|------<?php echo $this->_tpl_vars['item2']['name']; ?>
</option>
				<?php endforeach; endif; unset($_from); ?>
			<?php endforeach; endif; unset($_from); ?>
		<?php endforeach; endif; unset($_from); ?>
	  </select>
	  (按住Ctrl键进行多选操作)
    </td>
</tr>

</table>
</div>
<br /><br />
<center>
<input type="hidden" name="UrlReferer" value="<?php echo ((is_array($_tmp=@$this->_tpl_vars['UrlReferer'])) ? $this->_run_mod_handler('default', true, $_tmp, @URL) : smarty_modifier_default($_tmp, @URL)); ?>
">
<input type="hidden" name="EditOption" value="<?php echo $this->_tpl_vars['EditOption']; ?>
">
<input type="submit" name="Submit" value="<?php if ($this->_tpl_vars['EditOption'] == 'Edit'): ?>修改<?php else: ?>提交<?php endif; ?>" class="btn">
<input type="reset" name="Submit2" value="重置" class="btn">
<input type="button" name="Submit3" value="返回"  class="btn" onClick="history.back(-1);">
</center>
<br /><br />
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../tpl/admin/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>