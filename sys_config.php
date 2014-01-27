<?php
/**
 * Created on 2008-03-06
 * 系统配置文件
 * @since WEB_V2008
 * @author ld
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: config.php,v 1.11 2009/01/01 05:52:27
 */

/******************数据库相关配置**************************************/
define('DB_TYPE','mysql');
define('DB_HOST','localhost');
define('DB_NAME','mybrules');
define('DB_USER','root');
define('DB_PWD','ymvuzgkxmjm=');
define('DB_PORT','3306');
define('DB_PREFIX','web_');  //表前缀
define('DB_PREFIX_HOME','home_');  //表前缀
define('DB_PREFIX_DR','dr_');  //表前缀
define('DB_BOROUGH','-1');  //表前缀

//是否开启DEBUG
define('DB_MSG',true);

/******************系统目录******************************************/
// DIRECTORY_SEPARATOR 简写
define('DS',DIRECTORY_SEPARATOR);

// 定义MVC libs目录
define('LIBS_SMARTY', str_replace("includes", "", dirname(__FILE__)).'includes\smarty');

//缓存目录
define("WEB_CACHE", WEB_ROOT . "data/cache/");

//上传附近存储目录
define('UPLOAD_PATH',WEB_ROOT.'uploads');

//下载使用目录
define('UPDOWN_PATH',WEB_ROOT);

/******************smarty模板配置*************************************/
define('TPL_DIR',WEB_ROOT.'tpl');                       // 模板路径
define('TPL_COMPILE_DIR',WEB_ROOT.'data/tpl_compile');  // 模板编译路径
define('TPL_CACHE_DIR',WEB_ROOT.'data/tpl_cache');      // 模板缓存路径
//define('TPL_CONFIG_DIR',WEB_ROOT.'configs');     // 模板配置路径,将该目录放在smarty目录中

/******************Cookie配置****************************************/
// Cookie有效期
define('COOKIE_EXPIRE',3600);

// Cookie有效域名
define('COOKIE_DOMAIN','');

// Cookie路径
define('COOKIE_PATH','/');

// Cookie前缀 避免冲突
define('COOKIE_PREFIX','ck_');

//发布房源的管理者
$NO_ALLOW_USER = array('lee','timdog','luodong1','issac0099');
/*********************积分配置*****************************************/
// 新注册用户赠送积分
define('REG_SCORES',200);

// 登录一次所得积分,每天只能获得一次
define('LOGIN_SCORES',20);

// 成功举报一次所得积分
define('REPORT_SCORES',40);

// 对和睦家网提出的建议被采纳
define('OPINIONS_SCORES',40);

// 邀请好友注册驾照888网
define('INVITE_SCORES',5);

// 查看房东信息,消费3个积分
define('WATCH_JZ_SCORES',5);

// 短信链接地址
define('SEND_MESS_USER',"vivi");
define('SEND_MESS_PASSWORD',"2241595");
define('SEND_MESS_URL',"http://s.9dinghan.com:8080/Message.sv?method=sendMsg&userCode=".SEND_MESS_USER."&userPwd=".SEND_MESS_PASSWORD."&charset=utf-8&");

//积分信息
$scores_option = array(
	'reg_scores'=>array('注册赠送积分',REG_SCORES,'分'),
	'login_scores'=>array('登录所得积分,每天只限一次',LOGIN_SCORES,'分/天'),
	'report_scores'=>array('举报中介房源所得积分',REPORT_SCORES,'分/套'),
	'opinions_scores'=>array('对网站提出的建议被采纳',OPINIONS_SCORES,'分/条'),
	'invite_scores'=>array('邀请好友注册驾照888网',INVITE_SCORES,'分/人'),
	'watch_tel_scores'=>array('查看房东信息',WATCH_TEL_SCORES,'分/套')
);

// 查看电话,消费3个积分
define('BASE_NUMBER',5);

/******************发送邮件配置***************************************/
//邮件服务器
define('SMTP_SERVER','smtp.163.com');
//邮件端口
define('SMTP_PORT',25);
//用户名
define('SMTP_USER','younglly@163.com');
//密码
define('SMTP_PWD','');
//发件人 - 一般与用户名一致
define('SMTP_SENDUSER','younglly@163.com');
//是否开启DEBUG
define('SMTP_DEBUG',true);
//发送时连接加密密码
define('SMTP_LINK_PWD','123');
/******************导入缓存配置***************************************/
if ( file_exists( WEB_CACHE . 'web_config.php') ) {

	/** The web_config file resides in WEB_ROOT */
	require_once( WEB_CACHE . 'web_config.php' );

} else {

	// A web_config file doesn't exist
	die("系统错误：web_config.php配置文件不存在！");

}

?>