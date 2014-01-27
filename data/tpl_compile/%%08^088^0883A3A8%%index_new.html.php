<?php /* Smarty version 2.6.22, created on 2013-04-08 21:36:42
         compiled from index_new.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'index_new.html', 151, false),array('modifier', 'truncate_utf8', 'index_new.html', 292, false),array('function', 'fp', 'index_new.html', 266, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- Baidu Button BEGIN -->
<script type="text/javascript" id="bdshare_js" data="type=slide&amp;img=7&amp;uid=792971" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
</script>
<!-- Baidu Button END -->
<link rel="stylesheet" href="ui/css/orbit-1.2.3.css" />
<script type="text/javascript" src="ui/js/jquery.orbit-1.2.3.min.js"></script>
<script type="text/javascript" src="ui/js/jquery.nivo.slider.pack.js"></script>
<script type="text/javascript" src="ui/js/jquery.candor.form.search.min.js"></script>
<?php echo '
<script type="text/javascript">
            $(window).load(function() {
                $(\'#slider\').nivoSlider({
                    directionNav:false,
                    pauseTime:5000,
                    pauseOnHover:false,
                    controlNav:false
                });
                $(\'#featured\').orbit({timer:false});
                var $text = \'请输入关键字\',label_arr = [];
                label_arr[\'type-r\'] = \'borough\';
                label_arr[\'type-p\'] = \'price\';
                label_arr[\'type-l\'] = \'circle\';
                label_arr[\'type-t\'] = \'property\';
                $("#search_text").candor({
                    TextContent:$text,
                    LabelArr:label_arr,
                    ShowBody:\'list_body\',
                    ListToA:\'con_list\',
                    ChangeS:\'search_change\',
                    ListDiv:\'list_body\',
                    TextWidth:330
                })
                $("#search").bind(\'submit\',function(){ 
                    if($.trim($("#search_text").val())==\'\'||$.trim($("#search_text").val())==$text)
                    {
                        $("#search_text").remove();
                        return true;
                    }
                    
                })
                var showLoad = function($s){
                    var imgpath = \'ui/images/loading.gif\';
                    if($s==1)
                    {
                        $("#getScore,#getHouse,#getFav,#getCons").html("<img src=\'"+imgpath+"\' >");
                    }
                    else
                    {
                        $("#getScore,#getHouse,#getFav,#getCons").css({\'background\':"none transparent"});
                    }
                    
                }
                var getInfo = function(uid){

                     $.ajax({
                        type:\'post\',
                        dataType:\'json\',
                        url:\'index.php?action=getInfo\',
                        data:{uid:uid},
                        beforeSend: function(){
                            showLoad(1);
                        },
                        success:function($data){ 
                            if($data.status==\'1\')
                            {
                                $("#getScore").html($data.scores);
                                $("#getHouse").html($data.house);
                                $("#getFav").html($data.fav);
                                $("#getCons").html($data.cons);
                            }
                            
                        }
                        
                    });

                }
'; ?>

                <?php if (! $_SESSION['home_username']): ?>
<?php echo '
                $("#login_form").bind(\'submit\',function(){
                    var username = $("#username").val(),pwd = $("#password").val()
                    if(username.length<3||pwd.length<3){showMsg(\'用户名或密码不能为空且大于3位!\');return false;}
                    $.post(\'member_login.php?action=login\',{\'username\':username,\'password\':pwd,\'ajax\':1},function($data){ 
                        if(parseInt($data)>0)
                        {
                            showSuccess(username,$data);return;
                        }
                        switch($data){
                            case \'-1\' : showMsg(\'登录失败!\');break;
                            case \'0\' : showMsg(\'用户名或密码错误!\');break;
                        }
                            
                        
                    })
                    return false;
                })
                var showMsg=function(content){
                    $("#showMsg").html(content).show().fadeOut(5000);return false;
                }
                var showSuccess = function($username,$uid){ 
                    $("#loginName").html($username.substr(0,10)+\'，欢迎您来到和睦家！\');
                    $("#nologin,#noreg").hide();$("#yeslogin,#yesreg").show();
                    getInfo($uid);
                    if($("#subnav-h")&&$("#myHome")){$("#subnav-h").attr(\'id\',\'subnav\');$("#myHome").attr(\'href\',\'member_index.php\').removeAttr(\'onclick\');}
                }
'; ?>

                <?php else: ?>
                    getInfo('<?php echo $_SESSION['home_userid']; ?>
');
                    
                <?php endif; ?>
                
                
<?php echo '
                
            });
            $(document).ready(function(){
                $("#adl").jFloat({
                  position:"couplet",
                  top:80,
                  height:300,
                  width:70,
                  allowClose:true
                });
            })
            
</script>
<style>
#adl{display:none;}
'; ?>

<?php if (! $_SESSION['home_username']): ?>
<?php echo '
#yeslogin{display:none;}#yesreg{display:none;}
'; ?>

<?php else: ?>
<?php echo '
#nologin{display:none;}#noreg{display:none;}
'; ?>

<?php endif; ?>
</style>

<div id="wrapper">
	<div id="main_container">
		<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');
smarty_core_smarty_include_php(array('smarty_file' => "load_nav.php", 'smarty_assign' => '', 'smarty_once' => false, 'smarty_include_vars' => array()), $this); ?>

		<div id="body_container">
        	<div id="top_container">
            	<div class="login">
                        <div class="login_title"><span id="loginName"  title="<?php echo $_SESSION['home_username']; ?>
"><?php if ($_SESSION['home_username']): ?><?php echo ((is_array($_tmp=$_SESSION['home_username'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 10, '', true) : smarty_modifier_truncate($_tmp, 10, '', true)); ?>
，欢迎您来到和睦家！<?php else: ?>和睦家用户登录：<?php endif; ?></span></div>
                        <form action="member_login.php" method="post" id="login_form">
                        <div class="login_form" id="nologin">
                            <div id="showMsg"></div>
                        	<div class="form-item" id="edit-email">
                             <label for="inquiry-email">用户名:</label>
                             <input type="text" maxlength="255" size="20" value="" name="username" id="username" class="form-text" />
                    		</div>
                            <div class="form-item" id="edit-email">
                             <label for="inquiry-email">密 码:</label>
                             <input type="password" maxlength="255" size="20" value="" name="password" id="password" class="form-text" />
                    		</div>
                            <div class="login_msg"><a href="member_forgetpass.php">忘记密码</a></div>
                            <input class="login_btn" type="submit" name="submit" value="登录" />
                        </div>
                        </form>
                        <div class="login_form" id="yeslogin">
                        <!--div style="float:left;width:249px;">
                        </div-->
                        <div style="float:left;width:60px;height:64px;text-align:right" class="title_avatar"><img src="../ui/images/avatar.png" style="border:5px solid #CECECE; background:#EBEEE3"/></div>
                        <ul style="float:left;width:179px;padding-left:10px">
                        	<li style="line-height:22px"><a href="/member_info.php?action=edit_info&do=info" style="float:left;padding:0 15px 0 0;"><span class="f_brown">修改个人资料</span></a><a href="member_index.php?action=exit" style="float:left;margin-right:20px;"><span class="f_brown">退出系统</span></a></li>
                        	<li style="line-height:24px">您当前积分：<span class="f_green f_blod f_14" id='getScore'>&nbsp;</span></li>
                            <li style="line-height:24px">发布房屋：<span class="f_green f_blod f_14" id="getHouse">&nbsp;</span>&nbsp;套</li>
                            <li style="line-height:24px">收藏房屋：<span class="f_green f_blod f_14" id="getFav">&nbsp;</span>&nbsp;套</li>
                            <li style="line-height:24px">查看房东信息：<span class="f_green f_blod f_14" id="getCons">&nbsp;</span>&nbsp;套</li>
                        </ul>
                        <div style="float:left;padding-left:12px;padding-top:2px;font-size:14px;font-weight:bold"><img src="../ui/images/myhomejia.jpg" /></div>
                        </div>
                  <div class="login_regist" id="noreg">
                        	<span>您还没有注册和睦家用户？</span>
							<span><a href="member_reg_new.php<?php if ($_GET['tid'] > 0): ?>?tid=<?php echo $_GET['tid']; ?>
<?php endif; ?>">立即注册</a></span><br />
                            <a href="http://weibo.com/gshlee" target="_blank" title="新浪微博"><img src="../ui/images/icon/sinaweibo.png" height="24"  style="margin-top:5px;"/></a>
							<a href="<?php echo $this->_tpl_vars['code_url']; ?>
"><img src="weibo/images/weibo_login.png" title="点击进入授权页面" alt="点击进入授权页面" border="0" width="120" style="margin-top:7px;" /></a>
							</div>
                        <div class="login_manage" id="yesreg">
                        	<ul>
                            <li><a href="/member_pub.php?action=esf_add&house_type=2">发布出售</a></li>
                            <li><a href="/member_pub.php?action=esf_list&house_type=2">出售管理</a></li>
                            <li><a href="/member_pub.php?action=favorites">收藏管理</a></li>
                            <li><a href="/member_pub.php?action=esf_add&house_type=1">发布出租</a></li>
                            <li><a href="/member_pub.php?action=esf_list&house_type=1">出租管理</a></li>
                            <li><a href="/member_soures.php?action=cons">看房记录</a></li>
                            </ul>
                        </div>
                </div>
                <div class="separator_left"></div>
                <div class="search">
                	<div class="search_pic" id="slider">
                            <a href="helper.php?action=view&sp=aWRgNDQ0"><img src="ui/images/adv1.jpg" alt="" /></a>
                            <a href="helper.php?action=view&sp=aWRgNDQ0"><img src="ui/images/adv2.jpg" alt="" /></a>
                    </div>
                	<div class="search_box">
                        <div class="search_info">
                            <form action="house_list.php" name="search" id="search" class="search_form" method="get">
                                <div class="search_body">
                                    <div class="search_b_l search_con" id="search_change"></div>
                                    <div class="search_b_c search_con" id="search-text-div">
                                        <input type="text" name="keyword" class="search_text" id="search_text" value="请输入关键字" />
                                    </div>
                                </div>
                                <input type="submit"  class="search_button" value="搜索" />
                            </form>
                        </div>
                    </div>
                </div>
                <div class="list_body" id="list_body" tabindex >
                        <div class="con-list" id="con_list">
                            <dl id="type-r">
                                <dt>区域：</dt>
                                <dd>
                                    <?php $_from = $this->_tpl_vars['search']['borough']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                                        <?php if ($this->_tpl_vars['key'] != '0'): ?>
                                        <a data='<?php echo $this->_tpl_vars['key']; ?>
' ><?php echo $this->_tpl_vars['item']; ?>
</a>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                </dd>
                            </dl>
                            <dl id="type-p">
                            <dt>价格：</dt>
                                <dd>
                                    <a  data="0-30">30万以下</a>
                                    <a  data="30-50">30-50万</a>
                                    <a  data="50-80">50-80万</a>
                                    <a  data="80-100">80-100万</a>
                                    <a  data="100-150">100-150万</a>
                                    <a  data="150-200">150-200万</a>
                                    <a  data="200-300">200-300万</a>
                                    <a  data="300-0">300万以上</a>
                                </dd>
                            </dl>
                            <dl id="type-l">
                            <dt>环线：</dt>
                                <dd>
                                    <?php $_from = $this->_tpl_vars['search']['circle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                                        <?php if ($this->_tpl_vars['key'] != '0'): ?>
                                        <a data='<?php echo $this->_tpl_vars['key']; ?>
' ><?php echo $this->_tpl_vars['item']; ?>
</a>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                </dd>
                            </dl>
                            <dl class="last" id="type-t">
                            <dt>类型：</dt>
                                <dd>
                                    <?php $_from = $this->_tpl_vars['search']['property']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                                        <?php if ($this->_tpl_vars['key'] != '20313'): ?>
                                        <a data='<?php echo $this->_tpl_vars['key']; ?>
' ><?php echo $this->_tpl_vars['item']; ?>
</a>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                <div class="separator"></div>
                <div class="agency">
                	<div style="background:url(../ui/images/transfer.gif) no-repeat;width:237px;height:263px;margin-top:13px;float:left;cursor:pointer" onclick="location.href='/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 444), $this);?>
'">
                    	<div style="margin-top:220px;"><a href="/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 444), $this);?>
" style="width:238px;height:50px;background:url(../ui/images/transfer_btn.png) no-repeat;float: left;padding-left: 22px;cursor:pointer;border:none;"></a></div>
                    </div>
                </div>
            </div>
            <div id="mid_container">
            	<div class="user_guide" style="overflow:visible">
                	<ul class="citem">
                    	<li style="width:220px; height:21px; background:url(../ui/images/guohu.jpg) no-repeat"></li>
                        <?php $_from = $this->_tpl_vars['notice']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                        <li><img src="../ui/images/dot_square_green.gif" /><a href="/helper.php?cid=207">[二手房交易]</a><a href="helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => $this->_tpl_vars['item']['id']), $this);?>
"> <?php echo $this->_tpl_vars['item']['title']; ?>
</a></li>
                        <?php endforeach; endif; unset($_from); ?>
                        <li style="height:25px;"><a style="float:right;margin-right:10px;color:#FFF" href="/helper.php">更多<b>...</b></a><img src="../ui/images/more_arrow.gif" style="float:right;margin-top:6px;"/></li>
                    </ul>
                </div>
                <div class="hot_project">
                	<div class="hot_project_title"></div>
                    <div class="hot_project_left"><a class=""><img src="../ui/images/hot_project_left.jpg" class="glide left" /></a></div>
                    <div id="featured">
                    <?php $_from = $this->_tpl_vars['recommend']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['foo']['iteration']++;
?>
                    <?php if (($this->_foreach['foo']['iteration']-1) % 3 == 0): ?>
                        <div class="hot_project_mid">
                            <ul>
                            <?php unset($this->_sections['s']);
$this->_sections['s']['name'] = 's';
$this->_sections['s']['loop'] = is_array($_loop=$this->_tpl_vars['recommend']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['s']['start'] = (int)($this->_foreach['foo']['iteration']-1);
$this->_sections['s']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['s']['max'] = (int)3;
$this->_sections['s']['show'] = true;
if ($this->_sections['s']['max'] < 0)
    $this->_sections['s']['max'] = $this->_sections['s']['loop'];
if ($this->_sections['s']['start'] < 0)
    $this->_sections['s']['start'] = max($this->_sections['s']['step'] > 0 ? 0 : -1, $this->_sections['s']['loop'] + $this->_sections['s']['start']);
else
    $this->_sections['s']['start'] = min($this->_sections['s']['start'], $this->_sections['s']['step'] > 0 ? $this->_sections['s']['loop'] : $this->_sections['s']['loop']-1);
if ($this->_sections['s']['show']) {
    $this->_sections['s']['total'] = min(ceil(($this->_sections['s']['step'] > 0 ? $this->_sections['s']['loop'] - $this->_sections['s']['start'] : $this->_sections['s']['start']+1)/abs($this->_sections['s']['step'])), $this->_sections['s']['max']);
    if ($this->_sections['s']['total'] == 0)
        $this->_sections['s']['show'] = false;
} else
    $this->_sections['s']['total'] = 0;
if ($this->_sections['s']['show']):

            for ($this->_sections['s']['index'] = $this->_sections['s']['start'], $this->_sections['s']['iteration'] = 1;
                 $this->_sections['s']['iteration'] <= $this->_sections['s']['total'];
                 $this->_sections['s']['index'] += $this->_sections['s']['step'], $this->_sections['s']['iteration']++):
$this->_sections['s']['rownum'] = $this->_sections['s']['iteration'];
$this->_sections['s']['index_prev'] = $this->_sections['s']['index'] - $this->_sections['s']['step'];
$this->_sections['s']['index_next'] = $this->_sections['s']['index'] + $this->_sections['s']['step'];
$this->_sections['s']['first']      = ($this->_sections['s']['iteration'] == 1);
$this->_sections['s']['last']       = ($this->_sections['s']['iteration'] == $this->_sections['s']['total']);
?>
                            <li>
                                <a title="<?php echo $this->_tpl_vars['recommend'][$this->_sections['s']['index']]['reside']; ?>
" href="house_item.php?sp=<?php echo WebSmarty::_fp_(array('id' => $this->_tpl_vars['recommend'][$this->_sections['s']['index']]['id'],'house_type' => $this->_tpl_vars['recommend'][$this->_sections['s']['index']]['house_type']), $this);?>
">
                                    <p class="info"><span style="float:right"><?php echo $this->_tpl_vars['recommend'][$this->_sections['s']['index']]['price']; ?>
<?php if ($this->_tpl_vars['recommend'][$this->_sections['s']['index']]['house_type'] == '1'): ?>元/月<?php else: ?>万<?php endif; ?></span><?php echo ((is_array($_tmp=$this->_tpl_vars['recommend'][$this->_sections['s']['index']]['reside'])) ? $this->_run_mod_handler('truncate_utf8', true, $_tmp, 10) : smarty_modifier_truncate_utf8($_tmp, 10)); ?>
</p> 
                                    <img width="117" height="105" alt="icon pack" src="<?php echo $this->_tpl_vars['recommend'][$this->_sections['s']['index']]['image_path']; ?>
">
                                </a>
                            </li>
                            <?php endfor; endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                    </div>
                    <div class="hot_project_right"><a class=""><img src="../ui/images/hot_project_right.jpg" class="glide right" /></a></div>
                    
                </div>
                <div class="recent_activity" style="overflow:visible">
                	<ul class="citem">
                    	<li style="width:220px; height:21px; background:url(../ui/images/huodong.jpg) no-repeat"></li>
                        <?php $_from = $this->_tpl_vars['activity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                        <li><img src="../ui/images/dot_square_green.gif" /><!--a href="/helper.php?cid=230">[最新活动]</a--><a href="helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => $this->_tpl_vars['item']['id']), $this);?>
"> <?php echo $this->_tpl_vars['item']['title']; ?>
</a></li>
                        <?php endforeach; endif; unset($_from); ?>
                        <li style="height:25px;"><a style="float:right;margin-right:10px;color:#FFF" href="/helper.php">更多<b>...</b></a><img src="../ui/images/more_arrow.gif" style="float:right;margin-top:6px;"/></li>
                    </ul>
                </div>
            </div>
            
            <div id="bot_container">
            	<div class="stats">
                    <div class="stats_content">
                    	<span class="stats_content_one">累计节约购房产中介费</span><br />
                        <span class="stats_content_two"><?php echo $this->_tpl_vars['money_num']; ?>
元</span>
                    </div>
                    <div class="stats_content">
                    	<span class="stats_content_one">累计收录个人房源数</span><br />
                        <span class="stats_content_two"><?php echo $this->_tpl_vars['house_num']; ?>
套</span>
                    </div>
                    <div class="stats_content">
                    	<span class="stats_content_one">累计注册购（租）房用户数</span><br />
                        <span class="stats_content_two"><?php echo $this->_tpl_vars['user_num']; ?>
人</span>
                    </div>
                </div>
                <div class="process">
                	<ul class="regist">
                    	<li><img src="../ui/images/dot_square.jpg" /><a href="/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 442), $this);?>
">Home+介绍</a></li>
                        <li><img src="../ui/images/dot_square.jpg" /><a href="/member_reg_new.php">马上注册</a></li>
                    </ul>
                    
                    <ul class="choose">
                    	<li><img src="../ui/images/dot_square.jpg" /><a href="/house_list.php?house_type=2">直接进入选房</a></li>
                        <li><img src="../ui/images/dot_square.jpg" /><a href="/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 443), $this);?>
">积分看房东电话</a></li>
                        <li><img src="../ui/images/dot_square.jpg" />自行与房东联系</li>
                        <li><img src="../ui/images/dot_square.jpg" />现场看房</li>
                    </ul>
                    
                    <ul class="transaction">
                    	<li><img src="../ui/images/dot_square.jpg" />确认合意的房屋</li>
                        <li><img src="../ui/images/dot_square.jpg" /><a href="/helper.php?action=view&sp=<?php echo WebSmarty::_fp_(array('id' => 444), $this);?>
">联系网站代办服务部<br />&nbsp;&nbsp;&nbsp;&nbsp;400-076-1110</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	</div>        
    <div id="adl">
    <a href="/"><img src ="http://drmcmm.baidu.com/media/id=PWT3n1mknjc&gp=403&time=nHn1rHfsPWmkn6.gif" /> </a>
    </div>
</div>