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

input{color:#000000;}

</style>
<script>
  
</script>
{/literal}
<body  style="margin-top:5px;">
  <div class="t">
  <form action="?action=editSave&type={$type}"  method="post" id="form1" >
                <input type="hidden" name="id" value="{$info.id}" />
                <table id="table01">
                    <tr class="head">
                      <td colspan="99">
                      <img src="/admin/images/listhome.png" width="16" height="16" hspace="5" border="0" align="absmiddle" />年检代办模块设定
                      </td>
                    </tr>
                    <tr class="line">
                        <td>首行标题：</td>
                        <td colspan="3">
                            <div><input type="hidden" id="title" name="title" value="{$info.title}" style="display:none" /><input type="hidden" id="title___Config" value="" style="display:none" /><iframe id="title___Frame" name="title___Frame" src="../../includes/fckeditor/editor/fckeditor.html?InstanceName=title&amp;Toolbar=UserBasic" width="80%" height="150" frameborder="0" scrolling="no"></iframe></div>
                        </td>
                    </tr><tr class="line">
                        <td class="t_title">基础费用：</td>
                        <td colspan="3">
                            <input type="text" name="basicfee" class="binput"  value="{$info.basicfee}" maxlength="6" /><label class="msg1 clabel"></label>
                        </td>
                    </tr>
                  
                     {foreach from=$list item=item key=k}
                    <tr class="line newtr">
                        <td class="t_title">{$item.labels}<input type="hidden" name="labels[{$k}]" value="{$item.labels}" /><br /><br />
                        (<input type="checkbox" name="{$item.type}{$k}one" {if $item.one =='1'}checked{/if} value="1" />&nbsp;多选请勾上)
                        </td>
                        <td colspan="3">
                            <input type="hidden" name="type[{$k}]" value="{$item.type}" />
                            {if $item.type=='date'}
                            {foreach from=$item.list item=list key=key}
                            <span><select name="{$item.type}{$key}[]" class="bselect" >
                                {html_options options=$yearMonth selected=$list.name|default:0}
                            </select>
                        &nbsp;费用:<input type="text" name="{$item.type}{$key}_fee[]" class="binput"  value="{$list.fee}" maxlength="6" /><label class="msg1 clabel"></label><br /></span>
                            {/foreach}
                            {else}
                            {foreach from=$item.list item=list key=key}
                            <span><input type="text" class="useradd" data="{$item.type}{$k}" name="{$item.type}{$k}[]" value="{$list.name}" />&nbsp;&nbsp;费用：<input type="text" name="{$item.type}{$k}_fee[]" value="{$list.fee}" />&nbsp;&nbsp;默认：<input type="checkbox" name="{$item.type}{$k}_default[{$key}]" value="{$key+1}" {if $list.default=='1'}checked{/if} />&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="removeOn(this)">删除</a><br /></span>
                            {/foreach}
                            
                            {/if}
                            <span class="newAdd"></span>
                            <input type="button" onclick="newAdd(this)"  value="新加" />
                        </td>
                    </tr>
                   {/foreach}
            
                    <tr class="line ">
                        <td colspan="4">新增类别&nbsp;&nbsp;<button type="button" onclick="newCate()">新增类别</button></td>
                    </tr>
                     
                     <tr class="line">
                         <td>内容描述：</td>
                        <td colspan="3">
                            <div><input type="hidden" id="note" name="note" value="{$info.note}" style="display:none" /><input type="hidden" id="note___Config" value="" style="display:none" /><iframe id="note___Frame" name="note___Frame" src="../../includes/fckeditor/editor/fckeditor.html?InstanceName=note&amp;Toolbar=Default" width="80%" height="250" frameborder="0" scrolling="no"></iframe></div>
                        </td>
                    </tr>
                        <tr class="line" id="before">
                            <td></td>
                            <td colspan="3"><input id="subbutton" type="submit" value="提交" class="btn " /></td>
                        </tr>
                </table>
            </form>
  </div>
<script type="text/javascript">
{literal}
$(function(){
    
})

function newAdd(obj , isnew)
{
    var name = $(obj).siblings('span .useradd:eq(0)').attr('data') ; 
    var newtr = $(obj).parent('td').parent('tr.newtr').index();
    name = isnew !=void 0 ? 'select'+(newtr-4)   :  'select'+(newtr-3) ; 
    var len = $(obj).siblings('.newAdd').find('.useradd').size(); 
    var span = '<input type="text" class="useradd" data="'+name+'" name='+name+'[]" value="" />&nbsp;&nbsp;费用：<input type="text" name="'+name+'_fee[]" value="" />&nbsp;&nbsp;默认：<input type="checkbox" name="'+name+'_default['+(len)+']" value="'+(len+1)+'" />&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="removeOn(this)">删除</a><br />';
    $(obj).siblings('.newAdd').append(span);
}

function newCate()
{  
    var len = $('tr.newtr').size(), name = 'select'+len; 
    var tr = '<tr class="line newtr">'
        tr +=     '<td class="t_title"><input type="text" name="labels[]" value="" /><br /><br />(<input type="checkbox" name="'+name+'one" value="1" />&nbsp;多选请勾上)</td>'
        tr +=   '<td colspan="3">'
         tr +=       '<input type="hidden" name="type[]" value="select" />'
        tr +=        '<span><input type="text" class="useradd" data="'+name+'" name='+name+'[]" value="" />&nbsp;&nbsp;费用：<input type="text" name="'+name+'_fee[]" value="" />&nbsp;&nbsp;默认：<input type="checkbox" name="'+name+'_default['+(len)+']" value="'+(len+1)+'" />&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="removeOn(this)">删除</a><br /></span>'

          tr +=     ' <span class="newAdd"></span>'
         tr +=       '<input type="button" onclick="newAdd(this,\'new\')"  value="新加" />'
        tr +=    '</td></tr>' ;
    $(tr).insertBefore("#before");
}
function removeOn(obj)
{
    if(confirm("确定删除此设定吗？"))
    {
        $(obj).parent("span").remove();
    }
}
{/literal}
</script>
</body>
</html>
