<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include_once("Config.php");
?>
<head>
<script language="javascript">
//*====================================================================
//*                 www.YiiPay.com
//*
//*                 易支付 提供技术支持
//*
//*====================================================================

//您只要在Config.asp文件中配置参数即可，下方的源码可以不用动了

var MyAccount	=	'<?php echo $AliAccount;?>';							//您的支付宝账号，请在Config.asp文件中配置

var UserName	=	'<?php echo $_REQUEST["u"];?>';						//此处获取当前充值的用户名

var remark		=	'<?php echo $_REQUEST["b"];?>';						//此处是备注内容

var TheMoney	=	'<?php echo $_REQUEST["m"];?>';						//(可选) 直接获取固定金额，当没有获取固定金额时，就会出现选择金额的按扭

var IsNotify	=	<?php echo $IsNotify;?>;								//是否启用跳转功能 值为“1”或“0”(1:付款成功后，自动跳转 0:付款成功后，不自动跳转)


//*=================================================================================

//----------此分界线下方的源码无需更改----------此分界线下方的源码无需更改----------

//*=================================================================================

</script>
<title>易支付_支付宝充值_自动到账</title>
<meta name="keywords" content="易支付" />
<meta name="description" content="易支付 www.YiiPay.com" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="stylesheet" href="img/css.css" type="text/css" />
<script language="javascript">
	//改变金额
	function ChangeMoney(yuan){
		var Money;
		if(document.getElementById("OtherAmount").checked==true){
			Money=document.getElementById('OtherMoney').value;
		}else{
			Money=yuan;
		}
		if(Money>0){
			document.getElementById("payAmount").value=Money;
			document.getElementById("price").innerHTML='￥'+Money;
		}
	}
	//改变状态
	function ChangeStep(n){
		//检测是否启用跳转功能
		if(IsNotify==1){
			if(n==1){
				document.getElementById('step1').style.display='';
				document.getElementById('step2').style.display='none';
			}else if(n==2){
				document.getElementById('step1').style.display='none';
				document.getElementById('step2').style.display='';
			}
		}
	}
	//提交查询
	function Submit_G(){
		document.getElementById("G_optEmail").value=document.getElementById("optEmail").value;
		document.getElementById("G_payAmount").value=document.getElementById("payAmount").value;
		document.getElementById("G_title").value=document.getElementById("title").value;
		document.getElementById("G_memo").value=document.getElementById("memo").value;
		document.getElementById("g").submit();
	}
