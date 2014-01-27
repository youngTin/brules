<?php /* Smarty version 2.6.22, created on 2013-03-10 18:45:13
         compiled from mydr/erro.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo ' 
<style>
#right_container{border: solid 1px #FF7A00;padding:10px;width: 600px;margin:50px;}
.tab_on{color: #FF5500;font-size: 14px;padding:10px;}
.notice{padding:50px 100px;line-height: 136px;font-size: 16px;color:#666666;;}
.notice .nleft{float: left;}
.notice .nright{margin-left: 30px;float: left;line-height: 30px;padding-top: 10px;}
.notice .nright .nrurl{text-indent:1.5em;}
a{font-size:12px;text-decoration: underline;cursor: pointer;}
</style>
<script type="text/javascript">
'; ?>
 
var gourl = '<?php echo $this->_tpl_vars['gourl']; ?>
';
var litime = parseInt(<?php echo $this->_tpl_vars['litime']; ?>
)*1000;
<?php echo ' 
function JumpUrl(){//alert( $("#forms").attr("action"));
     //document.getElementById(\'forms\').action=gourl;
     document.getElementById(\'forms\').submit();
}
setTimeout(\'JumpUrl()\',litime);
</script>
'; ?>

<div id="right_container">
                <div class="right_header"><div class="tab_on">驾照交易网提示您：</div></div>
                <div class="right_mid">
                    <div class="right_content">
                        <div class="notice">
                            <div class="nleft">
                            <img width="136px" src='/ui/images/<?php if ($this->_tpl_vars['isok']): ?>ok<?php else: ?>no<?php endif; ?>.gif' align='absmiddle' hspace=20 >
                            </div>
                            <div class="nright">
                                <p class="f_brown"><?php echo $this->_tpl_vars['msg']; ?>
</p>
                                <p class="nrurl"><a onclick='JumpUrl();'>返回继续操作</a></p>
                            </div>
                            <form name="forms" id="forms" method="post" action="<?php echo $this->_tpl_vars['gourl']; ?>
">
                            <?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                                <input type="hidden" name="<?php echo $this->_tpl_vars['key']; ?>
" value="<?php echo $this->_tpl_vars['item']; ?>
">
                            <?php endforeach; endif; unset($_from); ?>
                            </form>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="right_bot"></div>
            </div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>