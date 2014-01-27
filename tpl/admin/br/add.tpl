<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.FC114_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<!--jquery-->
<script src="{$smarty.const.URL}/ui/js/jquery-1.5.1.min.js" type="text/javascript"></script>
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/admin/javascript/datepicker/WdatePicker.js"></script>
<!--thickbox控件-->
<!--结束-->
</head>
{literal}
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
{/literal}
<body  style="margin-top:5px;">
  <div class="t">
  <form action="?action=save"  method="post" id="form1" >
                <input type="hidden" name="id" value="{$info.id}" />
                <table>
                    <tr class="head">
                      <td colspan="99">
                      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />添加/修改信息
                      </td>
                    </tr>
                    <tr class="line">
                        <td>违章的区域：</td>
                        <td colspan="3"><input type="hidden" name="province" value="{$province}" />{$dist1}</td>
                    </tr><tr class="line">
                        <td class="t_title">车牌号：</td>
                        <td colspan="3">
                            <select name="lpp" class="bselect" >
                                {html_options options=$br_br_dist selected=$info.lpp}
                            </select>
                        <input type="text" name="lpno" class="binput"  value="{$info.lpno}" maxlength="6" verify="true" vtype='lpno' /><label class="msg1 clabel">车牌号必须</label>
                        </td>
                    </tr><tr class="line">
                        <td>车架号：</td>
                        <td colspan="3"><input type="text" name="chassisno" class="binput"  value="{$info.chassisno}" maxlength="6"  />&nbsp;&nbsp;<span class="gray ">车辆识别代号后6位</span></td>
                    </tr><tr class="line">
                        <td>发动机号：</td>
                        <td colspan="3"><input type="text" name="engno" class="binput" value="{$info.engno}" maxlength="6" />&nbsp;&nbsp;<span class="gray ">发动机号后6位</span></td>
                    </tr><tr class="line">
                        <td>车辆类型：</td>
                        <td colspan="3">
                            <select name="vtype">
                                {html_options options=$br_car_type selected=$info.vtype|default:0}
                            </select>
                        </td>
                    </tr>
                    <tr class="line">
                        <td>手机号:</td>
                        <td colspan="3"><input type="text" name="telephone" class="binput" id="telephone" value="{$info.telephone}" /></td>
                    </tr> <tr class="line">
                        <td>用户名:</td>
                        <td colspan="3"><input type="text" name="username" class="binput" id="username" value="{$info.username}" /></td>
                    </tr> <tr class="line">
                        <td>服务期限:</td>
                        <td colspan="3"><input type="text" name="time_limit" class="binput" id="time_limit" value="{if $info.time_limit >0}{$info.time_limit|date_format:'%Y-%m-%d'}{/if}"  onclick="WdatePicker();" /></td>
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
