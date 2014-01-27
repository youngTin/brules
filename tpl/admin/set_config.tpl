<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>web site config</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="/admin/css/admin.css" rel="stylesheet" type="text/css" />

<div class="m"></div>
<form action="/admin/set_config.php?action=save" method="post">
	<div class="t">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr class="head">
				<td colspan="2">站点全局设置</td>
			</tr>
			<tr class="tr2">
				<td colspan="2">基本设置</td>
			</tr>
			<tr class="line">
				<td width="25%">网站标题</td>
				<td width="75%"><input name="config[title]" type="text" class="input" id="config[title]" value="{$configList.db_title}" size="50"></td>
			</tr>
			<tr class="line">
				<td>站点网址</td>
				<td><input name="config[url]" type="text" class="input" id="config[url]" value="{$configList.db_url}" size="50" />
					<span style="color:#FF0000">(最后面不要加/，请务必设置正确)</span></td>
			</tr>
			<tr class="line">
				<td>网站Email</td>
				<td><input name="config[contact]" type="text" class="input" id="config[contact]" value="{$configList.db_contact}" size="50"></td>
			</tr>
			<tr class="line">
				<td>联系我们Tel</td>
				<td><input name="config[tel]" type="text" class="input" id="config[tel]" value="{$configList.db_tel}" size="50"></td>
			</tr>
			<tr class="line">
				<td>网站ICP备案号</td>
				<td><input name="config[icp]" type="text" class="input" id="config[icp]" value="{$configList.db_icp}" size="50"></td>
			</tr>
			<tr class="line">
				<td>区县配置</td>
				<td>
				<select id="config[borough]" name="config[borough]">
					{html_options options=$borough selected=$configList.db_borough}
				</select></td>
			</tr>
			<tr class="line">
				<td>DEBUG 模式运行网站</td>
				<td><input type="radio" name="config[debug]" value="1" {if $configList.db_debug==1}CHECKED{/if} />
					开启
					<input type="radio" name="config[debug]" value="0" {if $configList.db_debug==0}CHECKED{/if} />
					关闭 <br />
					(不屏蔽程序报错信息，同时开启数据库查询日志，但影响系统速度)</td>
			</tr>
			<tr class="line">
				<td>GZIP 压缩输出</td>
				<td><input type="radio" name="config[gzip]" value="1" {if $configList.db_gzip==1}CHECKED{/if} />
					开启
					<input type="radio" name="config[gzip]" value="0" {if $configList.db_gzip==0}CHECKED{/if}  />
					关闭 <br>
					(允许网站通过 gzip 输出页面,可以很明显的降低带宽需求,但需要客户端支持,并会加大服务器系统开销)</td>
			</tr>
			<tr class="line">
				<td>帮助消息框</td>
				<td><input type="radio" name="config[hidehelp]" value="0" {if $configList.db_hidehelp==0}CHECKED{/if} />
					显示
					<input type="radio" name="config[hidehelp]" value="1"  {if $configList.db_hidehelp==1}CHECKED{/if} />
					隐藏				</td>
			</tr>
			<tr class="line">
				<td>站点语言/编码</td>
				<td><select name="config[lang]" id="config[lang]">
						<option>请选择语言编码</option>
						<option value="utf-8" {if $configList.db_lang=='utf-8'}selected{/if}>utf-8</option>
					</select></td>
			</tr>
			<tr class="line">
				<td>站点Meta关键字</td>
				<td>
				<input type="text" maxlength="255" name="config[metakeyword]" id="config[metakeyword]" size="60" value="{$configList.db_metakeyword}" class="form-text" /></td>
			</tr>
			<tr class="line">
			  <td>站点Meta描述</td>
			  <td>
			  <input type="text" maxlength="255" name="config[metadescrip]" id="config[metadescrip]" size="60" value="{$configList.db_metadescrip}" class="form-text" />
			  </td>
		    </tr>
			<tr class="line">
				<td>站点首页模板</td>
				<td><input name="config[template_index]" type="text" class="input" id="config[template_index]" value="{$configList.db_template_index}" size="50" />
				<img src="/admin/images/selecttpl.png" name="Submit2" onclick="selectTpl('index');" align="absmiddle" style="cursor:pointer" /></td>
			</tr>
			<tr class="line">
				<td>站点默认模板路径</td>
				<td>
				<select id="config[default_tplpath]" name="config[default_tplpath]">
					<option value="tpl/news">选择模板路径</option>
					<option value="tpl/news" {if $configList.db_default_tplpath=='tpl/news'}selected{/if}>news</option>
					<option value="tpl/user1" {if $configList.db_default_tplpath=='tpl/user1'}selected{/if}>user1</option>
					<option value="tpl/user2" {if $configList.db_default_tplpath=='tpl/user3'}selected{/if}>user2</option>
				</select></td>
			</tr>
			<tr class="line">
				<td>忽略Gif图片的缩略</td>
				<td><input type="radio" name="config[skipgif]" value="1"  />
					忽略
					<input type="radio" name="config[skipgif]" value="0" CHECKED />
					不忽略 (部分空间对gif图片的处理存在兼容性问题，如果更新站点出现错误，可以忽略gif图片) </td>
			</tr>
			<tr class="line">
				<td>内容自动分页长度</td>
				<td><input name="config[perpage]" type="text" id="config[perpage]" value="5" size="5" class="input" />&nbsp;k</td>
			</tr>
			<tr class="line">
			  <td>网站尾部信息</td>
			  <td><div><input type="hidden" id="config[footer]" name="config[footer]" value="{$configList.db_footer}" style="display:none" />
	<input type="hidden" id="config[footer]___Config" value="" style="display:none" /><iframe id="config[footer]___Frame" name="config[footer]___Frame" src="../../includes/fckeditor/editor/fckeditor.html?InstanceName=config[footer]&amp;Toolbar=Default" width="650" height="170" frameborder="0" scrolling="no"></iframe></div></td>
		  </tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		<!--
			<tr class="tr2">
				<td colspan="2">系统负载优化设置</td>
			</tr>
			<tr class="line">
				<td>动态查询缓存时间</td>
				<td><input name="config[sqlcache]" type="text" id="config[sqlcache]" value="" size="5" class="input" />
					分钟 (开启缓存将有效降低系统负载，在读取重复的查询时，直接从缓存读取，设置为0表示不启用) </td>
			</tr>
			<tr class="line">
				<td>标签显示页结果数</td>
				<td><input name="config[tagsnum]" type="text" id="config[tagsnum]" value="" size="5" class="input" />
					(标签页相关内容最多读取数量，请合理设置来维持系统低负载运行)</td>
			</tr>
			<tr class="line">
				<td>列表最大静态分页数量</td>
				<td><input name="config[listpage]" type="text" id="config[listpage]" value="" size="5" class="input" />
					(此处设置静态分页的最大值，超出部分为动态显示)</td>
			</tr>
			<tr class="line">
				<td>搜索间隔时间</td>
				<td><input name="config[searchtime]" type="text" class="input" id="config[searchtime]" value="5" size="5" />
					秒</td>
			</tr>
			<tr class="line">
				<td>搜索内容范围</td>
				<td><input name="config[searchrange]" type="text" class="input" id="config[searchrange]" value="" size="5" />
					天(搜索多少天之内的文章)</td>
			</tr>
			<tr class="line">
				<td>搜索最大结果数</td>
				<td><input name="config[searchmax]" type="text" class="input" id="config[searchmax]" value="100" size="5" /></td>
			</tr>
			<tr class="line">
				<td>热门评论天数</td>
				<td><input name="config[commentdays]" type="text" class="input" id="config[commentdays]" value="" size="5" />(多少天之内发表的文章收录到热门评论里面,此功能只应用于评论独立页面)</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="tr2">
				<td colspan="2">伪静态相关规则</td>
			</tr>
			<tr class="line">
				<td>伪静态开启</td>
				<td><input name="config[rewrite]" type="radio" value="1"  />
					开启
					<input type="radio" name="config[rewrite]" value="0" CHECKED />
					关闭 <span style="color:#FF0000">(只有在页面被动态浏览时，伪静态才有开启必要)</span> </td>
			</tr>
			<tr class="line">
				<td>静态目录</td>
				<td><input name="config[rewrite_dir]" type="text" class="input" id="config[rewrite_dir]" value=".php?" /></td>
			</tr>
			<tr class="line">
				<td>静态目录扩展名设置</td>
				<td><input name="config[rewrite_ext]" type="text" class="input" id="config[rewrite_ext]" value=".html" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="tr2">
				<td colspan="2">静态内容发布设置</td>
			</tr>
			<tr class="line">
				<td>生成静态每次操作数量</td>
				<td><input name="config[opnum]" type="text" class="input" id="config[opnum]" value="" size="5"></td>
			</tr>
			<tr class="line">
				<td>全局静态文件发布目录</td>
				<td><input name="config[htmdir]" type="text" class="input" id="config[htmdir]" value="www" size="40"></td>
			</tr>
			<tr class="line">
				<td>静态文件后缀设置</td>
				<td><input name="config[htmext]" type="text" class="input" id="config[htmext]" value="html"></td>
			</tr>
			<tr class="line">
				<td>栏目静态文件分目录规则</td>
				<td><input type="radio" name="config[htmmkdir]" value="1"  />
					按年存储(8/2008/)<br />
					<input type="radio" name="config[htmmkdir]" value="2" checked />
					按月存储(8/2008-8/)<br />
					<input type="radio" name="config[htmmkdir]" value="3"  />
					按日存储(8/2008-8-8/)<br />
					<input type="radio" name="config[htmmkdir]" value="4"  />
					按月优化(0080808/)
				</td>
			</tr>
			-->
			<!--
  <tr class="line">
    <td>附件资源访问域名</td>
    <td><input name="config[attachurl]" type="text" class="input" id="config[attachurl]" value="" size="40" />
      <span style="color:#FF0000">(可将一个独立的域名绑定到附件目录)</span></td>
  </tr>
