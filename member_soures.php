<?php
/**
* 会员中心积分管理
* @Created 2010-6-24上午10:16:06
* @name soures.php
* @author 304260440@qq.com
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_soures.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
session_start();
require_once 'member_config.php'; //引入全局配置
check_login();
$smarty = new WebSmarty();
$smarty->caching = false;
$pdo=new MysqlPdo();

$user_type = utype;
$user_name = uname;
$user_id   = uid;
$smarty->assign('user_name',$user_name);
$smarty->assign('user_type',$user_type);
switch(isset($_GET['action'])?$_GET['action']:'index')
{
	case 'index':index(); //积分页面
		exit;
	case  'convert' : convert();//积分转换
		exit();	
	case 'cons': cons_log();break;
	default:index();
		exit;
}
/**
 * 积分详细列表
 * */
function index()
{
	global $pdo,$smarty,$user_name,$user_id,$user_type,$scores_option;
	//TODO...
	if ($user_type=='个人')
	{
		//ShowMsg("个人用户无此功能!3秒后将自动返回..",'javascript:history.back(-1)',0,3000);
		//exit();
	}
	extract($_POST);
	if (isset($do) && $do=='getinfo')
	{
		getinfo($get);
		exit();
	}
	$Res=$pdo->getRow("select total_integral,total_money from home_member where uid='$user_id'");
	//累计积分
	$s_uid = $pdo->getAll("select * from home_user_operation where uid ='$user_id'");
	$sum = array();
	foreach ($s_uid as $k=>$v)
	{
		$sum[]=intval($s_uid[$k]['score']);
	}
	$Res['jf'] = array_sum($sum);
	//积分规则
	foreach ($scores_option as $key=>$val)
	{
		$contents[$key][] = getIntegral($key,$user_id);
	}
	//累计数量及得分情况
	foreach ($contents as $k=>$val)
	{
		$index = 0;$int = 0 ;
		if(count($val[0])>0&&!empty($val[0])){
			foreach ($val as $s)
			{ 
				foreach ($s as $v)
				{
					if($v['operation']=='增加')
					{
						$int += intval($v['score']);
					}else {
						$int -= intval($v['score']);
					}
					$index ++;
				}
			}
		}
		$scores_option[$k]['int'] = $int ;
		$scores_option[$k]['index'] = $index > 0 ? $index : 0;
	}
	//消费记录
	$pageSize = 20;
    $offset = 0;
    $subPages=5;//每次显示的页数
    $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
    if($currentPage>0) $offset=($currentPage-1)*$pageSize;
    $where = ' where 1 ';
	//$costint = getCostInt($user_id);
	$sql = " select product,score,time from ".DB_PREFIX_HOME."user_operation where  uid = '$user_id' and operation = '减少'  ";
	$limit = " limit $offset,$pageSize ";
	$costint = getPdo()->getAll($sql.$limit);
	$count = getPdo()->find(DB_PREFIX_HOME.'user_operation'," uid = '$user_id' and operation = '减少' "," count(id) as count ");
	$page_info = 'action=index&';
	$page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,3);
	$splitPageStr=$page->get_page_html();
	foreach ($costint as $key=>$val)
	{
		if(array_key_exists($val['product'],$scores_option)){
			$costint[$key]['name'] = $scores_option[$val['product']][0];
			$costint[$key]['rule'] = $scores_option[$val['product']][1];
		}
		else 
		{
			$costint[$key]['name'] = '其他花费';
			$costint[$key]['rule'] = $val['score'];
		}
		
	}
	
	$smarty->assign('splitPageStr', $splitPageStr);
	$smarty->assign('pagesize',$pageSize);
    $smarty->assign('num',$count['count']);
	$smarty->assign('res',$Res);
	$smarty->assign('soption',$scores_option);
	$smarty->assign('costint',$costint);
	$tpl = 'member/index_soures.tpl';
	$smarty->assign('seoTitle','积分管理-和睦家');
	$smarty->show($tpl);
}
/**
*获取积分
*/
function getIntegral($type,$uid)
{
	return getPdo()->getAll("select score,operation from ".DB_PREFIX_HOME."user_operation where product='$type' and uid = '$uid' ");
}
/**
 * 获取积分消费
 * **/
function getCostInt($uid)
{
	return $res = getPdo()->find(DB_PREFIX_HOME.'user_operation',"uid = '$uid' and operation = '减少' ",'product,score,time');
}
/**
 * 积分金额互换
 * */
