<?php /* Smarty version 2.6.22, created on 2013-11-25 10:38:13
         compiled from service/banBox.tpl */ ?>
<?php echo '
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
'; ?>
 
<div class="dcontent c-content">
<p>注：<span class="red">*</span>请填写您的联系方式。</p>
<table>
   <tr>
        <td class="t_title">车主姓名：</td>
        <td><input type="text" class="input" name="pname" id="pname" value="" verify="true" vtype='noempty' />&nbsp;<span class="red">*</span>请输入车主姓名。</td>
    </tr><tr>
        <td class="t_title">手机号码：</td>
        <td><input type="text" class="input" name="phone" id="phone" value="" verify="true" vtype='telephone'  />&nbsp;<span class="red">*</span>请输入您的手机号码。</td>
    </tr><tr>
        <td class="t_title">你的车型：</td>
        <td><input type="text" class="input" name="cartype" id="cartype" value="" verify="true" vtype='noempty'  />&nbsp;<span class="red">*</span>车型必须</td>
    </tr><tr>
        <td class="t_title">所在区域：</td>
        <td><input type="text" name="area" id="area" value="" verify="true" vtype='noempty'  />&nbsp;<span class="red">*</span>所在区域必须</td>
    </tr><tr>
        <td class="t_title"></td>
        <td><input type="checkbox" name="chk" id="chk" checked="checked" value="1" />我接受《车司令协议》</td>
    </tr>
</table>
<p class="operation">
<a id="buyScoreButton" onclick="bookingInfo()" class="thickbox">确定</a><a onclick="$.dialog.get('itemT').close();">取消</a></p>
</div>