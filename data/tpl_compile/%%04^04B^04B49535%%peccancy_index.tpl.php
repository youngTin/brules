<?php /* Smarty version 2.6.22, created on 2013-07-28 11:37:59
         compiled from brules/peccancy_index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'brules/peccancy_index.tpl', 28, false),array('modifier', 'default', 'brules/peccancy_index.tpl', 43, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="center-box">
<script type="text/javascript" src="/ui/js/reg_new.js"></script>
<!--<div class="note-header">
    当前位置：<a>违章查询</a>
</div>-->

<div class="c-content">
    <div class="myinfo">
        <div class="myinfo_title">
            <ul><li class="active">违章查询提醒</li><li><a href="?action=mybrules">我的车辆</a></li></ul>
        </div>
        <div class="myinfo_content">
            <form action="?action=save"  method="post" id="form1" >
                <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['info']['id']; ?>
" />
                <table>
                    <tr>
                        <td>违章的区域：</td>
                        <td colspan="3"><input type="hidden" name="province" value="<?php echo $this->_tpl_vars['province']; ?>
" /><?php echo $this->_tpl_vars['dist1']; ?>
</td>
                    </tr><tr>
                        <td class="t_title">车牌号：</td>
                        <td colspan="3">
                        <?php if ($this->_tpl_vars['isbond'] == '1'): ?>
                        <?php echo $this->_tpl_vars['info']['lpp']; ?>
<?php echo $this->_tpl_vars['info']['lpno']; ?>

                        <?php else: ?>
                            <select name="lpp" class="bselect" >
                                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['br_br_dist'],'selected' => $this->_tpl_vars['info']['lpp']), $this);?>

                            </select>
                        <input type="text" name="lpno" class="binput"  value="<?php echo $this->_tpl_vars['info']['lpno']; ?>
" maxlength="6" verify="true" vtype='lpno' /><label class="msg1 clabel">车牌号必须</label>
                        <?php endif; ?>
                        </td>
                    </tr><tr>
                        <td>车架号：</td>
                        <td colspan="3"><?php if ($this->_tpl_vars['isbond'] == '1'): ?><?php echo $this->_tpl_vars['info']['chassisno']; ?>
<?php else: ?><input type="text" name="chassisno" class="binput"  value="<?php echo $this->_tpl_vars['info']['chassisno']; ?>
" maxlength="6"  />&nbsp;&nbsp;<span class="gray ">车辆识别代号后6位</span><?php endif; ?></td>
                    </tr><tr>
                        <td>发动机号：</td>
                        <td colspan="3"><input type="text" name="engno" class="binput" value="<?php echo $this->_tpl_vars['info']['engno']; ?>
" maxlength="6" />&nbsp;&nbsp;<span class="gray ">发动机号后6位</span></td>
                    </tr><tr>
                        <td>车辆类型：</td>
                        <td colspan="3">
                            <select name="vtype">
                                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['br_car_type'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['vtype'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>手机号:</td>
                        <td colspan="3"><input type="text" name="telephone" class="binput" id="telephone" value="<?php echo $this->_tpl_vars['info']['telephone']; ?>
" /></td>
                    </tr> <tr>
                        <td class="t_title"></td>
                        <td><div class="verimg"><a><img src="/includes/validate_code/vdimgck.php" name="ck" align="absmiddle" onclick="this.src=this.src+'?said='+Math.random();" id="vdimgck"></a>&nbsp;&nbsp;&nbsp;<a onclick="$(this).parent('div').children('a').children('img').attr('src',$(this).parent('div').children('a').children('img').attr('src')+'?said='+Math.random())">看不清，换一张？</a></div></td>
                    </tr><tr>
                        <td class="t_title">验证码:</td>
                        <td colspan="3"><input type="text" class="binput " name="vdcode" id="vercode" verify="true" vtype='vercode' vothfun='vercodefun' /><label class="msg1 clabel">请输入验证码</label><span class="loading"><img src="ui/images/loading.gif" alt="" id="loadimg"></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3"><input id="subbutton" type="button" value="提交" class="subbutton1 " /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="clear"></div>
</div>
</div>
<script type="text/javascript">
<?php echo '
$(function(){
    $("#subbutton").bind(\'click\',function(){
        checkInput();             
        if(isCheck)
        {
            $("#form1").submit();
        }
    })
})
'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>