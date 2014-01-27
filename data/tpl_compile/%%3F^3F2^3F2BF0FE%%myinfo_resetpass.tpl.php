<?php /* Smarty version 2.6.22, created on 2014-01-13 10:48:39
         compiled from mydr/myinfo_resetpass.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
<?php echo '
$(function(){
    $("#subbutton").bind(\'click\',function(){
        checkInput();
        if(isCheck)
        {
           $("#form1").submit();
        }
    })
})
'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>