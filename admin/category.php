<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>LD-EditCategory</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="/admin/css/admin.css" rel="stylesheet" type="text/css" />
<?php
	require_once('../sys_load.php');
	//start time
	$time_start = getmicrotime();

	$verify = new Verify();
	$verify->validate_category();

	$pdo = new MysqlPdo();
	$cid=intval(isset($_GET['cid'])?$_GET['cid']:0);
	//正常发布此栏目type=1 不需要栏目页面type=0,默认0
	$type=0;
	//all category
	if($_SESSION['isAdmin']){
		$category_sql="select * from category where mid>0 and parent_id=0  order by order_list desc";
	}else{
		$category_sql="select c.* from admin_category as uc left join category as c on uc.category_id=c.id where uc.uid=".$_SESSION['userId']." and c.mid>0 and c.parent_id=0  order by c.order_list desc";
	}
	$category=$pdo->getAll($category_sql);

	//all module
	$moduleArray=$pdo->getAll('select * from module');

	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'add':add(); //添加页面
			break;
		case 'edit':edit(); //修改页面
			break;
		case 'save':save(); //修改或添加后的保存方法
			break;
		//case 'index':index(); //列表页面
			//break;
		case 'del':del(); //删除单条记录方法
			break;
		//default:index();
			//exit;
	}

	/**
	 * Delete category column
	 */ 
	function del(){
		if(!$_SESSION['del'])page_msg('你没有权限访问',$isok=false);
		global $pdo,$cid;
		$childCid = "select id from category where id={$cid} or parent_id={$cid}";
		$cidArr = $pdo->getAll($childCid);
		foreach($cidArr as $citem){
			//包括recycle中cid等于该值的所有信息
			$allcontent = $pdo->getAll("select a.id,a.mid from ".DB_PREFIX."contentindex as a left join ".DB_PREFIX."recycle as b on a.id=b.tid where a.cid=".$citem['id']." or b.cid=".$citem['id']);
			//delete contentindex and content table's msg
			foreach($allcontent as $i){
				$pdo->remove("id=".$i['id'], DB_PREFIX."content".$i['mid']);
				$pdo->remove("id=".$i['id'], DB_PREFIX."contentindex");
				$pdo->remove("tid=".$i['id'], DB_PREFIX."recycle");
				//delete web_attachindex table's msg,即相关图片记录信息
				$pdo->remove("tid=".$i['id'], "web_attachindex");
			}
			//delete category table's msg
			$pdo->remove("id=".$citem['id'], "category");
			//delete admin_category table's msg
			$pdo->remove("category_id=".$citem['id'], "admin_category");
		}
		$url='/admin/main.php';
		page_msg($msg='Add category column successfully!',$isok=true,$url);
		exit;
	 }
	
	/**
	 * Add category column view
	 */ 
	function add(){
		if(!$_SESSION['add'])page_msg('你没有权限访问',$isok=false);
		global $pdo,$cid,$category,$moduleArray,$EditOption;
		foreach($category as $key=>$j){
			$child = $pdo->getAll('select * from category where parent_id='.$j['id']);
			if(count($child)>0){
				$category[$key]['ischild']=1;
				$category[$key]['child']=$child;
			}else{
				$category[$key]['ischild']=0;
			}
		}
		$EditOption='new';
	 }
	
	/**
	 * edit category column view
	 */ 
	function edit(){
		if(!$_SESSION['edit'])page_msg('你没有权限访问',$isok=false);
		global $pdo,$cid,$category,$moduleArray;
		global $cInfo,$type,$mid,$id,$EditOption;
		$categorySql = "select * from category where id={$cid}";
		$cInfo = $pdo->getRow($categorySql);
		$type = $cInfo['type'];
		$mid = $cInfo['mid'];
		$id = $cid;
		$cid = $cInfo['parent_id'];
		$EditOption='edit';
	}
	
	/**
	 * save category column
	 */ 
	function save()
	{	
		if(!$_SESSION['save'])page_msg('你没有权限访问',$isok=false);
		global $pdo;
		//new category save
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new') {
			$depth=$pdo->getRow('select depth from category where id='.$_POST['parent_id']);
			$category = array("name"=>$_POST['name'],
							  "mid"=>$_POST['mid'],
							  "parent_id"=>$_POST['parent_id'],
							  "url"=>"/admin/column/content.php?action=index",
							  "description"=>$_POST['description'],
							  "metakeyword"=>$_POST['metakeyword'],
							  "metadescrip"=>$_POST['metadescrip'],
							  "depth"=>$depth['depth']+1,
							  "type"=>$_POST['type'],
							  "tpl_index"=>$_POST['tpl_index'],
							  "tpl_content"=>$_POST['tpl_content']);
			$pdo->add($category, "category");
			$cid=$pdo->getLastInsID();
			//将该功能授予最高管理员
			$pdo->add(array('uid'=>1,'category_id'=>$cid),'admin_category');
			
			$url='/admin/column/content.php?action=index&cid='.$cid.'&mid='.$_POST['mid'];
			page_msg($msg='Add category column successfully!',$isok=true,$url);
			exit;
		}
		//edit category save
		if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit') {
			$depth=$pdo->getRow('select depth from category where id='.$_POST['parent_id']);
			$category = array("name"=>$_POST['name'],
							  "parent_id"=>$_POST['parent_id'],
							  "description"=>$_POST['description'],
							  "metakeyword"=>$_POST['metakeyword'],
							  "metadescrip"=>$_POST['metadescrip'],
							  "depth"=>$depth['depth']+1,
							  "type"=>$_POST['type'],
							  "tpl_index"=>$_POST['tpl_index'],
							  "tpl_content"=>$_POST['tpl_content']);
			$pdo->update($category, 'category', "id=".$_POST['id']);
			$url='/admin/column/content.php?action=index&cid='.$_POST['id'].'&mid='.$_POST['fmid'];
			page_msg($msg='Edit category column successfully!',$isok=true,$url);
			exit;
		}
	}
	
	//End time
	$time_end = getmicrotime();
	$time = $time_end - $time_start;
