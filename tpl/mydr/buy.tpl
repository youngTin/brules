{include file="brules/header.tpl"}
{include file="brules/menu.tpl"}
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
             <div class="pay_div">
                <form action="?action=getorder" id="getorder" method="post">
                    <h3>金额购买</h3>
                    <p>金额：&nbsp;<input type="text" name="scores" class="input" id="scores" maxlength="5" value="5" >&nbsp;&nbsp;(&nbsp;所需要购买的金币，必须为正整数&nbsp;)</p>
                    <p>所需金额：<span class="pay_money" id="pay_money">{$oinfo.money|default:5}</span>&nbsp;元</p>
                    <input type="hidden" name="ratio" id="ratio" value="{$ratio}" />
                    <p class="go_p_bnt"><input type="button" value="订单确认" class="go_bnt_order subbutton1" id="load_show"><span class="go_load"><img src="ui/img/loading.gif" alt="">&nbsp;订单生产中...</span><span class="pay_money"id="showMsg" >*&nbsp;金币不能为空且为不小于10的正整数</span></p>
                </form>
             </div>
        </div>
    </div>
    <div class="invite_znum">账单记录</div>
      <div class="search-list">
        <form action="member_deal.php" method="post">
            <table width="100%">
                <tr>
                    <th>订单号</th>
                    <th>购买积分</th>
                    <th>实付金额</th>
                    <th>下单时间</th>
                    <th>付款状态</th>
                    <th>操作</th>
                </tr>
                {foreach from=$list item=item}
                <tr>
                    <td>{$item.order_sn}</td>
                    <td>{$item.scores}</td>
                    <td>{$item.money}</td>
                    <td>{$item.addtime|date_format:'%Y-%m-%d %H:%M:%S'}</td>
                    <td>{if $item.status=='1'}<font class="remark">已完成</font>{else}未付款{/if}</td>
                    <td>
                    {if $item.status=='0'}
                        <a href="?action=gopay&sp={fp order_sn=$item.order_sn}" class="gobuy">付款</a>
                        <a href="?action=del&sp={fp order_sn=$item.order_sn}" onclick="return confirm('确定删除该订单吗？');">删除</a>
                    {/if}  
                    </td>
                </tr>
                {/foreach}
            </table>
            <div class="pageer">
                <ul><li>当前显示<span class="red">{$pagesize}</span>条记录，总共<span class="red">{$num}</span>条记录</li>{$splitPageStr}</ul>
                <div class="clear"></div>
            </div>
        </form>
        </div>
    <div class="clear"></div>
</div>
</div>
<script type="text/javascript">
{literal}
$(function(){
        var $ratio = $("#ratio").val();
        var $scores = $("#scores");
        var P_s = /^\d{0,5}$/
        $scores.bind('blur',function(){
                if(P_s.test($scores.val())&& $scores.val() >= 5)
                {
                    var money  = (parseFloat($scores.val())*100 / parseInt($ratio)) / 100 ;
                    $("#pay_money").html(toDecimal(money));
                }
                else if($scores.val()<5)
                {
                    $scores.val(5);
                }
                else
                {
                    $("#pay_money").html('');
                }
            
        }).bind('keyup',function(){
            setTimeout(function(){
                if(P_s.test($scores.val())&& $scores.val() >= 5)
                {
                    var money  = (parseFloat($scores.val())*100 / parseInt($ratio)) / 100 ;
                    $("#pay_money").html(toDecimal(money));
                }
                else if($scores.val()<5)
                {
                    $scores.val(5);
                }
                else
                {
                    $("#pay_money").html('');
                }
            
            },500)
            
        })
        
        $("#load_show").bind('click',function(){
            if(P_s.test($scores.val()) && $scores.val() >=5)
            {         
                $.ajax({
                    type: "POST",
                    url: "?action=getorder",
                    data: {'scores':$scores.val()},
                    beforeSend: function(){
                        $("#load_show").show()
                    },
                    success: function(msg){
                        if(!msg)
                        {
                            $("#showMsg").fadeIn('fast');
                            setTimeout(function(){$("#showMsg").fadeOut('slow');},3000) 
                        }
                        else
                        {  
                            window.location.href = '?action=gopay&sp='+msg;
                        }
                        return false;
                        
                    },
                    complete: function(){
                        $("#load_show").hide();
                    }
                })
                return false ;
            }
            else
            { 
                $("#showMsg").fadeIn('fast');
                setTimeout(function(){$("#showMsg").fadeOut('slow');},3000) 
            }
            return false;
        });
    })
    
    function toDecimal(x) {  
            var f = parseFloat(x);  
            if (isNaN(f)) {  
                return false;  
            }  
            var f = Math.round(x*100)/100;  
            var s = f.toString();  
            var rs = s.indexOf('.');  
            if (rs < 0) {  
                rs = s.length;  
                s += '.';  
            }  
            while (s.length <= rs + 2) {  
                s += '0';  
            }  
            return s;  
        }   
{/literal}
</script>
{include file="brules/footer.tpl"}