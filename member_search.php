<?php
/**
 * 会员首页
* @Created 2013-1-24 
* @name search.php
* @author QQ:279532103
* @version 1.0
* @version $Id: member_index.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
	session_start();
	//require_once('./sys_load.php');
	require_once('./member_config.php');
    require_once('./data/cache/base_code.php');
	check_login();
	$smarty = new WebSmarty();
	$smarty->caching = false;
	$pdo=new MysqlPdo();
	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
	case 'index':index(); //首页页面
		exit;
	case 'exit':exitlogin();//登录处理
		exit();
    case 'booking': booking(); break;//增加信息处理
    case 'dobooking': dobooking(); break;//增加信息处理
    case 'buy': costScores(); break;//增加信息处理
    case 'show': showlist(); break;//增加信息处理
	case 'cancleInfo': cancleInfo(); break;//增加信息处理
	default:index();
		exit;
	}
	
	/**
	 * 首页
	 * */
	function index()
	{
		global $smarty,$pdo,$member,$hb,$crecate_radio,$min_expectprice_option,$task_status,$score_option;
        
         $pageSize = 15;
        $offset = 0;
        $subPages=15;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        
        $_GET['type'] = empty($_GET['type'])&&$_GET['type']!='1' ? 0 : 1;
        
        $where = doRequestFilter($_GET);
        $limit = " limit $offset,$pageSize ";
        $sql = " select * from ".DB_PREFIX_DR."info where $where $limit";
        $info = $pdo->getAll($sql);
        $count = $pdo->find(DB_PREFIX_DR.'info ',$where,'count(id) as count');
        $smarty->assign('info',$info);
        
        $page_info = "type={$_GET['type']}&";
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,3);
        $subPages=$page->get_page_html();
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('subPages',$subPages);
        
        $smarty->assign('crecate_radio',$crecate_radio);
        $smarty->assign('score_option',$score_option);
        $smarty->assign('crecate',$crecate_radio);
        $smarty->assign('min_expectprice',$min_expectprice_option);
        $smarty->assign('task_status',$task_status);
        $smarty->assign('type',$_GET['type']);
        
		$tpl = "mydr/search.tpl";
		$smarty->assign('seoTitle','会员中心-和睦家');
		$smarty->assign('description',$hb['metadescrip']);
		$smarty->show($tpl);
	}
    /**
    *处理传值 
    */
    function doRequestFilter($request)
    {
        $uid = UID ;
        $where  = "  1 and flag = 0 and status = 'WAIT' ";
        $where .= " and type = '{$request['type']}'";
        if(!empty($request['on_province'])){
            $where .= " and on_province = '{$request['on_province']}'";
            if(!empty($request['on_city'])){
                $where .= " and on_city = '{$request['on_city']}'";
                if(!empty($request['on_dist'])){
                    $where .= " and on_dist = '{$request['on_dist']}'";
                }
            }
        }
        
        $where .=  !empty($request['crecate']) ? " and crecate = '{$request['crecate']}'" : '';
        if(!empty($request['score']))
        {
            $where .=   " and score >= '{$request['score']}' " ;
        }
        $where .=  !empty($request['min_expectprice']) ? " and min_expectprice <= '{$request['min_expectprice']}'" : '';
        $where .=  !empty($request['licensdate']) ? " and licensdate >= '".($request['licensdate'])."'" : '';
        return $where;
    }
    
function showlist()
{
    global $pdo,$smarty,$crecate_radio,$type_radio,$min_expectprice_option,$score_option;
    extract($_GET);
    if($id<=0)page_prompt("地址非法，请从正确的路径进入..",false,'index.html',3);
    $info = $pdo->getRow("select * from ".DB_PREFIX_DR."info  where id = '$id' and status = 'WAIT' ");
    $infos[0] = $info ;
    $smarty->assign('info',$infos);
    
    $smarty->assign('crecate_radio',$crecate_radio);
    $smarty->assign('score_option',$score_option);
    $smarty->assign('crecate',$crecate_radio);
    $smarty->assign('min_expectprice',$min_expectprice_option);
    $smarty->assign('task_status',$task_status);
    $smarty->assign('type',$_GET['type']);
    $tpl = "mydr/search.tpl";
    $smarty->show($tpl);
}
function booking()
{
    global $smarty;
    @extract($_REQUEST);
    $id = $sp;
    $uid = UID ;
    if(!$uid||intval($uid)<=0)
    {
        page_msg('请先登录后再进行查看',false,'login.html');
        //$smarty->assign('ajax',true);
//        $smarty->show('ajax_login.tpl');
        exit;
    }
    
    //是否存在信息
    if(!$id||intval($id)<=0||!$info = getItemById($id))
    {
        page_msg('该信息不存在或已被预订',false,'/',5,1);
    }
    //不能举报自己
    if($info['uid']==$uid)
    {
        page_msg('自己不能预订自己哦！',false,'/',5,1);
    }
    //查询该用户是否已经举报过该中介
    if(isBooking($info['uid'],$uid))
    {
        page_msg('您已经预订过该信息，不能重复预订！',false,'/',5,1);
    }
    //用户确认信息
    if(!isset($isconfirm))
    {
        confirmInfoWindow();
    }
    
    
    page_msg('预订失败',false,'/',5,1);
}
    
