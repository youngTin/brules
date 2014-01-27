<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>VeryCMS - Powered by PHPWind.Net</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<link href="/admin/css/admin.css" rel="stylesheet" type="text/css" />
<?php
	require_once('../sys_load.php');
	
	$verify = new Verify();
	$verify->validate_category();

	$pdo = new MysqlPdo();
	$depth=intval(isset($_GET['depth'])?$_GET['depth']:1);
	$up=intval(isset($_GET['up'])?$_GET['up']:0);
	$guide=isset($_GET['guide'])?$_GET['guide']:'ROOT';
	
	//category list
	$category_list=$pdo->getAll("select * from category where mid>0 and parent_id={$up} and depth={$depth} order by order_list desc");
	//系统模型，可以从module表中读取
	$module_list = array('1'=>'新闻资讯','2'=>'旅游景点','3'=>'旅游路线','4'=>'链接模型');
	
	switch(isset($_POST['action'])?$_POST['action']:'')
	{
		case 'edit':edit(); //修改排序
			break;
	}
	
	/**
	 * save category column
	 */ 
	function edit()
	{	
		if(!$_SESSION['edit'])page_msg('你没有权限访问',$isok=false);
		global $pdo;
		//print_r($_POST);exit;
		//new category save
		if (isset($_POST['taxis'])) {
			foreach($_POST['taxis'] as $key=>$item){
				$content = array("order_list"=>$item);
				$pdo->update($content, 'category', "id=".$key);
			}
			$url=$_SERVER['HTTP_REFERER'];
			page_msg($msg='Update successfully!',$isok=true,$url);
			exit;
		}
	}
?>
<body>
<div class="m"></div>
<form action="/admin/categorylist.php" method="post">
  <div class="t">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr class="head">
        <td colspan="7"><?php echo $guide; ?>  <a href="/admin.php?adminjob=category&action=add&up=">增加新栏目</a></td>
      </tr>
      <tr class="tr2">
        <td width="3%">&nbsp;</td>
        <td>CID</td>
        <td>分类名</td>
        <td>内容模型</td>
        <td>排序权重</td>
        <td>&nbsp;</td>
        <td>栏目操作</td>
      </tr>
      <?php foreach($category_list as $key=>$item){ ?>
      <tr class="tr3">
        <td><img src="/admin/images/cate.gif" align="absmiddle" /></td>
        <td><?php echo $item['mid']; ?></td>
        <td><?php echo $item['name']; ?></td>
        <td><?php echo $module_list[$item['mid']]; ?></td>
        <td><input name="taxis[<?php echo $item['id']; ?>]" type="text" class="input" id="taxis[<?php echo $key; ?>]" value="<?php echo $item['order_list']; ?>" size="5" maxlength="2"></td>
        <td>
		<a href="categorylist.php?action=index&depth=<?php echo $item['depth']+1; ?>&up=<?php echo $item['id']; ?>&guide=<?php echo $item['name']; ?>">查看子分类</a> 
		<a href="/admin/category.php?action=add&cid=<?php echo $item['id'];?>">添加子分类</a> 
		<a href="/admin/category.php?action=edit&cid=<?php echo $item['id'];?>">编辑分类</a> 
		<a href="/admin/category.php?action=del&cid=<?php echo $item['id'];?>" onClick="return confirm('确定要删除分类么?');" style="color:#FF0000">删除分类</a></td>
        <td>
		<a href="/admin/column/content.php?action=index&cid=<?php echo $item['id'];?>">查看内容</a> 
		<a href="/admin/column/content.php?action=add&cid=<?php echo $item['id'];?>">添加内容</a>&nbsp;</td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <div class="sub">
    <input name="action" type="hidden" id="action" value="edit">
    <input type="submit" name="Submit" value="提交" class="btn">
  </div>
</form>


<div style="margin:10px; line-height:150%; text-align:center">
LD v1.1 Code &copy; LD.CN<br />
Total 0.031469(s) query 0 , Gzip disabled <br />
<br />
</div>
</body>
</html>

<script language="javascript">
var agt = navigator.userAgent.toLowerCase();
var is_ie = ((agt.indexOf("msie") != -1) && (agt.indexOf("opera") == -1));
var is_gecko= (navigator.product == "Gecko");
var top=parent.topFrame;
if(typeof(top)=='object'){
	var loadMsg=top.document.getElementById('loadMsg');
	if(loadMsg!=undefined){
		loadMsg.style.display='none';
	}
}
</script>

