{include file="brules/header.tpl"}
{include file="brules/menu.tpl"}
<script type="text/javascript" src="/ui/js/datepicker/WdatePicker.js" ></script>
<script type="text/javascript" src="/ui/js/common.formcheck.js" ></script>
<div class="center-box">
<div class="note-header">
    当前位置：<a>个人信息</a>
</div>
<div class="c-content">
    <div class="myinfo">
        <div class="myinfo_title">
            <ul><li class="active">我的驾照</li><li><a href="?action=resetpass">添加驾照</a></li></ul>
        </div>
        <div class="myinfo_content">
            <form action="?action=save"  method="post" id="form1" >
                <table>
                    <tr>
                        <td>真实姓名：</td>
                        <td colspan="3"><input type="text" name="linkman" value="{$info.linkman}" /></td>
                    </tr><tr>
                        <td>性别：</td>
                        <td colspan="3">{html_radios radios=$sex_radio name=sex selected=$info.sex|default:1}</td>
                    </tr><tr>
                        <td>领证日期：</td>
                        <td colspan="3"><input type="text" name="licensdate"  value="{$info.licensdate|date_format:'%Y-%m-%d'}" onclick="WdatePicker();"  verify="true" vtype='date' />&nbsp;&nbsp;<span class="red font14">*</span></td>
                    </tr><tr>
                        <td>证件类型：</td>
                        <td colspan="3">{html_radios radios=$crecate_radio name=crecate selected=$info.crecate|default:1}&nbsp;&nbsp;<span class="red font14">*</span></td>
                    </tr><tr>
                        <td>最低期望价：</td>
                        <td>
                            <select name="min_expectprice">
                                {html_options options=$min_expectprice_option selected=$info.min_expectprice|default:80}
                            </select>
                        </td>
                        <td>手机号码：</td>
                        <td><input type="text" name="tel" verify="true" vtype='tel' value="{$info.tel}" /></td>
                    </tr><!--<tr>
                        <td>驾照所在地：</td>
                        <td colspan="3">{$dist1}</td>
                    </tr><tr>
                        <td>当前所在地：</td>
                        <td colspan="3">{$dist2}</td>
                    </tr>--><tr>
                        <td>驾驶证号：</td>
                        <td ><input type="text" name="licensid" value="{$info.licensid}" /></td>
                        <td>档案编号：</td>
                        <td ><input type="text" name="fileno"  value="{$info.fileno}" /></td>
                    </tr><tr>
                        <td>QQ:</td>
                        <td><input type="text" name="qq" id="qq" value="{$info.qq}" /></td>
                        <td>邮箱:</td>
                        <td><input type="text" name="email" id="qq" value="{$info.email}" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3"><input id="subbutton" type="button" value="确定" class="subbutton1 " /></td>
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