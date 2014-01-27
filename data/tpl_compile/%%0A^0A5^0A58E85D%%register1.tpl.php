<?php /* Smarty version 2.6.22, created on 2013-05-26 15:06:41
         compiled from mydr/register1.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'fp', 'mydr/register1.tpl', 109, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/rheader.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="/ui/js/reg_new.js"></script>
<?php echo '
<style type="text/css">
.register{padding:40px 0;}
.regsteps{margin:0 auto 40px;height:40px;background:url(/ui/img/regsteps.png) no-repeat;}
.regsteps-1{background-position:0 0;}
.regsteps-2{background-position:0 -40px;}
.regsteps-3{background-position:0 -80px;}
.regsteps li{font-size:133%;float:left;width:245px;height:40px;line-height:40px;text-align:center;color:#999;}
.regsteps em{font:normal 150% Georgia,Serif;vertical-align:-1px;}
.regsteps-1 .step-1,.regsteps-2 .step-2,.regsteps-3 .step-3{color:#fff;}

.regform{margin-left:240px;}

.regform .regoptions{font-size:14px;padding:0 36px 28px;}
.regform .regoptions label{margin-right:20px;}

.mainwrapper{background:url(images/bg_features.gif) repeat-x;}
.main{width:980px;margin:0 auto;background:url(images/bg_features.gif) repeat-x;}
.main .aside{float:left;width:180px;margin-right:20px;}
.main .conent,.main .article{float:left;width:780px;overflow:hidden;}

.reg-box{margin: 10px 0;font-size: 14px;}
.reg-box table,.reg-box td{border: 0 none;}
.reg-box tr td{line-height: 34px;}
.input{width:245px;padding:10px;border:1px solid #c8c8c8;-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.2);-webkit-box-shadow:inset 0 1px 2px rgba(0,0,0,0.2);box-shadow:inset 0 1px 2px rgba(0,0,0,0.2);}
.login-box{float: right;border-left: solid 1px #CBCBCB; padding: 125px 10px;background: url(\'ui/img/logo4qb.png\') no-repeat 10px 55px ;}
.f_grayblack{color:#7D7F7C;font-size:12px;font-style:normal;}
 
 .content-box{margin-left: 60px;}
.reg table .t_title{text-align:right;padding-right:5px;}
.reg table tr{height: 50px;}
.reg .inerro{border:solid 1px #F46700;}
.reg label{font-size:13px;height:35px;line-height:35px;padding: 0 10px 0 20px;margin:8px 0 0 10px;display:none; position:absolute; z-idnex:99;}
.reg .msg1{border:solid 1px #30B044;color:#285A14;background-color:#EDFFF0;}
.reg .msg2{border:solid 1px #FF0F0F;color:#FF0F0F;background-color:#FFF2F2;}
.reg .msg3{float:left;margin-left:10px;color:#777777;display:inline;}
.reg .msg3 span{margin:0 1px;padding:2px ;width:50px;height:14px;line-height:14px;*line-height:18px;line-height:18px \\0;background-color:#C4C4C4;display:inline-block;text-align:center;color:#FFFFFF;}
.reg .msg3 .on{background-color:#F79100;}

.reg .pass{background:url(\'ui/\') no-repeat left center;}

.reg .verimg img , .verimg a{float:left;padding:5px;}
.reg .verimg a{}

.reg .loading{display:inline-block;line-height:24px;height:24px;width:26px;text-align:center;}
.reg .loading img{display:none;}

.verimg a{color:#3E99C2;cursor: pointer;text-decoration: underline;}
</style>  
'; ?>

    <ul class="regsteps regsteps-1">
        <li class="step-1"><em>1</em> 填写注册账号</li>
        <li class="step-2"><em>2</em> 证件信息提交</li>
        <li class="step-3"><em>3</em> 信息等待交易</li>
        <li class="step-4"><em>4</em> 交易成功</li>
    </ul>

<div class="mainwrapper">
    <div class="clearfix main">
        <div class="content-box" >
            <div class="reg-box reg">
            <form action="/reg_new.html?action=save" method="post" id="form1">
            <input type="hidden" name="inuser" value="<?php echo $_GET['inuser']; ?>
" />
                 <table>
                    <tr>
                        <td class="t_title">用户名：</td>
                        <td >
                            <input type="text" name="username" id="username" value="" class="input" maxlength="25" size="17" verify='true' vtype='user' />
                            <em id="_username"><span class="f_grayblack">*用户名只能输入3-15位数组、字母、下划线</span></em>
                            <label class="msg2">请输入昵称,必须以英文字母开头+数字组成,不超过24个字符</label>
                        </td>
                    </tr>
                    <tr >
                      <td class="t_title">密码：</td>
                      <td height="34">
                      <input type="password" name="password" id="password" value="" class="input"  maxlength="25" size="17"  verify='true' vtype='password'>
                      <font  class="f_grayblack">*请输入6-15位字符！</font>
                      <label id="passwordMsg" class="msg2">*密码6-15位字符由英文和数字组成！</label>
                      </td>
                    </tr>
                    <tr >
                      <td class="t_title">确认密码：</td>
                      <td height="34">
                      <input type="password" name="repassword" id="repassword" value="" class="input"  maxlength="25" size="17"  verify='true' vtype='password' vothfun='repassword' />
                      <font  class="f_grayblack">*请再次输入密码！</font>
                      <label class="msg2">两次密码不一致</label>
                      </td>
                    </tr>
                    <tr >
                      <td class="t_title">手机：</td>
                      <td height="34">
                      <input type="text" name="phone" id="telephone" value="" class="input" size="17" verify='true' vtype='telephone' >
                      <font  class="f_grayblack">*您的手机号码</font>
                       <label class="msg2">手机号码不正确</label>
                      </td>
                    </tr>
                    <tr>
                        <td class="t_title"></td>
                        <td><div class="verimg"><a><img src="<?php echo @URL; ?>
/includes/validate_code/vdimgck.php" name="ck" align="absmiddle" onclick="this.src=this.src+'?said='+Math.random();" id="vdimgck"></a>&nbsp;&nbsp;&nbsp;<a onclick="$(this).parent('div').children('a').children('img').attr('src',$(this).parent('div').children('a').children('img').attr('src')+'?said='+Math.random())">看不清，换一张？</a></div></td>
                    </tr><tr>
                        <td class="t_title">验证码：</td>
                        <td height="34"><input type="text" class="input " name="vdcode" id="vercode" verify="true" vtype='vercode' vothfun='vercodefun' /><label class="msg1">请输入验证码</label><span class="loading"><img src="ui/images/loading.gif" alt="" id="loadimg"></span></td>
                    </tr>
                    <tr >
                      <td height="34"  valign="middle">&nbsp;</td>
                      <td height="34">
                      <input name="agree" id="agree" type="checkbox" class="jyd" checked="checked"> 我已经阅读并同意<a href="/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 449), $this);?>
" target="_blank">《驾照交易网网个人用户协议》</a>
                      </td>
                    </tr>
                    <tr >
                      <td height="34"  valign="middle">&nbsp;</td>
                      <td height="34" ><br />
                      <input type="button" id="regbutton" class="subbutton1 " value="提交注册" >
                      </td>
                    </tr>
                 </table> 
            </form>                
            </div>
            
        </div>
    </div>

<script type="text/javascript">
<?php echo '
$(function(){
    $("#regbutton").bind(\'click\',function(){
        checkInput();             
        if(isCheck)
        {
            if($("#agree").attr(\'checked\'))
            {
                //check bind
                        $("#form1").submit();
                
            }
            else alert(\'请先接受驾照888网用户使用协议，然后再注册！\');
        }
    })
})
'; ?>

</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>