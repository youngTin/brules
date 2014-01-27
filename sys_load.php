<?php
/**
 * ϵͳ���ļ�������WEB_ROOT��
 * ����sys_config.php�ļ�����sys_config.php���������ϵͳ�������ò���
 *
 * ����common.func.php�ļ�����common.func.php�ļ��У���ϵͳ����Ĺ�������
 *
 * Created on 2011-08-05
 * @since Android_V2011
 * @author luodong
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: sys-load.php,v 1.0 2011/08/05 010:52:27
 */

/** Define WEB_ROOT as this files directory */
define( 'WEB_ROOT', dirname(__FILE__) . '/' );

date_default_timezone_set('Asia/ShangHai');

if (!session_id())session_start();

// ���ñ༭
header('Content-Type:text/html;charset=utf-8');

if ( defined('E_RECOVERABLE_ERROR') )
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);
else
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING);

if ( file_exists( WEB_ROOT . 'sys_config.php') ) {

	/** The sys_config file resides in WEB_ROOT */
	require_once( WEB_ROOT . 'sys_config.php' );

} else {

	// A sys_config file doesn't exist
	die("ϵͳ����sys_config.php�����ļ������ڣ�");

}

if ( file_exists(WEB_ROOT . 'includes/common.func.php') ) {

	/** The functions file resides in WEB_ROOT */
	require_once( WEB_ROOT . 'includes/common.func.php' );

} else {

	// A functions file doesn't exist
	die("ϵͳ����includes/common.func.php�ļ������ڣ�");
}
//ini_set("display_errors","on");
?>
