<?php /* Smarty version 2.6.22, created on 2013-12-02 12:03:05
         compiled from service/allTemp.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "service/serv_left.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="/ui/js/jQselect/css/index.css" type="text/css" rel="stylesheet" >
<script type="text/javascript" src="/ui/js/jQselect/jQselect.js" ></script>

        <div class="guarRight">
            <div class="srHead">
                <h3><?php echo $this->_tpl_vars['info']['title']; ?>
</h3>
            </div>
            <div class="sr-box">
                <div class="srb-img">
                    <img src="/ui/img/<?php echo $this->_tpl_vars['info']['img']; ?>
" alt="">
                </div>
                <div class="srb-set">
                    <div class="srbs-row" types='no'>
                        <span class="srbs-title">价&nbsp;&nbsp;&nbsp;&nbsp;格:</span><span class="srbs-bprice" id="prices"><?php echo $this->_tpl_vars['info']['basicfee']; ?>
</span>元
                    </div>
                    
<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
?>
                    <div class="srbs-row" types='<?php echo $this->_tpl_vars['item']['type']; ?>
'>
                        <span class="srbs-title"><?php echo $this->_tpl_vars['item']['labels']; ?>
:</span>
                        <span>
                            <ul class="srbs-list" <?php if ($this->_tpl_vars['item']['one'] != '1'): ?>onlyOne="true"<?php endif; ?>>
                            <?php $_from = $this->_tpl_vars['item']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['items']):
?>
                                <li <?php if ($this->_tpl_vars['items']['default'] == '1'): ?>class="cur"<?php endif; ?> data="<?php echo $this->_tpl_vars['items']['fee']; ?>
" title="<?php echo $this->_tpl_vars['items']['fee']; ?>
"><?php echo $this->_tpl_vars['items']['name']; ?>
</li>
                            <?php endforeach; endif; unset($_from); ?>
                            </ul>
                        </span>
                        <div class="clear"></div>
                    </div>
<?php endforeach; endif; unset($_from); ?>
                     
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
                    <?php echo $this->_tpl_vars['info']['note']; ?>

                </div>
             </div>

            <div class="clear"></div>
        </div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "service/serv_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>