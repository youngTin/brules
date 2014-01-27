<?php /* Smarty version 2.6.22, created on 2013-03-10 18:49:23
         compiled from admin/dr/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/dr/index.tpl', 23, false),array('modifier', 'default', 'admin/dr/index.tpl', 23, false),)), $this); ?>
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
        <input type="hidden" name="type" value="<?php echo $this->_tpl_vars['type']; ?>
" />
        &nbsp;
        处理所在地：<?php echo $this->_tpl_vars['dist1']; ?>
&nbsp;&nbsp;&nbsp;
        证件类型：<select name="crecate">
                        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['crecate_radio'],'selected' => ((is_array($_tmp=@$_GET['crecate'])) ? $this->_run_mod_handler('default', true, $_tmp, 5) : smarty_modifier_default($_tmp, 5))), $this);?>

                   </select>
        分数：<select name="score" id="scoreS">
                        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['score_option'],'selected' => ((is_array($_tmp=@$_GET['score'])) ? $this->_run_mod_handler('default', true, $_tmp, 9) : smarty_modifier_default($_tmp, 9))), $this);?>

                   </select>
        价格区间：<select name="min_expectprice">
                        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['min_expectprice_option'],'selected' => ((is_array($_tmp=@$_GET['min_expectprice'])) ? $this->_run_mod_handler('default', true, $_tmp, 80) : smarty_modifier_default($_tmp, 80))), $this);?>

                   </select>
        领证时间：<input type="text" name="licensdate" onclick="WdatePicker();" />&nbsp;
        驾照要求：<select name="">
                    <option value="">不限制</option>
                   </select>
        
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
    <td colspan="20"><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />出售驾照分列表
    <!--<button style="float:right;" type="button" onclick="window.location.href='secondhouse_list.php?&exp=1'" class="btn3">导出联系人信息</button>
    -->
    </td>
     
   </tr>
  <tr class="tr2">
      <td>序号</td>
    <td>姓名</td>
    <td>驾照所在地</td>
    <td>处理所在地</td>
    <td>电话</td>
    <td>驾照类别</td>
    <td>可扣分数</td>
    <td>价格区间</td>
    <td>领证时间</td>
    <td>备注</td>
    <td>状态</td>
    <td> 操作</td>
  </tr>
 <?php 
            $info = $this->_tpl_vars['info'];
            if(count($info)<=0)
            echo "<tr><td colspan='10'><span class='gray'>所在条件下无信息</span></td></tr>";
            else
            foreach($info as $item):
            
            $values1 = array($item['in_province'],$item['in_city'],$item['in_dist']);
            $values2 = array($item['on_province'],$item['on_city'],$item['on_dist']);
            $colseButton = $item['flag'] == '1' ?"<a class='gray' href='info.php?action=open&id={$item['id']}' onclick='return confirm(\"确定开启此信息吗？\")'>已关闭</a>" :"<a href='info.php?action=close&id={$item['id']}' onclick='return confirm(\"确定关闭此信息吗？\")'>关闭</a>" ;
            $compButton = $item['status'] == 'DONE' ?"<a class='gray' >已完成</a>" :"<a href='info.php?action=comptask&id={$item['id']}' onclick='return confirm(\"确定完成此信息吗？\")'>完成</a>" ;
            echo "
            <tr class='tr3'>
                <td>{$item['id']}</td>
                <td>{$item['linkman']}</td>
                <td>".showdistricts($values1, '', '','',true)."</td>
                <td>".showdistricts($values2, '', '','',true)."</td>
                <td>{$item['tel']}</td>
                <td>{$this->_tpl_vars['crecate'][$item['crecate']]}</td>
                <td>{$item['score']}</td>
                <td>{$this->_tpl_vars['min_expectprice'][$item['min_expectprice']]}</td>
                <td>".$item['licensdate']."</td>
                <td>{$item['remark']}</td>
                <td>{$this->_tpl_vars['task_status'][$item['status']]}</td>
                <td><a href='info.php?did={$item['id']}'>查看</a>&nbsp;&nbsp;".$compButton."&nbsp;&nbsp;&nbsp;".$colseButton."</td>
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