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
    default:index();
        exit;
    }
    
    /**
     * 首页
     * */
    function index()
    {
        global $smarty,$pdo,$member,$hb,$crecate_radio,$min_expectprice_option;
        
        $pageSize = 15;
        $offset = 0;
        $subPages=15;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        
        //$where = doRequestFilter($_GET);
        $uid = UID;
        $sql = " select * from ".DB_PREFIX_DR."user_drinfo where uid = '{$uid}' ";
        $info = $pdo->getRow($sql);
        $smarty->assign('info',$info);
        //invite logs
        $limit = " limit $offset,$pageSize ";
        $where = " in_uid = '{$uid}' ";
        $sql = " select * from ".DB_PREFIX_DR."user_invite where $where $limit ";
        $count = $pdo->find(DB_PREFIX_DR.'user_invite ',$where,'count(id) as count , sum(gold) as tgold');
        $info = $pdo->getAll($sql);
        foreach($info as $key=>$item)
        {
            $user = substr($item['username'],0,3);
            $user .= '****'.substr($item['username'],-2,2);
            $info[$key]['username'] = $user;
        }
        $smarty->assign('ginfo',$info);
        
        
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,3);
        $splitPageStr=$page->get_page_html();
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('tgold',$count['tgold']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('splitPageStr', $splitPageStr);
        
        $tpl = "mydr/invite.tpl";
        $smarty->assign('seoTitle','会员中心-888');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    }
    
?>