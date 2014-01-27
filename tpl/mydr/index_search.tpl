{include file="mydr/header.tpl"}
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
                    {html_radios radios=$type_radio name=type selected=$info.type|default:0}
                    <span class="red font14">*</span>
                </td>
            </tr><tr>
                <td class="ttitle">处理所在地</td>
                <td colspan="3">
                    {$dist2}
                    &nbsp;&nbsp;&nbsp;
                    <span class="red font14">*</span>
                </td>
            </tr><tr>
                <td class="ttitle">证件类型</td>
                <td colspan="3">
                    {html_radios radios=$crecate_radio name=crecate selected=$info.crecate|default:6}
                    <span class="red font14">*</span>
                </td>
            </tr><tr>
                <td class="ttitle">分数</td>
                <td>
                    <select name="score" id="scoreS">
                        {html_options options=$score_option selected=$smarty.get.score|default:9}
                   </select>&nbsp;分
                </td>
                <td class="ttitle">价格区间</td>
                <td>
                   最高&nbsp;
                   <select name="min_expectprice">
                        {html_options options=$min_expectprice_option selected=$info.min_expectprice|default:80}
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
{include file="mydr/footer.tpl"}