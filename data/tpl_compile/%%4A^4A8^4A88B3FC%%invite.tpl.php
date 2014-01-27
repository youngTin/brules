<?php /* Smarty version 2.6.22, created on 2013-04-14 17:49:01
         compiled from mydr/invite.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'mydr/invite.tpl', 24, false),array('modifier', 'date_format', 'mydr/invite.tpl', 39, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="/ui/js/artDialog/artDialog.min.js" type="text/javascript"></script>
<script src="./ui/js/dialog.js" type="text/javascript"></script>
<div class="note-header">
    当前位置：<a>我的邀请</a>
</div>
<div class="c-content invite">
    <div class="invite_title">
        <p>邀请有奖</p>
        <p class="it_info">邀请好友加入驾照分交易网，交易成功每个好友<b>立奖10元现金</b>，赶快叫上好朋友，一起发布信息吧！</p>
    </div>
    <div class="invite_znum">总邀请人数：<b class="gray"><?php echo $this->_tpl_vars['num']; ?>
人</b></div>
    <div class="invite_notes">
        <div><ul><li class="in_title">邀请记录：</li><?php $_from = $this->_tpl_vars['ginfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?><li><?php echo $this->_tpl_vars['item']['username']; ?>
</li><?php endforeach; endif; unset($_from); ?></ul></div>
        <p>您的邀请奖励：每个好友<span class="red"><?php echo @INVITE_SCORES; ?>
</span>分</p>
    </div>
    <div class="invite_pri">
        <h3>您的专属链接</h3>
        <div class="ip_info">
            <p><input type="text" class="link" name="link" id="link" value="http://www.jiazhao888.com/i/<?php echo $this->_tpl_vars['info']['uid']; ?>
" /><button type="button" onclick="setClipboardfirst()" >复制</button></p>
            <p>复治上面的链接，通过QQ、旺旺、微博、论坛发帖等方式发送给好友，对方通过改链接注册即可~</p>
        </div>
    </div>
    <div class="invite_znum">总邀请收入：<b class="red"><?php echo $this->_tpl_vars['tgold']; ?>
</b>元&nbsp;;&nbsp;&nbsp;可提现佣金：<b class="red"><?php echo ((is_array($_tmp=@$this->_tpl_vars['info']['in_gold'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>
</b>元&nbsp;&nbsp;&nbsp;</div>
    <div class="search-list">
    <form action="member_deal.php" method="post">
        <table width="100%">
            <tr>
                <th>来源用户</th>
                <th>奖励类型</th>
                <th>收入金额</th>
                <th>时间</th>
            </tr>
            <?php $_from = $this->_tpl_vars['ginfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
            <tr>
                <td><?php echo $this->_tpl_vars['item']['username']; ?>
</td>
                <td>邀请收入</td>
                <td><?php echo $this->_tpl_vars['item']['gold']; ?>
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
<script type="text/javascript">
<?php echo '
function setClipboardfirst() {
    var value = $("#link").val();
    if (window.clipboardData) {
        window.clipboardData.setData("Text", value);
        alert("复制成功");
    } else {
        /*
        $("<div><p class=\'f12 fblod mt8\'>你使用的是非IE核心浏览器,请按下Ctrl+C复制代码到剪切板</p><textarea id=\'selectersecond\' class=\'mt8\' style=\'width:340px; height:60px; padding:5px; font-size:12px;\'>" + value + "</textarea>").dialog({ title: " 温馨提示", modal: true, width: 380, height: 150 });
        */
        
        var dialog1 = art.dialog({
            content: "<div style=\'padding:0 10px\'><p>你使用的是非IE核心浏览器</p><p class=\'f_blod\'>请点击”选取“按钮,按下Ctrl+C复制代码到剪切板</p><textarea id=\'selectersecond\' style=\'width:340px; height:60px;font-size:12px;margin-bottom:10px;\'>" + value + "</textarea>",
            yesText:\'选取\',
            yesFn: function(){
                $("#selectersecond").select();
                return false;
            }
        });
        
    }

 }
'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>