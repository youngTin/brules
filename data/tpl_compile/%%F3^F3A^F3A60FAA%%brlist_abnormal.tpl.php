<?php /* Smarty version 2.6.22, created on 2013-12-10 21:13:04
         compiled from admin/br/brlist_abnormal.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'admin/br/brlist_abnormal.tpl', 23, false),array('modifier', 'default', 'admin/br/brlist_abnormal.tpl', 98, false),)), $this); ?>
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
<form id="form1" name="form1" method="get" action="?action=abnormal" style="margin:0px; padding:0px;">
<input type="hidden" name="action" value="abnormal" />
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
<form name="form2" action="?action=delallAnm" method="post" style="margin:0px; padding:0px;">
<div class="t">
<input type="hidden" name="allow" value="<?php echo $this->_tpl_vars['refreshed']['allow']; ?>
" />
<input type="hidden" name="today" value="<?php echo $this->_tpl_vars['refreshed']['today']; ?>
" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="head">
    <td colspan="20"><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />违章信息车牌<b class="red">异常</b>列表
    <!--<button style="float:right;" type="button" onclick="window.location.href='secondhouse_list.php?&exp=1'" class="btn3">导出联系人信息</button>
    -->
    
    <input type="submit" class="btn" onclick="return confirm('确定删除所有的异常信息吗？,该删除只删除违章信息!');" value="一键删除" />
    </td>
     
   </tr>
  <tr class="tr2">
      <td>序号</td>
    <td>违章地区</td>
    <td>车牌号</td>
    <td>车架号</td>
    <td>发动机号</td>
    <td>手机号</td>
    <td>违章概况(最新)</td>
    <td>扣分总计(最新)</td>
    <td>数据更新日期</td>
    <td>提醒状态</td>
    <td>服务期限</td>
    <td>添加时间</td>
    <td> 操作</td>
  </tr>
 <?php 
                        $info = $this->_tpl_vars['info'];
                        $bs = $this->_tpl_vars['br_push_status'];
                        $province = $this->_tpl_vars['province'];
                        foreach($info as $key=>$item):
                            $uptime = $item['uptime']==0 ? "暂无更新" : date('Y-m-d',$item['uptime']) ;
                            if($item['exists']=='0')$uptime = '<span class="red">车牌号有误</span>';
                            $colseButton = $item['flag'] == '1' ?"<a class='gray' href='index.php?action=open&did={$item['id']}' onclick='return confirm(\"确定开启此信息吗？\")'>已关闭</a>" :"<a href='index.php?action=close&did={$item['id']}' onclick='return confirm(\"确定关闭此信息吗？\")'>关闭</a>" ;
                        echo "
                        <tr class='tr3'>
                            <td>".($key+1)."</td>
                            <td>".$province[$item['province']]."</td>
                            <td>".$item['lpp'].$item['lpno']."</td>
                            <td>".$item['chassisno']."</td>
                            <td>{$item['engno']}</td>
                            <td>{$item['telephone']}</td>
                            <td>{$item['brnum']}&nbsp;(<span class='red'>".$item['newnum']."</span>)|&nbsp;<a href=\"?action=showInfo&did={$item['id']}\">查看</a></td>
                            <td>".$item['totalscore']."&nbsp;(<span class='red'>".$item['newscore']."</span>)</td>
                            <td>".$uptime."</td>
                            <td>".$bs[$item['ispush']]."</td>
                            <td>".date("Y-m-d",$item['time_limit'])."</td>
                            <td>".date('Y-m-d H:i:s',$item['addtime'])."</td>
                            <td><a href='?action=info&did={$item['id']}'>查看</a>&nbsp;&nbsp;<a href='?action=dealAnmOne&did={$item['id']}' class='' onclick=\"return confirm('确定删除该车牌的所有违章吗？');\" >删除违章</a></td>
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