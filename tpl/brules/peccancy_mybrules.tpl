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
            <ul><li><a href="?action=index">违章查询提醒</a></li><li class="active">我的车辆</li></ul>
        </div>
        <div class="mytask_content">
            <div class="search-list">
                <form action="member_deal.php" method="post">
                    <table width="100%">
                        <tr>
                            <th>序号</th>
                            <th>车牌号</th>
                            <th>车架号</th>
                            <th>发动机号</th>
                            <th>手机号</th>
                            <th>违章概况(最新)</th>
                            <th>扣分总计</th>
                            <th>数据更新日期</th>
                            <th>提醒状态</th>
                            <th>服务期限</th>
                            <th colspan="2">操作</th>
                        </tr>
                        {php}
                        $info = $this->_tpl_vars['info'];
                        $bs = $this->_tpl_vars['br_push_status'];
                        foreach($info as $key=>$item):
                            $uptime = $item['uptime']==0 ? "暂无更新" : date('Y-m-d',$item['uptime']) ;
                            if($item['exists']=='0')$uptime = '<span class="red">车牌号有误</span>';
                        echo "
                        <tr>
                            <td>".($key+1)."</td>
                            <td>".$item['lpp'].$item['lpno']."</td>
                            <td>".$item['chassisno']."</td>
                            <td>{$item['engno']}</td>
                            <td>{$item['telephone']}</td>
                            <td>{$item['brnum']}(<span class='red'>{$item['newnum']}</span>)&nbsp;|&nbsp;<a href=\"?action=showInfo&did={$item['id']}\">查看</a></td>
                            <td>".$item['totalscore']."</td>
                            <td>".$uptime."</td>
                            <td>".$bs[$item['ispush']]."</td>
                            <td>".(!empty($item['time_limit']) ? date('Y-m-d',$item['time_limit']) : '')."</td>
                            <td><a href='?action=index&did={$item['id']}' class='' >修改</a>&nbsp;&nbsp;&nbsp;<!--<a href='?action=deal&did={$item['id']}' class='' onclick=\"return confirm('确定删除该任务吗？');\" >删除</a>--></td>
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