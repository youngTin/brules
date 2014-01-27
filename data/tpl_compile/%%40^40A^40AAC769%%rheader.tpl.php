<?php /* Smarty version 2.6.22, created on 2013-05-26 15:09:06
         compiled from brules/rheader.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>驾照888</title>
<link href="/ui/css/reg.css" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="/ui/js/jquery-1.5.1.min.js" ></script>
<script type="text/javascript" src="/ui/js/common.js" ></script>
</head>
<body>

<div class="headerwrapper">
<div class="header">
    <h1 class="logo">
        <a href="/" rel="home" title="驾分网www.jiazhao888.com">驾分网</a>
    </h1>
    <ul class="nav">
        <li><a href="/" <?php if (! $this->_tpl_vars['titlenow']): ?>class="current"<?php endif; ?> >网站首页</a></li>
        <li><a href="/index.html" >个人中心</a></li>
        <li><a href="/" >特色服务</a></li>
        <li><a href="/" >业务代理</a></li>
        <li><a href="/helper.html" <?php if ($this->_tpl_vars['titlenow'] == 'helper'): ?>class="current"<?php endif; ?> >帮助中心</a></li>
    </ul>
    <div class="account">
        <a class="link" href="/reg_new.html">注册</a>
        <a class="link" id="loginPopupToggle" href="/login.html">登录</a>
    </div>
</div>
</div>

<div class="clearfix main register">
        