</script>
</head>
<body>
<div class="recharge">
   <div class="recharge-inner">
      <div class="recharge-con clearfix">
         <!-- 左侧表单 -->
         <div id="step1" name="step1" style="display:;" class="recharge-form">
            <form name="f" id="f" action="http://www.thepayurl.com" method="get" target="_blank">
			<input name="optEmail" id="optEmail" type="hidden">
			<input name="payAmount" id="payAmount" type="hidden">
               <ul>
                  <li class="clearfix">
                     <label class="label-left">用 户 名：</label>
                     <input name="title" id="title" class="ipt-name" type="text" />
                  </li>
                  <li class="clearfix" id="SelectAmount" name="SelectAmount" style="display:;">
                     <label class="label-left">选 择：</label>
                     <span class="amount-value"><input type="radio" name="amount" onclick="javascript:ChangeMoney(20);" />20元</span>
                     <span class="amount-value"><input type="radio" name="amount" onclick="javascript:ChangeMoney(50);" />50元</span>
                     <span class="amount-value"><input type="radio" name="amount" onclick="javascript:ChangeMoney(100);" checked="checked" />100元</span>
                     <span class="amount-value"><input type="radio" name="amount" onclick="javascript:ChangeMoney(200);" />200元</span>
                     <span class="amount-value-ipt">
					 <i><input type="radio" name="amount" id="OtherAmount" onclick="javascript:ChangeMoney(0);" />其它</i> 
					 <input class="ipt-value" name="OtherMoney" id="OtherMoney" type="text" value="0.01" onKeyUp="javascript:ChangeMoney(0);" onBlur="javascript:ChangeMoney(0);" onfocus="javascript:ChangeMoney(0);" onkeypress="return event.keyCode>=48&&event.keyCode<=57||event.keyCode==46" onpaste="return !clipboardData.getData('text').match(/\D/)" ondragenter="return false" style="ime-mode:Disabled" />
					 </span>
                  </li>
                  <li class="clearfix">
                     <label class="label-left">确认金额：</label>
                     <span class="txt-price" id="price"></span>
                  </li>
                  <li class="clearfix" id="li_memo" name="li_memo" style="display:;">
                     <label class="label-left">备 注：</label>
                     <input name="memo" id="memo" class="ipt-name" type="text" value="" readonly="true"/>
                  </li>
                  <li class="clearfix">
                     <input class="recharge-btn" type="submit" value="支付宝充值" onclick="javascript:ChangeStep(2);" />
                  </li>
               </ul>
				<script language="javascript">
				document.getElementById("optEmail").value=MyAccount;//加载商户支付宝账号
				document.getElementById("title").value=UserName;//加载用户名
				document.getElementById("memo").value=remark;//加载备注
				if(TheMoney==''){
					ChangeMoney(100);			//默认选择充值金额
				}else{
					document.getElementById('SelectAmount').style.display='none';
					ChangeMoney(TheMoney);		//固定金额
				}
				if(remark==''){
					//隐藏备注
					document.getElementById('li_memo').style.display='none';
				}
				</script>
            </form>
        </div>
         
		 <div id="step2" name="step2" style="display:none;" class="recharge-form">
            <form name="g" id="g" action="http://www.YiiPay.com/GetNotify.asp" method="post" target="_blank">
				<input name="G_optEmail" id="G_optEmail" type="hidden">
				<input name="G_payAmount" id="G_payAmount" type="hidden">
				<input name="G_title" id="G_title" type="hidden">
				<input name="G_memo" id="G_memo" type="hidden">
               <ul>
                  <li class="clearfix">
                     <a href="javascript:ChangeStep(1);"><< 返回重新支付</a>
					 <br /><br />
					 <input class="recharge-btn-2" type="button" value="已付款 获取商品" onclick="javascript:Submit_G();" /> （付款成功后，请点击获取商品）
                  </li>
               </ul>
            </form>
        </div>
		 
		 <!-- 右侧文字 -->
         <div class="right-tips">
		 	<p>重要提示：</p>
			<p>支付宝付款时，请不要修改支付宝的“付款说明”和“备注”，否则不能自动到账。</p>
			<p><input class="recharge-btn-2" type="button" value="查看付款向导" onclick="javascript:window.location='#xd';" /></p>
		 </div>
      </div>
      
      <!-- 底部链接 -->
      <div class="recharge-bottom">
         <ul class="clearfix">
            <li><a href="/">返回主页</a></li>
			<!--此处链接若修改为您自己的推广链接，可获得额外的收入-->
            <li><a href="http://www.YiiPay.com" target="_blank">易支付(支付宝即时到账)接口</a></li>
         </ul>
      </div>
   </div>
</div>
<div class="xiangdao">
	<br />
	<h1 id="xd">↓ 付款向导 ↓</h1>
	<hr>
	<p><a href="#">↑ 返回</a></p>
	<p><img border="0" src="img/XiangDao_1.gif"></p>
	<p><img border="0" src="img/jt.jpg"> <a href="#">↑ 返回</a></p>
	<p><img border="0" src="img/XiangDao_2.gif"></p>
	<p><img border="0" src="img/jt.jpg"> <a href="#">↑ 返回</a></p>
	<p><img border="0" src="img/XiangDao_3.gif"></p>
	<p><img border="0" src="img/jt.jpg"> <a href="#">↑ 返回</a></p>
	<p><img border="0" src="img/XiangDao_4.gif"></p>
	<?php
	if ($IsNotify == 1){
	?>
		<p><img border="0" src="img/jt.jpg"> <a href="#">↑ 返回</a></p>
		<p><img border="0" src="img/XiangDao_5.gif"></p>
	<?php
	}
	?>
	<h1>完成！付款成功后，全自动到账。</h1>
	<p> <a href="#">↑ 返回</a></p>
</div>
</body>
</html>