<?php /* Smarty version 2.6.22, created on 2013-03-10 17:41:16
         compiled from admin/dr/info_sale.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin/dr/info_sale.tpl', 109, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo @FC114_TITLE; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo @URL; ?>
/admin/css/admin.css" rel="stylesheet" type="text/css" />
<!--jquery-->
<script src="<?php echo @URL; ?>
/ui/js/jquery-1.5.1.min.js" type="text/javascript"></script>
<!--thickbox控件-->
<!--结束-->
</head>
<?php echo '
<style>
.org{ color:#FF0000 ;font-size:12px}
.remark{ color:#666666; font-size:12px}
.description{ color:#FF9933; font-size:12px; border: 1px solid #66FFFF; background:#F7F7F7; padding:8px 0px 0px 15px; height:30px; }
#reside_info{ color:#FF9933; font-size:12px; border: 1px solid #66FFFF; background:#fff; padding:0px 0px 0px 0px; width:70%; display:none; cursor:hand;}
#reside_info_ul{ list-style:none; width:100%; }
#reside_info_ul li{ padding-left:10px; padding-top:3px;cursor: pointer;}
#reside_info_ul li span{ padding-left:10px; padding-top:3px; cursor:hand; color:#999999;}
.over{ background:#CCCCCC}
#vilad_in{ display:inline;}
#vilad_out{ display:none;}
.vilad_info{ font-size:12px; color:#000099;}
input{ height:21px; padding:3px; line-height:170%;  vertical-align:middle;color:#000099; }

.coverall{background:#000000;width:100%;height:100%; position:absolute;z-index:9999; display: none;}
.text-content{position:absolute;z-index:99999;background-color: #FFFFFF;height:430px;display: none;}
.map-head{padding:0 15px;margin: 0;height:26px;line-height: 26px;text-align: right;}
.map-head span{color:#008080;cursor: pointer;}
#container{width: 610px; height: 360px; margin:5px; border:2px solid #CCCCCC;}
.img-cur{cursor: pointer;}
.posinput{height:16px;}
</style>
<script>
  
</script>
'; ?>

<body  style="margin-top:5px;">
  <div class="t">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="head">
      <td colspan="99">
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />详细信息
      </td>
    </tr>
    <tr class="line">
      <td width="25%">类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别:</td>
      <td>出售驾照分</td>
    </tr>
    <tr class="line">
      <td>驾照所在地:</td>
      <td><?php echo $this->_tpl_vars['dist1']; ?>
</td>
    </tr>
    <tr class="line">
      <td>处理所在地:</td>
      <td><?php echo $this->_tpl_vars['dist2']; ?>
</td>
    </tr>
    <tr class="line">
      <td>证件类型:</td>
      <td> <?php echo $this->_tpl_vars['crecate_radio'][$this->_tpl_vars['info']['crecate']]; ?>
 </td>
    </tr>
    <tr class="line">
      <td>最<?php if ($this->_tpl_vars['info']['type'] == '1' || $this->_tpl_vars['info']['type'] == '1'): ?>高<?php else: ?>低<?php endif; ?>期望价:</td>
      <td><?php echo $this->_tpl_vars['min_expectprice_option'][$this->_tpl_vars['info']['min_expectprice']]; ?>
</td>
    </tr>
    <tr class="line">
      <td>可售:</td>
      <td><?php echo $this->_tpl_vars['score_option'][$this->_tpl_vars['info']['score']]; ?>
分</td>
    </tr>
     <?php if ($this->_tpl_vars['info']['revoke'] > 0): ?>
    <tr class="line">
      <td>可否吊销:</td>
      <td><?php echo $this->_tpl_vars['revoke_option'][$this->_tpl_vars['info']['revoke']]; ?>
</td>
    </tr>
        <?php if ($this->_tpl_vars['info']['expectprice'] > 0): ?>
        <tr class="line">
          <td>期望价格:</td>
          <td><?php echo $this->_tpl_vars['info']['expectprice']; ?>
</td>
        </tr>
        <?php endif; ?>
    <?php endif; ?>
    <tr class="line">
      <td>联系电话:</td>
      <td><?php echo $this->_tpl_vars['info']['tel']; ?>
</td>
    </tr> 
    <tr class="line">
        <td>领证日期:</td>
        <td><?php echo $this->_tpl_vars['info']['licensdate']; ?>
</td>
    </tr>
    <tr class="line">
      <td>联系人:</td>
      <td><?php echo $this->_tpl_vars['info']['linkman']; ?>
</td>
    </tr>
    <tr class="line">
      <td>邮件地址:</td>
      <td><?php echo $this->_tpl_vars['info']['email']; ?>
</td>
    </tr>
    <tr class="line">
      <td>时间安排:</td>
      <td><?php echo $this->_tpl_vars['timeline_option'][$this->_tpl_vars['info']['timeline']]; ?>
</td>
    </tr>
    <tr class="line">
      <td>备注:</td>
      <td><?php echo $this->_tpl_vars['info']['remark']; ?>
</td>
    </tr>
    <tr class="line">
      <td>发布时间:</td>
      <td><?php echo ((is_array($_tmp=$this->_tpl_vars['info']['addtime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%I:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%I:%S')); ?>
</td>
    </tr>
    <tr class="line">
      <td>用户名:</td>
      <td><?php echo $this->_tpl_vars['info']['username']; ?>
</td>
    </tr>
    <tr class="head">
      <td colspan="99"><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />该用户的其他任务</td>
    </tr>
    <tr>
        <td colspan='99'> <iframe id="img-iframe2" width="100%" frameborder="0" scrolling="yes" src='info.php?action=getInfoByUser&uid=<?php echo $this->_tpl_vars['info']['uid']; ?>
' height="100%"  ></iframe></td>
    </tr>
  </table>
  </div>

</body>
</html>