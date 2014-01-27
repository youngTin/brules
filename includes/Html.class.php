<?php
/**
 * Created on 2008-03-14
 * 首页
 * @author jctr<jc@cdrj.net.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: Html.class.php,v 1.1 2012/02/07 08:59:18 gfl Exp $
 */

// 加载系统函数
require_once('includes/functions.php');
$smarty = new WebSmarty;
$smarty->caching = false;
$smarty->cache_lifetime = 1800;

$code = new BaseCode();

switch(isset($_GET['action'])?$_GET['action']:'index')
	{
				case 'index':index(); //主界面
					exit;
				case 'pdt':pdt(); //生成页面
					exit;
				case 'login':login(); //首页头部调用的登录信息
					exit;
				default:index();
					exit;
	}

function index(){
		header('Location: '.URL.'index.html');
	}

function login(){
		global $smarty;
		$smarty->show('pagehomelogin.html');
	}

function pdt(){
	/////if(!$smarty->is_cached("index.html"))
	/////{
	ob_start();
	$pdo = new MysqlPdo();
	global $smarty;
	//获取网站楼盘总数
	//新表修改时要把判断是否是在售
	$sql = "SELECT COUNT(id) as layout_cnt FROM `".DB_PREFIX."layout`"." WHERE 1 and status = '22202' and  flag = 1";
	$smarty->assign($pdo->getRow($sql));
	//获取二手房总数
	$sql = "SELECT COUNT(id) as esf_cnt FROM `".DB_PREFIX."esf`"." WHERE house_type = 2";
	$smarty->assign($pdo->getRow($sql));
	//获取出租房总数
	$sql = "SELECT COUNT(id) as rent_cnt FROM `".DB_PREFIX."esf`"." WHERE house_type = 1";
	$smarty->assign($pdo->getRow($sql));
	//查询楼盘讨论贴
	$sql = "
			Select c.* , l.project_name
			From `home_layout_comment` c
				Left Join `home_layout` l On c.layout_id = l.id
			Where 1
				and c.content != ''
			Order by c.id desc
			Limit 0,7
		";
	$smarty->assign("comment", $pdo->getAll($sql));
	//查询楼盘的动态信息 [7条]
		$sql = "
			Select
				distinct d.layout_id as id, d.content, (select l.project_name From `".DB_PREFIX."layout` l Where l.id=d.layout_id) as project_name
			From
				`".DB_PREFIX."layout_dynamic` d
			Where
				1 and d.flag=9 and mark = 1
			Order By
				d.edit_at Desc
			Limit 7
		";

		$dynamic = array();
		$rs = $pdo->getAll($sql);
		for($i=0, $m=sizeof($rs); $i<$m; $i++)
		{
			$sql = "
				Select
					a.url
				From
					`".DB_PREFIX."layout_pic` p
						Left Join `".DB_PREFIX."attach` a On p.attach_id = a.id
				Where
					p.layout_id = {$rs[$i]['id']}
				Order By a.update_at Desc
				Limit 1;
			";
			$_temp = $pdo->getRow($sql);
			$rs[$i]['url'] = $_temp['url'];
			//$dynamic[floor($i/5)][] = $rs[$i];
		}

		$smarty->assign("dynamic", $rs);
	//查询楼盘的动态优惠信息 [5条]
	$sql = "
			Select
				distinct d.layout_id as id, d.content, (select l.project_name From `".DB_PREFIX."layout` l Where l.id=d.layout_id) as project_name
			From
				`".DB_PREFIX."layout_dynamic` d
			Where
				1 and d.flag=9 and mark = 2
			Order By
				d.edit_at Desc
			Limit 7
		";
	$dynamic_mark = $pdo->getAll($sql);
		for($i=0, $m=sizeof($dynamic_mark); $i<$m; $i++)
		{
			$sql = "
				Select
					a.url
				From
					`".DB_PREFIX."layout_pic` p
						Left Join `".DB_PREFIX."attach` a On p.attach_id = a.id
				Where
					p.layout_id = {$dynamic_mark[$i]['id']}
				Order By a.update_at Desc
				Limit 1;
			";
			$_temp = $pdo->getRow($sql);
			$dynamic_mark[$i]['url'] = $_temp['url'];
			//$dynamic[floor($i/5)][] = $rs[$i];
		}
	$smarty->assign("dynamic_mark", $dynamic_mark);
	//点击排行榜
	$sql = "select id,project_name from `".DB_PREFIX."layout` where pm_type like '%22303%' or pm_type like '%22302%' order by hit desc limit 10";
	$smarty->assign("hit", $pdo->getAll($sql));
	//新闻滚动
		$sql = "
			Select
				d.summary as new_summary , p.title as new_title, p.id,p.category_id
			From
				`".DB_PREFIX."doc_publish` p
					Left Join `".DB_PREFIX."doc` d On p.doc_id = d.id
			Where 1
				and category_id = '225'
				Order By p.publish_at desc
			Limit 12
		";
		$smarty->assign("new_roll", $pdo->getAll($sql));
	//新闻
		$sql = "
			Select d.content,
				d.summary as new_summary , p.title as new_title, p.id,p.category_id
			From
				`".DB_PREFIX."doc_publish` p
					Left Join `".DB_PREFIX."doc` d On p.doc_id = d.id
			Where 1
				and category_id = '126'
				and flag = '9'
				Order By p.publish_at desc
			Limit 8
		";
		$smarty->assign("new", $pdo->getAll($sql));
	//预告楼盘
			$sql = "select * from home_layout where (pm_type like '%22303%' or pm_type like '%22302%') and status = '22201'";
			$sql=$sql." order by create_at desc limit 7";
			$QueryArray=$pdo->getAll($sql);
			foreach ($QueryArray as $key=>$item){
				$sql="select url from home_layout_pic p Left Join home_attach a On p.attach_id = a.id where p.layout_id=".$item['id']." limit 1";
				$attr_row=$pdo->getRow($sql);
				if($attr_row['url']==''){$attr_row['url']='images/system/default.jpg';}
				$QueryArray[$key]['url']=$attr_row['url'];
			}
		$smarty->assign("layout_yg", $QueryArray);
	//最新销控表,公示合同信息

		$strat = rand(0,100);//
		$sql = "select t1.id,t1.project_name,t1.telephone,t2.ave_price 
					from home_layout as t1,home_layout_price_history as t2
					 where t1.id in 
					( select layout_id as id from `home_layout_licence` 
					order by create_at ) and t1.id = t2.layout_id 
					and t1.status = '22202' and t1.flag=1 group by t2.layout_id  limit $strat,7 ";
		$smarty->assign("layout_zs", $pdo->getAll($sql));
		
	//楼盘销售排行榜
	$sql_top = "select month from home_layout_top where is_show=1 order by id desc limit 1";
	$smarty->assign($pdo->getRow($sql_top));
	$sql_top_1 = "select * from home_layout_top as a left join home_layout_top_info as b on a.id = b.topid where a.is_show = 1 and b.type_id = 0 order by b.top asc";
	$smarty->assign("top1", $pdo->getAll($sql_top_1));
	$sql_top_2 = "select * from home_layout_top as a left join home_layout_top_info as b on a.id = b.topid where a.is_show = 1 and b.type_id = 1 order by b.top asc";
	$smarty->assign("top2", $pdo->getAll($sql_top_2));
	$sql_top_3 = "select * from home_layout_top as a left join home_layout_top_info as b on a.id = b.topid where a.is_show = 1 and b.type_id = 2 order by b.top asc";
	$smarty->assign("top3", $pdo->getAll($sql_top_3));
	$sql_top_4 = "select * from home_layout_top as a left join home_layout_top_info as b on a.id = b.topid where a.is_show = 1 and b.type_id = 3 order by b.top asc";
	$smarty->assign("top4", $pdo->getAll($sql_top_4));
	//调用房产局数据
	require_once(home_ROOT ."market/index_getdata.php");
	if(time() > $create_time || !$create_time){
			#require("market/index_setdata.php");
			#setData();
	}  
	$smarty->assign("titleInfo", $titleInfo);

	//住宅类即时交易信息";
	$smarty->assign("newhouse_immediately_info", $newhouse_immediately_info);
	//商业用房交易信息";
	$smarty->assign("business_info", $business_info);
	//办公类交易信息";
	$smarty->assign("office_info", $office_info);


	 $pdo = null;
	/////}
	$smarty->show('index.html');
	BuildPage('index','114首页');
}

