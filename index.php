<?php

	session_start();
	// 加载系统函数
	require_once('sys_load.php');
	require_once('data/cache/base_code.php');
    Header("Location: index.shtml");  
	$smarty = new WebSmarty();
	$smarty->caching = false;
	switch(isset($_REQUEST['action'])?$_REQUEST['action']:'index')
	{
		case 'index':index(); //首页页面
			exit;
		case 'detail':detail();
			exit;
		case 'url':url_();
			exit;
		case 'getInfo':getInfo();break;
		default:index();
			exit;
	}

	
	/**
	 * 首页页面
	 */
	function index()
	{
		global $smarty,$borough_option,$circle_option,$hb,$code_url;
		$pdo = getPdo();
		//搜索内容
		$code = new BaseCode();
		//区域
		$search['borough'] = $borough_option;
		//环线
		$search['circle'] = $circle_option;
		//类型
		$search['property'] =  $code->getPairBaseCodeByType(203);
		//用户须知
		$sql = 'select id,title from web_contentindex where cid=207 order by id desc limit 5';
		$notice = $pdo->getAll($sql); 
		//最新活动
		$sql = 'select id,title from web_contentindex web_contentindex where cid=230 order by id desc limit 5';
		$activity = $pdo->getAll($sql);

		//最热房源，对于数据库is_recommend字段
		$sql = 'select id,title,price,reside,image_path from home_esf where flag=1 and is_recommend=1 and image_path<>"" order by id desc limit 10';
		$recommend = $pdo->getAll($sql);
		foreach ($recommend as $i=>$val){ 
			if($recommend[$i]['house_type']==1){
				$recommend[$i]['price'] = substr($recommend[$i]['price'],0,-3);
			}else{
				$recommend[$i]['price'] = str_replace(".00","",$recommend[$i]['price']);
			}
		}
		$all_price = $pdo->getRow("select sum(price) as cnt from home_esf where house_type=2");
		$transaction_price = 834300;
		if(ceil($all_price['cnt'])>0)$transaction_price = floor($all_price['cnt']*10000*0.00017);
		
		//首页统计信息
		$user_num = $pdo->getRow("select count(*) as cnt from home_user");
		$house_num = $pdo->getRow("select count(*) as cnt from home_esf");

		$smarty->assign('money_num',$transaction_price);
		$smarty->assign('user_num',$user_num['cnt']+BASE_NUMBER);
		$smarty->assign('house_num',$house_num['cnt']+intval(BASE_NUMBER/8));
		
		$smarty->assign('search',$search);
		$smarty->assign('notice',$notice);
		$smarty->assign('activity',$activity);
		$smarty->assign('recommend',$recommend);
        $seoT = str_replace(',','|',$hb['metakeyword']);
        $smarty->assign('seoTitle',$seoT."-Home+和睦家网");
		$smarty->assign('keywords',$hb['metakeyword'].",和睦家");
		$smarty->assign('description',$hb['metadescrip']);

		$smarty->show("index_new.html");
	}

	//更改image路径
	function url_(){		
		global $smarty;
		$pdo = getPdo();
		$sql="select b.esf_id,a.url from home_esf_attach as a
   				left join home_esf_pic as b  on a.id= b.attach_id
  				left join home_esf as c on c.id=b.esf_id 
  				where b.esf_id>0 group by b.esf_id";
		$res = $pdo->getAll($sql);
		for ($k=0;$k<=count($res)-1;$k++){
			$sql="update home_esf set image_path= '".$res[$k]['url']."' where id=".$res[$k]['esf_id'];		
			if($pdo->execute($sql)){
				echo $pdo->getLastInsId()."<br>";
			}
		}
		
	}
	
	/**
	 * 详细页面
	 */
	function detail()
	{
		global $smarty;
		$smarty->show("details.html");
	}
    
	/**
	 * 畅销楼盘
	 * */
	function opening()
	{
		global $pdo,$smarty;
		$page_info = "action=opening&";
		$pageSize = 25;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		$sql = "SELECT	layout_id,project_name,open_date,red_house_price_average,developer,telephone,project_address FROM home_layout_new
				Inner Join home_layout_house ON home_layout_new.id = home_layout_house.layout_id order by open_date desc limit $offset,$pageSize";
		$sqlcount = "SELECT count(home_layout_new.id) as count FROM home_layout_new
					 Inner Join home_layout_house ON home_layout_new.id = home_layout_house.layout_id ";
	   	$res = $pdo->getAll($sql);
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",4);
	   // $page=new Page($pageSize,$recordCount,$sParam['currentPage'],$sParam['subPages'],"?"1$sParam['pageInfoOrder']."p=",4);
	    
		$splitPageStr=$page->get_page_html();
		
		 //获取今日头条
	    $result = $pdo->getAll("select id,title from web_contentindex where cid>0 and digest=3 order by postdate desc limit 5");
		$smarty->assign('news',$result);
			// 查询到的结果
		$smarty->assign('list', $res);
		//print_r($res);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);
		//INDEX 复制过来 最新优惠
		$sql = "select a.layout_id,a.mark,a.content,a.startdate,a.enddate,b.project_name,b.project_address,b.telephone from ".DB_PREFIX_HOME."layout_dynamic as a 
				left join ".DB_PREFIX_HOME."layout_new as b on a.layout_id=b.id where a.mark<=2 and a.flag=9 order by a.create_at desc  limit 12";
	   	$openHouseArray = $pdo->getAll($sql);
	   	$smarty->assign('openHouseArray',$openHouseArray);
		$smarty->show('newhouse/opening.tpl');
	}
	/**
 	* 优惠动态
 	* */
	function dynamic()
{
			global $pdo,$smarty;
		$page_info = "action=dynamic&";
		$pageSize = 25;
		$offset = 0;
		$subPages=5;//每次显示的页数
		$currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
		if($currentPage>0) $offset=($currentPage-1)*$pageSize;
		//INDEX 复制过来
		$sql = "select a.layout_id,a.mark,a.content,a.startdate,a.enddate,b.project_name,b.project_address,b.telephone from ".DB_PREFIX_HOME."layout_dynamic as a 
				left join ".DB_PREFIX_HOME."layout_new as b on a.layout_id=b.id where a.mark<=2 and a.flag=9 order by a.create_at desc  limit $offset,$pageSize";
		$sqlcount = "select count(a.layout_id) as count from ".DB_PREFIX_HOME."layout_dynamic as a 
					left join ".DB_PREFIX_HOME."layout_new as b on a.layout_id=b.id where a.mark<=2 and a.flag=9 order by a.create_at desc ";
	   	$res = $pdo->getAll($sql);
		foreach ($res as $k=>$v)
		{
			//住宅开盘时间
			$temp=$pdo->getRow("select open_date from `home_layout_house` where layout_id='".$v['layout_id']."'"); //开盘时间 顺序住宅-写字楼-别墅-商业
			$res[$k]['open_date'] = $temp['open_date'];
			if (!$temp['open_date'])
			{
				$temp=$pdo->getRow("select open_date from `home_layout_facilities_inner` where layout_id='".$v['layout_id']."'"); //写字楼
				$res[$k]['open_date'] = $temp['open_date'];
				if (!$temp['open_date'])
				{
					$temp=$pdo->getRow("select open_date from `home_layout_villa` where layout_id='".$v['layout_id']."'"); //别墅
					$res[$k]['open_date'] = $temp['open_date'];
					if (!$temp['open_date'])
					{
						$temp=$pdo->getRow("select open_date from `home_layout_business` where layout_id='".$v['layout_id']."'"); //商业
						$res[$k]['open_date'] = $temp['open_date'];
					}
				}
			}

		}
	   	$Count = $pdo->getRow($sqlcount);
		$recordCount = $Count['count'];
	    $page=new Page($pageSize,$recordCount,$currentPage,$subPages,"?".$page_info."p=",4);
	   // $page=new Page($pageSize,$recordCount,$sParam['currentPage'],$sParam['subPages'],"?"1$sParam['pageInfoOrder']."p=",4);
	    
		$splitPageStr=$page->get_page_html();
		//首页中间版块(最近开盘)，从住宅表(home_layout_house)中获取最近开盘的11个楼盘
		$openHouseSql = "select a.layout_id,a.price_average,a.open_date,b.project_name,b.borough from ".DB_PREFIX_HOME."layout_house as a left join ".DB_PREFIX_HOME."layout_new as b on a.layout_id=b.id order by a.open_date desc limit 12";
		$openHouseArray = $pdo->getAll($openHouseSql);
		$smarty->assign('openHouseArray',$openHouseArray);
		 //获取今日头条
	    $result = $pdo->getAll("select id,title from web_contentindex where cid>0 and digest=3 order by postdate desc limit 5");
		$smarty->assign('news',$result);
			// 查询到的结果
		$smarty->assign('list', $res);
		//print_r($res);
		// 显示分页信息
		$smarty->assign('splitPageStr', $splitPageStr);
		$smarty->show('newhouse/dynamic.tpl');
}
	//根据id获取房型
	function getFitment($id) {
	    //详细信息
	    global $pdo;
	    if (empty($id)) {
	    	return false;
	    }
	    $result = $pdo->getRow("SELECT a.*,b.name FROM ".DB_PREFIX_HOME."esf as a left join ".DB_PREFIX_HOME."code_basic as b on a.fitment=b.code where a.id=$id");
	      //房型
       $type=explode(',',sprintf(",%s室,%s厅,%s卫,%s阳台",$result['room'],$result['parlor'],$result['toilet'],$result['porch']));
       $key = array_search('0室',$type);
       $key1 = array_search('0厅',$type);
       $key2 = array_search('0卫',$type);
       $key3 = array_search('0阳台',$type);
       if($key=='1' || $key1=='2' || $key2=='3' || $key3=='4')
       {
           unset($type[0]);
           unset($type[$key]);
           unset($type[$key1]);
           unset($type[$key2]);
           unset($type[$key3]);
       }
        $type = implode("'",$type);
        $comma_separated = ereg_replace("'",'',$type);
        return $comma_separated;
	}
	//获取信息
	function getInfo()
	{	
		$uid=$_POST['uid'];
		if($uid>0)
		{
			
			//获取积分、房屋数
			$sql = " select total_integral, total_publish from ".DB_PREFIX_HOME."member where uid = '$uid' ";
			$res1 = getPdo()->getRow($sql);
			//获取收藏数
			$sql = " select count(id) as fav from ".DB_PREFIX_HOME."user_favorites where uid = '$uid' ";
			$res2 = getPdo()->getRow($sql);
//			//获取花费积分查看房东数
			$sql = " select count(id) as cons from ".DB_PREFIX_HOME."user_cons where uid = '$uid' ";
			$res3 = getPdo()->getRow($sql);
			$res['scores'] = intval($res1['total_integral']);
			$res['house'] = intval($res1['total_publish']);
			$res['fav'] = $res2['fav'];
			$res['cons'] = $res3['cons'];
			$res['status'] = '1';
			$res['uid'] = $uid;
			echo json_encode($res);exit;
		}
		exit('0');
	}
?>
