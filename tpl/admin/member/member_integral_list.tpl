<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$smarty.const.FC114_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{$smarty.const.URL}/admin/css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="UTF-8" src="/admin/javascript/jquery_last.js"></script>
<script src="{$smarty.const.URL}/admin/javascript/admin.js"></script>
{literal}
<style type="text/css">
table td{font-size:12px;}
</style>
<script type="text/javascript">

function checkAll(v)
    { 
        var i;
        for (i=0;i<document.form1.elements.length;i++)
        {
            var e = document.form1.elements[i];
                e.checked = v;
        }
        return false;
}

function delgo(){
    var ids =  document.getElementsByName('ids[]');
    var count = 0;
    for(var i = 0;i<ids.length;i++)
    {
        if(ids[i].checked==true)
        {
            count ++;
        }
    }
    if(count==0){
        alert('请选择需要删除的中介');
        return false;
    }
    
    if(confirm("您确认要删除!")){
            document.getElementById("EditOption").value = 'deleteall';
            return true;
    }
    
    return false;

}
</script>
{/literal}
</head>
<base target="mainFrame">
<body>
<div class="t" style="margin-top:5px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr class="tr4">
      <td style="text-align:left">
        <form name="frm_search2" method="GET" action="?" id="frm_search2">
              搜索：
              <!---搜索框添加--->
              会员用户名:
              <input type="text" name="username" value="{$smarty.get.username}" id="username" />
              &nbsp;&nbsp; 
              <!---结束--->
              <input type="submit" name="Submit" value="显示" class="btn" />
        </form>
        &nbsp;&nbsp;
        </td>
    </tr>
  </table>
</div>
<form name="form1" id="form1" method="post" action="?action=deleteall">
  <div class="t">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="head">
        <td colspan="16">
          <div><img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />积分记录</div></td>
      </tr>
      <tr class="tr2">
        <td>编号</td>
        <td>用户名</td>
        <td>积分</td>
        <td>记录</td>
        <td>操作</td>
      </tr>
      {if $list}
      {foreach item=s from=$list key=key}
      <tr class="tr3">
        <td>{$key+1}</td>
        <td>{$s.username|default:"&nbsp;"}</td>
        <td>{$s.operation|default:"&nbsp;"}{$s.score|default:"&nbsp;"}</td>
        <td>{$s.pname|default:"&nbsp;"}</td>
        <td><a href="?action=info&sp={fp Id=$s.id}"><img src="/admin/images/edit.gif" align="absmiddle" alt="详细" /></a> &nbsp;  </td>
      </tr>
      {/foreach}
      {/if}
    </table>
  </div>
  <div class="t">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="tr4">
        <td><input name="action" type="hidden" id="action" value="deleteall" />
          <input type="hidden" name="EditOption" value="{$EditOption}" id="EditOption">
        </td>
        <td style="text-align:right">{$splitPageStr|default:"&nbsp;"}</td>
      </tr>
    </table>
  </div>
</form>
{include file="../tpl/admin/footer.tpl"}