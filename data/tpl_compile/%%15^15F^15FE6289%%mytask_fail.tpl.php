<?php /* Smarty version 2.6.22, created on 2013-04-14 11:58:13
         compiled from mydr/mytask_fail.tpl */ ?>
<div class="myinfo_title">
            <ul><li><a href="?op=doing">进行中的任务</a></li><li><a href="?op=done">已完成任务</a></li><li><a href="?op=wait">未接手任务</a></li><li class="active">失败的任务</li></ul>
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
                        </tr>
                        <?php 
                        $info = $this->_tpl_vars['info'];
                        $ts = $this->_tpl_vars['task_status'];
                        $tt = $this->_tpl_vars['task_type'];
                        foreach($info as $item):
                        
                        echo "
                        <tr>
                            <td>{$item['taskno']}</td>
                            <td>{$item['taskname']}</td>
                            <td>".date("Y-m-d" , $item['startdate'])."</td>
                            <td>".date("Y-m-d" , $item['enddate'])."</td>
                            <td>{$item['pname']}</td>
                            <td>{$item['telephone']}</td>
                            <td>".$ts[$item['status']]."</td>

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