<?php /* Smarty version 2.6.22, created on 2013-07-25 21:20:35
         compiled from admin/member/member_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/member/member_edit.tpl', 54, false),array('function', 'html_radios', 'admin/member/member_edit.tpl', 73, false),array('modifier', 'default', 'admin/member/member_edit.tpl', 73, false),array('modifier', 'date_format', 'admin/member/member_edit.tpl', 136, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Layout licence</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo @URL; ?>
/admin/css/admin.css" rel="stylesheet" type="text/css" />
<!--jquery-->
<script type="text/javascript" charset="UTF-8" src="<?php echo @URL; ?>
/ui/js/jquery_last.js"></script>
<!--日期控件-->
<script type="text/javascript" charset="UTF-8" src="<?php echo @URL; ?>
/ui/js/datepicker/WdatePicker.js"></script>
</head>
<base target="mainFrame">
<body>
<div class="t" style="margin-top:5px;">
<table  width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr  class="head"><td align="left" colspan="4"><a href="member.php">用户管理列表</a> >> <?php if ($this->_tpl_vars['EditOption'] == 'Edit'): ?>修改<?php else: ?>新增<?php endif; ?>用户管理信息</td></tr>
<form name="form1" method="post" action="member.php?action=save" onsubmit="return chkform();"> 

  <tr  class="tr2">
	<td width="15%" align="left">个人用户基本信息</td>
    <td width="35%" align="left">&nbsp;</td>
	<td width="15%" align="left">&nbsp;</td>
	<td width="35%" align="left">&nbsp;</td>
  </tr>


	<input type="hidden" name="uid" value="<?php echo $this->_tpl_vars['userInfo']['uid']; ?>
">
	 <tr  class="line">
	  <td align="right">登录名:</td>
	  <td>
	  	 <input type="text" name="username" value="<?php echo $this->_tpl_vars['userInfo']['username']; ?>
" id="username">
	 </td>
	  <td align="right">真实姓名:</td>
	  <td><input type="text" name="name" value="<?php echo $this->_tpl_vars['drInfo']['linkman']; ?>
" id="name"></td>
	</tr>
	 <tr class="line">
	  <td align="right">证件类型:</td>
	  <td>
	  	<select  name="card_type" value="<?php echo $this->_tpl_vars['userInfo']['card_type']; ?>
">
			<option value="身份证" <?php if ($this->_tpl_vars['userInfo']['card_type'] == '身份证'): ?> selected="selected" <?php endif; ?>>身份证</option>
			<option value="工作证" <?php if ($this->_tpl_vars['userInfo']['card_type'] == '工作证'): ?> selected="selected" <?php endif; ?>>工作证</option>
			<option value="护照" <?php if ($this->_tpl_vars['userInfo']['card_type'] == '护照'): ?> selected="selected" <?php endif; ?>>护照</option>
			<option value="经纪人证" <?php if ($this->_tpl_vars['userInfo']['card_type'] == '经纪人证'): ?> selected="selected" <?php endif; ?>>经纪人证</option>
			<option value="驾驶证" <?php if ($this->_tpl_vars['userInfo']['card_type'] == '驾驶证'): ?> selected="selected" <?php endif; ?>>驾驶证</option>
			<option value="其他" <?php if ($this->_tpl_vars['userInfo']['card_type'] == '其他'): ?> selected="selected" <?php endif; ?>>其他</option>
		</select>
	   <td align="right">身份证:</td>
		<td><input type="text" name="card_num" value="<?php echo $this->_tpl_vars['userInfo']['card_num']; ?>
" id="card_num" size="20" maxlength="18">	
		</td></td>
    </tr>
	<tr class="line">
	  <td align="right">性别:</td>
	  <td><select name="sex" id="sex">
		<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['userInfo']['sex_text'],'selected' => $this->_tpl_vars['drInfo']['sex']), $this);?>

	  </select>	</td>  	  	  	
	  <td align="right"></td>
	  <td>&nbsp; </td> 	  	
    </tr>

   <tr class="line">
      <td align="right">联系电话:</td>
      <td>
      <input type="text" name="tel" value="<?php echo $this->_tpl_vars['drInfo']['tel']; ?>
" id="tel">                 
     </td>
    <td align="right">电子邮箱:</td>
    <td><input type="text" name="email" value="<?php echo $this->_tpl_vars['drInfo']['email']; ?>
" id="email">    </td>
  </tr> <tr class="line">
      <td align="right">领证日期：</td>
      <td>
      <input type="text" name="licensdate" value="<?php echo $this->_tpl_vars['drInfo']['licensdate']; ?>
" id="licensdate">                 
     </td>
    <td align="right">证件类型:</td>
    <td><?php echo smarty_function_html_radios(array('radios' => $this->_tpl_vars['crecate_radio'],'name' => 'crecate','selected' => ((is_array($_tmp=@$this->_tpl_vars['drInfo']['crecate'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>
    </td>
  </tr><tr class="line">
	  <td align="right">驾驶证号：</td>
	  <td>
	  <input type="text" name="licensid" value="<?php echo $this->_tpl_vars['drInfo']['licensid']; ?>
" id="licensid">	  	  	 
	 </td>
	<td align="right">档案编号：:</td>
	<td> <input type="text" name="fileno" value="<?php echo $this->_tpl_vars['drInfo']['fileno']; ?>
" id="fileno">	</td>
  </tr>
	<tr class="line">
	  <td align="right">联系地址:</td>
	  <td>
	  	  	  <input type="text" name="address" value="<?php echo $this->_tpl_vars['userInfo']['address']; ?>
" id="address">	  	  
	  </td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr class="line">
	  <td align="right">个人简介:</td>
	  <td colspan="10">
	  	  <textarea name="description" id="description" style="width:350px; height:100px;"><?php echo $this->_tpl_vars['userInfo']['description']; ?>
</textarea>
	  </td>

    </tr>

  <tr class="tr2">
	  <th colspan="1000" align="left">&nbsp;密码修改:</th>
  </tr>
  <tr class="line">
		<td align="right">&nbsp;初始密码:</td>
	  <td colspan="10">&nbsp;
	  	  <input type="password" name="password1" id="password1">	  	</td>

  </tr>
  	<tr class="line">
		<td align="right">&nbsp;确认密码:</td>
	  <td colspan="10">&nbsp;<input type="password" name="password2" id="password2" ></td>

	</tr>

  <tr class="tr2">
	  <td colspan="1000" align="left">&nbsp;权限修改信息</td>
  </tr>

	<input type="hidden" name="member_id" value="<?php echo $this->_tpl_vars['memberInfo']['member_id']; ?>
">
	<input type="hidden" name="uid" value="<?php echo $this->_tpl_vars['userInfo']['uid']; ?>
">
	<!--<input type="hidden" name="company_id" value="<?php echo $this->_tpl_vars['memberInfo']['company_id']; ?>
" >-->
	<tr class="line">
	  <td  align="right">&nbsp;会员类别:</td>
	  <td width="485" colspan="10">&nbsp;
	   <select name="user_type" id="user_type">
		<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['memberInfo']['user_type_text'],'selected' => $this->_tpl_vars['userInfo']['user_type']), $this);?>

	  </select>   	    
      </td>
    </tr>
	<tr class="line">
	  <td align="right">&nbsp;有效标志:</td>
	  <td colspan="10">&nbsp;
	  		<?php echo smarty_function_html_radios(array('name' => 'flag','options' => $this->_tpl_vars['memberInfo']['flag_text'],'checked' => $this->_tpl_vars['memberInfo']['flag'],'separator' => "&nbsp;"), $this);?>
	  	 </td>
    </tr>	
	<tr class="line">
	  <td align="right">&nbsp;注册时间:</td>
	  <td colspan="10">&nbsp;
	  	  		<input type="text" name="create_at" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['memberInfo']['create_at'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
"  class="Wdate" id="create_at" disabled="disabled" >	  	  	  </td>
    </tr>
  <tr class="tr2">
      <td colspan="1000" align="left">&nbsp;积分信息</td>
  </tr>
    <tr class="line">
      <td align="right">&nbsp;个人积分:</td>
      <td colspan="10">&nbsp;<input type="text" name="total_integral" id="total_integral" value="<?php echo $this->_tpl_vars['memberInfo']['total_integral']; ?>
" /></td>
    </tr>
    
	  <tr>
          <td height="30" colspan="40" align="center">
	    <input type="hidden" name="UrlReferer" value="<?php echo $this->_tpl_vars['UrlReferer']; ?>
">
	    <input type="hidden" name="EditOption" value="<?php echo $this->_tpl_vars['EditOption']; ?>
">
	    <input type="submit" name="Submit" class="btn" value="<?php if ($this->_tpl_vars['EditOption'] == 'Edit'): ?>修改<?php else: ?>新增<?php endif; ?>">
            <input type="reset" name="Submit2" class="btn" value=" 重添 ">
            <input type="button" name="Submit3" class="btn" value=" 返回 " onClick="history.back(-1);"></td>
  </tr>
</table>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../tpl/admin/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>