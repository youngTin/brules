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
<form id="form1" name="form1" method="get" action="index.php" style="margin:0px; padding:0px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="tr4">
      <td width="90%" style="text-align:left"> 
        &nbsp;
        处理所在地：{$dist1}&nbsp;&nbsp;&nbsp;
        车牌：<select name="lpp" class="bselect" >
                                {html_options options=$br_br_dist selected=$smarty.get.lpp}
                            </select><input type="text" name="lpno" value="">
        车架号：<input type="text" name="chassisno" class="binput"  value="{$smarty.get.chassisno}" maxlength="6"  />
        手机：<input type="text" name="telephone" class="binput" id="telephone" value="{$smarty.get.telephone}" />
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
    <td>状态</td>
    <td> 操作</td>
  </tr>
 {php}
                        $info = $this->_tpl_vars['info'];
                        $bs = $this->_tpl_vars['br_push_status'];
                        $province = $this->_tpl_vars['province'];
                        foreach($info as $key=>$item):
                            $uptime = $item['uptime']==0 ? "暂无更新" : date('Y-m-d',$item['uptime']) ;
                            if($item['exists']=='0')$uptime = '<span class="red">车牌号有误</span>';
                            if($item['flag']=='2')$status = '<span class="red">异常</span>';
                            else $status = '正常';
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
                            <td>".$status."</td>
                            <td><a href='?action=info&did={$item['id']}'>查看</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='?action=add&did={$item['id']}' class='' >修改</a>&nbsp;&nbsp;$colseButton&nbsp;&nbsp;<a href='?action=deal&did={$item['id']}' class='' onclick=\"return confirm('确定删除该任务吗？');\" >删除</a></td>
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
