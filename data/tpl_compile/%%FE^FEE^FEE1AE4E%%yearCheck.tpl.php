<?php /* Smarty version 2.6.22, created on 2013-12-02 11:59:40
         compiled from service/yearCheck.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'service/yearCheck.tpl', 20, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "service/serv_left.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

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
                    
                    <div class="srbs-row" types='<?php echo $this->_tpl_vars['list'][0]['type']; ?>
'>
                        <span class="srbs-title">出厂年月:</span>
                        <span >
                        <select name="year" id="year" class="select" data="50" dataFrom="30">
                            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['year'],'selected' => 2011), $this);?>

                        </select>
                         <select name="month" id="month" class="select">
                            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['month'],'selected' => 5), $this);?>

                        </select>
                        </span>
                        <div class="clear"></div>
                    </div>
                    <div class="srbs-row" types='<?php echo $this->_tpl_vars['list'][1]['type']; ?>
'>
                        <span class="srbs-title"><?php echo $this->_tpl_vars['list'][1]['labels']; ?>
:</span>
                        <span>
                            <ul class="srbs-list" onlyOne="true">
                            <?php $_from = $this->_tpl_vars['list'][1]['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                                <li <?php if ($this->_tpl_vars['item']['default'] == '1'): ?>class="cur"<?php endif; ?> data="<?php echo $this->_tpl_vars['item']['fee']; ?>
" title="<?php echo $this->_tpl_vars['item']['fee']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</li>
                            <?php endforeach; endif; unset($_from); ?>
                            </ul>
                        </span>
                        <div class="clear"></div>
                    </div> <div class="srbs-row" types='<?php echo $this->_tpl_vars['list'][2]['type']; ?>
'>
                        <span class="srbs-title"><?php echo $this->_tpl_vars['list'][2]['labels']; ?>
:</span>
                        <span>
                            <ul class="srbs-list">
                            <?php $_from = $this->_tpl_vars['list'][2]['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                                <li data="<?php echo $this->_tpl_vars['item']['fee']; ?>
" title="<?php echo $this->_tpl_vars['item']['fee']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</li>
                            <?php endforeach; endif; unset($_from); ?>
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