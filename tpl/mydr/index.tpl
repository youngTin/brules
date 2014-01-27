{include file="mydr/header.tpl"}

        <div class="pwrap">
            <div class="phead">
                <h3 class="ptitle">用户中心</h3>
            </div>
            <div class="pbody">
                <div class="pbox">
                    <div class="clearfix box-userinfo">
                        <div class="clearfix">
                        <div class="left">
                            <ul class="info">
                                <li>用户名：<strong>{$smarty.const.USERNAME}</strong></li>
                                <li>手机帐户：{if $userinfo.tel!=''}{$userinfo.tel}{else}<a href="myinfo.html">未设置</a>{/if}</li>
                                <li><span>进行中任务(<a href="mytask.html" class="red">{$doing|default:0}</a>)</span><span>已完成任务(<a href="mytask.html?op=done" class="red">{$done|default:0}</a>)</span><span>等待接手任务(<a href="mytask.html?op=wait" class="red">{$wait|default:0}</a>)</span></li>
                            </ul>
                        </div>
                        <div class="floatright finance">
                            <div class="floatleft balance">
                                账户余额：<strong class="larger2 orange">{$userinfo.now_gold}</strong> 元
                            </div>
                            <div class="floatright recharge">
                                <a href="buy.html">充 值</a>
                            </div>
                            <div class="clear clearfix detail">
                                <span class="floatleft">推广佣金：<span class="orange">{$userinfo.in_gold|default:0}</span> 元 [ <a href="">提现</a> ]</span>
                              
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pwrap">
            <div class="phead">
                <h3 class="ptitle">最新发布信息</h3>
            </div>
            <div class="pbody">
                <div class="pbox pbox-shaddow">
                    <div class="user-guide" style="height: 108px;overflow: hidden;" id="dmarq">
                        
                        {php}
                        $drinfo = $this->_tpl_vars['drinfo'];
                        $i =0;
                        foreach($drinfo as $item):
                            if($i%6==0)$ul .= '<ul class="clearfix dmarquee">';
                            $values = array($item['on_province'],$item['on_city'],$item['on_dist']);
                            $ul .= "<li><span>".date("Y-m-d H:i",$item['addtime'])."&nbsp;&nbsp;".showdistricts($values, '', '','',true)."&nbsp;&nbsp;{$item['linkman']}&nbsp;".$this->_tpl_vars['type_radio'][$item['type']]."&nbsp;{$item['score']}分<a href=\"search.html?action=show&id=".$item['id']."\">预订</a></span></li>";
                            if(($i+1)%6==0) $ul .='</ul>';
                         $i++;
                        endforeach;
                        echo $ul;
                        {/php}
                        
                    </div>
                </div>
            </div>
        </div><div class="pwrap">
            <div class="phead">
                <h3 class="ptitle">服务概况</h3>
            </div>
            <div class="pbody">
                <div class="pbox pbox-shaddow">
                    <div class="user-guide">
                        <ul class="clearfix">
                        {foreach from=$info item=item}
                            <li><a target="_blank" href="help.html?id={$item.id}">{$item.title}</a></li>
                        {/foreach}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
{include file="mydr/footer.tpl"}