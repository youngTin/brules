﻿<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{$smarty.const.WEB_TITLE}-后台管理系统</title>
<script language="javascript" type="text/javascript">
    if(self != top) top.location = self.location;
</script>
</head>
<frameset rows="80,5,*" cols="*" frameborder="no" border="0" framespacing="0">
  <frame src="{$smarty.const.URL}/admin/header.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
  <frame src="{$smarty.const.URL}/tpl/admin/mid.htm" name="mdiFrame" scrolling="no" noresize="noresize" id="mdiFrame" title="mdiFrame" frameborder="no" />
  <frameset cols="190,*" name="workframeset" id="workframeset" rows="*" frameborder="no" border="0" framespacing="0">
    <frame src="{$smarty.const.URL}/admin/lefttree.php" name="leftFrame" scrolling="yes" noresize="noresize" id="leftFrame" title="leftFrame" />
	<!--<frame src="{$smarty.const.URL}/tpl/admin/line.htm" name="lineFrame" scrolling="no" noresize="noresize" id="lineFrame" title="lineFrame" frameborder="no" />-->
 <frame src="{$smarty.const.URL}/tpl/admin/note/dotpl.php{$str}" name="mainFrame" 

scrolling="yes"  noresize="noresize" id="mainFrame" title="mainFrame" 

style="background:#fff" />
  </frameset>
</frameset>
<noframes>
<body>
<div>对不起您的浏览器不支持框架!</div>
</body>
</noframes>

