<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.FC114_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/ui/js/jquery_last.js"></script>
<!--jquery-->
<!--thickbox控件-->
<script type="text/javascript" src="{$smarty.const.URL}/ui/js/thickbox/thickbox-compressed.js"></script>
<link rel="stylesheet" href="{$smarty.const.URL}/ui/js/thickbox/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
{literal}
<style>
.org{ color:#FF0000 ;font-size:12px}
.remark{ color:#666666; font-size:12px}
.line{height: 40px;}.line textarea{overflow: auto;}
table td{font-size:12px;}
</style>
{/literal}
</head>

<body>
<form name="form1" method="post" action="?action=save" >
  <div class="t" style="margin-top:5px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="head">
        <td colspan="99"><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />积分详细信息 </td>
      </tr>
      <input type="hidden" name="Id" value="{$Info.Id}" class="input" >
      <tr class="line">
        <td width="20%">会员用户名:</td>
        <td>
          <font  class="remark"> {$Info.username}</font></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="line">
        <td>付费方式:</td>
        <td>
          <font  class="remark">{$Info.select} </font> </td>
        <td>&nbsp;</td>
      </tr><tr class="line">
        <td>积分:</td>
        <td>
          <font  class="remark"> {$Info.operation}&nbsp;&nbsp;{$Info.score}</font> </td>
        <td>&nbsp;</td>
      </tr><tr class="line">
        <td>金钱:</td>
        <td>
          <font  class="remark"> {$Info.money}</font> </td>
        <td>&nbsp;</td>
      </tr><tr class="line">
        <td>交易人:</td>
        <td>
          <font  class="remark"> {$Info.traderid}</font> </td>
        <td>&nbsp;</td>
      </tr><tr class="line">
        <td>交易时间:</td>
        <td>
          <font  class="remark"> {$Info.time|date_format:'%Y-%m-%d %H:%M:%S'}</font> </td>
        <td>&nbsp;</td>
      </tr><tr class="line">
        <td>积分记录:</td>
        <td>
          <font  class="remark"> {$Info.pname}</font> </td>
        <td>&nbsp;</td>
      </tr><tr class="line">
        <td>交易状态:</td>
        <td>
          <font  class="remark"> {$Info.sta}</font> </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div>
  
  <div class="sub">
    <input type="button" name="Submit3" value="返回"  class="btn"  onclick="javascript:location='member_integral.php'">
  </div>
</form>  

</body>
</html>