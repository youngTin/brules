<?php /* Smarty version 2.6.22, created on 2013-04-14 17:24:21
         compiled from mydr/mytask_doing.tpl */ ?>
<div class="myinfo_title">
            <ul><li class="active">进行中的任务</li><li><a href="?op=done">已完成任务</a></li><li><a href="?op=wait">未接手任务</a></li><li><a href="?op=fail">失败的任务</a></li></ul>
        </div>
        <div class="mytask_content">
            <div class="search-list">
                <form action="member_deal.php" method="post">
                    <table width="100%">
                        <tr>
                            <th>任务编号</th>
                            <th>任务名称</th>
                            <th>接收时间</th>
                            <th>结束时间</th>
                            <th>对方姓名</th>
                            <th>电话</th>
                            <th>任务状态</th>
                            <th>手动设置</th>
                        </tr>
                        <?php 
                        $info = $this->_tpl_vars['info'];
                        $ts = $this->_tpl_vars['task_status'];
                        $tt = $this->_tpl_vars['task_type'];
                        foreach($info as $item):
                        
                        if($item['status']=='CONFIRM'||$item['status']=='WAIT')
                        {
                            $tel =   '<span class="red">请先确认</span>';
                        }
                        else
                        {
                            if(UID==$item['duid'])
                            {
                                $tel =   $item['telephone'];
                            }
                            else $tel = $item['tel'];
                        }
                        if(UID==$item['duid'])
                        {
                            $pname =   $item['pname'];
                        }
                        else $pname = $item['linkman'];
                        
                        if($item['status']=='CONFIRM')
                        {
                            if(UID==$item['uid']){
                                $opDo = '等待对方确认';
                                if(time()-$item['addtime']>12*60*60)$opDo .= "&nbsp;&nbsp;<a href='search.html?action=cancleInfo&id={$item['id']}' onclick='return confirm(\"确定取消该任务？\");'>取消</a>";
                            }else
                            $opDo = "<a class='red' onclick=\"markG('dobooking','".$item['id']."');\">确认</a>&nbsp;&nbsp;&nbsp;<a href='?action=cancleConfirm&id={$item['id']}' class='' onclick=\"return confirm('确定取消该任务吗？');\" >取消</a>";
                        }
                        else
                        {
                            $opDo = "<a href='?action=comp&id={$item['id']}' class='' onclick=\"return confirm('确定完成任务吗？');\">任务完成</a>&nbsp;&nbsp;&nbsp;<a href='?action=fail&id={$item['id']}' class='' onclick=\"return confirm('确定让该任务置为吗？');\" >失败</a>";
                        }
                        echo "
                        <tr>
                            <td>{$item['taskno']}</td>
                            <td>{$item['taskname']}</td>
                            <td>".date("Y-m-d" , $item['startdate'])."</td>
                            <td>".date("Y-m-d" , $item['enddate'])."</td>
                            <td>{$pname}</td>
                            <td>{$tel}</td>
                            <td>".$ts[$item['status']]."</td>
                            <td>{$opDo}</td>
                        </tr>
                        ";
                        endforeach;
                         ?>
                    </table>
                    <div class="pageer">
                        <ul><li>当前显示<span class="red"><?php echo $this->_tpl_vars['pagesize']; ?>
</span>条记录，总共<span class="red"><?php echo $this->_tpl_vars['num']; ?>
</span>条记录</li><?php echo $this->_tpl_vars['splitPageStr']; ?>
</ul>
                        <div class="clear"></div>
                    </div>
                </form>
                </div>
        </div>