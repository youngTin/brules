<?php
/**
 * Created on 2008-03-21 
 * 网站栏目树 - JSON 菜单
 * @author ld<luodongdaxia@yahoo.com.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: categorytree.php,v 1.1 2012/02/07 09:03:01 gfl Exp $
 */

// 加载系统函数
require_once('../sys_load.php');

$pdo = new MysqlPdo();

$cid=intval($_GET['cid']);

if($cid){
		$xmlmsg = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n\t<tree>\n";
		if($_SESSION['isAdmin']){
			$child = $pdo->getAll("SELECT * FROM category WHERE parent_id='$cid' order by order_list desc");
		}else{
			$child = $pdo->getAll("select c.* from admin_category as uc left join category as c on uc.category_id=c.id where uc.uid=".$_SESSION['userId']." and c.mid>0 and c.parent_id='$cid'  order by c.order_list desc");
			//$rs = $db->query("SELECT * FROM cms_category WHERE up='$cid' AND cid IN($sqlfathercids)");
		}
		
		foreach($child as $item){
			$item['name'] = htmlspecialchars($item['name']);
			$item['_name'] = msubstr($item['name'],0,8);
			$children = $pdo->getAll("select * from category where parent_id=".$item['id']);
			if(count($children)){
				$xmlmsg.="\t\t<tree text=\"$item[_name]\" action=\"javascript:goMain('$item[url]&amp;cid=$item[id]&amp;mid=$item[mid]');\" cId=\"$item[id]\"  ";
				//$xmlmsg.="\t\t<tree text=\"$child[cname]\" action=\"javascript:goMain('$admin_file?adminjob=content&amp;action=view&amp;cid=$child[cid]');\" cId=\"$child[cid]\"  ";
			}else{
				//$xmlmsg.="\t\t<tree text=\"$item[name]\" action=\"javascript:void(0);\" cId=\"nopriv\"  ";
				$xmlmsg.="\t\t<tree text=\"$item[_name]\"  action=\"javascript:goMain('$item[url]&amp;cid=$item[id]&amp;mid=$item[mid]');\" cId=\"$item[id]\"  ";
			}
			if(count($children)){
				$xmlmsg.="src=\"categorytree.php?cid=$item[id]\"";
				//$xmlmsg.="src=\"$admin_file?adminjob=tree&amp;action=showXML&amp;cid=$child[cid]&amp;timestamp=$timestamp\"";
			}
			$xmlmsg.="/>\n";
		}
		$xmlmsg.="\t</tree>";
		header("Content-type: application/xml");
		print $xmlmsg;
}
?>