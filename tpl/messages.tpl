{include file="header.html"}
{literal} 
<style>
.notice{padding:50px 100px;line-height: 136px;font-size: 16px;color:#666666;;}
.notice .nleft{float: left;}
.notice .nright{margin-left: 30px;float: left;line-height: 30px;padding-top: 10px;}
.notice .nright .nrurl{text-indent:1.5em;}
a{font-size:12px;}
</style>
<script type="text/javascript">
{/literal} 
var gourl = '{$gourl}';
var litime = parseInt({$litime})*1000;
{literal} 
function JumpUrl(){//alert( $("#forms").attr("action"));
     //document.getElementById('forms').action=gourl;
     document.getElementById('forms').submit();
}
setTimeout('JumpUrl()',litime);
</script>
{/literal}
<div id="wrapper">
    <div id="main_container">
        {include_php file="load_nav.php"}
        <div id="second_container">
            {include file="left_search.tpl"}
            <div id="right_container">
                <div class="right_header"><div class="tab_on">HOME+提示您:</div></div>
                <div class="right_mid">
                    <div class="right_content">
                        <div class="notice">
                            <div class="nleft">
                            <img width="136px" src='/ui/images/{if $isok}ok{else}no{/if}.gif' align='absmiddle' hspace=20 >
                            </div>
                            <div class="nright">
                                <p class="f_brown">{$msg}</p>
                                <p class="nrurl"><a onclick='JumpUrl();'>返回继续操作</a></p>
                            </div>
                            <form name="forms" id="forms" method="post" action="{$gourl}">
                            {foreach from=$data item=item key=key}
                                <input type="hidden" name="{$key}" value="{$item}">
                            {/foreach}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="right_bot"></div>
            </div>
        </div>
        {include file="footer.tpl"}
    </div>
</div>