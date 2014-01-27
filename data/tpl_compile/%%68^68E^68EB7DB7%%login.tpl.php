<?php /* Smarty version 2.6.22, created on 2013-03-10 18:44:31
         compiled from mydr/login.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/rheader.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="/ui/js/reg_new1.js"></script>
<?php echo '
<style type="text/css">
.head{width:900px;border-bottom: solid 1px #CBCBCB;margin: 10px auto;}
.foot{width:900px;border-top: solid 1px #CBCBCB;margin: 10px auto;text-align: center;}
.head .logo img{border:none;}
.head .hright{float: right;margin: 40px 20px 0 0;}
 a{color: #3E99C2;}
.center{width:900px;margin: 30px auto;}
.content-box{width: 100%;margin: 0 auto;}
.rtitle{font-size:24px;font-weight:600;width: 250px;line-height: 50px;}

.input{width:245px;padding:10px;border:1px solid #c8c8c8;-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.2);-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.2);box-shadow:inset 0 1px 2px rgba(0,0,0,0.2);}
 .login-box{border: solid 1px #CBCBCB; padding: 25px;width: 360px;font-size: 14px;margin: 0 auto;border-radius: 4px 4px 4px 4px;box-shadow: 0 0 6px #DDDDDD;}
 .login-box ul li {line-height: 60px;}
 .login-box ul li span{width : 60px;display: inline-block;}
 .f_grayblack{color:#7D7F7C;font-size:12px;font-style:normal;}
 .msg1,.msg2{display: none;}
</style>  
'; ?>

<div class="center">
    
    <div class="content-box" >
    
        
        <div class="login-box">
            <div class="rtitle">用户登录</div>
            <form action="member_login.php?action=login" method="post" >
                <div class="login_main">
                <ul>
                    <li><span>用户名：</span><input type="text" class="input" name="username" id="username" /></li>
                    <li class="red msg1"><span></span>用户名不能为空且必须大于3位小于15位</li>
                    <li><span>密&nbsp;&nbsp;码：</span><input type="password" class="input" name="password" id="password" />
                    </li>
                    <li class="red msg2"><span></span>密码不能为空且必须大于6位小于15位</li>
                    <li><span>&nbsp;</span>忘记了密码？点这里 <a href="forgetpass.html" target="_blank">找回密码</a></li>
                    <li class="btn_login"><span>&nbsp;</span><input type="submit" class="subbutton1"  id="login1" value="登录"  /></li>
                    <li><span>&nbsp;</span>还没有账号？赶紧去注册吧 <a href="reg_new.html" target="_self">立即免费注册</a></li>
                </ul>
                </div>
                </form>
                <div class="login_infor">
        </div>
        <div class="clear"></div>

        </div>
        
    </div>
    <div class="clear"></div>
</div>
<?php echo '
<script type="text/javascript">
$(function(){
    $("#username").bind(\'blur\',function(){
         if($(\'#username\').val()==""||$("#username").val().length<3||$("#username").val().length>15)
        {
            $(\'#username\').focus();
            $(".msg1").show();
            return false;
        }
        else{
            $(".msg1").hide();
        }
        
    });
    $("#password").bind(\'blur\',function(){
        if($(\'#password\').val()==""||$("#password").val().length<6||$("#password").val().length>15)
        {
            $(\'#password\').focus();
            $(".msg2").show();
            return false;
        }
        else{
            $(".msg2").hide();
        }
    });
})

</script>
'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>