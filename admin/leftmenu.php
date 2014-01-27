<?php	
	require_once('../sys_load.php');
	$verify = new Verify();
	$cid = isset($_GET['cid'])?$_GET['cid']:1;
	$pdo = new MysqlPdo();
	//$category=$pdo->getAll("select * from category where mid>0 and parent_id=0 order by id desc");
	
	if($_SESSION['isAdmin']){
		$categorySql = "select c.id as cid,c.name,c.mid,c.parent_id,c.url from 
					category as c
					where c.flag=1 and c.parent_id=".$cid." order by order_list desc";
	}else{
		//根据用户登录$_SESSION['userId'],得到用户权限
		$categorySql = "select uc.id,c.id as cid,c.name,c.mid,c.parent_id,c.url from 
					admin_category as uc left join category as c on uc.category_id = c.id
					where c.flag=1 and uc.uid=".$_SESSION['userId']." and c.parent_id=".$cid." order by order_list desc";
	}
	$allCategory = $pdo->getAll($categorySql);
	
	if(count($allCategory)){
		//生产二维菜单数组
		$menu = array();
		foreach($allCategory as $key=>$item){
			if(!in_array($item['parent_id'],$menu)){
				$pName = $pdo->getRow('select name from category where flag=1 and id='.$item['parent_id']);
				$menuArray[$item['parent_id']]['pname'] = $pName['name'];
			}
			$menuArray[$item['parent_id']]['child'][] = $item;
		}
		foreach($menuArray as $item){
			$menu[]=$item;
		}
	}else{
		echo "对不起，没有栏目信息！";exit;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Guide Category</title>
</head>
<link rel="STYLESHEET" type="text/css" href="<?php echo URL; ?>/admin/css/admin.css">
<link rel="STYLESHEET" type="text/css" href="<?php echo URL; ?>/admin/css/subMenu.css">
<script type="text/javascript" src="<?php echo URL; ?>/admin/javascript/jquery_last.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>/admin/javascript/plugins/jquery.subMenu.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>/admin/javascript/plugins/jquery.cookie.js"></script>
<script type="text/javascript">
var Mysubmenu=null;
$(function(){
	Mysubmenu=$("#my_menu").submenu({oneSmOnly:false,speed:500,expandNum:5,savestatus:true});	
})
</script>

<base target="mainFrame" />
<body>
<div class="m"></div>
<div style="width: 170px;margin-left:4px; border:1px solid #D2EEFB">
	<div id="my_menu">
			<?php foreach($menu as $item){ ?>
			<div>
				<span><?php echo $item['pname'] ?></span>
				<?php foreach($item['child'] as $item2){ ?>
				<a href="<?php echo $item2['url']; ?>" id="menu_<?php echo $item2['cid']; ?>" onclick="isclick(this);"><?php echo $item2['name']; ?></a>
				<?php } ?>
			</div>
			<?php } ?>
	</div>
</div>
</body>
</html>