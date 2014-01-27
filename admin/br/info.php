<?php
/**
 * info
* @Created 2013-1-24 
* @name search.php
* @author QQ:279532103
* @version 1.0
* @version $Id: member_index.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
    session_start();
    require_once('../../sys_load.php');
    require_once('../../data/cache/base_code.php');
//    check_login();
    new Verify();
    $smarty = new WebSmarty();
    $smarty->caching = false;
    $pdo=new MysqlPdo();
    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
    case 'index':index(); //首页页面
        exit;
    case 'getInfoByUser':getInfoByUser();break;
    case 'del':del();break;
    case 'close':close();break;
    case 'open':opem();break;
    case 'comptask':comptask();break;
    default:index();
        exit;
    }
    
    function index()
    {
        global $smarty,$min_expectprice_option,$score_option,$timeline_option,$type_radio,$crecate_radio,$revoke_option,$de_province;
        
        $type = $_GET['type']=='1' ? '1' : '0';
        $values1 = $values2 = array(26,322,0,0);
        if(!empty($_GET['did'])&&is_numeric($_GET['did']))
        {
            $info = getInfoById($_GET['did']);
            $values1 = array($info['in_province'],$info['in_city'],$info['in_dist']);
            $values2 = array($info['on_province'],$info['on_city'],$info['on_dist']);
            $type = $info['type'] == '1' ? '1' : '0';
            $smarty->assign('info',$info);
        }
        if($type=='1')$values1= array(0,0,0,0);
        $elems = array('in_province', 'in_city', 'in_dist');
        $dist1 = showdistricts($values1, '', '','',true);
       
        $elems = array('on_province', 'on_city', 'on_dist');
        $dist2 = showdistricts($values2, '', '','',true);
        
        
        $smarty->assign('type_radio',$type_radio);
        $smarty->assign('crecate_radio',$crecate_radio);
        $smarty->assign('revoke_option',$revoke_option);
        $smarty->assign('min_expectprice_option',$min_expectprice_option);
        $smarty->assign('score_option',$score_option);
        $smarty->assign('timeline_option',$timeline_option);
        $smarty->assign('dist1',$dist1);
        $smarty->assign('dist2',$dist2);
        $smarty->assign('type',$type);
        $tpl = 'admin/dr/info_sale.tpl';
        if($type=='1')$tpl = 'admin/dr/info_buy.tpl';
        $smarty->show($tpl);
    }    
    
    function getInfoById($id)
    {
        global $pdo;
        $info = $pdo->find(DB_PREFIX_DR.'info'," id = '$id' ");
        return $info;
    }
    
    function getInfoByUser()
    {
        global $pdo,$smarty,$min_expectprice_option,$score_option,$timeline_option,$type_radio,$crecate_radio,$revoke_option,$de_province,$task_status;
        $uid=$_GET['uid'];
        //$pageSize =2;
//        $offset = 0;
//        $subPages=15;//每次显示的页数
//        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
//        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
//        $limit = " limit $offset,$pageSize ";
        $where  = " uid = '$uid' ";
        $sql = " select * from ".DB_PREFIX_DR."info where $where $limit ";
        $info = $pdo->getAll($sql);
        $count = $pdo->find(DB_PREFIX_DR.'info ',$where,'count(id) as count');
        $smarty->assign('info',$info);
        
        //$page_info = "action=getInfoByUser&uid=$uid&";
//        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,2);
//        $subPages=$page->get_page_html();
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('subPages',$subPages);
        
        $smarty->assign('crecate_radio',$crecate_radio);
        $smarty->assign('type_radio',$type_radio);
        $smarty->assign('score_option',$score_option);
        $smarty->assign('crecate',$crecate_radio);
        $smarty->assign('min_expectprice',$min_expectprice_option);
        $smarty->assign('task_status',$task_status);
        
        $smarty->show('admin/dr/info_foruser.tpl');
    }
    
    function del()
    {
        global $pdo;
        if($_GET['id']<=0)page_msg('地址非法，重新提交',false);
        $info = getInfoById($_GET['id']);
        if($info['id']<=0)page_msg('该条信息不存在',false);
        $sql = " delete from  ".DB_PREFIX_DR."info  where id = '{$info['id']}' ";
        if($pdo->execute($sql))page_msg('删除成功',true);
        else page_msg('删除失败，请稍后重试',false);
    }
    function close()
    {
        global $pdo;
        if($_GET['id']<=0)page_msg('地址非法，重新提交',false);
        $info = getInfoById($_GET['id']);
        if($info['id']<=0)page_msg('该条信息不存在',false);
        $sql = " update  ".DB_PREFIX_DR."info set flag = '1' where id = '{$info['id']}' ";
        if($pdo->execute($sql))page_msg('关闭成功',true);
        else page_msg('关闭失败，请稍后重试',false);
    }
    function open()
    {
        global $pdo;
        if($_GET['id']<=0)page_msg('地址非法，重新提交',false);
        $info = getInfoById($_GET['id']);
        if($info['id']<=0)page_msg('该条信息不存在',false);
        $sql = " update  ".DB_PREFIX_DR."info set flag = '0' where id = '{$info['id']}' ";
        if($pdo->execute($sql))page_msg('开启成功',true);
        else page_msg('开启失败，请稍后重试',false);
    }
    function comptask()
    {
        global $pdo;
        if($_GET['id']<=0)page_msg('地址非法，重新提交',false);
        $info = getInfoById($_GET['id']);
        if($info['id']<=0)page_msg('该条信息不存在',false);
        $sql = " update  ".DB_PREFIX_DR."info set status = 'DONE' where id = '{$info['id']}' ";
        if($pdo->execute($sql))page_msg('完成任务成功',true);
        else page_msg('完成任务失败，请稍后重试',false);
    }
?>