function convert()
{
	global $pdo;
	$uid = uid;
	if(isset($_GET))$_POST = array_merge($_POST, $_GET);
	extract($_POST);exit;
	if (@$do=='scorestomoney') //积分转化为金额
	{
		$res = $pdo->getRow("select total_money,total_integral from home_member where uid='$uid' ");
		if ($res['total_integral']<converttomoney)
		{
			ShowMsg("转换最低积分为".converttomoney."积分,请赚够".converttomoney."积分在来",-1);
			exit();
		}
		$m = number_format($res['total_integral']/converttomoney, 2, '.', '');
			//更新总积分 总金额
		$sql = "Update `home_member` set total_integral=0 ,total_money=total_money+{$m} where uid='$uid' ; ";
		if ($pdo->execute($sql))
		{
			ShowMsg("对话金额成功,3秒之后将自动转向..",-1,0,3000);exit();
		}
	}
	elseif (@$do=='moneytoscores') //金额转换为积分
	{
		//TODO.......暂无此功能 带扩展
	}
}
/**
 * AJAX 获取积分
 * */
function getinfo($name)
{
	global $scores_option,$pdo;
	$uid = uid;
	extract($_POST);
	if ($do=='getinfo') //获取积分
	{
			$name = explode(',',$name);
			for ($i=0;$i<Count($name);$i++)
			{
				$s=0;
				$res=$pdo->getAll("select * from home_user_operation where uid='$uid' and product='".$name[$i]."'");
				foreach ($res as $k=>$v)
				{
					$s += $res[$k]['score'];
				}
				$pname = $scores_option[$name[$i]][0]; //名称
				$score = $scores_option[$name[$i]][1]; //分数
				$units = $scores_option[$name[$i]][2]; //单位
				$num = count($res); //数量
				if (!$s)
					$s ='0';
				echo "    <div class=\"sxmmc\">
		                   <p class=\"xmmc\">$pname</p>
		                    <p>$score 分$units</p>
		                    <p>".$num."</p>
		                   <p>".$s."</p>
		             </div ";
			}
	}
}

    /**
    +----------------------------------------------------------
    * 积分消费记录
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param 
    +----------------------------------------------------------
    * @return 
    +----------------------------------------------------------
    */
	function  cons_log(){
		global  $smarty;
		
		$pageSize = 15;
        $offset = 0;
        $subPages=5;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        $where = ' where 1 ';
        if(isset($_GET)){
        	@extract($_GET);
        	if(!empty($start)){
        		$time = strtotime($start);
        		$where .= " and addtime  >= '$time' ";
        		$page_info .= "uc.start={$start}&";
        	}
        	if(!empty($end)){
        		$time = strtotime($end);
        		$where .= " and uc.addtime  <= '$time' ";
        		$page_info .= "end={$end}&";
        	}
        }
		$sql = " select uc.*,e.id,e.reside,e.house_type,e.price,e.linkman,e.telphone,e.link_require,e.images,e.flag,e.total_area  from  ".DB_PREFIX_HOME."user_cons as uc
				left join ".DB_PREFIX_HOME."esf as e on e.id = uc.esf_id
				".$where." and uc.uid = '".uid."'  group by uc.id order by uc.addtime desc  ";
		$limit = " limit $offset,$pageSize ";
		$res = getPdo()->getAll($sql.$limit);
		$count = getPdo()->getRow(" select count(distinct uc.id) as count  from  ".DB_PREFIX_HOME."user_cons as uc
				left join ".DB_PREFIX_HOME."esf as e on e.id = uc.esf_id
				".$where." and uc.uid = '".uid."'   ");

		$page=new Page($pageSize,$count['count'],$currentPage,$subPages,"?action=cons&".$page_info."p=",3);
		$splitPageStr=$page->get_page_html();
		foreach($res as $key=>$val){
			$res[$key]['hx'] = getFitment($val['id']);
            $res[$key]['link_require'] = preg_replace("/(\s|( )+|\xc2\xa0)/","&nbsp;",$val['link_require']);
		}
	//	print_r($res);
		
		$smarty->assign('splitPageStr', $splitPageStr);
		$smarty->assign('pagesize',$pageSize);
	    $smarty->assign('num',$count['count']);
		$smarty->assign('res',$res);
		$smarty->assign('seoTitle','积分消费记录-和睦家');
		$smarty->show('member/cons_list.tpl');
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
?>