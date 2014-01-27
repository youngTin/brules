{include file="member/header.tpl"}
<script type="text/javascript" src="/ui/js/jquery_last.js"></script>
<link type="text/css" rel="stylesheet" href="/ui/css/shopcart.css">
<div class="htgl_box">
    <div class="cart_info">
    {if !uid}
        <h3>您尚未登录</h3>
        马上去&nbsp;<a href="member_login.php">登录</a>&nbsp;或&nbsp;<a href="member_reg_new.php">注册</a>
    {else}
        <h3>购买成功</h3>
        马上去&nbsp;<a href="member_order.php">我的订单</a>，或&nbsp;<a href="/">随便逛逛</a>&nbsp;看看。<br>
        
    {/if}    
    </div>
    <div class="clear"></div>
</div>
{include file="footer.tpl"}