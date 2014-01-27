<?php /* Smarty version 2.6.22, created on 2013-12-10 18:46:39
         compiled from admin/br/info.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'admin/br/info.tpl', 79, false),)), $this); ?>
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
                        <td>违章的区域：</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['dist1']; ?>
</td>
                    </tr><tr class="line">
                        <td class="t_title">车牌号：</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['br_br_dist'][$this->_tpl_vars['info']['lpp']]; ?>

                        <?php echo $this->_tpl_vars['info']['lpno']; ?>
</td>
                    </tr><tr class="line">
                        <td>车架号：</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['info']['chassisno']; ?>
</td>
                    </tr><tr class="line">
                        <td>发动机号：</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['info']['engno']; ?>
</td>
                    </tr><tr class="line">
                        <td>车辆类型：</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['br_car_type'][$this->_tpl_vars['info']['vtype']]; ?>

                        </td>
                    </tr>
                    <tr class="line">
                        <td>手机号:</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['info']['telephone']; ?>
</td>
                    </tr> <tr class="line">
                        <td>用户名:</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['info']['username']; ?>
</td>
                    </tr> <tr class="line">
                        <td>违章概况:</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['info']['brnum']; ?>
</td>
                    </tr> <tr class="line">
                        <td>扣分总计:</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['info']['totalscore']; ?>
</td>
                    </tr> <tr class="line">
                        <td>数据更新日期:</td>
                        <td colspan="3"><?php echo ((is_array($_tmp=$this->_tpl_vars['info']['uptime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%I:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%I:%S')); ?>
</td>
                    </tr> <tr class="line">
                        <td>提醒状态:</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['br_push_status'][$this->_tpl_vars['info']['ispush']]; ?>
</td>
                    </tr> <tr class="line">
                        <td>服务期限 :</td>
                        <td colspan="3"><?php if ($this->_tpl_vars['info']['time_limit'] > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['info']['time_limit'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
<?php endif; ?></td>
                    </tr>  <tr class="line">
                        <td class="red">车辆品牌  :</td>
                        <td colspan="3"><span class="org"><?php echo $this->_tpl_vars['info']['brand']; ?>
</span></td>
                    </tr>  <tr class="line">
                        <td>初次登记  :</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['info']['reg_first']; ?>
</td>
                    </tr>
		    <tr class="line">
                        <td>最近定检  :</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['info']['check_last']; ?>
</td>
                    </tr>  <tr class="line">
                        <td>检验有效期  :</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['info']['valid']; ?>
</td>
                    </tr>  <tr class="line">
                        <td>保险终止期   :</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['info']['end_insure']; ?>
</td>
                    </tr> <tr class="line">
                        <td>添加时间   :</td>
                        <td colspan="3"><?php echo ((is_array($_tmp=$this->_tpl_vars['info']['addtime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%I:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%I:%S')); ?>
</td>
                    </tr> 
    <tr>
        <td colspan='99'> <iframe id="img-iframe2" width="100%" frameborder="0" scrolling="yes" src='index.php?action=showInfo&did=<?php echo $this->_tpl_vars['info']['id']; ?>
' height="100%"  ></iframe></td>
    </tr>
  </table>
  </div>

</body>
</html>