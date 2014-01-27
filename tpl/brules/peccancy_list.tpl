{include file="brules/header.tpl"}
<!--{include file="brules/menu.tpl"}    -->
<style type="text/css">
{literal}
.content{width:980px;margin:10px auto;}
.myinfo{width:100%;}
table td, table th {border:0 none;}
.br-list table{text-align:center;}
.trtitle{background: #e2f2ff;line-height:46px;}
.trcontent{background:#f4f4f4;}
.trtitle th,.trcontent td{padding:10px ;}
.trcontent {border-top:solid 1px #D1DDAA;}
.trcontent td dl {width:280px}
.trcontent td dl dt{float:left;}
.trcontent td dl dd{text-align:left;overflow:hidden;}
.br-total{margin-top:10px;border:solid 1px #ed8900;background:#ffeed6;}
.br-total .brt-01{padding:8px 10px;border-right:solid 1px #ed8900;width:817px;float:left;}
.br-total .brt-awd{width:auto;}
.br-total .brt-01 span{font-size:14px;margin-right:10px;}
.br-total .brt-01 span em{padding:0 5px;color:#ff5a00;font-style:normal;font-weight:600;}
.br-total .brt-01 .brt-total em{font-size:18px;}
.br-total .brt-02{padding:10px;background:url('/ui/img/button_bg.jpg') repeat-x ;float:left;height:19px;width:120px;line-height:19px;text-align:center;color:#FFFFFF;font-size:16px;cursor:pointer;}

{/literal}
</style>
<div class="content">
<script type="text/javascript" src="/ui/js/reg_new.js"></script>
<div class="note-header">
    当前位置：<a>{$brinfo.lpp}{$brinfo.lpno}违章查询结果</a>
</div>


    <div class="myinfo">
        <div class="myinfo_title">
            <ul><li class="active">[{$brinfo.lpp}{$brinfo.lpno}]违章信息</li></ul>
        </div>
        <div class="mytask_content">
            <div class="br-list">
                <form action="member_deal.php" method="post">
                    <table width="100%">
                        <tr class="trtitle">
                            <th align="left"><input type="checkbox" class="checkall" />全选</th>
                            <th>违章信息</th>
                            <th>罚款金额（元）</th>
                            <th>滞纳金额（元）</th>
                            <th>服务费用（元）</th>
                            <th>小计（元）</th>
                            <th>违章扣分（供参考）</th>
                        </tr>
                        {php}
                        $info = $this->_tpl_vars['info'];
                        $bs = $this->_tpl_vars['br_push_status'];
                        foreach($info as $key=>$item):
                            $uptime = $item['uptime']==0 ? "暂无更新" : date('Y-m-d',$item['uptime']) ;
                        echo '
                        <tr class="trcontent">
                            <td align="left"><input type="checkbox" name="bid[]" class="checkbox" value="'.$item['id'].'" /></td>
                            <td>
                                <dl>
                                    <dt>违章时间：</dt><dd>'.date('Y-m-d',strtotime($item['brtime'])).'</dd>
                                    <dt>违章地点：</dt><dd>'.$item['braddress'].'</dd>
                                    <dt>违章原因：</dt><dd>'.$item['brreason'].'</dd>
                                    
                                </dl>
                            </td>
                            <td name="fine">'.$item['fine'].'</td>
                            <td name="zfine">0</td>
                            <td name="sefine">'.(150*$item['marking'] == 0 ? 150 : 150*$item['marking']).'</td>
                            <td>'.(floatval($item['fine'])+100).'</td>
                            <td>'.$item['marking'].'</td>
                        </tr>
                        ';
                        endforeach;
                        {/php}
                    </table>
                    <div class="br-total">
                        <div class="brt-01">
                            <span><input type="checkbox" class="checkall" />全选</span>
                            <span>已选<em id="t-num">0</em>宗， 罚金<em id='t-fine'>0.00</em>元， 服务费<em id='t-sefine'>0.00</em>元。</span>
                            <span class="brt-total">合计：<em id='t-total'>0.00</em>元</span>
                        </div>
                        <div class="brt-02" id="subbutton">马上办理</div>
                        <div class="clear"></div>
                    </div>
                    <div class="pageer">
                        <ul><li>当前显示<span class="red">{$pagesize}</span>条记录，总共<span class="red">{$num}</span>条记录</li>{$splitPageStr}</ul>
                        <div class="clear"></div>
                    </div>
                </form>
                </div>
        </div>
    </div>
    <div class="clear"></div>
<script type="text/javascript">
{literal}
$(function(){
    $("#subbutton").bind('click',function(){
        if($(".checkbox:checked").size()==0)
        {
            showMsg('至少需要选择一项需要办理的违章信息！',false,'itemid');
        }
        else
        {
            var ids = [];
            $(".checkbox:checked").each(function(){
                ids.push($(this).val());
            })
            ids = ids.join('-');
            markG('peccancy.shtml?action=showHandle',ids,'itemT');
        }
    })
    
    $(".checkall").click(function(){
        if(this.checked)
        {
            $(".checkall").attr('checked','checked');
            $(".checkbox").attr('checked','checked');
        }
        else{
           $(".checkbox").removeAttr('checked'); 
           $(".checkall").removeAttr('checked');
        } 
        getSize();
    })
    
    $(".checkbox").click(function(){
        var clen = $(".checkbox:checked").size();
        if(clen==$(".checkbox").size())
        {
            $(".checkall").attr('checked','checked');
        }
        else
        {
            $(".checkall").removeAttr('checked');
        }
        getSize()
    })
})

function getSize()
{
    var fine = 0 , sefine = 0 ;
    $("#t-num").html($(".checkbox:checked").size());
    $(".checkbox:checked").each(function(){
        var f = $(this).parent('td').siblings('td[name="fine"]').html();
        var s = $(this).parent('td').siblings('td[name="sefine"]').html();
        fine += parseFloat(f);
        sefine += parseFloat(s);
    })
    $("#t-fine").html(fine.toFixed(2));
    $("#t-sefine").html(sefine.toFixed(2));
    $("#t-total").html((fine+sefine).toFixed(2));
}

function bookingInfo(id)
{
   
    var tel = /^\d{11}|(\d{3,4}-\d{7,8}(-\d+)*)$/,$issub = true,telval = $("#tel").val(); 
    if($("#pname").val().length<=0){$issub = false;showMsg('联系人必须',false,'pnames');return false;}
    if(!tel.test(telval)){$issub = false;showMsg('手机必须',false,'tels');return false;}
    if($issub)
    {
        var url = "&pname="+$("#pname").val();
            url += "&tel="+$("#tel").val();
        markG('peccancy.shtml?action=doHandle&isconfirm=yes'+url,id,'itemTs','itemT');
    }  
}
{/literal}
</script>
{include file="brules/footer.tpl"}