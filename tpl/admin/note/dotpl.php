<?php
/**
 * Created on 2008-03-20 
 * 后台管理 - 左边权限树信息
 * @author jctr<jc@cdrj.net.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: dotpl.php,v 1.1 2012/02/07 09:00:43 gfl Exp $
 */

session_start();

// 加载系统函数
require_once('../../../includes/functions.php');
$verify = new Verify();
// 生成Smarty 对象
$smarty = new WebSmarty;
$step = $_GET['step'];
$tpl = "admin/note/co_add_step".$step.".tpl";
$smarty->show($tpl);
?>