<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 左边权限树信息
 * @author jctr<jc@cdrj.net.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: main.php,v 1.1 2012/02/07 09:03:01 gfl Exp $
 */

// 加载系统函数
require_once('../sys_load.php');
$verify = new Verify();
// 生成Smarty 对象
$smarty = new WebSmarty;

//程序路径
$smarty->assign('filepath',__FILE__);

//PHP版本
$smarty->assign('sysversion',PHP_VERSION);

//GD库信息
$gdinfo=gd_info();
$smarty->assign('gdinfo',$gdinfo['GD Version']);
$smarty->assign('freetype',$gdinfo['FreeType Support']);

//MySql版本
$pdo = new MysqlPdo();
$pdo->connect();
$smarty->assign('dbversion',$pdo->getDbVersion());

//Web服务器信息
$smarty->assign('sysos',$_SERVER['SERVER_SOFTWARE']);

$smarty->show();
?>