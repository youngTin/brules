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
//*                 ��֧�� �ṩ����֧��
//*
//*====================================================================

//��ֻҪ��Config.asp�ļ������ò������ɣ��·���Դ����Բ��ö���

var MyAccount	=	'<?php echo $AliAccount;?>';							//����֧�����˺ţ�����Config.asp�ļ�������

var UserName	=	'<?php echo $_REQUEST["u"];?>';						//�˴���ȡ��ǰ��ֵ���û���

var remark		=	'<?php echo $_REQUEST["b"];?>';						//�˴��Ǳ�ע����

var TheMoney	=	'<?php echo $_REQUEST["m"];?>';						//(��ѡ) ֱ�ӻ�ȡ�̶�����û�л�ȡ�̶����ʱ���ͻ����ѡ����İ�Ť

var IsNotify	=	<?php echo $IsNotify;?>;								//�Ƿ�������ת���� ֵΪ��1����0��(1:����ɹ����Զ���ת 0:����ɹ��󣬲��Զ���ת)


//*=================================================================================

//----------�˷ֽ����·���Դ���������----------�˷ֽ����·���Դ���������----------

//*=================================================================================

</script>
<title>��֧��_֧������ֵ_�Զ�����</title>
<meta name="keywords" content="��֧��" />
<meta name="description" content="��֧�� www.YiiPay.com" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link rel="stylesheet" href="img/css.css" type="text/css" />
<script language="javascript">
	//�ı���
	function ChangeMoney(yuan){
		var Money;
		if(document.getElementById("OtherAmount").checked==true){
			Money=document.getElementById('OtherMoney').value;
		}else{
			Money=yuan;
		}
		if(Money>0){
			document.getElementById("payAmount").value=Money;
			document.getElementById("price").innerHTML='��'+Money;
		}
	}
	//�ı�״̬
	function ChangeStep(n){
		//����Ƿ�������ת����
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
	//�ύ��ѯ
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
         <!-- ���� -->
         <div id="step1" name="step1" style="display:;" class="recharge-form">
            <form name="f" id="f" action="http://www.thepayurl.com" method="get" target="_blank">
			<input name="optEmail" id="optEmail" type="hidden">
			<input name="payAmount" id="payAmount" type="hidden">
               <ul>
                  <li class="clearfix">
                     <label class="label-left">�� �� ����</label>
                     <input name="title" id="title" class="ipt-name" type="text" />
                  </li>
                  <li class="clearfix" id="SelectAmount" name="SelectAmount" style="display:;">
                     <label class="label-left">ѡ ��</label>
                     <span class="amount-value"><input type="radio" name="amount" onclick="javascript:ChangeMoney(20);" />20Ԫ</span>
                     <span class="amount-value"><input type="radio" name="amount" onclick="javascript:ChangeMoney(50);" />50Ԫ</span>
                     <span class="amount-value"><input type="radio" name="amount" onclick="javascript:ChangeMoney(100);" checked="checked" />100Ԫ</span>
                     <span class="amount-value"><input type="radio" name="amount" onclick="javascript:ChangeMoney(200);" />200Ԫ</span>
                     <span class="amount-value-ipt">
					 <i><input type="radio" name="amount" id="OtherAmount" onclick="javascript:ChangeMoney(0);" />����</i> 
					 <input class="ipt-value" name="OtherMoney" id="OtherMoney" type="text" value="0.01" onKeyUp="javascript:ChangeMoney(0);" onBlur="javascript:ChangeMoney(0);" onfocus="javascript:ChangeMoney(0);" onkeypress="return event.keyCode>=48&&event.keyCode<=57||event.keyCode==46" onpaste="return !clipboardData.getData('text').match(/\D/)" ondragenter="return false" style="ime-mode:Disabled" />
					 </span>
                  </li>
                  <li class="clearfix">
                     <label class="label-left">ȷ�Ͻ�</label>
                     <span class="txt-price" id="price"></span>
                  </li>
                  <li class="clearfix" id="li_memo" name="li_memo" style="display:;">
                     <label class="label-left">�� ע��</label>
                     <input name="memo" id="memo" class="ipt-name" type="text" value="" readonly="true"/>
                  </li>
                  <li class="clearfix">
                     <input class="recharge-btn" type="submit" value="֧������ֵ" onclick="javascript:ChangeStep(2);" />
                  </li>
               </ul>
				<script language="javascript">
				document.getElementById("optEmail").value=MyAccount;//�����̻�֧�����˺�
				document.getElementById("title").value=UserName;//�����û���
				document.getElementById("memo").value=remark;//���ر�ע
				if(TheMoney==''){
					ChangeMoney(100);			//Ĭ��ѡ���ֵ���
				}else{
					document.getElementById('SelectAmount').style.display='none';
					ChangeMoney(TheMoney);		//�̶����
				}
				if(remark==''){
					//���ر�ע
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
                     <a href="javascript:ChangeStep(1);"><< ��������֧��</a>
					 <br /><br />
					 <input class="recharge-btn-2" type="button" value="�Ѹ��� ��ȡ��Ʒ" onclick="javascript:Submit_G();" /> ������ɹ���������ȡ��Ʒ��
                  </li>
               </ul>
            </form>
        </div>
		 
		 <!-- �Ҳ����� -->
         <div class="right-tips">
		 	<p>��Ҫ��ʾ��</p>
			<p>֧��������ʱ���벻Ҫ�޸�֧�����ġ�����˵�����͡���ע�����������Զ����ˡ�</p>
			<p><input class="recharge-btn-2" type="button" value="�鿴������" onclick="javascript:window.location='#xd';" /></p>
		 </div>
      </div>
      
      <!-- �ײ����� -->
      <div class="recharge-bottom">
         <ul class="clearfix">
            <li><a href="/">������ҳ</a></li>
			<!--�˴��������޸�Ϊ���Լ����ƹ����ӣ��ɻ�ö��������-->
            <li><a href="http://www.YiiPay.com" target="_blank">��֧��(֧������ʱ����)�ӿ�</a></li>
         </ul>
      </div>
   </div>
</div>
<div class="xiangdao">
	<br />
	<h1 id="xd">�� ������ ��</h1>
	<hr>
	<p><a href="#">�� ����</a></p>
	<p><img border="0" src="img/XiangDao_1.gif"></p>
	<p><img border="0" src="img/jt.jpg"> <a href="#">�� ����</a></p>
	<p><img border="0" src="img/XiangDao_2.gif"></p>
	<p><img border="0" src="img/jt.jpg"> <a href="#">�� ����</a></p>
	<p><img border="0" src="img/XiangDao_3.gif"></p>
	<p><img border="0" src="img/jt.jpg"> <a href="#">�� ����</a></p>
	<p><img border="0" src="img/XiangDao_4.gif"></p>
	<?php
	if ($IsNotify == 1){
	?>
		<p><img border="0" src="img/jt.jpg"> <a href="#">�� ����</a></p>
		<p><img border="0" src="img/XiangDao_5.gif"></p>
	<?php
	}
	?>
	<h1>��ɣ�����ɹ���ȫ�Զ����ˡ�</h1>
	<p> <a href="#">�� ����</a></p>
</div>
</body>
</html>