-->
			<!--
			<tr class="line">
				<td>附件资源存放目录</td>
			<td><input name="config[attachdir]" type="text" class="input" id="config[attachdir]" value="attachment" size="40" />
					(上传的Flash 图片等等资源的保存目录)</td>
			</tr>
			<tr class="line">
				<td>附件保存规则</td>
				<td><input type="radio" name="config[attachmkdir]" value="1" >
					默认(全部存入同一目录,不建议)<br>
					<input name="config[attachmkdir]" type="radio" value="2" >
					按类型存入不同目录<br>
					<input type="radio" name="config[attachmkdir]" value="3" >
					按月份存入不同目录<br>
					<input type="radio" name="config[attachmkdir]" value="4" checked>
					按天存入不同目录 </td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="tr2">
				<td colspan="2">RSS输出设置</td>
			</tr>
			<tr class="line">
				<td>RSS输出内容数量</td>
				<td><input name="config[rss_itemnum]" type="text" class="input" id="config[rss_itemnum]" value="30" size="10" /></td>
			</tr>
			<tr class="line">
				<td>RSS输出图片数量</td>
				<td><input name="config[rss_imagenum]" type="text" class="input" id="config[rss_imagenum]" value="5" size="10" /></td>
			</tr>
			<tr class="line">
				<td>RSS自动更新时间</td>
				<td><input name="config[rss_update]" type="text" class="input" id="config[rss_update]" value="15" size="10" />
					分钟</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="tr2">
				<td colspan="2">首页细节设置</td>
			</tr>
			<tr class="line">
				<td>首页自动更新间隔时间</td>
				<td><input name="config[indexupdate]" type="text" class="input" id="config[indexupdate]" value="1" size="5" />
					分钟(如果设置为0表示不启用自动更新)</td>
			</tr>
			<tr class="line">
				<td>首页调用栏目</td>
				<td><select name="discate[]" size="5" multiple id="discate">

	<option value="2" selected  >&raquo;新闻动态</option><option value="1" selected  >&raquo;培训项目</option><option value="6" selected  >&raquo;考试介绍</option><option value="3" selected  >&raquo;校园生活</option><option value="4" selected  >&raquo;公司相册</option><option value="9" >&raquo;求职就业</option><option value="10" >&raquo;开课通知</option><option value="7" >&raquo;友情链接</option><option value="11" >&raquo;最新公告</option><option value="12" >&raquo;附件下载</option>


					</select>
					(按住Ctrl键进行多选操作,本设置只针对采用默认模板的首页)</td>
			</tr>
			
			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="tr2">
				<td colspan="2">安全设置</td>
			</tr>
			<tr class="line">
				<td>后台验证码开关</td>
				<td><input type="radio" name="config[ckadmin]" value="1"  />
					开启
					<input type="radio" name="config[ckadmin]" value="0" CHECKED />
					关闭</td>
			</tr>
			<tr class="line">
				<td>评论验证码开关</td>
				<td><input type="radio" name="config[ckcomment]" value="1"  />
					开启
					<input type="radio" name="config[ckcomment]" value="0" CHECKED />
					关闭</td>
			</tr>
			<tr class="line">
				<td>后台登录COOKIE失效时间</td>
				<td><input name="config[cktime]" type="text" class="input" id="config[cktime]" value="" size="5">
					分钟
					(在后台多长时间之内没有活动之后，登录自动失效)</td>
			</tr>
			<tr class="line">
				<td>后台登录IP限制</td>
				<td><textarea name="config[loginip]" cols="40" rows="5" id="config[loginip]"></textarea>
					<br />
					后台登录IP限制
					此功能可绑定登录后台的 IP，只有在列表内的 IP 才能登录论坛，创始人不受限制
					可以绑定单个IP地址格式如：192.0.0.1，也可以绑定一段IP格式如：192.0.0
					多个IP "," 分隔。</td>
			</tr>
			<tr class="line">
				<td>网站安全验证参数</td>
				<td><input name="config[hash]" type="text" class="input" id="config[hash]" value="kz@51*Ts3"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			-->
			<tr class="tr2">
				<td colspan="2">图片水印设置</td>
			</tr>
			<tr class="line">
				<td>是否开启图片水印功能</td>
				<td><input type="radio" name="config[ckwater]" value="1" {if $configList.db_ckwater==1}CHECKED{/if} />
					开启
					<input type="radio" name="config[ckwater]" value="0"  {if $configList.db_ckwater==0}CHECKED{/if} />
					关闭</td>
			</tr>
			<tr class="line">
				<td>使用水印类型</td>
				<td><input type="radio" name="config[watertype]" value="overlay" {if $configList.db_watertype=="overlay"}CHECKED{/if} />
					图片水印
					<input type="radio" name="config[watertype]" value="text"  {if $configList.db_watertype=="text"}CHECKED{/if} />
					文字水印</td>
			</tr>
			<tr class="line">
				<td>添加水印的图片大小控制</td>

				<td>
					宽: <input size="5" name="config[waterwidth]" value="{$configList.db_waterwidth}" type="text" class="input">
					高:<input size="5" name="config[waterheight]" value="{$configList.db_waterwidth}" type="text" class="input">只对超过程序设置的大小的附件图片才加上水印图片或文字(设置为0不限制)
				</td>
			</tr>
			<tr class="line">
				<td>水印位置</td>
				<td><input name="config[waterpos]" value="0" type="radio" {if $configList.db_waterpos==0}CHECKED{/if} />中心位置
					<input name="config[waterpos]" value="1" type="radio" {if $configList.db_waterpos==1}CHECKED{/if} />顶部居左
					<input name="config[waterpos]" value="2" type="radio" {if $configList.db_waterpos==2}CHECKED{/if} />底部居左
					<input name="config[waterpos]" value="3" type="radio" {if $configList.db_waterpos==3}CHECKED{/if} />顶部居右
					<input name="config[waterpos]" value="4" type="radio" {if $configList.db_waterpos==4}CHECKED{/if} />底部居右
				</td>
			</tr>
			<tr class="line">
				<td>水印图片文件名</td>
				<td><input type=text name="config[waterimg]" id="config[waterimg]" value="{$configList.db_waterimg}" class="input">
				<img src="/admin/images/select.png" name="Submit3" onclick="selectFile('waterimg');" align="absmiddle" style="cursor:pointer" /> 水印图片存放路径：images/water</td>
			</tr>
			<tr class="line">
				<td>水印文字字体库</td>
				<td><input name="config[watertextlib]" id="config[watertextlib]" value="{$configList.db_watertextlib}" type="text" class="input">
				<img src="/admin/images/select.png" name="Submit4" onclick="selectFile('watertextlib');" align="absmiddle" style="cursor:pointer" /> 请将你的文字库放在libs/encode文件夹下面</td>
			</tr>
			<tr class="line">
				<td>水印图片文字</td>
				<td><input name="config[watertext]" value="{$configList.db_watertext}" type="text" class="input"></td>
			</tr>
			<tr class="line">
				<td>水印图片文字字体大小</td>
				<td><input name="config[waterfont]" value="{$configList.db_waterfont}" type="text" class="input"></td>
			</tr>
			<tr class="line">
				<td>水印图片文字颜色</td>
				<td><input name="config[watercolor]" value="{$configList.db_watercolor}" type="text" class="input">（十六进制颜色值，默认为#FF0000:红色)</td>
			</tr>
			
			<tr class="line">
				<td>水印透明度</td>
				<td><input name="config[waterpct]" value="{$configList.db_waterpct}" type="text" class="input">该值决定图片水印清晰度，其值范围从 0 到 100<br />当使用文字水印，其值从 0 到 127。0 表示完全不透明，127 表示完全透明</td>
			</tr>
			<!--
			<tr class="line">
				<td>图片质量</td>
				<td><input name="config[jpgquality]" value="{$configList.db_jpgquality}" type="text" class="input">该值决定 jpg 格式图片的质量，范围从 0 到 100</td>
			</tr>
			-->
			<!--
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="tr2">
				<td colspan="2">WAP 设置</td>
			</tr>
			<tr class="line">
				<td>是否开启WAP功能</td>
				<td><input type="radio" name="config[wapifopen]" value="1"  />
					开启
					<input type="radio" name="config[wapifopen]" value="0" CHECKED />
					关闭
				</td>
			</tr>
			<tr class="line">
				<td>是否开启WAP功能</td>
				<td><input type="radio" name="config[wapcharset]" value="1"  />
					UTF-8
					<input type="radio" name="config[wapcharset]" value="0" CHECKED />
					UNICODE
				</td>
			</tr>
			<tr class="line">
				<td>WAP 页面长度控制</td>
				<td><input name="config[waplimit]" value="" type="text" class="input">建议设置为：300-2000 之间</td>
			</tr>
			<tr class="line">
				<td>WAP 推荐板块</td>
				<td><table cellspacing='0' cellpadding='0' border='0' width='100%' align='center'><tr><td><input type='checkbox' name='wapcids[]' value='1' >培训项目</td><td><input type='checkbox' name='wapcids[]' value='2' >新闻动态</td></tr><tr><td><input type='checkbox' name='wapcids[]' value='3' >校园生活</td><td><input type='checkbox' name='wapcids[]' value='4' >公司相册</td></tr><tr><td><input type='checkbox' name='wapcids[]' value='6' >考试介绍</td><td><input type='checkbox' name='wapcids[]' value='9' >求职就业</td></tr><tr><td><input type='checkbox' name='wapcids[]' value='11' >最新公告</td></tr></table></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="tr2">
				<td colspan="2">系统时间设置</td>
			</tr>
			<tr class="line">
				<td>默认时区设置</td>
				<td><select name="config[timedf]">
						<option value="-12" >(标准时-12:00) 日界线西</option>
						<option value="-11" >(标准时-11:00) 中途岛、萨摩亚群岛</option>
						<option value="-10" >(标准时-10:00) 夏威夷</option>
						<option value="-9" >(标准时-9:00) 阿拉斯加</option>
						<option value="-8" >(标准时-8:00) 太平洋时间(美国和加拿大)</option>
						<option value="-7" >(标准时-7:00) 山地时间(美国和加拿大)</option>
						<option value="-6" >(标准时-6:00) 中部时间(美国和加拿大)、墨西哥城</option>
						<option value="-5" >(标准时-5:00) 东部时间(美国和加拿大)、波哥大</option>
						<option value="-4" >(标准时-4:00) 大西洋时间(加拿大)、加拉加斯</option>
						<option value="-3.5" >(标准时-3:30) 纽芬兰</option>
						<option value="-3" >(标准时-3:00) 巴西、布宜诺斯艾利斯、乔治敦</option>
						<option value="-2" >(标准时-2:00) 中大西洋</option>
						<option value="-1" >(标准时-1:00) 亚速尔群岛、佛得角群岛</option>
						<option value="111" >(格林尼治标准时) 西欧时间、伦敦、卡萨布兰卡</option>
						<option value="1" >(标准时+1:00) 中欧时间、安哥拉、利比亚</option>
						<option value="2" >(标准时+2:00) 东欧时间、开罗，雅典</option>
						<option value="3" >(标准时+3:00) 巴格达、科威特、莫斯科</option>
						<option value="3.5" >(标准时+3:30) 德黑兰</option>
						<option value="4" >(标准时+4:00) 阿布扎比、马斯喀特、巴库</option>
						<option value="4.5" >(标准时+4:30) 喀布尔</option>
						<option value="5" >(标准时+5:00) 叶卡捷琳堡、伊斯兰堡、卡拉奇</option>
						<option value="5.5" >(标准时+5:30) 孟买、加尔各答、新德里</option>
						<option value="6" >(标准时+6:00) 阿拉木图、 达卡、新亚伯利亚</option>
						<option value="7" >(标准时+7:00) 曼谷、河内、雅加达</option>
						<option value="8" selected>(北京时间) 北京、重庆、香港、新加坡</option>
						<option value="9" >(标准时+9:00) 东京、汉城、大阪、雅库茨克</option>
						<option value="9.5" >(标准时+9:30) 阿德莱德、达尔文</option>
						<option value="10" >(标准时+10:00) 悉尼、关岛</option>
						<option value="11" >(标准时+11:00) 马加丹、索罗门群岛</option>
						<option value="12" >(标准时+12:00) 奥克兰、惠灵顿、堪察加半岛</option>
					</select></td>
			</tr>
			<tr class="line">
				<td>本地时间与网站服务器的时间差</td>
				<td><input name="config[cvtime]" type="text" class="input" id="config[cvtime]" value="0">
					单位(分)</td>
			</tr>
			<tr class="line">
				<td>网站默认时间显示格式</td>
				<td><input name="config[datefm]" type="text" class="input" id="config[datefm]" value="Y-m-d H:i"></td>
			</tr>
			-->
		</table>
	</div>
	<center>
		<input name="step" type="hidden" id="step" value="2">
		<input type="submit" name="Submit" value=" 提 交 " class="btn">
		<input type="reset" name="Submit2" value=" 重 置 " class="btn">
	</center>
