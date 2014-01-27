<?php /* Smarty version 2.6.22, created on 2013-04-24 14:28:35
         compiled from mydr/pubEdit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'mydr/pubEdit.tpl', 36, false),array('function', 'html_options', 'mydr/pubEdit.tpl', 43, false),array('modifier', 'default', 'mydr/pubEdit.tpl', 36, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="/ui/js/datepicker/WdatePicker.js" ></script>
<script type="text/javascript" src="/ui/js/common.formcheck.js" ></script>
<div class="center-box">
<div class="note-header">
    当前位置：<a>信息发布</a>
</div>
<div class="c-content">
    <h4>信息发布</h4>
    <div class="pub-box">
    <form action="member_pub.php?action=save"  method="post" id="form1" >
        <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['info']['id']; ?>
" />
        <table width="100%">
           <tr>
                <td class="ttitle">发布类别</td>
                <td colspan="3">
                    <input type="hidden" name="type" id="type" value="0" />出售驾照分
                </td>
           </tr> <tr>
                <td class="ttitle">驾照所在地</td>
                <td colspan="3">
                    <?php echo $this->_tpl_vars['dist1']; ?>

                    &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
           </tr> <tr>
                <td class="ttitle">处理所在地</td>
                <td colspan="3">
                     <?php echo $this->_tpl_vars['dist2']; ?>

                    &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
           </tr> <tr>
                <td class="ttitle">证件类型</td>
                <td colspan="3">
                    <?php echo smarty_function_html_radios(array('radios' => $this->_tpl_vars['crecate_radio'],'name' => 'crecate','selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['crecate'])) ? $this->_run_mod_handler('default', true, $_tmp, 6) : smarty_modifier_default($_tmp, 6))), $this);?>

                    <span class="red font14">*</span>
                </td>
           </tr> <tr>
                <td class="ttitle" id='exppriceTitle'>最<?php if ($_GET['type'] == '1' || $this->_tpl_vars['info']['type'] == '1'): ?>高<?php else: ?>低<?php endif; ?>期望价</td>
                <td>
                    <select name="min_expectprice" id="min_expectprice">
                        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['min_expectprice_option'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['min_expectprice'])) ? $this->_run_mod_handler('default', true, $_tmp, 80) : smarty_modifier_default($_tmp, 80))), $this);?>

                   </select>
                   &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
                <td class="ttitle" id="scTitle"><?php if ($_GET['type'] == '1' || $this->_tpl_vars['info']['type'] == '1'): ?>收购<?php else: ?>可售<?php endif; ?>分数</td>
                <td>
                    <select name="score" id="scoreS">
                        <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['score_option'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['score'])) ? $this->_run_mod_handler('default', true, $_tmp, 9) : smarty_modifier_default($_tmp, 9))), $this);?>

                   </select>
                   分
                   <span id="changeSg1" <?php if ($_GET['type'] != '1' && $this->_tpl_vars['info']['type'] != '1'): ?>class='disnone'<?php endif; ?>>
                        <input type="checkbox" id='othersc' name="othersc" value="1" <?php if ($this->_tpl_vars['info']['score'] > 12): ?>checked<?php endif; ?>>其他 
                         &nbsp;&nbsp;
                        <span id="expp1" class="disnone">收购分数&nbsp;
                        <input type="text" value="<?php echo $this->_tpl_vars['info']['score']; ?>
" name="scorceNew" id="scorceNew" /><label class="msg2">收购分数不能为空</label></span>
                   </span><span id="changeSg" <?php if ($_GET['type'] == '1' && $this->_tpl_vars['info']['type'] == '1'): ?>class='disnone'<?php endif; ?>>
                       &nbsp;&nbsp;&nbsp;
                        <span class="red font14">*</span>
                        <span id="isrevoke" <?php if ($this->_tpl_vars['info']['revoke'] <= 0): ?>class="disnone"<?php endif; ?>>&nbsp;&nbsp;可否吊销&nbsp;&nbsp;
                        <select name="revoke" id="revoke">
                            <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['revoke_option'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['revoke'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                        </select>
                        &nbsp;&nbsp;
                        <span id="expp" <?php if ($this->_tpl_vars['info']['expectprice'] <= 0): ?>class="disnone"<?php endif; ?>>期望价格&nbsp;
                        <input type="text" value="<?php echo $this->_tpl_vars['info']['expectprice']; ?>
" name="expectprice" id="expectprice" /><label class="msg2">期望价格不能为空</label></span></span>
                       
                    </span>
                </td>
           </tr><tr>
                <td class="ttitle">联系电话</td>
                <td>
                    <input type="text" name="tel" id='tel' verify="true" vtype='tel' value="<?php echo $this->_tpl_vars['info']['tel']; ?>
" />
                   &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span><label class="msg2">联系电话不正确</label>
                </td>
                <td class="ttitle">领证日期</td>
                <td>
                    <input type="text" name="licensdate" id="licensdate"  value="<?php echo $this->_tpl_vars['info']['licensdate']; ?>
" onclick="WdatePicker();"  verify="true" vtype='date' />
                   &nbsp;&nbsp;&nbsp;
                    <span class="red font14">&nbsp;*&nbsp;</span>
                    <label class="msg2">日期格式不正确</label>
                </td>
           </tr><tr>
                <td class="ttitle">联系人</td>
                <td >
                    <input type="text" name="linkman" id="linkman" verify="true" vtype='name' value="<?php echo $this->_tpl_vars['info']['linkman']; ?>
" />
                   &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span><label class="msg2">联系人不能为空</label>
                </td>
                <td class="ttitle">时间安排</td>
                <td>
                    <select name="timeline">
                    <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['timeline_option'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['timeline'])) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>

                   </select>
                </td>
           </tr><tr>
                <td class="ttitle">备注</td>
                <td colspan="3">
                    <textarea name="remark" cols="42" rows="3"><?php echo $this->_tpl_vars['info']['remark']; ?>
</textarea>
                   &nbsp;&nbsp;&nbsp;
                </td>
           </tr>
           <tr>
            <td></td>
            <td colspan="3"><input id="subbutton" type="button" value="确定" class="subbutton red" /></td>
           </tr>
        </table>
    </form>
    </div>
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
    $("#scoreS").bind(\'change\',function(){
        var data = $(this).val();
        var type = $("input[name=\'type\']:checked").val();
        if(type==\'1\')
        {
            
        }
        else
        {
            
            if(data==\'12\')
            {
                $("#isrevoke").show();
            }
            else{
                $("#isrevoke").hide();
                $("#revoke").attr(\'value\',\'0\');
                $("#expp").hide();
            }
        }
        
    })
    
    $("#revoke").bind(\'change\',function(){
        var data = $(this).find(\'option:selected\').val();
        if(data==\'0\')
        {
            $("#expp").hide();
            $("#expectprice").val(\'\').removeAttr(\'verify\').removeAttr(\'vtype\');
        }
        else
        {
            $("#expp").show();
            $("#expectprice").attr(\'verify\',\'true\');
            $("#expectprice").attr(\'vtype\',\'money\');
        }
    })
    
    $("input[name=\'type\']").bind(\'click\',function(){
        if($(this).val()==\'1\'){
            $("#exppriceTitle").html(\'最高期望价\');
            $("#scTitle").html(\'收购分数\');
            $("#changeSg1").show();
            $("#changeSg").hide();
        }
        else {
            $("#exppriceTitle").html(\'最低期望价\');
            $("#scTitle").html(\'可售分数\');
            $("#changeSg").show();
            $("#changeSg1").hide();
        }
    })
    
    $("#othersc").bind(\'click\',function(){
        if($(this).attr(\'checked\'))
        {
            $("#expp1").show();
        }
        else 
        {
            $("#scorceNew").val(\'\');
            $("#expp1").hide();
        }
    })
    
    $("input[name=\'crecate\']").bind(\'change\',function(){
            $("#min_expectprice").html(meoptions);
            $.ajax({
                url:\'?action=getMe\',
                type: "POST",
                data: {oid:$(this).val(),city:$("#on_city").val(),type:$("#type").val()},
                dataType:\'html\',
                success: function(data) 
                {
                    if(data!=\'none\')
                    {
                        var option = data;
                        $("#min_expectprice").html(option);
                    }
                }
            });
            
    })
})
window.meoptions = $("#min_expectprice").html();
'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>