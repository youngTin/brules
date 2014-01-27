<?php /* Smarty version 2.6.22, created on 2013-07-16 09:42:44
         compiled from mydr/common_helper.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/rheader.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style type="text/css">
<?php echo '
.ccenter{width:980px;margin:0 auto;padding:20px 0;}
.ccenter .hh3{border-bottom:3px solid #C41414;font-size:24px;margin:0 0 10px 0;}
.rleft,.rright{float:left;}
.rleft{width:190px;}
.rleft .rmenu ul {border-top:1px solid #D9D8D8;border-left:1px solid #D9D8D8;border-right:1px solid #D9D8D8;overflow:hidden;}
.rleft .rmenu ul li{height:50px;line-height:50px;font-size:16px;color:#565656;border-bottom:1px solid #D9D8D8;overflow:hidden;}
.rleft .rmenu ul li.cur{background:url(\'/ui/img/right_arrows2.jpg\') 150px center no-repeat #EBEBEB;}
.rleft .rmenu ul li a{margin-right:50px;float:right;color:#565656;text-decoration:none;}
.rleft .rmenu ul li.cur a{color:#C41414;}
/*.rleft .rmenu ul li.cur a span{font-size:140px;width:12px;width:50px;height:50px;float:right;display:inline-block;}*/

.rright{width:750px;margin-left:10px;border:1px solid #D9D8D8;padding:10px;}
'; ?>

</style>
<div class="ccenter">
    <h3 class="hh3">帮助中心</h3>
    <div class="rleft">
        
        <div class="rmenu">
            <ul>
            <?php $_from = $this->_tpl_vars['ginfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
                <li <?php if (( $_GET['id'] == null && ($this->_foreach['foo']['iteration']-1) == 0 ) || $_GET['id'] == $this->_tpl_vars['item']['id']): ?>class="cur"<?php endif; ?>><a href="helper.html?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></li>
            <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
    </div>
    <div class="rright">
            <div class="pwrap">
                <div class="phead">
                    <h3 class="ptitle"><?php if ($_GET['mod'] == '1'): ?>顶部通知<?php else: ?>用户指南<?php endif; ?></h3>
                </div>
                <div class="pbody">
                    <div class="pbox">
                        <div class="clearfix box-userinfo">
                            <div class="clearfix">
                                <?php echo $this->_tpl_vars['info']['content']; ?>

                            
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>