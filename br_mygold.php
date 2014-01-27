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
        //gold logs
        $limit = " limit $offset,$pageSize ";
        $sql = " select * from ".DB_PREFIX_DR."gold_log where uid = '{$uid}' $limit ";
        $count = $pdo->find(DB_PREFIX_DR.'gold_log ',$where,'count(id) as count');
        $info = $pdo->getAll($sql);
        $smarty->assign('ginfo',$info);
        
        
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,3);
        $splitPageStr=$page->get_page_html();
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('splitPageStr', $splitPageStr);
        
        $tpl = "brules/mygold.tpl";
        $smarty->assign('seoTitle','会员中心-和睦家');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    }
    
?>