<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.WEB_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/scripts/jquery_last.js"></script>
{literal}
<script>
//采集公用js
//游览器判断
function Nav(){
	if(window.navigator.userAgent.indexOf("MSIE")>=1) return 'IE';
  else if(window.navigator.userAgent.indexOf("Firefox")>=1) return 'FF';
  else return "OT";
}
//选取ID
function MyObj(oid)
{
	return $("#"+oid);
	}	
//step 1显示
function SelSourceSet()
{
	if( MyObj('source2').attr("checked"))
    {
	    MyObj('s3').show();
        MyObj('s1').hide();
        MyObj('s2').hide();
    }
  else
    {
       $("#s3").hide()
        MyObj('s1').show();
        MyObj('s2').show();

    }
}
//URL测试显示
function TestRegx()
{
	var regxurl=MyObj('regxurl').val(); //URL
	var startid=MyObj('startid').val(); //startid
	var endid=MyObj('endid').val(); //endid
	var addv=MyObj('addv').val();
	var t=Array();
	if(isNaN(startid) || isNaN(endid) || isNaN(addv))
	{
		alert('请填入数字!');
		return false;
	}
	for(i=startid;i<=endid;i++)
	{
		t+=regxurl.replace("(*)",i)+"\r";
	}
	MyObj('addurls').val(t);
	
}

</script>
{/literal}
<body>
<base target="mainFrame">
<!--
<div class="t" style="margin-top:5px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="tr4">
		<td>快捷操作</td>
		<td><input type="button" name="Submit" value="首页更新" onclick="window.location='http://www.tibettreks.com';" class="btn" />
			&nbsp;&nbsp;
			<input type="button" name="Submit3" value="更新所有详细页面" onclick="window.location='http://www.tibettreks.com';" class="btn" />
			&nbsp;&nbsp;</td>
	</tr>
</table>
</div>
-->
<div class="m"></div>
<div class="t">
<table align=center cellspacing=0 cellpadding=0>
<tr class=head>
  <td>System helps-系统版本:万能采集系统 -- BY 天字1号</td>
</tr>
<tr class=line>
  <td>
<font color="#6699FF">新增采集节点：第一步设置基本信息及网址索引页规则</font></b><br /><font color="#6699FF">本系统特殊标记均为:(*)代替</font></td>
</tr></table>
</div>
<form method="post" action="/admin/co_add.php">
<input type='hidden' name='step' value='go1' />
<input type='hidden' name='dopost' value='test' />
<div class="t">
<table align=center cellspacing=0 cellpadding=0>
<tr class=head>
  <td colspan="2">△节点基本信息</td>
</tr>
<tr class=line>
  <td width="20%">节点名称:</td> <td align="left" width="70%"><input type="text" name="name" style='width:250px' value="{$res.name}"/></td>
</tr>
<tr class=line>
  <td width="20%">目标页面编码:</td> <td align="left" width="70%">    
  				<input type="radio" name="sourcelang" id='language1' class="np" value="gb2312" checked='1' />
              GB2312 
              <input type="radio" name="sourcelang" id='language2' class="np" value="utf-8" />
              UTF8 
              <input type="radio" name="sourcelang" id='language3' class="np" value="big5" />
              BIG5 </td>
</tr>
<tr class=line>
  <td width="20%">引用网址:</td> <td align="left" width="70%"><input name="yyurl" type="text" id="refurl" size="30" style='width:250px' value="{if !$res.yyurl}http://{else}{$res.yyurl}{/if}"/></td>
</tr>
</table>
</div>
<div class="t">
<table align=center cellspacing=0 cellpadding=0>
<tr class=head>
  <td colspan="2">列表网址获取规则</td>
</tr>
<tr class=line>
  <td width="10%">来源属性</td> <td width="75%" align="left">   <input type="radio" name="sourcetype" id="source1" class='np' onclick="SelSourceSet()" value="batch" checked="checked" />
            批量生成列表网址
            <input type="radio" name="sourcetype" id="source2" class='np' onclick="SelSourceSet()" value="hand" />
            手工指定列表网址</td>
</tr>
<tr class=line id="s1">
  <td width="10%">批量生成地址设置：</td> <td width="75%" align="left">   匹配网址：
                 <input type="text" name="regxurl" id="regxurl" style="width:350px" value="{$res.regxurl}"/>
                 <input type="button" name="btv1" id="btv1" value="测试" onclick="TestRegx()" /><br />
                 <font color="#999999">(如：http://www.fc114.com/news/list_(*).html，如果不能匹配所有网址，可以在手工指定网址的地方输入要追加的网址) </font>
                 <br />  (*)从
                  <input type="text" name="startid" id="startid" style="width:30px" value="{$res.startid}"  />
                  到
                  <input type="text" name="endid" id="endid" style="width:30px" value="{$res.endid}" />
                  (页码或规律数字)&nbsp;
                  每页递增：
                  <input type="text" name="addv" id="addv" style="width:30px" value="{$res.addv}" />
                 
                 </td>
</tr>
<tr class=line id="s2">
  <td>自动生成网址:</td>
    <td><textarea name="addurls" id="addurls" cols="45" rows="5" style="width:80%;height:160px"></textarea></td>
</tr>
<tr class=line id="s3" style="display:none">
  <td>手动指定网址:<br />
  <font color="#999999">(网址以@分割结束)如:www.baidu.com/test.php@www.163.com/test.php</font>
  </td>
    <td><textarea name="addurls" id="addurls" cols="45" rows="5" style="width:80%;height:160px"></textarea></td>
</tr>
</table>
</div>
<div class="t">
<table align=center cellspacing=0 cellpadding=0>
<tr class=head>
  <td colspan="2">列表区域匹配规则</td>
</tr>
<tr class=line>
  <td width="10%"> 包含有文章网址的区域设置：</td>
    <td><table width="100%">
            <tr>
              <td width="22%" align="center">区域开始的HTML：</td>
              <td width="78%">
              <textarea name="areastart" id="areastart" cols="45" rows="5" style="width:80%;height:60px">{$res.areastart}</textarea>
              </td>
            </tr>
            <tr>
              <td align="center">区域结束的HTML：</td>
              <td>
              	<textarea name="areaend" id="areaend" cols="45" rows="5" style="width:80%;height:60px">{$res.areaend}</textarea>
              </td>
            </tr>
            
           
          </table></td>
</tr>

</table>
</div>
<div class="t">
<table align=center cellspacing=0 cellpadding=0>
<tr class=head>
  <td colspan="2">列表连接匹配规则</td>
</tr>
<tr class=line>
  <td width="10%"> 包含有文章网址的区域设置：</td>
    <td><table width="100%">
            <tr>
              <td width="22%" align="center">区域开始的HTML(正则)：</td>
              <td width="78%">
              <textarea name="liststart" id="liststart" cols="45" rows="5" style="width:80%;height:60px" >{$res.liststart}</textarea>
 
              </td>
            </tr>
            
           
          </table></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="button" value="返回上一步进行修改" class="coolbg np" onclick="history.back()" style="width:200px" /><input type="submit"  value="保存信息并进入下一步设置"  style="width:200px" /></td>
</tr>
</table>
</div>
</form>
 {include file="../tpl/admin/footer.tpl"}
</body>
</html>
{literal}
<script language="javascript">
var top=parent.topFrame;
if(typeof(top)=='object'){
	var loadMsg=top.document.getElementById('loadMsg');
	if(loadMsg!=undefined){
		loadMsg.style.display='none';
	}
}
</script>
{/literal}
