{include file="brules/header.tpl"}
<div class="center-box">
<script type="text/javascript" src="/ui/js/reg_new.js"></script>
<div class="note-header">
    当前位置：<a>违章查询提交</a>
</div>

<div class="c-content">
    <div class="myinfo">
        <div class="myinfo_title">
            <ul><li class="active">违章提交</li></ul>
        </div>
        <div class="myinfo_content">
            <form action="?action=save"  method="post" id="form1" >
                <table>
                    <tr>
                        <td>唯一号：</td>
                        <td colspan="3"><input type="text" name="bno" class="binput" maxlength="7" /></td>
                    </tr><tr>
                        <td>车牌号码：</td>
                        <td ><input type="text" name="no" class="binput" maxlength="7" /></td>
                        <td>车辆品牌：</td>
                        <td ><input type="text" name="brand" class="binput" maxlength="7" /></td>
                    </tr> <tr>
                        <td>初次登记：</td>
                        <td ><input type="text" name="reg_first" class="binput" maxlength="7" /></td>
                        <td>最近定检：</td>
                        <td ><input type="text" name="check_last" class="binput" maxlength="7" /></td>
                    </tr><tr>
                        <td>检验有效期：</td>
                        <td ><input type="text" name="valid" class="binput" maxlength="7" /></td>
                        <td>保险终止期：</td>
                        <td ><input type="text" name="end_insure" class="binput" maxlength="7" /></td>
                    </tr>
                </table>
                <table class="border-dashed">
                    <tr>
                        <td>违章时间：</td>
                        <td ><input type="text" name="brtime[]" class="binput" value="{$info.engno}"  /></td>
                        <td>违章地点：</td>
                        <td ><input type="text" name="braddress[]" class="binput" value="{$info.engno}"  /></td>
                        <td>违章原因：</td>
                        <td ><input type="text" name="brreason[]" class="binput" value="{$info.engno}"  /></td>
                    </tr><tr>
                        <td>扣分：</td>
                        <td ><input type="text" name="marking[]" class="binput" value="{$info.engno}"  /></td>
                        <td>罚金：</td>
                        <td ><input type="text" name="fine[]" class="binput" value="{$info.engno}"  /></td>
                    </tr>
                </table><table class="border-dashed">
                    <tr>
                        <td>违章时间：</td>
                        <td ><input type="text" name="brtime[]" class="binput" value="{$info.engno}"  /></td>
                        <td>违章地点：</td>
                        <td ><input type="text" name="braddress[]" class="binput" value="{$info.engno}"  /></td>
                        <td>违章原因：</td>
                        <td ><input type="text" name="brreason[]" class="binput" value="{$info.engno}"  /></td>
                    </tr><tr>
                        <td>扣分：</td>
                        <td ><input type="text" name="marking[]" class="binput" value="{$info.engno}"  /></td>
                        <td>罚金：</td>
                        <td ><input type="text" name="fine[]" class="binput" value="{$info.engno}"  /></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td></td>
                        <td colspan="3"><input id="subbutton" type="button" value="提交" class="subbutton1 " /></td>
                    </tr>
                </table>
            </form>
            <div class="border-dashed">
                    提交注意项：<br />
                    提交方式:<span class="orange">&nbsp;POST&nbsp;</span>方式提交<br />
                    提交地址:<span class="orange"> getapi.shtml?action=save </span><br />
                    提交内容：(模拟input提交，以下为name字段名)<br />
                    *唯一号 ：&nbsp;<b class="orange">bno</b>&nbsp;<br />
                    1、车牌号码 ：&nbsp;<b class="orange">no</b>&nbsp;<br />
                    2、车辆品牌 ：&nbsp;<b class="orange">brand</b>&nbsp;<br />
                    3、初次登记 ：&nbsp;<b class="orange">reg_first</b>&nbsp;<br />
                    4、最近定检 ：&nbsp;<b class="orange">check_last</b>&nbsp;<br />
                    5、检验有效期 ：&nbsp;<b class="orange">valid</b>&nbsp;<br />
                    6、保险终止期 ：&nbsp;<b class="orange">end_insure</b>&nbsp;<br />
                    以下要以数组形式提交：<br />
                    7、违章时间：&nbsp;<b class="orange">brtime[]</b>&nbsp;<br />
                    8、违章地点：&nbsp;<b class="orange">braddress[]</b>&nbsp;<br />
                    9、违章原因：&nbsp;<b class="orange">brreason[]</b>&nbsp;<br />
                    10、扣分：&nbsp;<b class="orange">marking[]</b>&nbsp;<br />
                    11、罚金：&nbsp;<b class="orange">fine[]</b>&nbsp;<br />
            </div>
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