?>
<base target="mainFrame">
<body>
  <form action="category.php?action=save" method="post" name="editcate">
  <div class="t" style="margin-top:5px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="head">
        <td colspan="2">编辑栏目</td>
      </tr>
      <tr class="tr2">
        <td colspan="2">基本信息[必须填写]</td>
      </tr>
      <tr class="line">
        <td width="20%">上级栏目</td>
        <td width="80%"><select name="parent_id" id="parent_id">
          <option value="0">站点根分类</option>
		  <?php foreach($category as $item){ ?>
		  	<option value="<?php echo $item['id']; ?>" <?php if($item['id']==$cid) echo "selected"; ?> >&raquo;<?php echo $item['name']; ?></option>
			<?php
				if($item['ischild']){ 
					foreach($item['child'] as $item2){
						if($item2['id']==$cid){$select="selected";}else{$select="";}
						echo "<option value='".$item2['id']."' ".$select.">|---".$item2['name']."</option>";
					}
				}
			?>
		  <?php } ?>
          </select></td>
      </tr>
      <tr class="line">
        <td>栏目名称</td>
        <td><input name="name" type="text" class="input" id="name" value="<?php echo @$cInfo['name']; ?>"></td>
      </tr>
      <tr class="line">
        <td>栏目类型</td>
        <td>
		<input type="radio" name="type" value="1" <?php if($type==1) echo "checked='checked'" ?> />正常发布此栏目
		<input type="radio" name="type" value="0" <?php if($type==0) echo "checked='checked'" ?>/>屏蔽此栏目
		</td>
      </tr>
      <tr class="line">
        <td>内容模型</td>
        <td>
		<?php if($_GET['action']=='add'){ ?>
		  <select name="mid" id="mid" onchange="ShowSet(this.value);" >
			<?php foreach($moduleArray as $mItem){
				echo "<option value='".$mItem['mid']."' ".$slt.">".$mItem['mname']."</option>";
			} ?>
          </select>
		<?php }else{ ?>
		  <input type="hidden" name="fmid" id="fmid" value="<?php echo $mid; ?>" /> 
		  <select name="mid" id="mid" onchange="ShowSet(this.value);" disabled >
		    <?php foreach($moduleArray as $mItem){
				if($mid==$mItem['mid']) $slt = "selected"; else $slt = "";
				echo "<option value='".$mItem['mid']."' ".$slt.">".$mItem['mname']."</option>";
			} ?>
          </select>
		<?php } ?>
		</td>
      </tr>
