$(document).ready(function()
{
	check();
	
});
function checkbut()
{
	
		if($('#name').val()=="")
		{
			$('#name').focus();
			$('#_name').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u771F\u5B9E\u59D3\u540D\u4E0D\u80FD\u4E3A\u7A7A!</font>");
			return false;
		}

		if($('#username').val()=="" || $('#username').val()=='\u8BF7\u8F93\u5165\u60A8\u7684\u624B\u673A\u53F7')
		{
			$('#username').focus();
			$('#_username').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u7528\u6237\u540D\u4E0D\u80FD\u4E3A\u7A7A!</font>");
			return false;
		}
		else
		{
			var t=/^(13\d{9})|(15\d{9})|(18\d{9})|(0\d{10,11})$/;
			if(!t.test($('#username').val()) ||$('#username').val().length>11){
						$('#_username').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u8BF7\u8F93\u5165\u6B63\u786E\u7684\u624B\u673A\u53F7\u7801!</font>");
			$('#username').focus();
			return false; 
			}
			else
			{
				$.ajax({type: "GET",url: "reg_new.php",
				data: "action=checkuser&username="+$("#username").val(),
				dataType: 'html',
				success: function(result){$("#_username").html(result);
				if(result!="<img src='/ui/member/img/icon_detection_yes.gif'>")
						{
							$('#username').focus();	
						}
				}}); 
			}
		
		}
	
		if($('#password').val().length<6 || $('#password').val().length>16)
		{
			$('#password').focus();
			$('#_password').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u5BC6\u7801\u4E0D\u80FD\u5C0F\u4E8E6\u4F4D\u5927\u4E8E16\u4F4D!</font>");
			return false;
		}
		if($('#repassword').val().length<6 || $('#repassword').val().length>16)
		{
			$('#repassword').focus();
			$('#_repassword').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u5BC6\u7801\u4E0D\u80FD\u5C0F\u4E8E6\u4F4D\u5927\u4E8E16\u4F4D!</font>");
			return false;
		}
		if($('#repassword').val() != $('#password').val())
		{
			$('#repassword').focus();
			$('#_repassword').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u4E24\u6B21\u8F93\u5165\u7684\u5BC6\u7801\u4E0D\u4E00\u6837!</font>");
			return false;
		}
		if($('#dl').attr("checked")) //\u672A\u8F93\u5165\u516C\u53F8\u540D \u72EC\u7ACB\u7ECF\u7EAA\u4EBA\u53EF\u9009\u62E9 
		{}else
		{
			if($('#company').val().length==0)
			{
				$('#company').focus();
				return false;
			}
		}
		var sEmail = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
		if(!sEmail.exec($("#email").val()))
		{
			$('#_email').html("<font color='red'><b><img src='/ui/member/img/icon_detection_no.gif'>Email\u683C\u5F0F\u4E0D\u6B63\u786E</b></font>");
			$('#email').focus();
			return false;
		}
		var eQQ=  /^[1-9]\d{4,9}$/;
		if(!eQQ.exec($("#qq").val()))
		{
			$('#_qq').html("<font color='red'><b><img src='/ui/member/img/icon_detection_no.gif'>QQ\u683C\u5F0F\u4E0D\u6B63\u786E</b></font>");
			$('#qq').focus();
			return false;
		}
		if($('#vdcode').val().length==0) //\u672A\u8F93\u5165\u516C\u53F8\u540D \u72EC\u7ACB\u7ECF\u7EAA\u4EBA\u53EF\u9009\u62E9 
		{
			$('#vdcode').focus();
			return false;
		}
		if(!$('#xy').get(0).checked) {
		alert("\u4F60\u5FC5\u987B\u540C\u610F\u6CE8\u518C\u534F\u8BAE\uFF01");
		return false;
		}
}
function check()
{
		//\u771F\u5B9E\u59D3\u540D\u8BA4\u8BC1
	$('#name').change(function()
	{
		if($('#name').val()=="")
		{
			$('#name').focus();
			$('#_name').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u771F\u5B9E\u59D3\u540D\u4E0D\u80FD\u4E3A\u7A7A!</font>");
			return false;
		}
		else
		{
			$('#_name').html("<img src='/ui/member/img/icon_detection_yes.gif'>");
		}
		
	});
		//\u7528\u6237\u540D\u9A8C\u8BC1\u662F\u5426\u91CD\u590D
	$('#username').change(function()
	{
		if($('#username').val()=="")
		{
			$('#username').focus();
			$('#_username').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u7528\u6237\u540D\u4E0D\u80FD\u4E3A\u7A7A!</font>");
			return false;
		}
		else
		{
			var t=/^(13\d{9})|(15\d{9})|(18\d{9})|(0\d{10,11})$/;
			if(!t.test($('#username').val()) ||$('#username').val().length>11){
			$('#_username').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u8BF7\u8F93\u5165\u6B63\u786E\u7684\u624B\u673A\u53F7\u7801!</font>");
			$('#username').focus();
			return false; 
			}
			else
			{
				$.ajax({type: "GET",url: "reg_new.php",
				data: "action=checkuser&username="+$("#username").val(),
				dataType: 'html',
				success: function(result){$("#_username").html(result);
				if(result!="<img src='/ui/member/img/icon_detection_yes.gif'>")
						{
							$('#username').focus();	
						}
				}}); 
			}
		
		}
		
	});
	
	//\u5BC6\u7801\u8BA4\u8BC1
		$('#password').change(function()
	{
		if($('#password').val().length<6 || $('#password').val().length>16)
		{
			$('#password').focus();
			$('#_password').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u5BC6\u7801\u4E0D\u80FD\u5C0F\u4E8E6\u4F4D\u5927\u4E8E16\u4F4D!</font>");
			return false;
		}
		else
		{
			$('#_password').html("<img src='/ui/member/img/icon_detection_yes.gif'>");
		}
		
	});
	$('#repassword').change(function()
	{
		if($('#repassword').val().length<6 || $('#repassword').val().length>16)
		{
			$('#repassword').focus();
			$('#_repassword').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u5BC6\u7801\u4E0D\u80FD\u5C0F\u4E8E6\u4F4D\u5927\u4E8E16\u4F4D!</font>");
			return false;
		}
		else
		{
			$('#_repassword').html("<img src='/ui/member/img/icon_detection_yes.gif'>");
		}
		if($('#repassword').val() != $('#password').val())
		{
			$('#repassword').focus();
			$('#_repassword').html("<img src='/ui/member/img/icon_detection_no.gif'><font>\u4E24\u6B21\u8F93\u5165\u7684\u5BC6\u7801\u4E0D\u4E00\u6837!</font>");
			return false;
		}
		else
		{
			$('#_repassword').html("<img src='/ui/member/img/icon_detection_yes.gif'>");
		}
	});
	//\u516C\u53F8
	$('#company').click(function()
	{
			$('#dl').attr('disabled','disabled');
	});
		//\u516C\u53F8
	$('#company').blur(function()
	{
			if($('#company').val().length==0) //\u672A\u8F93\u5165\u516C\u53F8\u540D \u72EC\u7ACB\u7ECF\u7EAA\u4EBA\u53EF\u9009\u62E9 
		{
			$('#dl').attr('disabled','');
		}
	});
	//\u516C\u53F8
	$('#company').change(function()
	{
		if($('#company').val().length==0) //\u672A\u8F93\u5165\u516C\u53F8\u540D \u72EC\u7ACB\u7ECF\u7EAA\u4EBA\u53EF\u9009\u62E9 
		{
			$('#dl').attr('disabled','disabled');
		}
	});
		//\u72EC\u7ACB\u7ECF\u7EAA\u4EBA \u9009\u4E2D\u72EC\u7ACB\u7ECF\u7EAA\u4EBA \u516C\u53F8\u540D\u4E0D\u5141\u8BB8\u8F93\u5165
	$('#dl').click(function()
	{
		
	  if ($( this ).attr("checked"))
	  {
		 	$('#company').attr('disabled','disabled');
		}
		else
		{
			$('#company').attr('disabled','');
			
		}
	});
	//email\u9A8C\u8BC1
	$("#email").change( function() {
	var sEmail = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
	if(!sEmail.exec($("#email").val()))
	{
		$('#_email').html("<font color='red'><b><img src='/ui/member/img/icon_detection_no.gif'>Email\u683C\u5F0F\u4E0D\u6B63\u786E</b></font>");
		$('#email').focus();
		return false;
	}
	else
	{
		$('#_email').html("<img src='/ui/member/img/icon_detection_yes.gif");
	}
	});
	//QQ\u9A8C\u8BC1
	$('#qq').change(function(){
		var eQQ=  /^[1-9]\d{4,9}$/;
			if(!eQQ.exec($("#qq").val()))
			{
				$('#_qq').html("<font color='red'><b><img src='/ui/member/img/icon_detection_no.gif'>QQ\u683C\u5F0F\u4E0D\u6B63\u786E</b></font>");
				$('#qq').focus();
				return false;
			}
			else
			{
				$('#_qq').html("<img src='/ui/member/img/icon_detection_yes.gif");
			}	
		
	});
	//\u9A8C\u8BC1\u7801
	$('#vdcode').change(function()
	{
		if($('#vdcode').val().length==0) //\u672A\u8F93\u5165\u516C\u53F8\u540D \u72EC\u7ACB\u7ECF\u7EAA\u4EBA\u53EF\u9009\u62E9 
		{
			alert('\u8BF7\u8F93\u5165\u9A8C\u8BC1\u7801');
			$('#vdcode').focus();
			return false;
		}
	});
	
}
