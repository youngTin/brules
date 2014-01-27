{include file="service/serv_left.tpl"}

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
                    
                    <div class="srbs-row" types='{$list[0].type}'>
                        <span class="srbs-title">出厂年月:</span>
                        <span >
                        <select name="year" id="year" class="select" data="50" dataFrom="30">
                            {html_options options=$year selected=2011}
                        </select>
                         <select name="month" id="month" class="select">
                            {html_options options=$month selected=5}
                        </select>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="srbs-row" types='{$list[1].type}'>
                        <span class="srbs-title">{$list[1].labels}:</span>
                        <span>
                            <ul class="srbs-list" onlyOne="true">
                            {foreach from=$list[1].list item=item }
                                <li {if $item.default=='1'}class="cur"{/if} data="{$item.fee}" title="{$item.fee}">{$item.name}</li>
                            {/foreach}
                            </ul>
                        </span>
                        <div class="clear"></div>
                    </div> <div class="srbs-row" types='{$list[2].type}'>
                        <span class="srbs-title">{$list[2].labels}:</span>
                        <span>
                            <ul class="srbs-list">
                            {foreach from=$list[2].list item=item }
                                <li data="{$item.fee}" title="{$item.fee}">{$item.name}</li>
                            {/foreach}
                            </ul>
                        </span>
                        <div class="clear"></div>
                    </div>
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