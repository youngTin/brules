<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>出售驾照分管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/admin/javascript/formValidator/jquery_last.js"></script>
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/admin/javascript/datepicker/WdatePicker.js"></script>
<script src="{$smarty.const.URL}/admin/javascript/admin.js"></script>
</head>
<base target="mainFrame">
<body>
<div class="m"></div>
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="head">
    <td colspan="20"><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />违章信息车牌列表
    <!--<button style="float:right;" type="button" onclick="window.location.href='secondhouse_list.php?&exp=1'" class="btn3">导出联系人信息</button>
    -->

    </td>
   </tr>
  <tr class="tr2">
      <td>违章时间</td>
    <td>违章地点</td>
    <td>违章原因</td>
    <td>扣分</td>
    <td>罚金</td>
    <td>代办费</td>
    <td>办理</td>
  </tr>
 {php}
                        $info = $this->_tpl_vars['info'];
                        $bs = $this->_tpl_vars['br_push_status'];
                        foreach($info as $key=>$item):
                            $uptime = $item['uptime']==0 ? "暂无更新" : date('Y-m-d',$item['uptime']) ;
                        echo "
                        <tr class='tr3'>
                            <td>".date('Y-m-d',strtotime($item['brtime']))."</td>
                            <td>".$item['braddress']."</td>
                            <td>".$item['brreason']."</td>
                            <td>{$item['marking']}</td>
                            <td>{$item['fine']}</td>
                            <td>{$item['agencyfees']}</td>
                            <td>?</td>
                        </tr>
                        ";
                        endforeach;
                        {/php}
</table>
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>&nbsp;</td>
    <td style="text-align:right">{$subPages|default:"&nbsp;"}</td>
  </tr>
</table>
</div>
</body>
</html>