<!--
      <tr>
        <td colspan="2"><div id='more'>
            <div id='blog' style="display:none;">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr class="line">
                  <td width="20%">调用分类ID</td>
                  <td width="80%"><input name="bloginfo[fid]" type="text" class="input" value=""></td>
                </tr>
				<tr class="line">
                  <td>内容页浏览方式</td>
                  <td><input name="bloginfo[viewtype]" type="radio" value="1" >
                    在CMS站点浏览
                    <input name="bloginfo[viewtype]" type="radio" value="0" CHECKED>
                    转入blog浏览</td>
                </tr>

                <tr class="line">
                  <td>是否只调用精华</td>
                  <td><input name="bloginfo[digest]" type="radio" value="1" CHECKED />
                    是
                    <input name="bloginfo[digest]" type="radio" value="0"  />
                    否 </td>
                </tr>
                <tr class="line">

                	<td>调用时间限制</td>
                	<td><input name="bloginfo[postdate]" type="text" class="input" id="bloginfo[postdate]" value="" size="5" />
                		天 </td>
                	</tr>
                <tr class="line">
                	<td>&nbsp;</td>

                	<td>&nbsp;</td>
                </tr>

              </table>
            </div>
            <div id='bbs' style="display:none;">
              <table width="100%" cellpadding="0" cellspacing="0">
                <tr class="line">
                  <td width="20%">调用板块ID</td>
                  <td width="80%"><input class="input" name="bbsinfo[fid]" type="text" value="">
                    (可以用逗号,区分多个版块id,如果留空调用所有板块)</td>

                </tr>
				<tr class="line">
                  <td>内容页浏览方式</td>
                  <td><input name="bbsinfo[viewtype]" type="radio" value="1" >
                    在CMS站点浏览
                    <input name="bbsinfo[viewtype]" type="radio" value="0" CHECKED>
                    转入论坛浏览</td>
                </tr>

                <tr class="line">
                  <td>是否只调用精华</td>
                  <td><input name="bbsinfo[digest]" type="radio" value="1" CHECKED>
                    是
                    <input name="bbsinfo[digest]" type="radio" value="0" >
                    否 </td>
                </tr>
                <tr class="line">

                  <td>主题排序方法</td>
                  <td><input name="bbsinfo[taxis]" type="radio" value="1" >
                    主题时间
                    <input name="bbsinfo[taxis]" type="radio" value="0" >
                    回复时间 </td>
                </tr>
                <tr class="line">
                  <td>调用帖浏览数</td>

                  <td><input name="bbsinfo[hits]" type="text" class="input" id="bbs[hits]" value="" size="5" />
                    (只调用浏览数大于这个值的主题,留空不作限制)</td>
                </tr>
                <tr class="line">
                  <td>调用帖回复数</td>
                  <td><input name="bbsinfo[replies]" type="text" class="input" id="bbs[replies]" value="" size="5" />
                    (只调用回复数大于这个值的主题,留空不作限制)</td>

                </tr>
                <tr class="line">
                  <td>调用主题时间段</td>
                  <td><input name="bbsinfo[postdate]" type="text" class="input" id="bbs[postdate]" value="" size="5" />
                    (只调用多少天以内发表的主题,留空不作限制)</td>
                </tr>
                <tr class="line">
                  <td>调用回复时间段</td>

                  <td><input name="bbsinfo[lastpost]" type="text" class="input" id="bbs[lastpost]" value="" size="5" />
                    (只调用多少天以内回复过的主题,留空不作限制) </td>
                </tr>
              </table>
            </div>
			<div id='link' style="display:none;">
              <table width="100%" cellpadding="0" cellspacing="0">
			       <tr class="line">

						<td width="20%">连接地址</td>
						<td width="80%"><input name="link" type="text"  class="input" id="linkurl" value="" size=50 /> (连接到一个外部网址)</td>
		 			</tr>
			  </table>
			  </div>
          </div></td>
      </tr>
