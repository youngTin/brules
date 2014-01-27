<?php /* Smarty version 2.6.22, created on 2013-07-20 13:43:52
         compiled from admin/br/sendone.tpl */ ?>
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
<script type="text/javascript" charset="UTF-8" src="<?php echo @URL; ?>
/admin/javascript/datepicker/WdatePicker.js"></script>
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
  <form action="?action=sendOnlyOne"  method="post" id="form1" >
                <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
                <table>
                    <tr class="head">
                      <td colspan="99">
                      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />发送短信信息
                      </td>
                    </tr>
                    <tr class="line">
                        <td>发送手机：</td>
                        <td colspan="3"><input type="text" name="tel" value="<?php echo $this->_tpl_vars['tel']; ?>
" readonly="readonly" /></td>
                    </tr><tr class="line">
                        <td>发送内容：</td>
                        <td colspan="3"><textarea cols="80" rows="6" name="content"><?php echo $this->_tpl_vars['sms']; ?>
</textarea></td>
                    </tr>
                    <tr class="line">
                        <td></td>
                        <td colspan="3"><input id="subbutton" type="submit" value="提交" class="btn " /></td>
                    </tr>
                </table>
            </form>
  </div>

</body>
</html>