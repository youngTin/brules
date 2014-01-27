var email = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/ ;
var user =/^[a-zA-Z]{1}([a-zA-Z0-9]){4,23}$/ ;
var password = vercode = /\w{4,15}/;
var telephone = /^1[3-9][0-9]\d{8}$/;
var lpno = /^[A-Za-z0-9]{6}$/;
var noempty = /^.+$/;
var isCheck = isLock = true;
function initBindBlur()
{
    $("input[verify='true']").each(function(){
            $(this).bind('blur',function(){
                checkInput();
            })
        })
}
var repassword = 
{
    fun:function(obj){
        var vtype = $(obj).attr('vtype');
        var value = $(obj).val();
        if(!eval(vtype).test(value))
        {
            isCheck = false;
            showErro(obj,$("#password").parent('td').children('label').html());
            $(obj).addClass('inerro');
            return false;
        }
        else if($('#password').val()!=value)
        {
            isCheck = false;
            showErro($("#password"),'两次密码不一致');
            $(obj).addClass('inerro');
            return false;
        }
    }
}
var vercodefun = 
{
    fun:function(obj)
    {
        var vtype = $(obj).attr('vtype');
        var value = $(obj).val();
        var result = true;
        if(!eval(vtype).test(value))
        {
            isCheck = false;
            showErro(obj);
            result = false; 
        }
        else
        {
            $.ajax({
                type:'post',
                dataType:'json',
                url:'/member_reg_new.php?action=checkVerCode',
                data:{vercode:value,ajax:1},
                timeout:30000,
                beforeSend: function(){
                    $("#loadimg").show();
                },
                success:function(msg){
                    $("#loadimg").hide();
                    if(msg=='1')
                    {
                        isCheck = true;
                    }
                    else{
                        isCheck = false ;
                        showErro(obj);
                        result = false;
                    } 
                }
            });
        }
        return result ;
    }
}
function checkInput()
{
    if(!isLock)return;
    var result = true ;
    var len = $("input[verify='true']").size();
    $("input[verify='true']").each(function(){
         isLock = false ;
            var vtype = $(this).attr('vtype');
            var value = $(this).val();
            if($(this).attr('vothfun'))
            {
                var fun = $(this).attr('vothfun');
                try{ 
                    var func = eval(fun+".fun");
                    if(func(this)==false)return false;
                    else
                    {
                        $(this).removeClass('inerro');
                        $(this).parent('td').children('label').hide();
                    }
                }catch(e){
                    alert($(this).attr('name')+'未定义错误');
                }
                
            }
            else if(!eval(vtype).test(value))
            {
                isCheck = result = false;
                showErro(this);
                return false;
            }
            else
            {
                $(this).removeClass('inerro');
                $(this).parent('td').children('label').hide();
                isCheck = true ;
            }    
    })
    setTimeout(function(){isLock = true ;},200) ;
    return result;
}
function showErro(obj,content)
{
    var pObj = $(obj).parent().parent('tr');
    var title = pObj.children('td.t_title').html();
    var msg = pObj.children('td').children('label');
    if(title!=null && (title.indexOf(':')||title.indexOf('：')))
    {
        var len = title.indexOf(':') == '-1' ? title.indexOf('：') : title.indexOf(':') ;
        title = title.substring(0,len);
        
    }
    $(obj).addClass('inerro');
    var left = $(obj).offset().left;
    var width = $(obj).width();
    var top = $(obj).offset().top;

    if(content != void 0)
    {
        msg.html(content).show();
    }
    if(typeof(msg)!='undefined')
    {
        msg.show();
        msg.css({'left':left+width+(parseFloat($(obj).css('padding-left')))+(parseFloat($(obj).css('padding-right')))+4,'top':top-(parseFloat($(obj).css('margin-top'))),'margin':'0'});
    }
}
$(window).load(function(){initBindBlur();})