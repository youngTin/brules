<?php /* Smarty version 2.6.22, created on 2013-03-10 18:49:14
         compiled from mydr/mytask_wait.tpl */ ?>
<div class="myinfo_title">
            <ul><li><a href="?op=doing">进行中的任务</a></li><li><a href="?op=done">已完成任务</a></li><li class="active">未接手任务</li><li><a href="?op=fail">失败的任务</a></li></ul>
        </div>
        <div class="mytask_content">
            <div class="search-list">
                <form action="member_deal.php" method="post">
                    <table width="100%">
                        <tr>
                            <th>任务名称</th>
                            <th>发布时间</th>
                            <th>价格</th>
                            <th>姓名</th>
                            <th>电话</th>
                            <th>任务状态</th>
                            <th>手动设置</th>
                        </tr>
                        <?php 
                        $info = $this->_tpl_vars['info'];
                        $ts = $this->_tpl_vars['task_status'];
                        $tt = $this->_tpl_vars['task_type'];
                        $tr = $this->_tpl_vars['type_radio'];
                        $meo = $this->_tpl_vars['min_expectprice_option'];
                        $ttn = $this->_tpl_vars['task_type_name'];
                        foreach($info as $item):
                        
                        echo "
                        <tr>
                            <td>".$tr[$item['type']]."&nbsp;".$item['score']."&nbsp;分</td>
                            <td>".date("Y-m-d" , $item['addtime'])."</td>
                            <td>".$meo[$item['min_expectprice']]."</td>
                            <td>{$item['linkman']}</td>
                            <td>{$item['tel']}</td>
                            <td>".$ttn[$item['type']]."</td>
                            <td><a href='pub.html?did={$item['id']}' class='' >修改</a>&nbsp;&nbsp;&nbsp;<a href='pub.html?action=deal&did={$item['id']}' class='' onclick=\"return confirm('确定删除该任务吗？');\" >删除</a></td>
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