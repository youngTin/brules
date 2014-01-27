<?php /* Smarty version 2.6.22, created on 2013-04-08 21:36:42
         compiled from load_nav.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'fp', 'load_nav.html', 18, false),)), $this); ?>
<?php echo '
<style>
#menu ul.nav li ul.subnav {list-style: none; position: absolute; left: 0; top: 30px; z-index:9999; background: #000; margin: 0; padding:5px; display:none; float: left; border:1px solid #666;}
#menu ul.nav li ul.subnav li {border-left:1px solid #FF6604;clear:both;width:80px;margin-right:0px; margin-left:2px;line-height:24px;}
#menu ul.nav li ul.subnav li a {display:block; width:76px; font-size:12px;font-weight:normal;}
#menu ul.nav li ul.subnav li a:hover {background:#707070;text-decoration:none;}
</style>
'; ?>

<div id="header">
	<div id="logo"></div>
	<div id="menu">
		<div style="position: absolute;">
			<ul class="nav" id="web_nav">
			  <li <?php if ($this->_tpl_vars['titleNav'] == 'index'): ?>class="last"<?php endif; ?>><a href="/index.php">首页</a></li>
			  <li <?php if ($this->_tpl_vars['titleNav'] == 'house_sold'): ?>class="last"<?php endif; ?>><a href="/house_list.php?house_type=2">二手房</a></li>
			  <li <?php if ($this->_tpl_vars['titleNav'] == 'house_rent'): ?>class="last"<?php endif; ?>><a href="/house_list.php?house_type=1">租房</a></li>
			  <li <?php if ($this->_tpl_vars['titleNav'] == 'publish_house'): ?>class="last"<?php endif; ?>><a href="/publish_house.php?action=option">房源发布</a></li>
			  <li <?php if ($this->_tpl_vars['titleNav'] == 'helper'): ?>class="last"<?php endif; ?>><a href="/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 444), $this);?>
">代办过户</a></li>
			  <li <?php if ($this->_tpl_vars['titleNav'] == 'member'): ?>class="last"<?php endif; ?>><a href="/member_index.php" id="myHome">我的home+</a>
                <?php if ($_SESSION['home_userid'] < 0): ?>
				<!--<ul class="subnav" id="subnav" >
					<li><a href="/member_pub.php?action=esf_add&house_type=2">发布出售</a></li>
                    <li><a href="/member_pub.php?action=esf_list&house_type=2">出售管理</a></li>
                    <li><a href="/member_pub.php?action=favorites">收藏管理</a></li>
                    <li><a href="/member_pub.php?action=esf_add&house_type=1">发布出租</a></li>
                    <li><a href="/member_pub.php?action=esf_list&house_type=1">出租管理</a></li>
                    <li><a href="/member_info.php?action=edit_info&do=pwd">修改密码</a></li>
				</ul>-->
                <?php endif; ?>                
			  </li>

			</ul>
		</div>
	</div>
	<div style="position:absolute; top:8px;right:5px; font-size:14px;font-weight:bold;color:#F49A22"><a target="_blank" href="http://wpa.qq.com/msgrd?V=1&Uin=1628745952&Site=和睦家&Menu=yes"><img border="0" SRC=http://wpa.qq.com/pa?p=1:1628745952:6 alt="您有什么问题，我们将及时给您解答" align="absmiddle"></a></div>
    <div style="position:absolute; top:35px;right:5px; font-size:14px;font-weight:bold;color:#F49A22">咨询热线：400-076-1110 13208187538</div>
</div>
<br class="clear">

<script>
/**/

<?php echo '
$(document).ready(function(){
	$("ul#subnav").parent().mouseover(function() { 
		$(this).parent().find("ul#subnav").slideDown(\'normal\');
		$(this).hover(function(){}, function(){	
			$(this).parent().find("ul#subnav").slideUp(\'normal\');
		});
	});
});
'; ?>


</script>