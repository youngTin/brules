<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>驾照888</title>
<link href="/ui/css/common.css" rel="stylesheet" type="text/css" > 
<script type="text/javascript" src="/ui/js/jquery-1.5.1.min.js" ></script>
<script type="text/javascript" src="/ui/js/common.js" ></script>
<script type="text/javascript" src="/ui/js/reg_new.js"></script>
</head>
{literal}
<style type="text/css">
.head{width:900px;border-bottom: solid 1px #CBCBCB;margin: 10px auto;}
.foot{width:900px;border-top: solid 1px #CBCBCB;margin: 10px auto;text-align: center;}
.head .logo img{border:none;}
.head .hright{float: right;margin: 40px 20px 0 0;}
.center{width:800px;margin: 30px auto;}
.content-box{width: 100%;}
a{color: #3E99C2;}
.rtitle{font-size:16px;font-weight:600;width: 250px;}
.rt_note{background:url('/ui/img/finger.png') no-repeat ;float: right;padding-left: 36px;color: #D65E21;}
.reg-box{margin: 10px 0;font-size: 14px;}
 .reg-box table,.reg-box td{border: 0 none;}
 .reg-box tr td{line-height: 34px;}
 .input{border:solid 1px #CBCBCB;height: 24px;}
 .login-box{float: right;border-left: solid 1px #CBCBCB; padding: 125px 10px;background: url('ui/img/logo4qb.png') no-repeat 10px 55px ;}
 .f_grayblack{color:#7D7F7C;font-size:12px;font-style:normal;}
 
 .reg table .t_title{text-align:right;padding-right:5px;}
 .reg .inerro{border:solid 1px #F46700;}
.reg label{font-size:13px;height:24px;line-height:24px;padding: 0 10px 0 20px;margin:8px 0 0 10px;display:none; position:absolute; z-idnex:99;}
.reg .msg1{border:solid 1px #30B044;color:#285A14;background-color:#EDFFF0;}
.reg .msg2{border:solid 1px #FF0F0F;color:#FF0F0F;background-color:#FFF2F2;}
.reg .msg3{float:left;margin-left:10px;color:#777777;display:inline;}
.reg .msg3 span{margin:0 1px;padding:2px ;width:50px;height:14px;line-height:14px;*line-height:18px;line-height:18px \0;background-color:#C4C4C4;display:inline-block;text-align:center;color:#FFFFFF;}
.reg .msg3 .on{background-color:#F79100;}

.reg .pass{background:url('ui/') no-repeat left center;}

.reg .verimg img , .verimg a{float:left;padding:5px;}
.reg .verimg a{}

.reg .loading{display:inline-block;line-height:24px;height:24px;width:26px;text-align:center;}
.reg .loading img{display:none;}
</style>  
{/literal}
<body>
<div class="head">
     <div class="hright"><a href="login.html">登录</a></div><a href="" class="logo"><img src="ui/img/logo4qb.png" alt=""></a>
</div>
<div class="center">
    
    <div class="content-box" >
    
        <div class="rtitle"><div class="rt_note">注册就送500元</div>用户注册</div>
        <div class="reg-box reg">
            <div class="login-box">
                   已有驾照交易网帐户，可<a href="login.html" class="red">直接登录</a>
            </div> 
        <form action="/reg_new.html?action=save" method="post" id="form1">
        <input type="hidden" name="inuser" value="{$smarty.get.inuser}" />
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
                    <td><div class="verimg"><a><img src="{$smarty.const.URL}/includes/validate_code/vdimgck.php" name="ck" align="absmiddle" onclick="this.src=this.src+'?said='+Math.random();" id="vdimgck"></a>&nbsp;&nbsp;&nbsp;<a onclick="$(this).parent('div').children('a').children('img').attr('src',$(this).parent('div').children('a').children('img').attr('src')+'?said='+Math.random())">看不清，换一张？</a></div></td>
                </tr><tr>
                    <td class="t_title">验证码：</td>
                    <td height="34"><input type="text" class="input " name="vdcode" id="vercode" verify="true" vtype='vercode' vothfun='vercodefun' /><label class="msg1">请输入验证码</label><span class="loading"><img src="ui/images/loading.gif" alt="" id="loadimg"></span></td>
                </tr>
                <tr >
                  <td height="34"  valign="middle">&nbsp;</td>
                  <td height="34">
                  <input name="agree" id="agree" type="checkbox" class="jyd" checked="checked"> 我已经阅读并同意<a href="/helper.php?action=view&sp={fp id=449}" target="_blank">《驾照交易网网个人用户协议》</a>
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
    <div class="clear"></div>
</div>
<script type="text/javascript">
{literal}
$(function(){
    $("#regbutton").bind('click',function(){
        checkInput();
        if(isCheck)
        {
            if($("#agree").attr('checked'))
            {
                //check bind
                        $("#form1").submit();
                
            }
            else alert('请先接受驾照888网用户使用协议，然后再注册！');
        }
    })
})
{/literal}
</script>
<div class="foot">
    <p>Copyright 2013 © 驾照888 版权所有</p>
</div>