function getItemById($id,$status='WAIT')
{
    global $pdo ;     
    return $pdo->getRow(" select * from ".DB_PREFIX_DR."info where id = $id and status = '$status' and flag = 0 ");
    
}
function getItemBydId($id,$status='WAIT')
{
    global $pdo ;     
    return $pdo->getRow(" select * from ".DB_PREFIX_DR."task where id = $id and status = '$status' and flag = 0 ");
    
}
function isBooking($id,$uid)
{
    global $pdo ;
    return $pdo->getRow(" select * from ".DB_PREFIX_DR."task where did = $id and flag = 0 and uid = '$uid' ");
}
//确认信息
function confirmInfoWindow($i=0,$mod='CONFIRM')
{
    global $smarty;
    $smarty->assign('sp',$_GET['sp']);
    $smarty->assign('mod',$mod);
    $tpl = $i == 0 ? 'mydr/ajax_suggest.tpl' : 'mydr/ajax_taskBox.tpl';
    $smarty->show($tpl);exit;
}

/**
+----------------------------------------------------------
* 扣除金额
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function costScores()
{
    global $smarty,$type_radio;
    @extract($_REQUEST);
    $id = $sp;
    $uid = UID ;
    if(!$uid||intval($uid)<=0)
    {
        page_msg('请先登录后再进行查看',false,'login.html');
        //$smarty->assign('ajax',true);
//        $smarty->show('ajax_login.tpl');
        exit;
    }
    
    //是否存在信息
    if(!$id||intval($id)<=0||!$info = getItemById($id))
    {
        page_msg('该信息不存在或已被预订',false,'/',5,1);
    }
    //不能预订自己
    if($info['uid']==$uid)
    {
        page_msg('自己不能预订自己哦！',false,'/',5,1);
    }
    //查询该用户是否已经预订过该中介
    if(isBooking($info['uid'],$uid))
    {
        page_msg('您已经预订过该信息，不能重复预订！',false,'/',5,1);
    }

    //用户金额是否买足扣费
    $fileds = array('total_integral');
    $userinfo = getPdo()->find(DB_PREFIX_DR.'user_drinfo','uid='.$uid);
    #该房源所需花费的金额
    $costs = WATCH_JZ_SCORES ;
    if(intval($userinfo['now_gold'])<intval($costs))
    {
        page_msg('提示：您的金额不足，请充值<br>或代理电话：****',false,'search.html?action=buy&do=index',5,1);
    }
    else 
    {
        //用户确认信息
        if(!isset($_GET['isconfirm'])&&$_GET['isconfirm']!='yes')
        {
            confirmInfoWindow(1);
        }
        else
        {
            //开始下任务订单
            if(addTask($id,$info,$pname,$tel))
            {
                //扣费
                if(up_user_scores($costs,$uid))
                {
                    //更新状态
                    upInfo($id);
                    //插入信息
                    in_user_cons($id,-$costs,$uid,USERNAME,($userinfo['now_gold']-$costs));
                    //成功开始发送短信
                    $content = "{$info['linkman']}您好！您在驾分网发布的任务“{$type_radio[$info['type']]}{$info['score']}”分-{$info['min_expectprice']}/分，已被预订，请您尽快登录网站处理！jiazhao888.com";
                    @sendMess($content,$info['tel'],$id);
                    $other = "<script type='text/javascript'>window.location.reload;</script>";
                    page_msg('预订成功，请等待对方确认！<br>预订成功后有15天的确认期限',true,$url,5,1,$other);
                }
            }
        }
    }
     page_msg('预订失败，请稍后重试！',false,$url,5,1);
}
//添加任务
function addTask($id,$info,$pname,$tel)
{
    global $task_tname;
    $taskno = date('YmdHis').rand(100,999);
    $uid = UID;
    $username = USERNAME;
    $type = $info['type'];
    $taskname = $task_tname[$info['type']].$info['score'].'分';
    $did = $info['id'];
    $duid = $info['uid'];
    $dusername = $info['username'];
	$time = time();
    $pname = $pname;
    $telephone = $tel;
    $sql = " insert into ".DB_PREFIX_DR."task set taskno = '$taskno' ,did = '$did' ,type = '$type' , taskname='$taskname' ,  pname = '$pname' ,telephone = '$telephone' ,uid = '$uid',username = '$username' , duid = '$duid',dusername = '$dusername',addtime='$time', status = 'CONFIRM'  ";
    return getPdo()->execute($sql);
}
function upTask($id,$info)
{
    $startdate = time();
    $enddate = empty($enddate) ? time()+(15*24*60*60) : $enddate;
    $sql = " update ".DB_PREFIX_DR."task set  startdate = '$startdate' ,enddate = '$enddate' , status = 'DOING' where id = '$id'  ";
    return getPdo()->execute($sql);
}
function upInfo($id,$status='CONFIRM')
{
    $sql = " update ".DB_PREFIX_DR."info set status = '$status' where id = '".$id."' ";
    return getPdo()->execute($sql);
}
//更新用户金额
function up_user_scores($scores,$uid)
{
    $sql = " update ".DB_PREFIX_DR."user_drinfo set `now_gold` = `now_gold` - {$scores} ,`s_gold` = `s_gold` + {$scores}
                where uid = '".$uid."' ";
    return getPdo()->execute($sql);
}
//插入金额购买
function in_user_cons($gno,$scores,$uid,$username,$banlance,$tabname='info',$op='预定信息扣分')
{
    $time = time();
    $sql = " insert into ".DB_PREFIX_DR."gold_log set
              uid = '$uid',username='$username',tablename='$tabname',gno = '$gno' ,gold = '$scores',banlance='$banlance',op='$op',addtime = '$time'
            ";
    return getPdo()->execute($sql);
}

function dobooking()
{
    global $smarty;
    @extract($_REQUEST);
    $id = $sp;
    $uid = UID ;
    if(!$uid||intval($uid)<=0)
    {
        page_msg('请先登录后再进行查看',false,'login.html');
        //$smarty->assign('ajax',true);
//        $smarty->show('ajax_login.tpl');
        exit;
    }
    
    //是否存在信息
    if(!$id||intval($id)<=0||!$info = getItemBydId($id,'CONFIRM'))
    {
        page_msg('该信息不存在或已进入其他流程',false,'/',5,1);
    } 
    //不能举报自己
    if($info['duid']!=$uid)
    {
        page_msg('该信息不属于您的任务，不能执行此操作！',false,'/',5,1);
    }
    //查询该用户是否已经
    if($info['status']=='DOING')
    {
        page_msg('您已经确认过该信息，不能重复确认！',false,'/',5,1);
    }
    //用户金额是否买足扣费
    $fileds = array('total_integral');
    $userinfo = getPdo()->find(DB_PREFIX_DR.'user_drinfo','uid='.$uid);
    #该房源所需花费的金额
    $costs = WATCH_JZ_SCORES ;
    if(intval($userinfo['now_gold'])<intval($costs))
    {
        page_msg('提示：您的余额不足，请充值<br>或代理电话：****',false,'search.html?action=buy&do=index',5,1);
    }
    else
    {
        //用户确认信息
        if(!isset($isconfirm))
        {
            confirmInfoWindow(0,'doConfirm');
        }
        else
        {
            if(upTask($id,$info))
            {
                if(up_user_scores(WATCH_JZ_SCORES,UID))
                {
                    //更新状态
                     upInfo($info['did'],'DOING');
                     //插入信息
                     in_user_cons($info['did'],-WATCH_JZ_SCORES,UID,USERNAME,($userinfo['now_gold']-WATCH_JZ_SCORES));
                     $other = "<script type='text/javascript'>window.location.reload;</script>";
                    page_msg('确认预订信息成功！<br>预订成功后有15天的交易期限，15天后自动完成任务',true,$url,5,1,$other);
                }
            }
             
        }
        
    }
    page_msg('确认失败',false,'/',5,1);
}

//取消任务
function cancleInfo()
{
    global $smarty,$pdo;
    @extract($_REQUEST);
    $uid = UID ;
    if(!$uid||intval($uid)<=0)
    {
        page_prompt('请先登录后再进行查看',false,'login.html');
        //$smarty->assign('ajax',true);
//        $smarty->show('ajax_login.tpl');
        exit;
    }
    
    //是否存在信息
    if(!$id||intval($id)<=0||!$info = getItemBydId($id,'CONFIRM'))
    {
        page_prompt('该信息不存在或已取消',false,'/',5,1);
    } 
    if($info['uid']!=$uid)
    {
        page_prompt('该信息不属于您的任务，不能执行此操作！',false,'/',5,1);
    }
    //查询该用户是否已经
    if($info['status']=='DOING')
    {
        page_prompt('已经确认过该信息，不能执行取消任务！',false,'/',5,1);
    } 
    $userinfo = $pdo->find(DB_PREFIX_DR.'user_drinfo','uid='.$uid);
    $costs = WATCH_JZ_SCORES ;
    if(upTaskStatus($id,'FAIL'))
    {
        //返还金额
        if(up_user_scores(-WATCH_JZ_SCORES,UID))
        {
            //更新状态
             upInfo($info['did'],'WAIT');
             //插入信息
             in_user_cons($info['did'],+WATCH_JZ_SCORES,$info['uid'],$info['username'],($userinfo['now_gold']+WATCH_JZ_SCORES),'info','取消预订信息返还');
             page_prompt('取消成功',true,'mytask.html');
        }
    }
    else page_prompt('取消失败',false,'mytask.html');
}

function upTaskStatus($id,$status)
{
    $sql = " update ".DB_PREFIX_DR."task set   status = '$status' where id = '$id'  ";
    return getPdo()->execute($sql);
    }
?>
