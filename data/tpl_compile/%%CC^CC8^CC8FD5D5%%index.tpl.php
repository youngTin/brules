<?php /* Smarty version 2.6.22, created on 2013-12-24 10:51:39
         compiled from brules/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'brules/index.tpl', 59, false),array('modifier', 'default', 'brules/index.tpl', 59, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="content">
<link href="/ui/css/index.yi.css" rel="stylesheet" type="text/css" >
<div class="banner">
    
    <ul id="bshow">
        <li class="bs01 cur"><div class="btext"></div></li>
        <li class="bs02"><div class="btext"></div></li>
        <li class="bs03"><div class="btext"></div></li>
        <li class="bs014"><div class="btext"></div></li>
    </ul>
    <p></p>
    <div class="hd-center lbc">
        <div class="loginbox">
            <div class="lb-content">
                <h2>请选择服务类型和服务区域</h2>
                <p>
                    选择服务
                    <span><input type="radio" name="type" id="typ1" checked="checked" />违章代办</span>
                    <span><input type="radio" name="type" id="typ2" />车务服务</span>
                </p>
                <p>
                    选择城市
                    <span class="lb-input">四川<input type="hidden" class="lb-input" name="city" id='city' value="26" /></span>
                </p>
                <p><button class="lb-button" id="lb-sub">点击进行下一步</button></p>
            </div>
            
        </div>
    </div>
    <div class="clear"></div>
</div>

<div class="center-box">
    <div class="search-box">
        <div class="search-head">
            <div class="sh-title">四川省交通违章查询</div>
        </div>
        <div class="search-content">
            <form action="psearch.shtml?action=searchSave" id="searchPen" method="post">
                <input type="hidden" name="s-tel" id="s-tel" value="" />
                <div class="src-cols">
                    <div class="src-rows">
                        <div class="src-title">车牌号码：</div>
                        <div class="src-put"><input class="src-lpp" type="text" name="lpp" id="s-lpp" value="川" readonly="readonly" /><input class="src-lpno"  type="text" name="lpno"  id="s-lpno" value="" maxlength="6" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="src-rows">
                        <div class="src-title">车辆识别码：</div>
                        <div class="src-put"><input class="src-input"  type="text" name="cno" id="s-cno" value="" maxlength="6" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div><div class="src-cols">
                    <div class="src-rows">
                        <div class="src-title">车辆类型：</div>
                        <div class="src-put">
                             <select name="vtype" id="s-vtype" class="src-input src-select">
                                <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['br_car_type'],'selected' => ((is_array($_tmp=@$this->_tpl_vars['info']['vtype'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

                            </select>
                            <div class="lptype">
                                
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="src-rows">
                        <div class="src-title">发动机号：</div>
                        <div class="src-put"><input class="src-input"  type="text" name="engno" id="s-engno" value="" maxlength="6" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div><div class="src-cols">
                    <div class="src-rows">
                        <div class="src-title">验证码：</div>
                        <div class="src-put"><input class="src-input"  type="text" id="s-vercode" name="vercode" value="" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="src-rows">
                        <div class="src-title">&nbsp;</div>
                        <div class="src-put">
                            <div class="src-input src-veriy" >
                                <img src="/includes/validate_code/vdimgck.php" name="ck" align="absmiddle" onclick="this.src=this.src+'?said='+Math.random();" width="80px" height="20px"  id="vdimgck">&nbsp;|&nbsp;<a onclick="$(this).siblings('img').attr('src',$(this).siblings('img').attr('src')+'?said='+Math.random())">刷新</a><span class="loading"><img src="ui/images/loading.gif" alt="" id="loadimg"></span>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="src-cols">
                    <div class="src-sub">
			<input type="hidden" id="isIndex" value="1" />
                        <button type="button" id="psubBtn">违章查询</button>
                    </div>
                    
                </div>
                <div class="clear"></div>
            </form>
            <div class="show-cno" id="show-cno">
                <div class="show-tips">
                    <h3>什么是车辆识别码？</h3>
                    <p>又称车架号，英文简称VIN，可在机动车行驶证主页或在机动车登记证书第2页找到。</p>
                    <h3>为什么要输入？</h3>
                    <p>
                        为保护车主隐私，违章查询时需输入车辆识别代码后6位。
                        <span>输入时请留意：车辆识别码后6位除纯数字以外，倒数第6位还可能是字母。</span>
                    </p> 
                                
                </div>
                <img src="/ui/img/vehicle_cno.png" alt="">
                
            </div>
            
            <div class="show-cno" id="show-engno">
                <div class="show-tips">
                    <h3>什么是发动机号？</h3>
                    <p>是发动机上的编号，可在机动车行驶证主页登记证书第2页找到。</p>
                    <h3>为什么要输入？</h3>
                    <p>为保证快速办理，需提供真实的发动机号码后6位。<span>输入时请留意：部分车辆发动机号后6位除纯数字以外，还包括字母、标点符号等。</span></p>
                                
                                
                </div>
                <img src="/ui/img/vehicle_engno.png" alt="">
                
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>

<div class="center-box">
    <div class="hd-center">
        <div class="cb-main">
            <a href="/serv/yearhelp.shtml" class="cbm-abg1">
                <p class="cbm-head">
                    <span>年检代办</span>违章处理，疑难验车
                </p>
                <p class="cbm-note">上门取、送车，正规代办，省时省力省心</p>
                <p class="cbm-price">
                    <i>¥</i><span>300</span>元起
                </p>
            </a><a href="/serv/driving.shtml" class="cbm-abg2">
                <p class="cbm-head">
                    <span>驾驶证代办</span>快速便捷，服务有保障
                </p>
                <p class="cbm-note">年审、到期换证、降级、外转京等</p>
                <p class="cbm-price">
                    <i>¥</i><span>200</span>元起
                </p>
            </a><a href="/serv/transfer.shtml" class="cbm-abg3">
                <p class="cbm-head">
                    <span>车辆过户</span>专人代办，服务到家
                </p>
                <p class="cbm-note">二手车过户、外迁、外转京、夫妻过户等</p>
                <p class="cbm-price">
                    <i>¥</i><span>200</span>元起
                </p>
            </a><a href="/serv/makeup.shtml" class="cbm-abg4">
                <p class="cbm-head">
                    <span>补办证件</span>专业服务，安心选择
                </p>
                <p class="cbm-note">牌照、行驶证、驾驶证等证件补办</p>
                <p class="cbm-price">
                    <i>¥</i><span>200</span>元起
                </p>
            </a>
        </div>
        <div class="cb-dist">
            <h3>违章查询 / 违章代缴</h3>
            <div class="cbd-content">
                <span>查询省份：</span>
                <span>
                    <a target="_blank" href="/apps/illegal/c/beijing">北京市</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/gansu">甘肃省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/shanxi">陕西省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/jilin">吉林省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/anhui">安徽省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/hunan">湖南省</a>
                    <br>
                    <a target="_blank" href="/apps/illegal/c/fujian">福建省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/heilongjiang">黑龙江省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/guangdong">广东省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/zhejiang">浙江省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/shandong">山东省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/hubei">湖北省</a>
                    <br>
                    <a target="_blank" href="/apps/illegal/c/sanxi">山西省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/guizhou">贵州省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/henan">河南省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/chongqing">重庆市</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/shanghai">上海市</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/sichuan">四川省</a>
                    <br>
                    <a target="_blank" href="/apps/illegal/c/liaoning">辽宁省</a>
                     | 
                    <a target="_blank" href="/apps/illegal/c/jiangsu">江苏省</a>
                </span>
            </div>
            <div class="cb-s"><button class="cbs-button">立即查询</button></div>
        </div>
    </div>
</div>
<?php echo '
<script type="text/javascript">
$(function(){
  $("#lb-sub").bind(\'click\',function(){
    window.location.href = \'/peccancy.shtml\';
  })
  
})

</script>
'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "brules/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>