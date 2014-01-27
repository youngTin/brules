{include file="mydr/header.tpl"}
<style type="text/css">
{literal} 
.pay_div{margin :10px 0px;padding:5px 10px;}
.pay_div h3{color:#E47911;font-size: 14px;font-weight: 600;height:30px;line-height: 30px;border-bottom: dashed 1px #FF8080;}
.pay_div p{margin:10px 0;}
.pay_money{color:#FF8080;font-size: 14px;font-weight: 600;}
.pay_div ul{margin: 10px auto;}
.pay_li{height:40px;line-height: 40px;word-spacing: 2em;padding:5px;}
.pay_p_bnt{display: inline-block;height: 60px;line-height: 60px;}
.go_p_bnt{display: inline-block;height: 30px;line-height: 30px;}
.pay_bnt_order{width:160px;height:53px;line-height: 53px;background: url(/ui/images/bnt_sub.gif) center center;border:none 0;padding: 0;text-indent: -999em;cursor: pointer;margin-left: 10px;float: left;}
.go_bnt_order{width:80px;height: 30px;float: left;text-align: center;}
.go_load{line-height: 16px;height: 24px;padding:5px 0 0 5px;display: inline-block;color: #FF0000;display: none;}
#showMsg{display: none;width:300px;float: left;margin-left: 20px;color: #FF0000;}
.recharge-btn-2{display:block;width:150px;height:28px;line-height:28px;border:none;cursor:pointer;padding:0;background:url(/ui/img/btn_2.png) 0 0 no-repeat;color:#fff;font-size:14px;font-weight:bold;}
#step2{display:none;}
{/literal} 
</style>
<script type="text/javascript" src="/ui/js/datepicker/WdatePicker.js" ></script>
<script type="text/javascript" src="/ui/js/common.formcheck.js" ></script>
<div class="center-box">
<div class="note-header">
    当前位置：<a>充值提现</a>
</div>
<div class="c-content">
    <div class="myinfo">
        <div class="myinfo_title">
            <ul><li class="active">充值</li></ul>
        </div>
        <div class="myinfo_content">
                 <div class="pay_div" id="step1">
                    <form action="http://www.thepayurl.com" id="con_form" method="post" target="_blank">
                        <h3>订单信息</h3>
                        <p>订单号：{$oinfo.order_sn}</p>
                        <p>购买金额：<span class="pay_money">{$oinfo.scores}</span></p>
                        <p>实付金额：<span class="pay_money">{$oinfo.money}</span>&nbsp;元</p>
                        <h3>选择您的支付方式</h3>
                        <ul>
                        {foreach from=$payway item=p key=key}
                            {if $p.flag=='1'}
                            <li class="pay_li"><input type="radio" name="payway" id="payway" value="{$key}" />&nbsp;<img src="ui/img/pay/{$key}.gif" title="{$p.name}"></li>
                            {/if}
                        {/foreach}
                        </ul>
                        <h3>&nbsp;</h3>
                        <input type="hidden" name="order_sn" value="{$oinfo.order_sn}">
                        <input name="optEmail" id="optEmail" type="hidden" value="{$account}">
                        <input name="payAmount" id="payAmount" type="hidden" value="{$oinfo.money}">
                        <input name="title" id="title" class="ipt-name" type="hidden" value="{$smarty.const.USERNAME}::{$oinfo.order_sn}" />
                        <input name="amount" id="amount" class="ipt-name" type="hidden" value="{$oinfo.money}" />
                       <!-- <input name="memo" id="memo" class="ipt-name" type="hidden" value="{$note}&_input_charset=utf-8" />-->
                        <input name="_input_charset"  type="hidden" value="utf-8" />
                        <p class="pay_p_bnt"><input type="submit" value="订单确认" class="pay_bnt_order"><span class="pay_money"id="showMsg" >*&nbsp;至少需要选择一种支付方式</span></p>
                    </form>
                    </div>
                    <div class="pay_div" id="step2">
                        <h3>订单信息</h3>
                       <p> <input class="recharge-btn-2" type="button" value="已付款 返回支付信息" onclick="window.location.href='buy.html';" /> （付款成功后，请点击查看充值信息）</p>
                    </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
</div>
<script type="text/javascript">
{literal}
$(function(){
    $("#con_form").bind('submit',function(){
        var radio = $("input[name='payway']:checked").val();
        if(radio==null){
            $("#showMsg").fadeIn('fast');
            setTimeout(function(){$("#showMsg").fadeOut('slow');},3000)
            return false;
        }
        $("#step1").hide();
        $("#step2").show();
    })
    
})
{/literal}
</script>
{include file="mydr/footer.tpl"}