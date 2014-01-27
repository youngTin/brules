{literal}
<style type="text/css">
.dcontent{margin: 10px;}
.dcontent p{margin: 20px auto;}
.dcontent p span.red{color:#FF0000;}
.operation{text-align: center;margin-top: 5px;}
.operation a{margin: 0 20px;border:solid 1px #FF7533;padding:5px 10px;background: #FFFFC0;cursor: pointer;}
</style>
{/literal}
<div class="dcontent">
<p>注：{if $mod=='doConfirm'}确认{else}预订{/if}驾照交易信息联系方式需要扣除您<span class="red">{$smarty.const.WATCH_JZ_SCORES}</span>元，如需{if $mod=='doConfirm'}确认{else}预订{/if}请点击“确定”，否则“取消”。</p>
<p class="operation"><a id="buyScoreButton" onclick="markG('{if $mod=='doConfirm'}dobooking&isconfirm=yes{else}buy{/if}','{$sp}','itemT');" class="thickbox">确定</a><a onclick="$.dialog.get('itemText').close();">取消</a></p>
</div>
