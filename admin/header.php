<?php
	require_once('../sys_load.php');
	new Verify();
	$pdo = new MysqlPdo();
	if($_SESSION['isAdmin']){
		$category=$pdo->getAll("select * from category where mid=0 and parent_id=0 and id<>5 and flag=1 order by id asc");
	}else{

		$category=$pdo->getAll("SELECT * FROM `category` WHERE id in (SELECT b.parent_id FROM `admin_category` as a left join `category` as b on a.category_id=b.id where a.uid=".$_SESSION['userId']." and b.mid=0 and b.parent_id<>5 group by b.parent_id union SELECT b.id  FROM `admin_category` as a left join `category` as b on a.category_id=b.id where a.uid=".$_SESSION['userId']." and b.mid=0 and b.parent_id=0 group by b.parent_id)");
		//print_r($category);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo WEB_TITLE; ?>-后台管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<style>
body { font-size: 12px; background: #fff; margin:0; padding:0;}
.frameTop{
	background: url('images/top_bg.png') top left no-repeat;
	background-color:#cfe2f6;
	height: 45px;
	min-width: 610px;
	width: 100%;
	margin: 0 auto;
}
.topLogo{
	float:left;
	height:25px;
	width:280px;
	padding-top:20px;
	background: url('images/logo1.png') top left no-repeat;
}
.nav{
	padding-top: 10px;
	float: right;
	width:380px;
}
.nav a:link,
.nav a:visited,
.nav a:active,
.nav a:hover{
	float: right;
	display: block;
	padding: 6px 8px;
	margin: 0px 10px 0px 0px;
	color: #333;
	text-decoration: none;
}
.nav a:hover{
	color: white;
	background: #8cd6ff;
}
.navPanel{
	background: url('images/bg_btn.png') left repeat-x;
	line-height: 200%;
	border:0px;
	border-top:1px #8cd6ff solid;
}
.innerNavPanel {
	margin: 0 auto;
	width: 800px;
}
.topButtons{
	line-height: 200%;
	white-space: nowrap;
	width: 100%; /* ie6 fix */
	overflow: hidden;
	border-left: 1px solid #8cd6ff;
}
.topButtons a:link,
.topButtons a:active,
.topButtons a:visited,
.topButtons a:hover
{
	float: left;
	display: block;
	padding: 4px 20px;
	color: #333;
	font-size:12px;
	text-decoration: none;
	border-right: 1px solid #8cd6ff;
	border-left: 1px solid #fff;
	background: #F4FBE1 url('images/bg_btn.png');
}
.navActive{
	color: #395500;
	background: #8cd6ff url('images/bg_btn_hover.png') top left repeat-x;
}
.topButtons a:hover
{
	color: #395500;
	background: #8cd6ff url('images/bg_btn_hover.png') top left repeat-x;
}
.topImage {
	float:right;
	padding:5px 8px 5px 0;
	cursor:pointer
}
</style>
<body>
<div class="frameTop">
	<div class="topLogo">&nbsp;&nbsp; <?php echo WEB_TITLE; ?> - 后台管理系统 <?php echo $_SESSION['userName'] ?></div>
	<div class="nav">
		<a href="/admin/admin.php?action=out" title="Login out" target="_parent" onClick="return loginOut();">退出</a>	<a href="#" target="mainFrame">更新首页</a>	<a href="<?php echo URL; ?>/" title="Home page" target="_blank">首页</a></div>
</div>
<div class="navPanel">
	<img src="/admin/images/close.png" class="topImage" onClick="closeSys();" title="关闭本系统">
	<img src="/admin/images/fresh.png" class="topImage" onClick="parent.mainFrame.location.reload();" title="刷新主框架">
	<img src="/admin/images/back.png" class="topImage" onClick="parent.mainFrame.history.go(-1);" title="后退">
	<div class="innerNavPanel">
		<div class="topButtons">
		<?php foreach($category as $item){
				if($item['target']=='mainFrame'){
		?>
				<a href="javascript:void(0);" onclick="ShowContent('<?php echo $item['url']; ?>');"><?php echo $item['name']; ?></a>
				<?php }else{ ?>
				<a href="javascript:void(0);" onclick="ShowMenu('leftmenu',<?php echo $item['id']; ?>);"><?php echo $item['name']; ?></a>
		<?php }} ?>
		<a href="javascript:void(0);" onclick="ShowMenu('lefttree',0);">信息管理</a>
	</div>
	</div>
</div>
<div style="position:absolute;padding:5px;top:10px; right:45%;border:#98b1c8 1px solid; background-color:#ffffe1; z-index:60; display:none" id="loadMsg"><img src="/admin/images/loading.gif" align="absmiddle"/>&nbsp;<span id="spnMsg">Data loading，Please wait...  </span></div>
</body>
{literal}
<script language="javascript">
function ShowMenu(nav,cid){
	var left = parent.leftFrame;
	//var main = parent.mainFrame;
	left.location=nav+'.php'+'?cid='+cid;
	//main.location='main.php';
}
function ShowContent(url){
	var main = parent.mainFrame;
	main.location=url;
}
function closeSys(){
	var msg = confirm('您确认要离开本管理系统么?');
	if(msg){
		parent.close();
	}else{
		return false;
	}
}
function loginOut(){
	var msg = confirm("确定要退出系统么？");
	if(!msg){
		return false;
	}
/*
	var out=new XHR('out');
	var url ='$admin_file?adminjob=login&action=out';
	out.get(url);
*/
}

function out(res){
	if(	res == 'ok'){
		SetCookie("Adminuser",'',0);
		parent.location.href = "$admin_file";
		//parent.location.reload();
		return false;
	}else{
		alert('数据异常，无法退出登录，请直接关闭网页');
	}
}
</script>
{/literal}