<?php /* Smarty version 2.6.22, created on 2013-04-14 13:27:15
         compiled from mydr/ajax_suggest.tpl */ ?>
<?php echo '
<style type="text/css">
.dcontent{margin: 10px;}
.dcontent p{margin: 20px auto;}
.dcontent p span.red{color:#FF0000;}
.operation{text-align: center;margin-top: 5px;}
.operation a{margin: 0 20px;border:solid 1px #FF7533;padding:5px 10px;background: #FFFFC0;cursor: pointer;}
</style>
'; ?>

<div class="dcontent">
<p>注：<?php if ($this->_tpl_vars['mod'] == 'doConfirm'): ?>确认<?php else: ?>预订<?php endif; ?>驾照交易信息联系方式需要扣除您<span class="red"><?php echo @WATCH_JZ_SCORES; ?>
</span>元，如需<?php if ($this->_tpl_vars['mod'] == 'doConfirm'): ?>确认<?php else: ?>预订<?php endif; ?>请点击“确定”，否则“取消”。</p>
<p class="operation"><a id="buyScoreButton" onclick="markG('<?php if ($this->_tpl_vars['mod'] == 'doConfirm'): ?>dobooking&isconfirm=yes<?php else: ?>buy<?php endif; ?>','<?php echo $this->_tpl_vars['sp']; ?>
','itemT');" class="thickbox">确定</a><a onclick="$.dialog.get('itemText').close();">取消</a></p>
</div>