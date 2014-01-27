<?php
/**
* FILE_NAME : house_item.php   FILE_PATH : E:\home+\house_item.php
* 帮助其他
* @author younglly@163.com
* ChengDu CandorSoft Co., Ltd.
* @version 1.0 Tue Mar 13 13:31:21 CST 2012
*/  
require_once('member_config.php');
$smarty = new WebSmarty();
$smarty->caching = false;

switch(isset($_GET['action'])?$_GET['action']:'index')
	{
		case 'list':publish();break;
		case 'view':view();break;
        case 'tools':tools();break;
		case 'adv':adv();break;
		default:index();break;
	}


function index()
{
	global $smarty,$hb;
	$pdo = getPdo();
	$pageSize = 15;
    $offset = 0;
    $subPages=5;//每次显示的页数
    $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
    if($currentPage>0) $offset=($currentPage-1)*$pageSize;
    
	$category_sql = "select * from category where type=1 and mid=1 ";
	
	$category = $pdo->getAll($category_sql);
	
	//当前分类id
	if(isset($_GET['cid']) and $_GET['cid']!=''){
		$cid = intval($_GET['cid']);
	}else{
		$cid = $category[0]['id'];
	}
	//获取当前分类信息列表
	$category_list_sql = "select * from web_contentindex where cid=".$cid;
	$limit = " limit $offset,$pageSize ";
	$category_list = $pdo->getAll($category_list_sql.$limit);
	$count = $pdo->find('web_contentindex','cid='.$cid,'count(id) as count');
	$page_info = "cid={$_GET['cid']}&";
//print_r($categroy_list);
	$page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,3);
	$splitPageStr=$page->get_page_html();
	
	if (intval($_GET['cid'])>0) {
		foreach ($category as $val)
		{
			if($val['id']==$_GET['cid'])$seoTitle = $val['name'];
		}
		
	}
	
	$smarty->assign('num',$count['count']);
	$smarty->assign('pagesize',$pageSize);
    $smarty->assign('splitPageStr', $splitPageStr);
	$smarty->assign('category',$category);
	$smarty->assign('cid',$cid);
	$smarty->assign('category_list',$category_list);

	$smarty->assign('seoTitle','成都二手房资讯-二手房购房流程-二手房交易注意事项-和睦家');
	$smarty->assign('description',$hb['metadescrip']);

	$smarty->show('helper_list.tpl');

}

function view(){
	global $smarty,$hb;
	$para = formatParameter($_GET["sp"], "out"); 
	$res = getPdo()->find('web_contentindex','id='.$para['id'],'mid,cid,title,postdate');
	if($res)
	{
		$tab = 'web_content'.$res['mid'];
		$info = getPdo()->find($tab,'id='.$para['id']);
		$info = array_merge($info,$res);
		$sql= "select * from category where  id=".$res['cid'];
		$cate=getPdo()->getRow($sql);
	}
	$smarty->assign('info',$info);
	if($info['cid']==232){
		//if($res['intro']=='')$res['intro']=$hb['metadescrip'];
		$smarty->assign('seoTitle',$res['title'].'-成都二手房资讯-二手房交易注意事项-成都二手房买卖-和睦家');
        $smarty->assign('keywords',$res['title'].",".$hb['metakeyword']);
		$smarty->assign('description',$res['title'].",".$hb['metadescrip']);
		$smarty->show('helper_view1.tpl');
	}else{
		//if($res['intro']=='')$res['intro']=$hb['metadescrip'];
		$smarty->assign('seoTitle',$res['title'].'-成都二手房资讯-二手房交易注意事项-成都二手房买卖-和睦家');
        $smarty->assign('keywords',$res['title'].",".$hb['metakeyword']);
		$smarty->assign('description',$res['title'].",".$hb['metadescrip']);
		$smarty->assign('cate',$cate);
		$smarty->show('helper_view.tpl');
	}
}

function tools()
{
	global $smarty;
	$smarty->show('tools_new.tpl');
}

function adv()
{
    global $smarty;
    $smarty->show('helper_adv.tpl');
}
?>
