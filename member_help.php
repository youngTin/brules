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
    default:index();
        exit;
    }
    
    function index()
    {
         global $smarty,$pdo;
         $id = empty($_GET['id']) ? '545' : $_GET['id'] ;
         $res = $pdo->find('web_contentindex','id='.$id,'mid,cid,title,postdate');
         if($res)
        {
            $tab = 'web_content'.$res['mid'];
            $info = $pdo->find($tab,'id='.$id);
            $info = array_merge($info,$res);
        }
         $smarty->assign('info',$info);
         $smarty->show('mydr/help.tpl');
    }
    
?>