-->
<!--
      <tr class="line">
        <td>栏目类型</td>
        <td><input name="iflink" type="radio" value="0" onclick="document.getElementById('link').disabled='disabled';document.getElementById('advance').style.display='';"  />
          内部栏目
          <input type="radio" name="iflink" value="1"  onclick="document.getElementById('link').disabled='';document.getElementById('advance').style.display='none';"  />
          外部栏目 </td>
      </tr>
-->
    </table>
  </div>
<div id="advance" class="t">
  <table width="100%" cellpadding="0" cellspacing="0">
	<tr class="head">
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr class="tr2">
	  <td colspan="2">高级模式[选择性填写]</td>
	</tr>
	<!--
	<tr class="line">
	  <td width="20%">唯一标识符</td>
	  <td width="80%"><div style="float:right; padding-right:65px;">(可以使用该标识符代替CID进行CMS内容调用,)</div><input name="varname" type="text" class="input" id="varname" value="" /></td>
	</tr>
	-->
	<tr class="line">
	  <td width="20%">栏目简介</td>
	  <td width="80%">
	  <div style="float:right; padding-right:65px;">(栏目的简单描述，可用于Rss输出栏目摘要)</div>
	 <div><input type="hidden" id="description" name="description" value="<?php echo @htmlspecialchars($cInfo['description']); ?>" style="display:none" /><input type="hidden" id="description___Config" value="" style="display:none" />
	   <iframe id="description___Frame" name="description___Frame" src="../includes/fckeditor/editor/fckeditor.html?InstanceName=description&amp;Toolbar=Basic" width="350" height="150" frameborder="0" scrolling="no"></iframe>
	 </div></td>
	</tr>
	<tr class="line">
	  <td>栏目Meta关键字</td>
	  <td><div style="float:right; padding-right:165px;">(有利于搜索引擎的搜索)</div><input name="metakeyword" type="text" class="input" id="metakeyword" value="<?php echo @$cInfo['metakeyword']; ?>" size="50" /></td>
	</tr>
	<tr class="line">
	  <td>栏目Meta描述</td>
	  <td><div style="float:right; padding-right:165px;">(有利于搜索引擎的搜索)</div><input name="metadescrip" type="text" class="input" id="metadescrip" value="<?php echo @$cInfo['metadescrip']; ?>" size="50" /></td>
	</tr>
	<!--
	<tr class="line">
	  <td>内容页发布形式</td>
	  <td><div style="float:right; padding-right:100px;">(是否将栏目文章自动生成Html文件)</div>
		<input type="radio" name="htmlpub" value="0" >
		动态发布
		<input type="radio" name="htmlpub" value="1" CHECKED>
		静态发布 </td>
	</tr>
	<tr class="line">
	  <td>列表页发布形式</td>
	  <td><div style="float:right; padding-right:100px;">(是否将栏目列表自动生成Html文件)</div>
		<input type="radio" name="listpub" value="0"  />
		动态发布
		<input type="radio" name="listpub" value="1" CHECKED />
		静态发布 </td>
	</tr>
	<tr class="line">
	  <td>静态列表页更新时间</td>
	  <td><div style="float:right; padding-right:65px;">(是否将静态栏目列表页栏目首页自动更新)</div>
	  <input name="autoupdate" type="text" class="input" id="autoupdate" value="" size="5" />
	  分钟(0表示关闭)</td>
	</tr>
	<tr class="line">
	  <td>是否自动发布</td>
	  <td><div style="float:right; padding-right:65px;">(添加文章之后自动发布出去还是手动发布)</div>
		<input name="autopub" type="radio" value="1" CHECKED>
		自动发布
		<input type="radio" name="autopub" value="0"  />
		手动发布 </td>
	</tr>
	<tr class="line">
	  <td>是否允许评论</td>
	  <td><input type="radio" name="comment" value="1" CHECKED />
		开启评论
		<input type="radio" name="comment" value="0"  />
		关闭评论</td>
	</tr>
	<tr class="line">
	  <td>是否开启文章水印</td>
	  <td><div style="float:right; padding-right:200px;">(防止文章被复制)</div>
		<input type="radio" name="copyctrl" value="1"  />
		开启水印
		<input type="radio" name="copyctrl" value="0" CHECKED />
		关闭水印</td>
	</tr>
	<tr class="line">
	  <td>静态文件发布点</td>
	  <td><input name="path" type="text" class="input" id="path" value="" size="50" />
		(相对于站点www目录下的子目录,最后不要加斜杠,请不要随意更改)</td>

	</tr>
	-->
	<tr class="line">
	  <td>栏目首页模板</td>
	  <td><input name="tpl_index" type="text" class="input" id="tpl_index" value="<?php echo @$cInfo['tpl_index']; ?>" size="50" />
		<img src="/admin/images/selecttpl.png" name="Submit2" onclick="selectTpl('list');" align="absmiddle" style="cursor:pointer" /></td>
	</tr>
	<tr class="line">
	  <td>内容页模板</td>
	  <td><input name="tpl_content" type="text" class="input" id="tpl_content" value="<?php echo @$cInfo['tpl_content']; ?>" size="50" />
		<img src="/admin/images/selecttpl.png" name="Submit22" onclick="selectTpl('content');" align="absmiddle" style="cursor:pointer" /></td>
	</tr>
	<!--当前版本暂不支持自定义名
