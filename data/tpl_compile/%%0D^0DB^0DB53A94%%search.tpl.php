<?php /* Smarty version 2.6.22, created on 2013-04-14 13:35:06
         compiled from mydr/search.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="/ui/js/Tin.js.min.js" ></script>
<script type="text/javascript" src="/ui/js/datepicker/WdatePicker.js" ></script>
<div class="center-box">
<div class="note-header">
    当前位置：<a>查询</a>
</div>
<div class="c-content">
    <h4>搜索结果</h4>
    <div class="search-list">
    <form action="member_deal.php" method="post">
        <table width="100%">
            <tr>
                <th>序号</th>
                <th>姓名</th>
                <th>驾照所在地</th>
                <th>处理所在地</th>
                <th>驾照类别</th>
                <th>领证日期</th>
                <th>可扣份数</th>
                <th>价格区间</th>
                <th>预定</th>
            </tr>
            <?php 
            $info = $this->_tpl_vars['info'];
            if(count($info)<=0)
            echo "<tr><td colspan='10'><span class='gray'>所在条件下无信息</span></td></tr>";
            else
            foreach($info as $item):
            
            $values1 = array($item['in_province'],$item['in_city'],$item['in_dist']);
            $values2 = array($item['on_province'],$item['on_city'],$item['on_dist']);
            echo "
            <tr>
                <td>{$item['id']}</td>
                <td>{$item['linkman']}</td>
                <td>".showdistricts($values1, '', '','',true)."</td>
                <td>".showdistricts($values2, '', '','',true)."</td>
                <td>{$this->_tpl_vars['crecate'][$item['crecate']]}</td>
                <td>{$item['licensdate']}</td>
                <td>{$item['score']}</td>
                <td>{$this->_tpl_vars['min_expectprice'][$item['min_expectprice']]}</td>
                <td><a class='red' onclick='booking({$item['id']})' >预定</a></td>
            </tr>
            ";
            endforeach;
             ?>
        </table>
        <div class="pageer">
            <ul><li>当前显示<span class="red"><?php echo $this->_tpl_vars['pagesize']; ?>
</span>条记录，总共<span class="red"><?php echo $this->_tpl_vars['num']; ?>
</span>条记录</li><?php echo $this->_tpl_vars['subPages']; ?>
</ul>
            <div class="clear"></div>
        </div>
    </form>
    </div>
</div>
</div>
<script type="text/javascript">
<?php echo '       
    function booking(id)
    {
         markG(\'booking\',id);
    }
    
    function bookingInfo(id)
    {
       
        var tel = /^\\d{11}|(\\d{3,4}-\\d{7,8}(-\\d+)*)$/,$issub = true,telval = $("#tel").val(); 
        if($("#pname").val().length<=0){$issub = false;showMsg(\'联系人必须\',false,\'pnames\');return false;}
        if(!tel.test(telval)){$issub = false;showMsg(\'手机必须\',false,\'tels\');return false;}
        if($issub)
        {
            var url = "&pname="+$("#pname").val();
                url += "&tel="+$("#tel").val();
            markG(\'buy&isconfirm=yes\'+url,id,\'itemTs\',\'itemT\');
        }  
    }
'; ?>

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "mydr/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>