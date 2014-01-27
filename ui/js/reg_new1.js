$(document).ready(function()
{
    //\u767B\u5F55\u9A8C\u8BC1
    $('#login').click(function()
    {
        if($('#username').val()==""||$("#username").val().length<3||$("#username").val().length>15)
        {
            $('#username').focus();
            $.dialog.tips('用户名不能为空且必须大于3位小于15位',2);
            return false;
        }
        if($('#password').val()==""||$("#password").val().length<6||$("#password").val().length>15)
        {
            $('#password').focus();
            $.dialog.tips('密码不能为空且必须大于6位小于15位',2);
            return false;
        }
        if($("#password").val()!=$("#repassword").val())
        {
            $('#repassword').focus();
            $.dialog.tips('两次密码输入不一致',2);
            return false;
        }
        if($.trim($("#phone").val()).length==0)
        {
            $('#phone').focus();
            $.dialog.tips('手机号码不能为空',2);
            return false;
        }
        var sPhone = /^1\d{10}$/;
        if(!sPhone.exec($("#phone").val()))
        {
            $('#phone').focus();
            $.dialog.tips('手机号码格式不正确',2);
            return false;
        }
        if($("#vdcode").val()=='')
        {
            $("#vdcode").focus();
            $.dialog.tips('验证码不能为空',2);
            return false;
        }
    });
     $('#login1').click(function()
    {
        if($('#username').val()==""||$("#username").val().length<3||$("#username").val().length>15)
        {
            $('#username').focus();
            $(".msg1").show();
            return false;
        }
        if($('#password').val()==""||$("#password").val().length<6||$("#password").val().length>15)
        {
            $('#password').focus();
            $(".msg2").show();
            return false;
        }
    })
    
});