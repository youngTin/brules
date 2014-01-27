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
        global $smarty,$pdo,$type_radio,$br_car_type;
        
        $smarty->assign('wait',getTaskCount('wait'));
        $smarty->assign('done',getTaskCount('done'));
        $smarty->assign('doing',getTaskCount('doing'));
        getHelper();
        $userinfo = MemberLogin::GetUserInfo(UID);
        getNewPubInfo();
        $smarty->assign('userinfo',$userinfo);
        $count = $pdo->find(DB_PREFIX_DR.'user_invite '," in_uid = '".UID."' ",'count(id) as count , sum(gold) as tgold');
        $smarty->assign('tgold',$count['tgold']);
        $tpl = "brules/index.tpl";
        $smarty->assign('type_radio',$type_radio);
        $smarty->assign('br_car_type',$br_car_type);
        $smarty->assign('seoTitle','会员中心-车司令');
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
    
    function getTaskCount($type='wait')
    {
        global $pdo ;
        $uid = UID;
        $where= $type=='doing' ? "(t.uid = '{$uid}' or t.duid = '$uid') and (t.status = '$type' or t.status = 'CONFIRM') " :" t.uid = '{$uid}' and t.status = '$type' ";
        if($type=='wait')
        {
            $count = $pdo->find(DB_PREFIX_DR.'info as t',$where,'count(t.id) as count');
        }
        else $count = $pdo->find(DB_PREFIX_DR.'task as t ',$where,'count(t.id) as count');
        return $count['count'];
    }
    function getHelper()
    {
        global $smarty,$pdo;
        $pageSize = 10;
        $offset = 0;
        
        $category_sql = "select * from category where type=1 and mid=1 ";
        $category = $pdo->getAll($category_sql);
        
        //获取当前分类信息列表
        $cid = 237;
        $category_list_sql = "select * from web_contentindex where cid=".$cid;
        $limit = " limit $offset,$pageSize ";
        $category_list = $pdo->getAll($category_list_sql.$limit);
        $smarty->assign('info',$category_list);
    }
    
    function getNewPubInfo()
    {
        global $smarty,$pdo;
        $sql = " select * from ".DB_PREFIX_DR."info where flag = 0 and status = 'WAIT' order by id desc limit 18  ";
        $info = $pdo->getAll($sql);
        $smarty->assign('drinfo',$info);
    }
    
    /**
     * 退出登录
     * */
    function exitlogin()
    {
        global $member;
        $member->ExitLogin();
         Header("Location: login.shtml");  
    }

?>