</form>


<div style="margin:10px; line-height:150%; text-align:center">
FDKL v3.3 Code &copy; FDKL.CN<br />
Total {$time}(s) query 1 , Gzip disabled <br />
<br />
</div>

{literal}
<script language="javascript">
function IsBrowser(){
	var sAgent = navigator.userAgent.toLowerCase() ;
	if ( sAgent.indexOf("msie") != -1 && sAgent.indexOf("mac") == -1 && sAgent.indexOf("opera") == -1 )
		return "msie" ;
	if ( navigator.product == "Gecko" && !( typeof(opera) == 'object' && opera.postError ) )
		return "gecko";
	if ( navigator.appName == 'Opera')
		return "opera" ;
	if ( sAgent.indexOf( 'safari' ) != -1 )
		return "safari";
	return false ;
}

function selectTpl(name){
	var time = new Date();
	var timestamp = time.valueOf();
	if(IsBrowser()=='msie'){
		objts=showModalDialog("/admin/file_tpl.php?action=index&type="+name+"&inputtype=input&inputname=tpl_index",window,'dialogWidth=650px;dialogHeight=500px;help:no;status:no;');
	}else{
		window.open("/admin/file_tpl.php?action=index&type="+name+"&inputtype=input&inputname=tpl_index","selectimg","width=840,height=500,resizable=no,z-look=yes,alwaysRaised=yes,depended=yes,scrollbars=yes,left=" + (window.screen.width-840)/2 + ",top=" + (window.screen.height-500)/2);
	}
	return;
}

function selectFile(name){
	var time = new Date();
	var timestamp = time.valueOf();
	if(IsBrowser()=='msie'){
		objts=showModalDialog("/admin/file_tpl.php?action="+name+"&type="+name+"&inputtype=input&inputname=tpl_index",window,'dialogWidth=650px;dialogHeight=500px;help:no;status:no;');
	}else{
		window.open("/admin/file_tpl.php?action="+name+"&type="+name+"&inputtype=input&inputname=tpl_index","selectimg","width=840,height=500,resizable=no,z-look=yes,alwaysRaised=yes,depended=yes,scrollbars=yes,left=" + (window.screen.width-840)/2 + ",top=" + (window.screen.height-500)/2);
	}
	return;
}

</script>
{/literal}

