{include file="mydr/header.tpl"}
<script type="text/javascript" src="/ui/js/datepicker/WdatePicker.js" ></script>
<script type="text/javascript" src="/ui/js/common.formcheck.js" ></script>
<script type="text/javascript" src="/ui/js/Tin.js.min.js" ></script>
<div class="center-box">
<div class="note-header">
    当前位置：<a>我的任务</a>
</div>
<div class="c-content">
    <div class="myinfo">
        {if $smarty.get.op=='wait'}
            {include file="mydr/mytask_wait.tpl"}
        {elseif $smarty.get.op=='done'}
            {include file="mydr/mytask_done.tpl"}
        {elseif $smarty.get.op=='fail'}
            {include file="mydr/mytask_fail.tpl"}
        {else}
            {include file="mydr/mytask_doing.tpl"}
        {/if}
    </div>
    <div class="clear"></div>
</div>
</div>

{include file="mydr/footer.tpl"}