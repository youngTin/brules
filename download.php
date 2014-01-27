<?php
/**
 * This software is the proprietary information of PHPWind.com.
 * $Id: download.php 513 2008-02-18 09:41:17Z vcteam $
 * @Copyright (c) 2003-08 PHPWind.com Corporation.
 */
require_once('sys_load.php');
$id = $_GET['id'];
if(!$id){
	page_prompt('�Ƿ���Ϣ��',$isok=true,$_SERVER['HTTP_REFERER']);
}
$pdo = new MysqlPdo();
$rt = $pdo->getRow("SELECT * FROM web_attach WHERE aid='$id'");
if(empty($rt)){
	header("HTTP/1.1 404 Not Found");
	exit;
}
@extract($rt);

$file = WEB_ROOT.'/'.$rt['filepath'];

switch($type){
	case "pdf"	: $ctype = "application/pdf"; break;
	case "exe"	: $ctype = "application/octet-stream"; break;
	case "rar"	: $ctype = "application/rar"; break;
	case "zip"	: $ctype = "application/zip"; break;
	case "doc"	: $ctype = "application/msword"; break;
	case "xls"	: $ctype = "application/vnd.ms-excel"; break;
	case "ppt"	: $ctype = "application/vnd.ms-powerpoint"; break;
	case "gif"	: $ctype = "image/gif"; break;
	case "png"	: $ctype = "image/png"; break;
	case "jpeg"	:
	case "jpg"	: $ctype = "image/jpg"; break;
	case "mp3"	: $ctype = "audio/mpeg"; break;
	case "wav"	: $ctype = "audio/x-wav"; break;
	case "mpeg"	:
	case "mpg"	:
	case "mpe"	: $ctype = "video/mpeg"; break;
	case "mov"	: $ctype = "video/quicktime"; break;
	case "avi"	: $ctype = "video/x-msvideo"; break;
	case "php"	:
	case "htm"	:
	case "html"	: die("<b>Cannot be used for $type files!</b>"); break;
	default		: $ctype = "application/force-download";
}
$browser = $_SERVER["HTTP_USER_AGENT"];
if (preg_match("/MSIE/", $browser)) {
	$filename = "=".urlencode($filename);
}elseif (preg_match("/Firefox/", $browser)) {
	$filename = "*=utf8''".urlencode($filename);
}else {
	$filename = "=".$filename;
}
ob_end_clean();
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Type: $ctype");
header("Content-Disposition: attachment; filename".$filename);
header("Content-Transfer-Encoding: binary");
header("Content-Length: $size");
@readfile($file);
?>