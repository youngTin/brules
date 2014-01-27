<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.FC114_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<!--jquery-->
<script src="{$smarty.const.URL}/ui/js/jquery-1.5.1.min.js" type="text/javascript"></script>
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
.line p{margin-bottom: 5px;}
</style>
<script>
  
</script>
{/literal}
<body  style="margin-top:5px;">
  <div class="t">
  <form action="?action=save" method="post">
  <input type="hidden" name="id" value="{$info.id}" />
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="head">
      <td colspan="99">
      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />详细信息
      </td>
    </tr>
    <tr class="line">
      <td width="25%">类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别:</td>
      <td>{html_radios radios=$type_radio name=type selected=$info.type|default:1}</td>
    </tr>
    <tr class="line">
      <td>处理所在地:</td>
      <td>{$dist1}&nbsp;&nbsp;&nbsp;只根据城市判断</td>
    </tr>
    <tr class="line">
      <td>价格区间:</td>
      <td> 
      <p>A1<input type="text" name="a1" value="{$info.a1}" />&nbsp;&nbsp;<span class="red">各价格区间用“|”分隔</span>  </p>
      <p>A2<input type="text" name="a2" value="{$info.a2}" />&nbsp;&nbsp;<span class="red">各价格区间用“|”分隔</span>  </p>
      <p>B1<input type="text" name="b1" value="{$info.b1}" />&nbsp;&nbsp;<span class="red">各价格区间用“|”分隔</span>  </p>
      <p>B2<input type="text" name="b2" value="{$info.b2}" />&nbsp;&nbsp;<span class="red">各价格区间用“|”分隔</span>  </p>
      <p>C1<input type="text" name="c1" value="{$info.c1}" />&nbsp;&nbsp;<span class="red">各价格区间用“|”分隔</span>  </p>
      <p>C2<input type="text" name="c2" value="{$info.c2}" />&nbsp;&nbsp;<span class="red">各价格区间用“|”分隔</span>  </p>
      
      </td>
    </tr>
    <tr class="line">
      <td>是否关闭:</td>
      <td>
        <select name="status" >
            <option value="1">否</option>
            <option value="0">是</option>
        </select>
      </td>
    </tr>
    <tr class="line">
      <td>添加时间:</td>
      <td>{$info.addtime|date_format:'%Y-%m-%d %H:%I:%S'}</td>
    </tr> 
    <tr class="head">
      <td colspan="99"><input type="submit" value="提交" /></td>
    </tr>
   
  </table>
  </form>        
  </div>

</body>
</html>
