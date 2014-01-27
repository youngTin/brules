<?php /* Smarty version 2.6.22, created on 2013-07-15 09:53:37
         compiled from brules/peccancy_myban.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
                        <?php 
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
    </div>
    <div class="clear"></div>
</div>
</div>
<script type="text/javascript">
<?php echo '
$(function(){
    $("#subbutton").bind(\'click\',function(){
        checkInput();             
        if(isCheck)
        {
            $("#form1").submit();
        }
    })
})
'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>