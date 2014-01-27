<?php /* Smarty version 2.6.22, created on 2013-04-14 17:46:35
         compiled from mydr/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'mydr/index.tpl', 15, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

        <div class="pwrap">
            <div class="phead">
                <h3 class="ptitle">用户中心</h3>
            </div>
            <div class="pbody">
                <div class="pbox">
                    <div class="clearfix box-userinfo">
                        <div class="clearfix">
                        <div class="left">
                            <ul class="info">
                                <li>用户名：<strong><?php echo @USERNAME; ?>
</strong></li>
                                <li>手机帐户：<?php if ($this->_tpl_vars['userinfo']['tel'] != ''): ?><?php echo $this->_tpl_vars['userinfo']['tel']; ?>
<?php else: ?><a href="myinfo.html">未设置</a><?php endif; ?></li>
                                <li><span>进行中任务(<a href="mytask.html" class="red"><?php echo ((is_array($_tmp=@$this->_tpl_vars['doing'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</a>)</span><span>已完成任务(<a href="mytask.html?op=done" class="red"><?php echo ((is_array($_tmp=@$this->_tpl_vars['done'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</a>)</span><span>等待接手任务(<a href="mytask.html?op=wait" class="red"><?php echo ((is_array($_tmp=@$this->_tpl_vars['wait'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</a>)</span></li>
                            </ul>
                        </div>
                        <div class="floatright finance">
                            <div class="floatleft balance">
                                账户余额：<strong class="larger2 orange"><?php echo $this->_tpl_vars['userinfo']['now_gold']; ?>
</strong> 元
                            </div>
                            <div class="floatright recharge">
                                <a href="buy.html">充 值</a>
                            </div>
                            <div class="clear clearfix detail">
                                <span class="floatleft">推广佣金：<span class="orange"><?php echo ((is_array($_tmp=@$this->_tpl_vars['userinfo']['in_gold'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</span> 元 [ <a href="">提现</a> ]</span>
                              
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pwrap">
            <div class="phead">
                <h3 class="ptitle">最新发布信息</h3>
            </div>
            <div class="pbody">
                <div class="pbox pbox-shaddow">
                    <div class="user-guide" style="height: 108px;overflow: hidden;" id="dmarq">
                        
                        <?php 
                        $drinfo = $this->_tpl_vars['drinfo'];
                        $i =0;
                        foreach($drinfo as $item):
                            if($i%6==0)$ul .= '<ul class="clearfix dmarquee">';
                            $values = array($item['on_province'],$item['on_city'],$item['on_dist']);
                            $ul .= "<li><span>".date("Y-m-d H:i",$item['addtime'])."&nbsp;&nbsp;".showdistricts($values, '', '','',true)."&nbsp;&nbsp;{$item['linkman']}&nbsp;".$this->_tpl_vars['type_radio'][$item['type']]."&nbsp;{$item['score']}分<a href=\"search.html?action=show&id=".$item['id']."\">预订</a></span></li>";
                            if(($i+1)%6==0) $ul .='</ul>';
                         $i++;
                        endforeach;
                        echo $ul;
                         ?>
                        
                    </div>
                </div>
            </div>
        </div><div class="pwrap">
            <div class="phead">
                <h3 class="ptitle">服务概况</h3>
            </div>
            <div class="pbody">
                <div class="pbox pbox-shaddow">
                    <div class="user-guide">
                        <ul class="clearfix">
                        <?php $_from = $this->_tpl_vars['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                            <li><a target="_blank" href="help.html?id=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></li>
                        <?php endforeach; endif; unset($_from); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>