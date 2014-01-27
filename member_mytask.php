<?php
/**
 * 会员首页
* @Created 2013-1-24 
* @name search.php
* @author QQ:279532103
* @version 1.0
* @version $Id: member_myinfo.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
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
        case 'index':index();break; //首页页面
        case 'deal':deal();break;
        case 'wait':wait();break;
        case 'fail':fail();break;
        case 'cancleConfirm':cancleConfirm();break;
        default:index();break;
    }
    
     function index()
    {
        global $smarty,$pdo,$member,$hb,$task_status,$task_type,$type_radio,$min_expectprice_option,$task_type_name;
        
        //$where = doRequestFilter($_GET);
        $pageSize = 15;
        $offset = 0;
        $subPages=15;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        
        $op = empty($_GET['op']) ? 'doing' : $_GET['op'] ;
        
        $uid = UID;
        $limit = " limit $offset,$pageSize ";
        $where = $op=='doing' ? "(t.uid = '{$uid}' or t.duid = '$uid') and (t.status = '$op' or t.status = 'CONFIRM') " : " t.uid = '{$uid}' and t.status = '$op' ";
        if($op=='fail')$where = "(t.uid = '{$uid}' or t.duid = '$uid') and (t.status = '$op') ";
        //$sql = " select * from ".DB_PREFIX_DR."task where $where   $limit ";
        $sql = " select t.*,i.tel,i.linkman from  ".DB_PREFIX_DR."task as t left join ".DB_PREFIX_DR."info as i on t.did = i.id where $where $limit ";
        $countsql = " select count(*) as count from ".DB_PREFIX_DR."info  where uid = '$uid' and status = '$op' ";
        if($op=='wait')
        {
            $sql =" select * from  ".DB_PREFIX_DR."info where uid = '$uid' and status = 'WAIT'  $limit ";
        }
        elseif($op=='done')$sql =" select * from  ".DB_PREFIX_DR."info where uid = '$uid' and status = 'DONE'  $limit ";
        else{
            $countsql = "select count(t.id) as count from  ".DB_PREFIX_DR."task as t left join ".DB_PREFIX_DR."info as i on t.did = i.id where $where";
        }
        
        $info = $pdo->getAll($sql);
        $smarty->assign('info',$info);
        
        $count = $pdo->getRow($countsql);
        
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,3);
        $splitPageStr=$page->get_page_html();
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('splitPageStr', $splitPageStr);
        
        $smarty->assign('task_status', $task_status);
        $smarty->assign('task_type', $task_type);
        $smarty->assign('type_radio', $type_radio);
        $smarty->assign('min_expectprice_option', $min_expectprice_option);
        $smarty->assign('task_type_name', $task_type_name);
        
        $tpl = "mydr/mytask_now.tpl";
        $smarty->assign('seoTitle','会员中心-和睦家');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    }
    
    function deal()
    {
        extract($_GET);
        $mods = array('comp','fail');
        if(!in_array($mod,$mods))page_prompt('传入地址非法，请从正确的路劲传入',false,'mytask.html');
        if(!isExistTask($id))page_prompt('该任务不存在或已更改！',false,'mytask.html');
        if($mod=='comp')
        {
            
        }
    }
    
    function isExistTask($id,$status='CONFIRM')
    {
        global $pdo;
        $uid = UID;
        return  $pdo->find(DB_PREFIX_DR.'task ',"id='$id' and status ='$status' ",'*');
    }
    
    function cancleConfirm()
    {
        global $pdo;
        $uid = UID;
        if(!empty($_GET['id']))
        {
            $id = $_GET['id'];
            if(!$info = isExistTask($id))page_prompt('该任务不存在或已更改！',false,'mytask.html');
            $userinfo = $pdo->find(DB_PREFIX_DR.'user_drinfo','uid='.$info['uid']);
            $costs = WATCH_JZ_SCORES ;
            if(upTaskStatus($id,'FAIL'))
            {
                //返还金额
                if(up_user_scores(-WATCH_JZ_SCORES,UID))
                {
                    //更新状态
                     upInfo($info['did'],'WAIT');
                     //插入信息
                     in_user_cons($info['did'],+WATCH_JZ_SCORES,$info['uid'],$info['username'],($userinfo['now_gold']+WATCH_JZ_SCORES));
                     page_prompt('取消成功',true,'mytask.html');
                }
            }
            else page_prompt('取消失败',false,'mytask.html');
        }
    }
    function upTaskStatus($id,$status)
    {
        $sql = " update ".DB_PREFIX_DR."task set   status = '$status' where id = '$id'  ";
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
function in_user_cons($gno,$scores,$uid,$username,$banlance,$tabname='info')
{
    $time = time();
    $op = "对方取消预订信息返还";
    $sql = " insert into ".DB_PREFIX_DR."gold_log set
              uid = '$uid',username='$username',tablename='$tabname',gno = '$gno' ,gold = '$scores',banlance='$banlance',op='$op',addtime = '$time'
            ";
    return getPdo()->execute($sql);
}
function upInfo($id,$status='CONFIRM')
{
    $sql = " update ".DB_PREFIX_DR."info set status = '$status' where id = '".$id."' ";
    return getPdo()->execute($sql);
}
?>