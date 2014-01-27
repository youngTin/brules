{include file="service/serv_left.tpl"}
<link href="/ui/js/jQselect/css/index.css" type="text/css" rel="stylesheet" >
<script type="text/javascript" src="/ui/js/jQselect/jQselect.js" ></script>

        <div class="guarRight">
            <div class="srHead">
                <h3>{$info.title}</h3>
            </div>
            <div class="sr-box">
                <div class="srb-img">
                    <img src="/ui/img/{$info.img}" alt="">
                </div>
                <div class="srb-set">
                    <div class="srbs-row" types='no'>
                        <span class="srbs-title">价&nbsp;&nbsp;&nbsp;&nbsp;格:</span><span class="srbs-bprice" id="prices">{$info.basicfee}</span>元
                    </div>
                    
{foreach from=$list item=item key=k}
                    <div class="srbs-row" types='{$item.type}'>
                        <span class="srbs-title">{$item.labels}:</span>
                        <span>
                            <ul class="srbs-list" {if $item.one!='1'}onlyOne="true"{/if}>
                            {foreach from=$item.list item=items }
                                <li {if $items.default=='1'}class="cur"{/if} data="{$items.fee}" title="{$items.fee}">{$items.name}</li>
                            {/foreach}
                            </ul>
                        </span>
                        <div class="clear"></div>
                    </div>
{/foreach}
                     
                     <div class="srbs-row" types='no'>
                        <span class="srbs-title"></span>
                        <span>
                            <a id="servSub" class="servBtn">马上办理</a>
                        </span>
                        <div class="clear"></div>
                    </div>
                    
                </div>
            </div>

             <div class="sr-box">
                <div class="box_bg">
                    <span>服务介绍</span>
                </div>
                <div class="sr-note">
                    {$info.note}
                </div>
             </div>

            <div class="clear"></div>
        </div>
{include file="service/serv_footer.tpl"}