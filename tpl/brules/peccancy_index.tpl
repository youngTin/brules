{include file="brules/header.tpl"}
{include file="brules/menu.tpl"}
<div class="center-box">
<script type="text/javascript" src="/ui/js/reg_new.js"></script>
<!--<div class="note-header">
    当前位置：<a>违章查询</a>
</div>-->

<div class="c-content">
    <div class="myinfo">
        <div class="myinfo_title">
            <ul><li class="active">违章查询提醒</li><li><a href="?action=mybrules">我的车辆</a></li></ul>
        </div>
        <div class="myinfo_content">
            <form action="?action=save"  method="post" id="form1" >
                <input type="hidden" name="id" value="{$info.id}" />
                <table>
                    <tr>
                        <td>违章的区域：</td>
                        <td colspan="3"><input type="hidden" name="province" value="{$province}" />{$dist1}</td>
                    </tr><tr>
                        <td class="t_title">车牌号：</td>
                        <td colspan="3">
                        {if $isbond=='1'}
                        {$info.lpp}{$info.lpno}
                        {else}
                            <select name="lpp" class="bselect" >
                                {html_options options=$br_br_dist selected=$info.lpp}
                            </select>
                        <input type="text" name="lpno" class="binput"  value="{$info.lpno}" maxlength="6" verify="true" vtype='lpno' /><label class="msg1 clabel">车牌号必须</label>
                        {/if}
                        </td>
                    </tr><tr>
                        <td>车架号：</td>
                        <td colspan="3">{if $isbond=='1'}{$info.chassisno}{else}<input type="text" name="chassisno" class="binput"  value="{$info.chassisno}" maxlength="6"  />&nbsp;&nbsp;<span class="gray ">车辆识别代号后6位</span>{/if}</td>
                    </tr><tr>
                        <td>发动机号：</td>
                        <td colspan="3"><input type="text" name="engno" class="binput" value="{$info.engno}" maxlength="6" />&nbsp;&nbsp;<span class="gray ">发动机号后6位</span></td>
                    </tr><tr>
                        <td>车辆类型：</td>
                        <td colspan="3">
                            <select name="vtype">
                                {html_options options=$br_car_type selected=$info.vtype|default:0}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>手机号:</td>
                        <td colspan="3"><input type="text" name="telephone" class="binput" id="telephone" value="{$info.telephone}" /></td>
                    </tr> <tr>
                        <td class="t_title"></td>
                        <td><div class="verimg"><a><img src="/includes/validate_code/vdimgck.php" name="ck" align="absmiddle" onclick="this.src=this.src+'?said='+Math.random();" id="vdimgck"></a>&nbsp;&nbsp;&nbsp;<a onclick="$(this).parent('div').children('a').children('img').attr('src',$(this).parent('div').children('a').children('img').attr('src')+'?said='+Math.random())">看不清，换一张？</a></div></td>
                    </tr><tr>
                        <td class="t_title">验证码:</td>
                        <td colspan="3"><input type="text" class="binput " name="vdcode" id="vercode" verify="true" vtype='vercode' vothfun='vercodefun' /><label class="msg1 clabel">请输入验证码</label><span class="loading"><img src="ui/images/loading.gif" alt="" id="loadimg"></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3"><input id="subbutton" type="button" value="提交" class="subbutton1 " /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="clear"></div>
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
})
{/literal}
</script>
{include file="brules/footer.tpl"}