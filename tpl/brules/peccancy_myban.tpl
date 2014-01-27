{include file="brules/header.tpl"}
{include file="brules/menu.tpl"}
<div class="center-box">
<script type="text/javascript" src="/ui/js/reg_new.js"></script>
<!--<div class="note-header">
    当前位置：<a>查询</a>
</div>-->

<div class="c-content">
    <div class="myinfo">
        <div class="myinfo_title">
            <ul><li class="active">我的办理</li></ul>
        </div>
        <div class="mytask_content">
            <div class="search-list">
                <form action="member_deal.php" method="post">
                    <table width="100%">
                        <tr>
                            <th>序号</th>
                            <th>车牌号</th>
                            <th>违章条数</th>
                            <th>扣分</th>
                            <th>罚款</th>
                            <th>服务费</th>
                            <th>总费用</th>
                            <th>办理时间</th>
                            <th>预留人</th>
                            <th>预留电话</th>
                        </tr>
                        {php}
                        $info = $this->_tpl_vars['info'];
                        foreach($info as $key=>$item):
                            $addtime =  date('Y-m-d',$item['addtime']) ;
                        echo "
                        <tr>
                            <td>".($key+1)."</td>
                            <td>".$item['lpno']."</td>
                            <td>".$item['brnum']."</td>
                            <td>{$item['marking']}</td>
                            <td>{$item['fine']}</td>
                            <td>{$item['sefine']}</td>
                            <td>".$item['totalfee']."</td>
                            <td>".$addtime."</td>
                            <td>".$item['sname']."</td>
                            <td>".$item['telephone']."</td>
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