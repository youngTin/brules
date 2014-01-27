<?php
/**
 * 会员首页
* @Created 2010-5-27 上午11:25:03
* @name index.php
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
    case 'do': do_handle(); //增加信息处理
        exit();
    case 'search': search(); //增加信息处理
        exit();
    default:index();
        exit;
    }
    
    
    /**
     * 首页
     * */
    function index()
    {
        global $smarty,$pdo,$type_radio;
        

        $count = $pdo->find(DB_PREFIX_DR.'user_invite '," in_uid = '".UID."' ",'count(id) as count , sum(gold) as tgold');
        $smarty->assign('tgold',$count['tgold']);
        $tpl = "brules/search_index.tpl";
        $smarty->assign('type_radio',$type_radio);
        $smarty->assign('seoTitle','会员中心-驾照888');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    }
    
    function search()
    {
        global $smarty,$pdo,$member,$hb,$de_province,$crecate_radio,$type_radio,$min_expectprice_option,$score_option;
        
        $elems = array('on_province', 'on_city', 'on_dist');
        $dist2 = '<span id="residedistrictbox2">'.showdistricts($de_province, $elems, 'residedistrictbox2').'</span>';
        $smarty->assign('dist2',$dist2);
        
        $smarty->assign('type_radio',$type_radio);
        $smarty->assign('crecate_radio',$crecate_radio);
        $smarty->assign('min_expectprice_option',$min_expectprice_option);
        $smarty->assign('score_option',$score_option);
        $tpl = "brules/index_search.tpl";
        $smarty->assign('seoTitle','会员中心-驾照888');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    }    

?>
