<?php

session_start(); 
require_once('./member_config.php');

require_once('./data/cache/base_code.php');
//check_login();

if($_GET['op']=='dist2'){
    $showlevel = intval($_GET['level']);
    $showlevel = $showlevel >= 1 && $showlevel <= 4 ? $showlevel : 4;
    $values = array(intval($_GET['pid']), intval($_GET['cid']), intval($_GET['did']), intval($_GET['coid']));
    $elems = array();
    if($_GET['province']) {
        $elems = array($_GET['province'], $_GET['city'], $_GET['district'], $_GET['community']);
    }
    $container = $_GET['container'];
    $html = showdistricts($values, $elems, $container, $showlevel);
    echo $html;exit;
}
    


?>