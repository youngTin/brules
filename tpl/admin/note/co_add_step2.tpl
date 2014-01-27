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
function show(type)
{
	if(type=='show')
	{
		$("#tm").show();	
	}
	if(type=='close')
	{
		$("#tm").hide();	
	}
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
  <td>System helps</td>
</tr>
<tr class=line>
  <td> 1.采集模型选择 暂只支持文章入库。<br />
  <b>
<font color="#6699FF">新增采集节点：第三步设置基本信息及网址索引页规则</font></b>
  <b>
<font color="#6699FF">规则样式：起始[内容]结束 如:<title>[内容]</title></font></b>
</td>
</tr></table>
</div>

<div class="t">
  <table align=center cellspacing=0 cellpadding=0>
<form method="post" action="/admin/co_do.php">
<input type='hidden' name='do' value='add' />
<input type="hidden" name="pid" value="{$id}" />
<tr class=head>
  <td colspan="2">文章内容匹配规则&nbsp;<input type="button" value="增加采集字段" onclick="show('show')"/></td>
  <div id="tm" style="display:none">字段名:<input type="text" id="title" name="name" />注:只能为英文&nbsp;入库字段:<input type="text" name="exname" />注:需与入库字段吻合!<input type="text" name="cnname" />注:字段中文注释<input type="submit" value="增加" /></div>
</tr>
</form>
<form method="post" action="/admin/co_add.php" method="post">
<input type='hidden' name='step' value='go3' />
<input type="hidden" name="pid" value="{$id}" />
{section name=s loop=$res}
<tr class=line>
  <td width="10%"> 包含有文章网址的区域设置：<a href="/admin/co_do.php?do=del&pid={$res[s].pid}&name={$res[s].name}">删除该字段</a></td>
    <td><table width="100%">
    
            <tr id="list">
              <td width="22%" align="center">{$res[s].cnname}:</td>
              <td width="78%">
              <textarea name="{$res[s].name}" id="{$res[s].name}" cols="45" rows="5" style="width:80%;height:60px">{$res[s].value}</textarea>格式:前字符串(*)后字符串
              </td>
            </tr>
            
           
          </table></td>
</tr>
{/section}
<tr>
<td colspan="2" align="center"> <input type="button" name="b" value="返回上一步进行修改" class="coolbg np" onclick="history.back()" style="width:200px" /><input type="submit" value="保存信息并进入下一步设置"  style="width:200px" /></td>
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
