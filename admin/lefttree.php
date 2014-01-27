<?php
	require_once('../sys_load.php');
	$verify = new Verify();
	$pdo = new MysqlPdo();
	//$category=$pdo->getAll("select * from category where mid>0 and parent_id=0 order by order_list desc");
	$column = new Column();
	$category=$column->getWebCategory();//得到网站栏目管理列表
	foreach($category as $key=>$j){
		$isExit = $pdo->getRow('select count(id) as cnt from category where parent_id='.$j['id']);
		if($isExit['cnt']>0){$category[$key]['ischild']=1;}else{$category[$key]['ischild']=0;}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Category Tree</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="<?php echo URL; ?>/admin/css/admin.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:291px;
	top:52px;
	width:248px;
	height:93px;
	z-index:10;
}
.leftmenu td{
	height:28px;
	color:#333333;
	padding-left:30px;
	background-image:url(/admin/images/bg_menu.png);
	background-repeat:no-repeat;
}
.leftmenu a{
	color:#9c8d6b;
	text-decoration:none;
}
.leftH td {
	color:#333;
	padding:2px 0px 3px 20px;
	text-align: left;color:#000000;
	font-size:14px;
	height:25px;
	background:#e6f5ff;
	font-weight:bold;
}
-->
</style>
<link href="<?php echo URL; ?>/admin/images/tree/xtree.css" rel="stylesheet" type="text/css" />
<link href="<?php echo URL; ?>/admin/images/tree/xmenu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo URL; ?>/admin/images/tree/xtree.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>/admin/images/tree/xmlextras.js"></script>

<script type="text/javascript" src="<?php echo URL; ?>/admin/images/tree/xloadtree.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>/admin/images/tree/xmenu.js"></script>
<script language=JavaScript>
var elo;
var loadmenuok=false;
var type = 'main';

function goMain(action) {
	var main = parent.mainFrame;
	var top=parent.topFrame;
	top.document.getElementById('loadMsg').style.display='';
	main.location=action;
}
function goNew(action){
	window.open(action);
	return;
}
function goDel(action){
	var msg = confirm('您确定要删除此栏目么？删除之后所有栏目下数据都将丢失!');
	if(msg){
		goMain(action);
		return;
	}else{
		return;
	}

}
function rightMenu(e,cid) {
	var toolMenu = new WebFXMenu;
	toolMenu.width = 90;
	if(cid == 'root'){
		toolMenu.add(new WebFXMenuItem('新建栏目','javascript:goMain("/admin/category.php?action=add&cid=0")','新建栏目'));
		//toolMenu.add(new WebFXMenuItem('统计内容','javascript:goMain("/admin.php?adminjob=category&action=total")','统计内容数'));
		//toolMenu.add(new WebFXMenuItem('更新首页','javascript:goMain("/admin.php?adminjob=category&action=pubindex")','更新首页'));
		//toolMenu.add(new WebFXMenuItem('批量处理','javascript:goMain("/admin.php?adminjob=category&action=batpub")','批量处理'));
	} else if(cid == 'recycle'){
		toolMenu.add(new WebFXMenuItem('清空回收站','javascript:if(confirm("确定要清空回收站?"))goMain("/admin.php?adminjob=recycle&action=del&type=all");','清空回收站'));
		toolMenu.add(new WebFXMenuItem('还原所有项','javascript:if(confirm("确定要还原所有项目?"))goMain("/admin.php?adminjob=recycle&action=undo&type=all");','还原所有'));
	}else if(cid == 'nopriv'){
		
	} else {
		toolMenu.add(new WebFXMenuItem('添加新内容','javascript:goMain("/admin/column/content.php?action=add&cid='+ cid +'")','新建文档'));
		//toolMenu.add(new WebFXMenuItem('查看此首页','javascript:goNew("/admin.php?adminjob=category&action=viewlist&cid='+ cid +'")','查看首页'));
		//toolMenu.add(new WebFXMenuItem('更新此首页','javascript:goMain("/admin.php?adminjob=category&action=publist&cid='+ cid +'")', '更新栏目首页'));
		toolMenu.add(new WebFXMenuItem('栏目设置','javascript:goMain("/admin/category.php?action=edit&cid='+ cid +'")','栏目设置'));
		toolMenu.add(new WebFXMenuItem('新建栏目','javascript:goMain("/admin/category.php?action=add&cid='+ cid +'")','添加子栏目'));
		//toolMenu.add(new WebFXMenuItem('发布此栏目','javascript:goMain("/admin.php?adminjob=category&action=pubview&cid='+ cid +'")', '发布此栏目'));
		//toolMenu.add(new WebFXMenuItem('更新此栏目','javascript:goMain("/admin.php?adminjob=category&action=pubupdate&cid='+ cid +'")', '更新此栏目'));
		toolMenu.add(new WebFXMenuItem('删除此栏目','javascript:goDel("/admin/category.php?action=del&cid='+ cid +'")', '删除此栏目'));
	}
	var menudata = document.getElementById('menudata');
	menudata.innerHTML = toolMenu ;
	var eve = e || document.event;
	elo=eve.srcElement;
	toolMenu.left = eve.clientX;
	toolMenu.top = eve.clientY+document.body.scrollTop;
	toolMenu.show();

}

