{literal}
<style type="text/css">
.dcontent{margin: 10px;}
.dcontent p{margin: 20px auto;}
.dcontent p span.red{color:#FF0000;}
.operation{text-align: center;margin-top: 5px;}
.operation a{margin: 0 20px;border:solid 1px #FF7533;padding:5px 10px;background: #FFFFC0;cursor: pointer;}
.dcontent table td{line-height: 30px;padding: 5px;}
.t_title{color:#6D6D6D;font-size:14px;}
.input{border:1px solid #CCCCCC;height:25px;line-height:25px;}
</style>
{/literal} 
<div class="dcontent c-content">
<p>注：<span class="red">*</span>请填写您的联系方式。输入手机号码后我们将把相关信息发送到您的手机！！</p>
<table>
  <!-- <tr>
        <td class="t_title">车主姓名：</td>
        <td><input type="text" class="input" name="pname" id="pname" value="" verify="true" vtype='noempty' />&nbsp;<span class="red">*</span>请输入车主姓名。</td>
    </tr><tr>-->
        <td class="t_title">手机号码：</td>
        <td><input type="text" class="input" name="phone" id="s-phone" value="" verify="true" vtype='telephone'  />&nbsp;<span class="red">*</span>请输入您的手机号码。</td>
    </tr><tr>
        <td class="t_title"></td>
        <td><input type="checkbox" name="chk" id="s-chk" checked="checked" value="1" />我接受《车司令协议》</td>
    </tr>
</table>
<p class="operation">
<a id="sercTelButton" class="thickbox">确定</a><a onclick="$.dialog.get('itemText').close();">取消</a></p>
</div>
{if $tel != null }

<script type="text/javascript">
$("#s-tel").val('{$tel}');
subSearchmit();

</script>

{/if}