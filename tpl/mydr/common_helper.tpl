{include file="mydr/rheader.tpl"}
<style type="text/css">
{literal}
.ccenter{width:980px;margin:0 auto;padding:20px 0;}
.ccenter .hh3{border-bottom:3px solid #C41414;font-size:24px;margin:0 0 10px 0;}
.rleft,.rright{float:left;}
.rleft{width:190px;}
.rleft .rmenu ul {border-top:1px solid #D9D8D8;border-left:1px solid #D9D8D8;border-right:1px solid #D9D8D8;overflow:hidden;}
.rleft .rmenu ul li{height:50px;line-height:50px;font-size:16px;color:#565656;border-bottom:1px solid #D9D8D8;overflow:hidden;}
.rleft .rmenu ul li.cur{background:url('/ui/img/right_arrows2.jpg') 150px center no-repeat #EBEBEB;}
.rleft .rmenu ul li a{margin-right:50px;float:right;color:#565656;text-decoration:none;}
.rleft .rmenu ul li.cur a{color:#C41414;}
/*.rleft .rmenu ul li.cur a span{font-size:140px;width:12px;width:50px;height:50px;float:right;display:inline-block;}*/

.rright{width:750px;margin-left:10px;border:1px solid #D9D8D8;padding:10px;}
{/literal}
</style>
<div class="ccenter">
    <h3 class="hh3">帮助中心</h3>
    <div class="rleft">
        
        <div class="rmenu">
            <ul>
            {foreach from=$ginfo item=item name=foo}
                <li {if ($smarty.get.id==null&&$smarty.foreach.foo.index==0)||$smarty.get.id==$item.id}class="cur"{/if}><a href="helper.html?id={$item.id}">{$item.title}</a></li>
            {/foreach}
            </ul>
        </div>
    </div>
    <div class="rright">
            <div class="pwrap">
                <div class="phead">
                    <h3 class="ptitle">{if $smarty.get.mod=='1'}顶部通知{else}用户指南{/if}</h3>
                </div>
                <div class="pbody">
                    <div class="pbox">
                        <div class="clearfix box-userinfo">
                            <div class="clearfix">
                                {$info.content}
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>   
     </div>  
     <div class="clear"></div>     
 </div>
    </div>
{include file="mydr/footer.tpl"}