<tr class="line">
<td>首页文件名</td>
<td><input name="file_index" type="text" class="input" id="file_index" value="">
(例如index.html)</td>
</tr>
<tr class="line">
<td>内容页文件名命名规则</td>
<td><input name="file_content" type="text"  class="input" id="file_content" value="">
（）</td>
</tr>
<tr class="line">
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
-->
  </table>
</div>
  <div class="sub">
    <input type="hidden" name="EditOption" value="<?php echo $EditOption; ?>">
	<input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
    <input type="submit" name="Submit" value=" 提 交 " class="btn">
  </div>
</form>

<script type="text/JavaScript">
<!--
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
	//window.open('/admin/file_tpl.php?type'+name);
	var time = new Date();
	var timestamp = time.valueOf();
	if(IsBrowser()=='msie'){
		objts=showModalDialog("/admin/file_tpl.php?action=index&type="+name+"&inputtype=input&inputname=tpl_index",window,'dialogWidth=650px;dialogHeight=500px;help:no;status:no;');
	}else{
		window.open("/admin/file_tpl.php?action=index&type="+name+"&inputtype=input&inputname=tpl_index","selectimg","width=840,height=500,resizable=no,z-look=yes,alwaysRaised=yes,depended=yes,scrollbars=yes,left=" + (window.screen.width-840)/2 + ",top=" + (window.screen.height-500)/2);
	}
	return;
}
function ShowSet(value){
	var divname='';
	value = parseInt(value);
	switch(value){
		case -2:
			divname='bbs';
			break;
		case -1:
			divname = 'blog';
			break;
		default:
			break;
	}

	var more = document.getElementById('more');
	var divs = more.getElementsByTagName('div');
	for(var i=0; i<divs.length; i++){
		if(divs[i].id!=divname){
			divs[i].style.display = 'none';
		}else{
			divs[i].style.display = 'block';
		}
	}
	if(divname!=''){
		document.getElementById('advance').style.display="";
		document.getElementById('linkurl').disabled="disabled";
	}else if(value>0){
		document.getElementById('advance').style.display="";
		document.getElementById('linkurl').disabled="disabled";
	}else if(value==0){
		document.getElementById('advance').style.display="none";
		document.getElementById('link').style.display="";
		document.getElementById('linkurl').disabled="";
		document.getElementById('linkurl').focus();
	}else if(value<0){
		document.getElementById('advance').style.display="";
		document.getElementById('linkurl').disabled="disabled";
	}

}
//ShowSet("1");
//-->
</script>

<div style="margin:10px; line-height:150%; text-align:center">
LD v1.1 Code &copy; <br />
Total <?php echo substr($time,0,10); ?>(s) , Gzip disabled <br />
<br />
</div>

</body>
</html>

<script language="javascript">
var top=parent.topFrame;
if(typeof(top)=='object'){
	var loadMsg=top.document.getElementById('loadMsg');
	if(loadMsg!=undefined){
		loadMsg.style.display='none';
	}
}
</script>


