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
<form id="form1" name="form1" method="get" action="list.php" style="margin:0px; padding:0px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="tr4">
      <td width="90%" style="text-align:left"> 
        &nbsp;
        服务类型：<select name="marks" class="bselect" >
                                {html_options options=$br_br_dist selected=$smarty.get.lpp}
                            </select><input type="text" name="lpno" value="">
        车主姓名：<input type="text" name="name" class="binput"  value="{$smarty.get.chassisno}" maxlength="6"  />
        手机：<input type="text" name="phone" class="binput" id="phone" value="{$smarty.get.telephone}" />
        用户：<input type="text" name="username" class="binput" id="username" value="{$smarty.get.username}" />
        
      &nbsp;&nbsp;&nbsp;<input type="submit" name="submit2" class="btn" value="查询"  />      </td>

      <td width="10%">      </td>
    </tr>
  </table>
</form>
</div>
<form name="form2" action="esf_action.php" method="post" style="margin:0px; padding:0px;">
<div class="t">
<input type="hidden" name="allow" value="{$refreshed.allow}" />
<input type="hidden" name="today" value="{$refreshed.today}" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="head">
    <td colspan="20"><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />违章信息车牌列表
    <!--<button style="float:right;" type="button" onclick="window.location.href='secondhouse_list.php?&exp=1'" class="btn3">导出联系人信息</button>
    -->
    </td>
     
   </tr>
  <tr class="tr2">
      <td>序号</td>
    <td>服务类型</td>
    <td>价格</td>
    <td width="500px">服务内容</td>
    <td>车主姓名</td>
    <td>手机号</td>
    <td>车型</td>
    <td>区域</td>
    <td width="70px">添加时间</td>
    <td>状态</td>
    <td> 操作</td>
  </tr>
 {php}
                        $info = $this->_tpl_vars['info'];
                        $serv_Marks = $this->_tpl_vars['serv_Types'];
                        $serv_Status = $this->_tpl_vars['serv_Status'];
                        foreach($info as $key=>$item):
                            $uptime = $item['uptime']==0 ? "暂无更新" : date('Y-m-d',$item['uptime']) ;
                            $project = unserialize($item['project']); 
                            $project = implode(';',$project) ;
                            
                            $colseButton = $item['status'] == '0' || $item['status'] == '1'  ?"<a href='?action=doHand&did={$item['id']}' onclick='return confirm(\"确定处理吗？\");' >处理</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='?action=comp&did={$item['id']}' class='' onclick='return confirm(\"确定完成吗？\");' >完成</a>" :"&nbsp;&nbsp;&nbsp;&nbsp;<a href='?action=comp&did={$item['id']}' class='' onclick='return confirm(\"确定完成吗？\");' >完成</a>" ;
                        echo "
                        <tr class='tr3'>
                            <td>".($key+1)."</td>
                            <td>".$serv_Marks[$item['srvmarks']]."</td>
                            <td>".$item['price']."</td>
                            <td>".$project."</td>
                            <td>{$item['name']}</td>
                            <td>{$item['phone']}</td>
                            <td>{$item['cartype']}&nbsp;</td>
                            <td>".$item['area']."</td>
                            <td>".date('Y-m-d H:i:s',$item['addtime'])."</td>
                            <td>".$serv_Status[$item['status']]."</td>
                            <td>{$colseButton}&nbsp;&nbsp;&nbsp;&nbsp;<a href='?action=deal&did={$item['id']}' class='' onclick=\"return confirm('确定删除该任务吗？');\" >删除</a></td>
                        </tr>
                        ";
                        endforeach;
                        {/php}
</table>
</div>
<div class="t">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tr4">
    <td>&nbsp;</td>
    <td style="text-align:right">{$subPages|default:"&nbsp;"}</td>
  </tr>
</table>
</div>
</form>
{include file="../tpl/admin/footer.tpl"}
</body>
</html>
