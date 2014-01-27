<?php /* Smarty version 2.6.22, created on 2013-04-08 21:36:42
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'fp', 'footer.tpl', 20, false),)), $this); ?>
<?php 
//友情链接
    $linkInfo = getPdo()->find('web_contentindex'," cid='237' and mid='4' and ifpub='1' ",'mid,cid,title,photo,linkurl','comnum desc');
    if($linkInfo[0])
    {
        foreach($linkInfo as $item)
        {
            $aUrl .= "<a href='{$item['linkurl']}' target='_blank'>{$item['title']}</a>"; 
        }
    }
    else
    {
         $aUrl .= "<a href='{$linkInfo['linkurl']}' target='_blank'>{$linkInfo['title']}</a>"; 
    }
 ?>
﻿<div id="footer_container">
    <p class="link">
    友情链接：<?php echo $aUrl; ?>
    </p>
    <p><a href="/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 442), $this);?>
">关于Home+</a> - <a href="/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 444), $this);?>
">帮助中心</a> - <a href="/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 461), $this);?>
">免责申明</a> - <a href="/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 462), $this);?>
">媒体报道</a></p> 
	<p>服务时间：周一至周日09:00-17：30  客服热线：400-076-1110 13208187538</p>
	<p>地址：成都市武侯区科华北路3号（磨子桥下）</p>
	<p>Copyrights @ 2012 51homej.com All Rights Reserved 和睦家 版权所有 蜀ICP备12009016号-1</p>
    <script src="http://s15.cnzz.com/stat.php?id=4144054&web_id=4144054&show=pic" language="JavaScript"></script>
</div>