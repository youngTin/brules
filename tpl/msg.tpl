<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title></title>
<meta name="keywords" content="{$keywords}" />
<meta name="description" content="{$descrition}" />
<link href="ui/css/main.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div class="main">
  <div class="con">
       <div class="crumb"><a href="/" title="China Travel"> 首 页 </a> &raquo; {$msg}</div>
			<div style="padding-top:15px; font-size:18px; font-weight:bold">{$msg}</div>
			{if $isok}
			<div style="line-height:200%">
				true
			</div>
			{else}
			<div style="line-height:200%">
				<a href="{$url}">页面将在3秒后自动返回，点击直接返回</a>
			</div>
			{/if} 
  </div>
  <span class="cl" /> </div>
</body>
</html>

