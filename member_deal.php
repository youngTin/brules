<?php
session_start();
    require_once('./member_config.php');
//    check_login();
    $smarty = new WebSmarty();
    $smarty->caching = false;
    $pdo=new MysqlPdo();
    $pdo=new MysqlPdo();
    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
    case 'index':index(); //首页页面
        exit;
    case 'exit':exitlogin();//登录处理
        exit();
    case 'do': do_handle(); //增加信息处理
        exit();
    default:index();
        exit;
    }
    
    /**
     * 首页
     * */
    function index()
    {
        global $smarty,$pdo,$member,$hb;
        $tpl = "mydr/index.tpl";
        $smarty->assign('seoTitle','会员中心-和睦家');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    }
    
?>