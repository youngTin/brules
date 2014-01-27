<?php /* Smarty version 2.6.22, created on 2013-07-16 10:08:37
         compiled from admin/br/banlist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/br/banlist.tpl', 22, false),array('modifier', 'default', 'admin/br/banlist.tpl', 95, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>出售驾照分管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo @URL; ?>
/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="<?php echo @URL; ?>
/admin/javascript/formValidator/jquery_last.js"></script>
<script type="text/javascript" charset="UTF-8" src="<?php echo @URL; ?>
/admin/javascript/datepicker/WdatePicker.js"></script>
<script src="<?php echo @URL; ?>
/admin/javascript/admin.js"></script>
</head>
<base target="mainFrame">
<body>
<div class="m"></div>
<div class="t">
<form id="form1" name="form1" method="get" action="index.php" style="margin:0px; padding:0px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="tr4">
      <td width="90%" style="text-align:left"> 
        &nbsp;
        处理所在地：<?php echo $this->_tpl_vars['dist1']; ?>
&nbsp;&nbsp;&nbsp;
        车牌：<select name="lpp" class="bselect" >
                                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['br_br_dist'],'selected' => $_GET['lpp']), $this);?>

                            </select><input type="text" name="lpno" value="">
        车架号：<input type="text" name="chassisno" class="binput"  value="<?php echo $_GET['chassisno']; ?>
" maxlength="6"  />
        手机：<input type="text" name="telephone" class="binput" id="telephone" value="<?php echo $_GET['telephone']; ?>
" />
        用户：<input type="text" name="username" class="binput" id="username" value="<?php echo $_GET['username']; ?>
" />
        
      &nbsp;&nbsp;&nbsp;<input type="submit" name="submit2" class="btn" value="查询"  />      </td>

      <td width="10%">      </td>
    </tr>
  </table>
</form>
</div>
<form name="form2" action="esf_action.php" method="post" style="margin:0px; padding:0px;">
<div class="t">
<input type="hidden" name="allow" value="<?php echo $this->_tpl_vars['refreshed']['allow']; ?>
" />
<input type="hidden" name="today" value="<?php echo $this->_tpl_vars['refreshed']['today']; ?>
" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="head">
    <td colspan="20"><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />违章信息车牌列表
    <!--<button style="float:right;" type="button" onclick="window.location.href='secondhouse_list.php?&exp=1'" class="btn3">导出联系人信息</button>
    -->
    </td>
     
   </tr>
  <tr class="tr2">
      <td>序号</td>
    <td>违章地区</td>
    <td>车牌号</td>
    <td>违章条数</td>
    <td>扣分</td>
    <td>罚款</td>
    <td>服务费</td>
    <td>总费用</td>
    <td>预留人</td>
    <td>预留电话</td>
    <td>代办人</td>
    <td>代办人电话</td>
    <td>办理时间</td>
    <td> 操作</td>
  </tr>
 <?php 
                        $info = $this->_tpl_vars['info'];
                        $bs = $this->_tpl_vars['br_push_status'];
                        $province = $this->_tpl_vars['province'];
                        foreach($info as $key=>$item):
                            $colseButton = $item['flag'] == '1' ?"<a class='gray' href='ban.php?action=open&did={$item['id']}' onclick='return confirm(\"确定开启此信息吗？\")'>已关闭</a>" :"<a href='ban.php?action=close&did={$item['id']}' onclick='return confirm(\"确定关闭此信息吗？\")'>关闭</a>" ;
                        echo "
                        <tr class='tr3'>
                            <td>".($key+1)."</td>
                            <td>".$province[$item['province']]."</td>
                            <td>".$item['lpno']."</td>
                            <td>".$item['brnum']."</td>
                            <td>{$item['marking']}</td>
                            <td>{$item['fine']}</td>
                            <td>{$item['sefine']}</td>
                            <td>".$item['totalfee']."</td>
                            <td>".$item['sname']."</td>
                            <td>".$item['telephone']."</td>
                            <td>".$item['agperson']."</td>
                            <td>".$item['agtelephone']."</td>
                            <td>".date('Y-m-d H:i:s',$item['addtime'])."</td>
                            <td>&nbsp;$colseButton&nbsp;&nbsp;</td>
                        </tr>
                        ";
                        endforeach;
                         ?>
</table>
</div>
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>&nbsp;</td>
    <td style="text-align:right"><?php echo ((is_array($_tmp=@$this->_tpl_vars['subPages'])) ? $this->_run_mod_handler('default', true, $_tmp, "&nbsp;") : smarty_modifier_default($_tmp, "&nbsp;")); ?>
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
</body>
</html>