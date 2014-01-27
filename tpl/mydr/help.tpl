{include file="mydr/header.tpl"}

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
        
    </div>
{include file="mydr/footer.tpl"}