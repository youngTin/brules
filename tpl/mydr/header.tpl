<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>驾分网---驾照888--www.jiazhao888.com</title>
<meta name="keywords" content="驾分网,驾照卖分,收购,买驾照,驾照888,jiazhao888,驾照分查询,违章查询,代办" />
<meta name="description" content="驾照888，最新最全的驾照信息交流平台" />
<link href="/ui/css/common.css" rel="stylesheet" type="text/css" >
<script type="text/javascript" src="/ui/js/jquery-1.5.1.min.js" ></script>
<script type="text/javascript" src="/ui/js/jquery.marquee.min.js" ></script>
<script type="text/javascript" src="/ui/js/common.js" ></script>
<link type="text/css" href="/ui/css/jquery.marquee.min.css" rel="stylesheet" title="default" media="all" />
</head>
<body>

<div class="topbar">
    <div class="cleafix inner">
        <div class="notification">
            <ul id="j-rollingnews" class="marquee">
	    {php}
		$info = getHeaderNote();
		foreach($info as $item):
			echo "<li><a href='help.html?id={$item['id']}&mod=1' target='_blank' >{$item['title']}</a></li>";
		endforeach;
	    {/php}
	    </ul>
        </div>
        <ul class="accountlink">
            <li class="item-user">
                <div class="multimenu">
                    <p class="j-multimenu"><a href="">{$smarty.const.USERNAME}</a></p>
                </div>
            </li>
            <li class="item-notice"><a href="">通知                                   </a></li>
            
            <li class="item-logout"><a href="index.html?action=exit">退出</a></li>
        </ul>
    </div>
</div>
<div class="header">
    <div class="cleafix inner">
        <h1 class="logo"><a href="http://www.jiazhao888.com/" rel="home" title=""></a></h1>
        <ul class="nav">
            <li><a class="current" href="index.html"><span>用户中心</span></a></li>
            <li><a href="peccancy.shtml?action=index"><span>车辆监控中心</span></a></li>
            <li><a href=""><span>代理信息交流</span></a></li>
        </ul>
    </div>
</div>
<div class="clearfix main">
    <div class="aside">
    <ul class="asidenav">
                            <li class="first-child"><a class="current" href=""><em class="ic-1">.</em>任务管理</a></li>
                                   <!--<li><a href="index.html?action=search"><em class="ic-15">.</em>搜索首页</a></li -->
                                   <li><a href="peccancy.shtml?action=index"><em class="ic-15">.</em>驾车违章提醒</a></li 
				    <li><a href="pub.html"><em class="ic-14">.</em>出售驾照分</a></li
                                    <li><a href="pub.html?type=1"><em class="ic-8">.</em>收购驾照分</a></li
                                    <li><a href="mytask.html"><em class="ic-18">.</em>我的任务</a></li
                                    <li><a class="current" href=""><em class="ic-27">.</em> 账户管理</a></li
                                    <li><a href="myinfo.html"><em class="ic-21">.</em>我的信息</a></li                                   
                                    <li><a href="buy.html"><em class="ic-19">.</em>充值提现</a></li
                                    <li><a href="mygold.html"><em class="ic-20">.</em>账务流水</a></li
                                   <li><a href="invite.html"><em class="ic-23">.</em>邀请赚钱</a></li
                                     <li><a class="current" href=""><em class="ic-16">.</em> 客服中心</a>
                                     <li class="last-child"><a href="/helper.html"><em class="ic-25">.</em>帮助中心</a></li>
                                    </ul>
</div>    
<div class="content">

        
