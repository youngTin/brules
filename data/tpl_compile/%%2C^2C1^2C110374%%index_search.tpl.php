<?php /* Smarty version 2.6.22, created on 2013-03-10 18:29:15
         compiled from mydr/index_search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'mydr/index_search.tpl', 16, false),array('function', 'html_options', 'mydr/index_search.tpl', 36, false),array('modifier', 'default', 'mydr/index_search.tpl', 16, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="center-box">
<script type="text/javascript" src="/ui/js/datepicker/WdatePicker.js" ></script>
<div class="note-header">
    当前位置：<a>查询</a>
</div>

<div class="c-content">
    <h4>查询页面</h4>
    <div class="search-box">
    <form action="member_search.php" method="get">
        <table width="100%">
            <tr>
                <td class="ttitle">查询类别</td>
                <td colspan="3">
                    <?php echo smarty_function_html_radios(array('radios' => $this->_tpl_vars['type_radio'],'name' => 'type','selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['type'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                    <span class="red font14">*</span>
                </td>
            </tr><tr>
                <td class="ttitle">处理所在地</td>
                <td colspan="3">
                    <?php echo $this->_tpl_vars['dist2']; ?>

                    &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
            </tr><tr>
                <td class="ttitle">证件类型</td>
                <td colspan="3">
                    <?php echo smarty_function_html_radios(array('radios' => $this->_tpl_vars['crecate_radio'],'name' => 'crecate','selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['crecate'])) ? $this->_run_mod_handler('default', true, $_tmp, 6) : smarty_modifier_default($_tmp, 6))), $this);?>

                    <span class="red font14">*</span>
                </td>
            </tr><tr>
                <td class="ttitle">分数</td>
                <td>
                    <select name="score" id="scoreS">
                        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['score_option'],'selected' => ((is_array($_tmp=@$_GET['score'])) ? $this->_run_mod_handler('default', true, $_tmp, 9) : smarty_modifier_default($_tmp, 9))), $this);?>

                   </select>&nbsp;分
                </td>
                <td class="ttitle">价格区间</td>
                <td>
                   最高&nbsp;
                   <select name="min_expectprice">
                        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['min_expectprice_option'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['min_expectprice'])) ? $this->_run_mod_handler('default', true, $_tmp, 80) : smarty_modifier_default($_tmp, 80))), $this);?>

                   </select>
                   &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
            </tr><tr>
                <td class="ttitle">领证时间</td>
                <td>
                    <input type="text" name="licensdate" onclick="WdatePicker();" />&nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
                <td class="ttitle">驾照要求</td>
                <td>
                   <select name="">
                    <option value="">不限制</option>
                   </select>
                   &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
            </tr>
            <tr>
                <td class="ttitle"></td>
                <td colspan="3">
                    <input type="submit" value="查询" class="subbutton" />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="reset" value="重置" class="subbutton" />
                </td>
            </tr>
        </table>
    </form>
    </div>
    <div class="clear"></div>
</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>