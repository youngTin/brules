<?php /* Smarty version 2.6.22, created on 2013-07-16 09:37:11
         compiled from admin/login.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo @WEB_TITLE; ?>
-后台管理系统</title>
</head>
<link href="<?php echo @URL; ?>
/admin/css/admin.css" rel="stylesheet" type="text/css" />
<?php echo '
<style>
body{background-color:#f3f2ef; margin:0 auto; padding:0; text-align:center; font-size:12px}
</style>
'; ?>

<body>
<div style="width:350px; margin:0 auto; margin-top:30px; text-align:left">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="13" height="13"><img src="/admin/images/l1_c.gif" width="13" height="13"></td>
    <td background="/admin/images/top_line.gif"></td>
    <td width="13" height="13"><img src="/admin/images/r1_c.gif" width="13" height="13"></td>
  </tr>
  <tr>
    <td background="/admin/images/l_line.gif"></td>
    <td style="padding:10px; background-color:#FFFFFF">
	<form action="admin.php?action=login" method="post" target="_self" id="form1">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr><td colspan="2">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width=2><img src="/admin/images/line_lft.png"></td>
        <td background="/admin/images/loginline.png" style="color:white; font-weight:bold;height:30px; padding-left:10px;"> <?php echo @WEB_TITLE; ?>
-后台管理系统 </td>
        <td><img src="/admin/images/line_rt.png"></td>
        </tr>
      </table>
      </td></tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr class="tr">
        <td width="30%" style="padding-left:20px;">用户名:</td>
        <td width="70%">
          <input name="user_name" type="text" class="input" /></td>
      </tr>
      
      <tr class="tr">
        <td style="padding-left:20px">密　码:</td>
        <td>
          <input name="password" type="password" class="input" /></td>
      </tr>
	  <?php echo '
	  <script>
	  	function post_url(value){
			var obj=document.getElementById(\'form1\');
			if(value===\'1\'){
				obj.action="admin.php?action=login";
			}else{
				obj.action="admin/client/user.php?action=login";
			}
		}
	  </script>
	  '; ?>

      <tr class="tr">
        <td style="padding-left:15px">验证码:</td>
        <td><img src="/includes/validate_code/vdimgck.php" name="ck" align="absmiddle" id='ck'>
          <input name="ck" type="text" class="input" size="4" /></td>
      </tr>
      <tr class="tr">
        <td colspan="2" align="center"><a href="javascript:void(0);" onClick="return showck();" style="font-size:12px">看不清，换一张图片</a></td>
      </tr>
      <tr class="tr">
        <td colspan="2" align="center">
        <input type="submit" name="Submit" value="确 定" class="btn" /> 
        <input type="button" name="Submit2" value="重 置" class="btn" onClick="window.history.go(-1);" /></td>
        </tr>
    </table>
	</form>
	</td>
    <td background="/admin/images/r_line.gif"></td>
  </tr>
  <tr>
    <td width="13" height="13" background="/admin/images/l2_c.gif"></td>
    <td height="13" background="/admin/images/bot_line.gif"></td>
    <td background="/admin/images/r2_c.gif"></td>
  </tr>
</table>
</div>
</body>
<?php echo '
<script language="javascript">
function showck(){
	var ck=document.getElementById(\'ck\');
	ck.src=\'http://www.fun.com/includes/validate_code/vdimgck.php?id=\'+Math.random();
	return false;
}
</script>
'; ?>

</html>