/**
* 生成主页和相关文件
*/
function BuildPage($borough,$name)
{
	//生产静态页面
	$BuildName=dirname(__FILE__)."/".$borough.".html";
	$this_my_f= ob_get_contents();
	ob_end_clean();
	//$this_my_f = str_replace("/View/Admin/", "", $this_my_f, $count);
	if(tohtmlfile_cjjer($BuildName,$this_my_f) && strpos($this_my_f,"</body>")>0){
		echo "<font color='green'>生成<font color='blue'>".$name."</font>主页成功！</font><br>";
	}else{echo "<font color='red'>生成<font color='blue'>".$name."</font>主页失败！</font><br>";}
}
//把生成静态文件的方法
function tohtmlfile_cjjer($file_cjjer_name,$file_cjjer_content)
{
	  if (is_file($file_cjjer_name))
	  {
		@unlink($file_cjjer_name);
	  }
	  $cjjer_handle = fopen($file_cjjer_name,"w");
	  if (!is_writable($file_cjjer_name))
	  {
		 return false;
	  }
	  if (!fwrite($cjjer_handle,$file_cjjer_content))
	  {
		 return false;
	  } 
	  fclose ($cjjer_handle); //关闭指针
	  return $file_cjjer_name;
}

function file_mode_info($file_path)
{
    /* 如果不存在，则不可读、不可写、不可改 */
    if (!file_exists($file_path))
    {
        return false;
    }
    $mark = 0;
    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
    {
        /* 测试文件 */
        $test_file = $file_path . '/cf_test.txt';
        /* 如果是目录 */
        if (is_dir($file_path))
        {
            /* 检查目录是否可读 */
            $dir = @opendir($file_path);
            if ($dir === false)
            {
                return $mark; //如果目录打开失败，直接返回目录不可修改、不可写、不可读
            }
            if (@readdir($dir) !== false)
            {
                $mark ^= 1; //目录可读 001，目录不可读 000
            }
            @closedir($dir);
            /* 检查目录是否可写 */
            $fp = @fopen($test_file, 'wb');
            if ($fp === false)
            {
                return $mark; //如果目录中的文件创建失败，返回不可写。
            }
            if (@fwrite($fp, 'directory access testing.') !== false)
            {
                $mark ^= 2; //目录可写可读011，目录可写不可读 010
            }
            @fclose($fp);
            @unlink($test_file);
            /* 检查目录是否可修改 */
            $fp = @fopen($test_file, 'ab+');
            if ($fp === false)
            {
                return $mark;
            }
            if (@fwrite($fp, "modify test.\r\n") !== false)
            {
                $mark ^= 4;
            }
            @fclose($fp);
            /* 检查目录下是否有执行rename()函数的权限 */
            if (@rename($test_file, $test_file) !== false)
            {
                $mark ^= 8;
            }
            @unlink($test_file);
        }
        /* 如果是文件 */
        elseif (is_file($file_path))
        {
            /* 以读方式打开 */
            $fp = @fopen($file_path, 'rb');
            if ($fp)
            {
                $mark ^= 1; //可读 001
            }
            @fclose($fp);
            /* 试着修改文件 */
            $fp = @fopen($file_path, 'ab+');
            if ($fp && @fwrite($fp, '') !== false)
            {
                $mark ^= 6; //可修改可写可读 111，不可修改可写可读011...
            }
            @fclose($fp);
            /* 检查目录下是否有执行rename()函数的权限 */
            if (@rename($test_file, $test_file) !== false)
            {
                $mark ^= 8;
            }
        }
    }
    else
    {
        if (@is_readable($file_path))
        {
            $mark ^= 1;
        }
        if (@is_writable($file_path))
        {
            $mark ^= 14;
        }
    }
    return $mark;
}
?>
