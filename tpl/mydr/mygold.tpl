{include file="brules/header.tpl"}
{include file="brules/menu.tpl"}
<div class="center-box">
<div class="note-header">
    当前位置：<a>财务流水</a>
</div>
<div class="c-content">
    <p class="ptitle">当前金额：<span class="red">{$info.now_gold}</span>&nbsp;&nbsp;&nbsp;保证金：<span class="red">{$info.s_gold}</span>元&nbsp;&nbsp;&nbsp;&nbsp;可用数量：<span class="red">{$info.now_gold}</span>元</p>
    <div class="search-list">
    <form action="member_deal.php" method="post">
        <table width="100%">
            <tr>
                <th>流水号</th>
                <th>金额</th>
                <th>钱包余额</th>
                <th>操作</th>
                <th>时间</th>
            </tr>
            {foreach from=$ginfo item=item}
            <tr>
                <td>{$item.gno}</td>
                <td>{$item.gold}</td>
                <td>{$item.banlance}</td>
                <td>{$item.op}</td>
                <td>{$item.addtime|date_format:'%Y-%m-%d %H:%M:%S'}</td>
            </tr>
            {/foreach}
        </table>
        <div class="pageer">
            <ul><li>当前显示<span class="red">{$pagesize}</span>条记录，总共<span class="red">{$num}</span>条记录</li>{$splitPageStr}</ul>
            <div class="clear"></div>
        </div>
    </form>
    </div>
</div>
</div>

{include file="brules/footer.tpl"}