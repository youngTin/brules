<?php /* Smarty version 2.6.22, created on 2013-07-20 17:29:36
         compiled from brules/ajax_bansuccess.tpl */ ?>
<?php echo '
<style type="text/css">
.dcontent{margin: 10px;}
.dcontent p{margin: 20px auto;}
.dcontent p span.red{color:#FF0000;}
.operation{text-align: center;margin-top: 5px;}
.operation a{margin: 0 20px;border:solid 1px #FF7533;padding:5px 10px;background: #FFFFC0;cursor: pointer;}
.dcontent table td{line-height: 30px;padding: 5px;}
</style>
<script type="text/javascript">
'; ?>
 
var gourl = 'peccancy.shtml';
var litime = parseInt(3)*1000;
<?php echo ' 
function JumpUrl(){
     window.location.href=gourl;
}
setTimeout(\'JumpUrl()\',litime);
</script>
'; ?>

<div class="dcontent">
<p>恭喜：您已成功办理违章处理。我们将尽快安排人员为您服务！</p>
<div class="br-total">
                        <div class="brt-01 brt-awd">
                            <span>处理违章<em><?php echo $this->_tpl_vars['info']['tnum']; ?>
</em>宗，违章扣分<em><?php echo $this->_tpl_vars['info']['marking']; ?>
</em>分， 罚金<em><?php echo $this->_tpl_vars['info']['fine']; ?>
</em>元， 服务费<em><?php echo $this->_tpl_vars['info']['sefine']; ?>
</em>元。</span>
                            <span class="brt-total">合计：<em id='t-total'><?php echo $this->_tpl_vars['info']['totalfine']; ?>
</em>元</span>
                        </div>
                        <div class="clear"></div>
                    </div>
<p class="operation"></p>
</div>