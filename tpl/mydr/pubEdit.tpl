{include file="mydr/header.tpl"}
<script type="text/javascript" src="/ui/js/datepicker/WdatePicker.js" ></script>
<script type="text/javascript" src="/ui/js/common.formcheck.js" ></script>
<div class="center-box">
<div class="note-header">
    当前位置：<a>信息发布</a>
</div>
<div class="c-content">
    <h4>信息发布</h4>
    <div class="pub-box">
    <form action="member_pub.php?action=save"  method="post" id="form1" >
        <input type="hidden" name="id" value="{$info.id}" />
        <table width="100%">
           <tr>
                <td class="ttitle">发布类别</td>
                <td colspan="3">
                    <input type="hidden" name="type" id="type" value="0" />出售驾照分
                </td>
           </tr> <tr>
                <td class="ttitle">驾照所在地</td>
                <td colspan="3">
                    {$dist1}
                    &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
           </tr> <tr>
                <td class="ttitle">处理所在地</td>
                <td colspan="3">
                     {$dist2}
                    &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
           </tr> <tr>
                <td class="ttitle">证件类型</td>
                <td colspan="3">
                    {html_radios radios=$crecate_radio name=crecate selected=$info.crecate|default:6}
                    <span class="red font14">*</span>
                </td>
           </tr> <tr>
                <td class="ttitle" id='exppriceTitle'>最{if $smarty.get.type=='1'||$info.type=='1'}高{else}低{/if}期望价</td>
                <td>
                    <select name="min_expectprice" id="min_expectprice">
                        {html_options options=$min_expectprice_option selected=$info.min_expectprice|default:80}
                   </select>
                   &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
                <td class="ttitle" id="scTitle">{if $smarty.get.type=='1'||$info.type=='1'}收购{else}可售{/if}分数</td>
                <td>
                    <select name="score" id="scoreS">
                        {html_options options=$score_option selected=$info.score|default:9}
                   </select>
                   分
                   <span id="changeSg1" {if $smarty.get.type!='1'&&$info.type!='1'}class='disnone'{/if}>
                        <input type="checkbox" id='othersc' name="othersc" value="1" {if $info.score>12}checked{/if}>其他 
                         &nbsp;&nbsp;
                        <span id="expp1" class="disnone">收购分数&nbsp;
                        <input type="text" value="{$info.score}" name="scorceNew" id="scorceNew" /><label class="msg2">收购分数不能为空</label></span>
                   </span><span id="changeSg" {if $smarty.get.type=='1'&&$info.type=='1'}class='disnone'{/if}>
                       &nbsp;&nbsp;&nbsp;
                        <span class="red font14">*</span>
                        <span id="isrevoke" {if $info.revoke<=0}class="disnone"{/if}>&nbsp;&nbsp;可否吊销&nbsp;&nbsp;
                        <select name="revoke" id="revoke">
                            {html_options options=$revoke_option selected=$info.revoke|default:0}
                        </select>
                        &nbsp;&nbsp;
                        <span id="expp" {if $info.expectprice<=0}class="disnone"{/if}>期望价格&nbsp;
                        <input type="text" value="{$info.expectprice}" name="expectprice" id="expectprice" /><label class="msg2">期望价格不能为空</label></span></span>
                       
                    </span>
                </td>
           </tr><tr>
                <td class="ttitle">联系电话</td>
                <td>
                    <input type="text" name="tel" id='tel' verify="true" vtype='tel' value="{$info.tel}" />
                   &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span><label class="msg2">联系电话不正确</label>
                </td>
                <td class="ttitle">领证日期</td>
                <td>
                    <input type="text" name="licensdate" id="licensdate"  value="{$info.licensdate}" onclick="WdatePicker();"  verify="true" vtype='date' />
                   &nbsp;&nbsp;&nbsp;
                    <span class="red font14">&nbsp;*&nbsp;</span>
                    <label class="msg2">日期格式不正确</label>
                </td>
           </tr><tr>
                <td class="ttitle">联系人</td>
                <td >
                    <input type="text" name="linkman" id="linkman" verify="true" vtype='name' value="{$info.linkman}" />
                   &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span><label class="msg2">联系人不能为空</label>
                </td>
                <td class="ttitle">时间安排</td>
                <td>
                    <select name="timeline">
                    {html_options options=$timeline_option selected=$info.timeline|default:1}
                   </select>
                </td>
           </tr><tr>
                <td class="ttitle">备注</td>
                <td colspan="3">
                    <textarea name="remark" cols="42" rows="3">{$info.remark}</textarea>
                   &nbsp;&nbsp;&nbsp;
                </td>
           </tr>
           <tr>
            <td></td>
            <td colspan="3"><input id="subbutton" type="button" value="确定" class="subbutton red" /></td>
           </tr>
        </table>
    </form>
    </div>
</div>
</div>
<script type="text/javascript">
{literal}
$(function(){
    $("#subbutton").bind('click',function(){
        checkInput();
        if(isCheck)
        {
           $("#form1").submit();
        }
    })
    $("#scoreS").bind('change',function(){
        var data = $(this).val();
        var type = $("input[name='type']:checked").val();
        if(type=='1')
        {
            
        }
        else
        {
            
            if(data=='12')
            {
                $("#isrevoke").show();
            }
            else{
                $("#isrevoke").hide();
                $("#revoke").attr('value','0');
                $("#expp").hide();
            }
        }
        
    })
    
    $("#revoke").bind('change',function(){
        var data = $(this).find('option:selected').val();
        if(data=='0')
        {
            $("#expp").hide();
            $("#expectprice").val('').removeAttr('verify').removeAttr('vtype');
        }
        else
        {
            $("#expp").show();
            $("#expectprice").attr('verify','true');
            $("#expectprice").attr('vtype','money');
        }
    })
    
    $("input[name='type']").bind('click',function(){
        if($(this).val()=='1'){
            $("#exppriceTitle").html('最高期望价');
            $("#scTitle").html('收购分数');
            $("#changeSg1").show();
            $("#changeSg").hide();
        }
        else {
            $("#exppriceTitle").html('最低期望价');
            $("#scTitle").html('可售分数');
            $("#changeSg").show();
            $("#changeSg1").hide();
        }
    })
    
    $("#othersc").bind('click',function(){
        if($(this).attr('checked'))
        {
            $("#expp1").show();
        }
        else 
        {
            $("#scorceNew").val('');
            $("#expp1").hide();
        }
    })
    
    $("input[name='crecate']").bind('change',function(){
            $("#min_expectprice").html(meoptions);
            $.ajax({
                url:'?action=getMe',
                type: "POST",
                data: {oid:$(this).val(),city:$("#on_city").val(),type:$("#type").val()},
                dataType:'html',
                success: function(data) 
                {
                    if(data!='none')
                    {
                        var option = data;
                        $("#min_expectprice").html(option);
                    }
                }
            });
            
    })
})
window.meoptions = $("#min_expectprice").html();
{/literal}
</script>
{include file="mydr/footer.tpl"}