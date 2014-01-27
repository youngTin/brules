<?php /* Smarty version 2.6.22, created on 2014-01-13 10:44:49
         compiled from mydr/myinfo_index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'mydr/myinfo_index.tpl', 34, false),array('function', 'html_options', 'mydr/myinfo_index.tpl', 45, false),array('modifier', 'default', 'mydr/myinfo_index.tpl', 34, false),array('modifier', 'date_format', 'mydr/myinfo_index.tpl', 37, false),)), $this); ?>
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
<script type="text/javascript" src="/ui/js/datepicker/WdatePicker.js" ></script>
<script type="text/javascript" src="/ui/js/common.formcheck.js" ></script>
<div class="center-box">
<div class="note-header">
    当前位置：<a>个人信息</a>
</div>
<div class="c-content">
    <div class="myinfo">
        <div class="myinfo_title">
            <ul><li class="active">基本信息</li><li><a href="?action=resetpass">修改密码</a></li></ul>
        </div>
        <div class="myinfo_content">
            <form action="?action=save"  method="post" id="form1" >
            <?php if (@UTYPE == '2'): ?>
                <table>
                    <tr>
                        <td>代理商名称：</td>
                        <td colspan="3"><input type="text" name="agperson" value="<?php echo $this->_tpl_vars['info']['agperson']; ?>
" /></td>
                    </tr>
                    <tr>
                        <td>代理商联系电话：</td>
                        <td colspan="3"><input type="text" name="agtelephone" value="<?php echo $this->_tpl_vars['info']['agtelephone']; ?>
" /></td>
                    </tr>
                </table>
            <?php else: ?>
                <table>
                    <tr>
                        <td>真实姓名：</td>
                        <td colspan="3"><input type="text" name="linkman" value="<?php echo $this->_tpl_vars['info']['linkman']; ?>
" /></td>
                    </tr><tr>
                        <td>性别：</td>
                        <td colspan="3"><?php echo smarty_function_html_radios(array('radios' => $this->_tpl_vars['sex_radio'],'name' => 'sex','selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['sex'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>
</td>
                    </tr><tr>
                        <td>领证日期：</td>
                        <td colspan="3"><input type="text" name="licensdate"  value="<?php echo ((is_array($_tmp=$this->_tpl_vars['info']['licensdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" onclick="WdatePicker();"  verify="true" vtype='date' />&nbsp;&nbsp;<span class="red font14">*</span></td>
                    </tr><tr>
                        <td>证件类型：</td>
                        <td colspan="3"><?php echo smarty_function_html_radios(array('radios' => $this->_tpl_vars['crecate_radio'],'name' => 'crecate','selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['crecate'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>
&nbsp;&nbsp;<span class="red font14">*</span></td>
                    </tr><tr>
                        <td>最低期望价：</td>
                        <td>
                            <select name="min_expectprice">
                                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['min_expectprice_option'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['min_expectprice'])) ? $this->_run_mod_handler('default', true, $_tmp, 80) : smarty_modifier_default($_tmp, 80))), $this);?>

                            </select>
                        </td>
                        <td>手机号码：</td>
                        <td><input type="text" name="tel" verify="true" vtype='tel' value="<?php echo $this->_tpl_vars['info']['tel']; ?>
" /></td>
                    </tr><!--<tr>
                        <td>驾照所在地：</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['dist1']; ?>
</td>
                    </tr><tr>
                        <td>当前所在地：</td>
                        <td colspan="3"><?php echo $this->_tpl_vars['dist2']; ?>
</td>
                    </tr>--><tr>
                        <td>驾驶证号：</td>
                        <td ><input type="text" name="licensid" value="<?php echo $this->_tpl_vars['info']['licensid']; ?>
" /></td>
                        <td>档案编号：</td>
                        <td ><input type="text" name="fileno"  value="<?php echo $this->_tpl_vars['info']['fileno']; ?>
" /></td>
                    </tr><tr>
                        <td>QQ:</td>
                        <td><input type="text" name="qq" id="qq" value="<?php echo $this->_tpl_vars['info']['qq']; ?>
" /></td>
                        <td>邮箱:</td>
                        <td><input type="text" name="email" id="qq" value="<?php echo $this->_tpl_vars['info']['email']; ?>
" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3"><input id="subbutton" type="button" value="确定" class="subbutton1 " /></td>
                    </tr>
                </table>
            <?php endif; ?>
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