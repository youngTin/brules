<?php /* Smarty version 2.6.22, created on 2013-03-10 18:02:05
         compiled from admin/dr/info_foruser.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'admin/dr/info_foruser.tpl', 62, false),)), $this); ?>
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
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr2">
      <td>序号</td>
    <td>姓名</td>
    <td>驾照所在地</td>
    <td>处理所在地</td>
    <td>电话</td>
    <td>驾照类别</td>
    <td>可扣份数</td>
    <td>价格区间</td>
    <td>发布类型</td>
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
           //$colseButton = $item['flag'] == '1' ?"<a>已关闭</a>" :"<a onclick='return confirm(\"确定关闭此信息吗？\")'>关闭</a>" ;
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
                <td>{$this->_tpl_vars['type_radio'][$item['type']]}</td>
                <td>{$this->_tpl_vars['task_status'][$item['status']]}</td>
                <td><a href='info.php?action=index&type={$item['type']}&did={$item['id']}' target='mainFrame'>查看</a>&nbsp;&nbsp;</td>
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
</body>
</html>