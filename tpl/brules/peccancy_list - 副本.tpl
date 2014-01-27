{include file="brules/header.tpl"}
{include file="brules/menu.tpl"}
<div class="center-box">
<script type="text/javascript" src="/ui/js/reg_new.js"></script>
<div class="note-header">
    当前位置：<a>查询</a>
</div>

<div class="c-content">
    <div class="myinfo">
        <div class="myinfo_title">
            <ul><li class="active">[{$brinfo.lpp}{$brinfo.lpno}]违章信息</li></ul>
        </div>
        <div class="mytask_content">
            <div class="search-list">
                <form action="member_deal.php" method="post">
                    <table width="100%">
                        <tr>
                            <th>违章时间</th>
                            <th>违章地点</th>
                            <th>违章原因</th>
                            <th>扣分</th>
                            <th>罚金</th>
                            <th>代办费</th>
                            <th>办理</th>
                        </tr>
                        {php}
                        $info = $this->_tpl_vars['info'];
                        $bs = $this->_tpl_vars['br_push_status'];
                        foreach($info as $key=>$item):
                            $uptime = $item['uptime']==0 ? "暂无更新" : date('Y-m-d',$item['uptime']) ;
                        echo "
                        <tr>
                            <td>".date('Y-m-d',strtotime($item['brtime']))."</td>
                            <td>".$item['braddress']."</td>
                            <td>".$item['brreason']."</td>
                            <td>{$item['marking']}</td>
                            <td>{$item['fine']}</td>
                            <td>{$item['agencyfees']}</td>
                            <td>?</td>
                        </tr>
                        ";
                        endforeach;
                        {/php}
                    </table>
                    <div class="pageer">
                        <ul><li>当前显示<span class="red">{$pagesize}</span>条记录，总共<span class="red">{$num}</span>条记录</li>{$splitPageStr}</ul>
                        <div class="clear"></div>
                    </div>
                </form>
                </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
</div>
<script type="text/javascript">
{literal}
$(function(){
    $("#subbutton").bind('click',function(){
        checkInput();             
        if(isCheck)
        {
            $("#form1").submit();
        }
    })
})
{/literal}
</script>
{include file="brules/footer.tpl"}