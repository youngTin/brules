<?php /* Smarty version 2.6.22, created on 2013-07-16 10:08:20
         compiled from admin/member/member_integral_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'admin/member/member_integral_list.tpl', 90, false),array('function', 'fp', 'admin/member/member_integral_list.tpl', 93, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo @FC114_TITLE; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo @URL; ?>
/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="/admin/javascript/jquery_last.js"></script>
<script src="<?php echo @URL; ?>
/admin/javascript/admin.js"></script>
<?php echo '
<style type="text/css">
table td{font-size:12px;}
</style>
<script type="text/javascript">

function checkAll(v)
    { 
        var i;
        for (i=0;i<document.form1.elements.length;i++)
        {
            var e = document.form1.elements[i];
                e.checked = v;
        }
        return false;
}

function delgo(){
    var ids =  document.getElementsByName(\'ids[]\');
    var count = 0;
    for(var i = 0;i<ids.length;i++)
    {
        if(ids[i].checked==true)
        {
            count ++;
        }
    }
    if(count==0){
        alert(\'请选择需要删除的中介\');
        return false;
    }
    
    if(confirm("您确认要删除!")){
            document.getElementById("EditOption").value = \'deleteall\';
            return true;
    }
    
    return false;

}
</script>
'; ?>

</head>
<base target="mainFrame">
<body>
<div class="t" style="margin-top:5px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="tr4">
      <td style="text-align:left">
        <form name="frm_search2" method="GET" action="?" id="frm_search2">
              搜索：
              <!---搜索框添加--->
              会员用户名:
              <input type="text" name="username" value="<?php echo $_GET['username']; ?>
" id="username" />
              &nbsp;&nbsp; 
              <!---结束--->
              <input type="submit" name="Submit" value="显示" class="btn" />
        </form>
        &nbsp;&nbsp;
        </td>
    </tr>
  </table>
</div>
<form name="form1" id="form1" method="post" action="?action=deleteall">
  <div class="t">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="head">
        <td colspan="16">
          <div><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />积分记录</div></td>
      </tr>
      <tr class="tr2">
        <td>编号</td>
        <td>用户名</td>
        <td>积分</td>
        <td>记录</td>
        <td>操作</td>
      </tr>
      <?php if ($this->_tpl_vars['list']): ?>
      <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['s']):
?>
      <tr class="tr3">
        <td><?php echo $this->_tpl_vars['key']+1; ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['s']['username'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['s']['operation'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
<?php echo ((is_array($_tmp=@$this->_tpl_vars['s']['score'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
        <td><?php echo ((is_array($_tmp=@$this->_tpl_vars['s']['pname'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
</td>
        <td><a href="?action=info&sp=<?php echo WebSmarty::_fp_(array('Id' => $this->_tpl_vars['s']['id']), $this);?>
"><img src="/admin/images/edit.gif" align="absmiddle" alt="详细" /></a> &nbsp;  </td>
      </tr>
      <?php endforeach; endif; unset($_from); ?>
      <?php endif; ?>
    </table>
  </div>
  <div class="t">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="tr4">
        <td><input name="action" type="hidden" id="action" value="deleteall" />
          <input type="hidden" name="EditOption" value="<?php echo $this->_tpl_vars['EditOption']; ?>
" id="EditOption">
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