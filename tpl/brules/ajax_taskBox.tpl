{literal}
<style type="text/css">
.dcontent{margin: 10px;}
.dcontent p{margin: 20px auto;}
.dcontent p span.red{color:#FF0000;}
.operation{text-align: center;margin-top: 5px;}
.operation a{margin: 0 20px;border:solid 1px #FF7533;padding:5px 10px;background: #FFFFC0;cursor: pointer;}
.dcontent table td{line-height: 30px;padding: 5px;}
</style>
{/literal}
<div class="dcontent">
<p>注：<span class="red">*</span>请填写您的联系方式。</p>
<table>
   <tr>
        <td>联系人：</td>
        <td><input type="text" name="pname" id="pname" value="" /></td>
    </tr><tr>
        <td>联系电话：</td>
        <td><input type="text" name="tel" id="tel" value="" /></td>
    </tr>
</table>
<p class="operation">
<a id="buyScoreButton" onclick="bookingInfo('{$sp}')" class="thickbox">确定</a><a onclick="$.dialog.get('itemT').close();">取消</a></p>
</div>
