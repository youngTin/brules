<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 回收站管理
 * @author ld<luodongdaxia@yahoo.com.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: left.php,v 1.1 2009/08/28 24:45:23
 */

	// 加载系统函数
	require_once('../../sys_load.php');
	
	$verify = new Verify();
	$verify->validate_recycle();

	// 生成Smarty 对象
	$smarty = new WebSmarty;
	$pdo = new MysqlPdo();

	//模板路径,生成后自行修改
	$template_edit = "admin/column/recycle.tpl";

	switch(isset($_GET['action'])?$_GET['action']:'show')
	{
		case 'undo':undo(); //还原
			exit;
		case 'del':del(); //彻底删除
			exit;
		case 'show':show(); //列表页面
			exit;
		default:show();
			exit;
	}

	/**
	 * 还原
	 */
	function undo()
	{
		global $pdo;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 0;
		$rid=$pdo->update(array('cid'=>$para['cid']), DB_PREFIX.'contentindex', "id=".$id);
		$pdo->remove("tid={$id}",DB_PREFIX."recycle");
		page_msg('<font color=green>还原成功！</font>',$isok=true,'recycle.php?action=show&cid='.$para['cid']);
	}
	
	/**
	 * 执行删除
	 */
	function del()
	{
		global $pdo;
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['id']) ? $para['id'] : 0;
		//如果有附件图片，则删除attachindex表中的记录信息
		$pdo->remove("tid={$id} and mid=".$para['mid'],DB_PREFIX."attachindex");
		$pdo->remove("id={$id}",DB_PREFIX."content".$para['mid']);
		$pdo->remove("id={$id}",DB_PREFIX."contentindex");
		$pdo->remove("tid={$id}",DB_PREFIX."recycle");
		page_msg('<font color=green>删除成功！</font>',$isok=true,'recycle.php?action=show&cid='.$para['cid']);
	}

	/**
	 * 输出列表界面
	 */
	function show()
	{
		global $smarty, $pdo, $template_list, $digest_text;
		//得到项目功能分类信息
		$moduleSql="select c.id as cid,c.name,c.mid,c.parent_id,c.depth from category as c where c.mid>0 and c.parent_id=0";
		$menu = $pdo->getAll($moduleSql);
		foreach($menu as $key=>$i){
			$sqlChild = "select c.id as cid,c.name,c.mid,c.parent_id,c.depth from category as c where parent_id=".$i['cid'];
			$child = $pdo->getAll($sqlChild);
			$menu[$key]['child']=$child;
			if(!isset($_GET['cid']))$_GET['cid']=$menu[$key]['cid'];
		}
		$_GET['cid']=isset($_GET['cid'])?$_GET['cid']:0;

		$page_info = "";
		$pageSize = 15;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$where = "where b.cid=".$_GET['cid']." and 1 ";
	   	if($_GET) {
	    	advanced_search($_GET,$page_info,$filter_where);
	    	$where .= $filter_where;
	    }
	    $select_columns = "select %s from ".DB_PREFIX."contentindex as a left join ".DB_PREFIX."recycle as b on a.id=b.tid %s %s %s";
	    
	    $order = "order by deltime desc";
	    $limit = "limit $offset,$pageSize";
	    $count = " count(a.id) as count ";
	    $sql = sprintf($select_columns,'a.id,a.mid,a.title,a.publisher,b.cid,b.admin,b.deltime',$where,$order,$limit);
	    $sqlcount = sprintf($select_columns,$count,$where,'','');
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();

		$smarty->assign('menu',$menu);
		
		//得到类名
		$smarty->assign('className',getClassName($_GET['cid']));
		
		$smarty->assign('cid',$_GET['cid']);

	 	// 查询到的结果
		$smarty->assign('recycleList', $res);
		
		$smarty->assign('count',$recordCount);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);
		// 指定模板
		$smarty->show($template_list);
	}

	/**
	 * 处理get方式传过来的查询条件
	 */
	function advanced_search($Data,&$page_info,&$where)
	{
		global $smarty;
		$where = " ";
		$page_info = "";
		if(isset($Data['cid']) && $Data['cid'] != ""){
			$where .=" and b.`cid` = '{$Data['cid']}'";
			$page_info.="cid={$Data['cid']}&";
			$smarty->assign("cid",$Data['cid']);
		}
		if(isset($Data['title']) && $Data['title'] != ""){
			$where .=" and a.`title` like '%{$Data['title']}%'";
			$page_info.="title={$Data['title']}&";
			$smarty->assign("title",$Data['title']);
		}
	}
	/**
	 * 根据cid获取，新闻模型分类名
	 */
	function getClassName($cid)
	{
		global $pdo;
		$className=$pdo->getRow("select name from category where id={$cid}");
		return $className['name'];
	}
	/**
	 * 根据cid获取，新闻模型mid
	 */
	function getMid($cid)
	{
		global $pdo;
		$Mid=$pdo->getRow("select mid from category where id={$cid}");
		return $Mid['mid'];
	}

?>