/// XP Look
webFXTreeConfig.rootIcon		= "/admin/images/tree/xp/folder.png";
webFXTreeConfig.openRootIcon	= "/admin/images/tree/xp/openfolder.png";
webFXTreeConfig.folderIcon		= "/admin/images/tree/xp/folder.png";
webFXTreeConfig.openFolderIcon	= "/admin/images/tree/xp/openfolder.png";
webFXTreeConfig.fileIcon		= "/admin/images/tree/xp/file.png";
webFXTreeConfig.lMinusIcon		= "/admin/images/tree/xp/Lminus.png";
webFXTreeConfig.lPlusIcon		= "/admin/images/tree/xp/Lplus.png";
webFXTreeConfig.tMinusIcon		= "/admin/images/tree/xp/Tminus.png";
webFXTreeConfig.tPlusIcon		= "/admin/images/tree/xp/Tplus.png";
webFXTreeConfig.iIcon			= "/admin/images/tree/xp/I.png";
webFXTreeConfig.lIcon			= "/admin/images/tree/xp/L.png";
webFXTreeConfig.tIcon			= "/admin/images/tree/xp/T.png";


var rti;
var tree = new WebFXTree("Root","root");
var rtree = new WebFXTree("回收站","recycle","javascript:goMain('/admin/column/recycle.php?action=show')");
rtree.icon		="/admin/images/tree/xp/recycle.png";
rtree.openIcon	="/admin/images/tree/xp/recycle.png";

<?php 	
	foreach($category as $item){
		if($item['ischild']==1){
?>
	tree.add(new WebFXLoadTreeItem("<?php echo $item['name']; ?>", "/admin/categorytree.php?cid=<?php echo $item['id']; ?>","javascript:goMain('<?php echo $item['url']; ?>&cid=<?php echo $item['id']; ?>&mid=<?php echo $item['mid']; ?>');","<?php echo $item['id']; ?>"));
<?php }else{ ?>
	tree.add(new WebFXTreeItem("<?php echo $item['name']; ?>","javascript:goMain('<?php echo $item['url']; ?>&cid=<?php echo $item['id']; ?>&mid=<?php echo $item['mid']; ?>');","<?php echo $item['id']; ?>"));
<?php } } ?>
/*
	tree.add(new WebFXLoadTreeItem("实例效果", "/admin.php?adminjob=tree&action=showXML&cid=9","javascript:goMain('/admin.php?adminjob=content&action=view&cid=9');","9"));
	tree.add(new WebFXTreeItem("友情链接","javascript:goMain('/admin.php?adminjob=content&action=view&cid=7');","7"));
*/
</script>
<body style="overflow-x:hidden;"> 
<div id="menus" style="margin:5px 5px 0 5px;">
<div class="t">
<table border="0" cellspacing="0" cellpadding="0" width=100%>
  <tr class="leftH">
    <td>栏目信息管理</td>
  </tr>

  <tr class="tr">
  	<td style="text-align:left"><a href="categorylist.php" target="mainFrame"><img src="/admin/images/page_nav.png" hspace="2" style="vertical-align:middle;" />栏目结构</a> &nbsp;
	<!--<a href="javascript:goMain('main.php');"><img src="/admin/images/page_view.png" hspace="2" style="vertical-align:middle;margin-left:3px;" />栏目内容</a>--></td>
  </tr>
  <tr class="tr3"><td>
<script>
document.write(tree);
document.write(rtree);
</script>
  </td>
  </tr>

</table>
</div>
</div>
<div id="menudata"></div>
</body>
