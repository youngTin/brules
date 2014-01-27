{literal}
<style type="text/css">
#itemTextcontent{margin:0;}
.outer{font-size: 12px;background:url(../ui/images/ajax_login_bg.jpg) repeat-x}
.outer,.login_box{width:510px;margin: 0;padding: 0;overflow: hidden;}
.login_box{text-align:left;width:980px;}
.login_main{float:left;width:425px;height:267px;padding:52px 0 0 86px}

.login_main li{width:425px;margin-bottom:20px;color:#3e4143}
.login_main li span{display:inline-block;width:60px}
.login_main .btn_login input{width:112px;height:36px;background:url(../ui/images/green_btn.png) no-repeat 0 0;border:none;cursor:pointer;border:none;padding-left: 32px;font-weight: bold;font-size:14px;color: #FFFFFF;}
.login_main input{width:200px;height:23px;background:#fff;border:1px solid #969a9d;line-height:23px}
.login_infor{width:448px;height:397px;background:url(../ui/images/login_infor_bg.gif) no-repeat 40px 0;float:left}

.login_main ul li{list-style: none;}
#showMsg1{background: #FFF2F2;padding:2px 10px;width:180px;margin-left: 20px;color: #000000;border:solid 1px #FF8080;display:none;}
.login_main li a{color:#666666;}

.green_button{
	width:112px;
	height:36px;
    background:url(../ui/images/green_btn.png) no-repeat scroll 0 0 transparent;
    color: #FFFFFF;
    float: left;
    font-weight: bold;
    padding-left: 22px;
    text-decoration: none;
    text-transform: uppercase;
	cursor:pointer;
	border:none;
}
</style>    
<script type="text/javascript">
    var loginG =function(){
                    var username = $("#username1").val(),pwd = $("#password1").val();
                    if(username.length<3||pwd.length<3){showMsg1('用户名或密码不能为空且大于3位!');return false;}
                    $.post('/login.shtml?action=login',{'username':username,'password':pwd,'ajax':1},function($data){ 
                            switch($data){
                                case '-1' : showMsg1('登录失败!');break;
                                case '0' : showMsg1('用户名或密码错误!');break;
                            }
                            if(parseInt($data)>0)showSuccess1(username);
                        
                    })
                    return false;
    }
    var showMsg1=function(content){
        $("#showMsg1").html(content).show().fadeOut(5000);return false;
    }
    var showSuccess1 = function($username){
        $.dialog.get('itemT').close();
        window.location.reload();
        
    }

</script>
{/literal}
<div class="outer">
    <div class="login_box">
    <form action="/login.shtml?action=login" method="post" id="login_form1" onsubmit="return loginG();" >
        <div class="login_main">
        <ul>
            <li><span>用户名：</span><input type="text" name="username" id="username1" /></li>
            <li><span>密&nbsp;&nbsp;码：</span><input type="password" name="password" id="password1" />
            </li>
            <li><span>&nbsp;</span>忘记了密码？点这里 <a href="/forgetpass.shtml">找回密码</a></li>
            <li class="btn_login"><span>&nbsp;</span><input type="submit" class="btn_login" id="login1" value="登  录"  /><span id="showMsg1">*登录失败</span></li>
            <li><span>&nbsp;</span>还没有账号？赶紧去注册吧 <a href="/reg_new.shtml" target="_self">立即免费注册</a></li>
        </ul>
        </div>
        </form>
        </div>
        <div class="clear"></div>
    </div>
