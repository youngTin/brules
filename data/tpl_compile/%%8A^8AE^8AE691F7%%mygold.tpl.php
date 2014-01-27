<?php /* Smarty version 2.6.22, created on 2013-04-14 12:09:14
         compiled from mydr/mygold.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'mydr/mygold.tpl', 24, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="center-box">
<div class="note-header">
    当前位置：<a>财务流水</a>
</div>
<div class="c-content">
    <p class="ptitle">当前金额：<span class="red"><?php echo $this->_tpl_vars['info']['now_gold']; ?>
</span>&nbsp;&nbsp;&nbsp;保证金：<span class="red"><?php echo $this->_tpl_vars['info']['s_gold']; ?>
</span>元&nbsp;&nbsp;&nbsp;&nbsp;可用数量：<span class="red"><?php echo $this->_tpl_vars['info']['now_gold']; ?>
</span>元</p>
    <div class="search-list">
    <form action="member_deal.php" method="post">
        <table width="100%">
            <tr>
                <th>流水号</th>
                <th>金额</th>
                <th>钱包余额</th>
                <th>操作</th>
                <th>时间</th>
            </tr>
            <?php $_from = $this->_tpl_vars['ginfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
            <tr>
                <td><?php echo $this->_tpl_vars['item']['gno']; ?>
</td>
                <td><?php echo $this->_tpl_vars['item']['gold']; ?>
</td>
                <td><?php echo $this->_tpl_vars['item']['banlance']; ?>
</td>
                <td><?php echo $this->_tpl_vars['item']['op']; ?>
</td>
                <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['addtime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
</td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
        </table>
        <div class="pageer">
            <ul><li>当前显示<span class="red"><?php echo $this->_tpl_vars['pagesize']; ?>
</span>条记录，总共<span class="red"><?php echo $this->_tpl_vars['num']; ?>
</span>条记录</li><?php echo $this->_tpl_vars['splitPageStr']; ?>
</ul>
            <div class="clear"></div>
        </div>
    </form>
    </div>
</div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>