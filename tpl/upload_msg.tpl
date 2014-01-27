<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" charset="UTF-8" src="{$smarty.const.URL}/ui/js/artDialog/artDialog.min.js"></script>
<title></title>
{literal}
<style type="text/css">
body { height:100%;}
.msg { margin:0 auto; border:1px solid #82C5D8; width:100%; margin-top:0px; }
.msg .msgBody { padding:5px; text-align:center; font-size:13px; color:#0099FF }
.msg .msgBody a { color:#000 }
</style>
<script>
setTimeout(function(){
    art.dialog.close();
},3000);

</script>
{/literal}
</head>
<body>
<div class="msg">
  <div class="msgBody">
	上传成功,<br /><font color=red>5秒</font>后将自关闭页面
	<p>如果没有跳转，<a href="javascript:self.parent.tb_remove();self.parent.reloadiframe();">请点击关闭页面</a></p>
	<p><a href="{$url}">我要继续上传</a></p>
  </div>
</div>
</body>
</html>