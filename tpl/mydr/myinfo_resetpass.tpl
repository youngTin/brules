{include file="brules/header.tpl"}
{include file="brules/menu.tpl"}
<script type="text/javascript" src="/ui/js/datepicker/WdatePicker.js" ></script>
<script type="text/javascript" src="/ui/js/common.formcheck.js" ></script>
<div class="center-box">
<div class="note-header">
    当前位置：<a>修改密码</a>
</div>
<div class="c-content">
    <div class="myinfo">
        <div class="myinfo_title">
            <ul><li><a href="?action=index">基本信息</a></li><li class="active">修改密码</li></ul>
        </div>
        <div class="myinfo_content">
            <form action="?action=savepass"  method="post" id="form1" >
                <table>
                    <tr>
                        <td>请输入旧密码：</td>
                        <td colspan="3"><input type="password" name="upass" id="upass"  verify="true" vtype='password' />&nbsp;&nbsp;<span class="red font14">*</span></td>
                    </tr><tr>
                        <td>请输入新密码：</td>
                        <td colspan="3"><input type="password" name="password" id="password"  verify="true" vtype='password'   />&nbsp;&nbsp;<span class="red font14">*</span><label class="msg2">密码不正确</label></td>
                    </tr><tr>
                        <td>请再次确认新密码：</td>
                        <td colspan="3"><input type="password" name="repassword" id="repassword"   verify="true" vtype='password' vothfun='repassword' />&nbsp;&nbsp;<span class="red font14">*</span></td>
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