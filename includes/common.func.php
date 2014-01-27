<?php
/**
 * Created on 2008-03-06
 * 公共函数库
 * @since WEB_V2008
 * @author luodong<deathking1983@sina.com>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: common.func.php,v 1.1 2012/02/07 08:59:18 gfl Exp $
 */


/**
 * 系统自动加载类库
 * @param string $className 对象类名
 * @return void
 */
function __autoload($className) {
	//echo $className = strtolower($className);
    $classPath = WEB_ROOT."includes/{$className}";
    if(file_exists($classPath.".class.php")) {
        require_once($classPath.".class.php");
        return ;
    } else{
        throw_exception($className."包含的文件不存在，请检查路径!");
    }
    //require_once(WEB_ROOT."includes/{$className}.class.php");
    //return ;
    
}

function dhtmlspecialchars($string) { 
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = dhtmlspecialchars($val);
        }
    } else {
        $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1',
        str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
        
    }
    return $string;
}

function dhtmlspecialchars_decode($string) {
    if(is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = dhtmlspecialchars_decode($val);
        }
    } else {
        $string = str_replace( array('&amp;', '&quot;', '&lt;', '&gt;'),array('&', '"', '<', '>'), $string);
    }
    return $string;
}

/**
 +----------------------------------------------------------
 * 仿连接池得到数据库连接
 +----------------------------------------------------------
 * @return 数据库连接
 +----------------------------------------------------------
 */
function getPdo(){
    return new MysqlPdo();
    /*
    if(empty($_SESSION['_aPdoLink_'])){
        $_aPdoLink_ = array();
        $_aPdoLink_[] = new MysqlPdo;
		$_SESSION['_aPdoLink_'] = $_aPdoLink_;
	} else {
		if(count($_SESSION['_aPdoLink_']) < POOL_SIZE) {
            $_aPdoLink_ = $_SESSION['_aPdoLink_'];
            $_aPdoLink_[] = new MysqlPdo;
            $_SESSION['_aPdoLink_'] = $_aPdoLink_;
		}
	}

	//srand((float) microtime() * 10000000);
    $_aPdoLink_ = $_SESSION['_aPdoLink_'];
	$pdoKey = array_rand($_aPdoLink_);
	$oPdo = $_aPdoLink_[$pdoKey];

	if(gettype($oPdo) != "object") {
		$oPdo = new MysqlPdo;
		$_SESSION['_aPdoLink_'][$pdoKey] = $oPdo;
	}
    */
}

/**
* 格式化参数
*
* 调用举例:
* <code>
* 生成加密串
* $aPara = array("id"=>10, "name"=>"tom's", addr=>"四川省，成都市");
* formatParameter($aPara, "in");
* // 返回：YWRkciwlQ0IlQzQlQjQlQTglQ0ElQTElQTMlQUMlQjMlQzklQjYlQkMlQ0ElRDAsaWQsMTAsbmFtZSx0b20lMjdz
*
* 将加密串还原成数组
* $str = "YWRkciwlQ0IlQzQlQjQlQTglQ0ElQTElQTMlQUMlQjMlQzklQjYlQkMlQ0ElRDAsaWQsMTAsbmFtZSx0b20lMjdz";
* formatParameter($aPara, "out");
* // 返回：
* Array
* (
*    [addr] => 四川省，成都市
*    [id] => 10
*    [name] => tom's
* )
* </code>
*
* @access public
* @param $ipt   输入数据
* @param $type  参数转化类型 in:生成加密传递字符串，out:将加密字符串还原成数组
* @return Array 或 String 根据转换类型返回指定数据
*/
function formatParameter($ipt, $type = "in") {
    if(empty($ipt)) return "";
    $output = null; // 返回数据
    $arrTemp = array(); // 临时数组
    if("in" === $type) { // 参数输入转换
        if(is_string($ipt) || is_int($ipt))  return $ipt = rawurlencode(base64_encode(rawurlencode(trim($ipt))));

        if(is_array($ipt)) ksort($ipt);

        foreach ($ipt as $k => $v) { // 编码字符
            $arrTemp[] = rawurlencode(trim($k));
            $arrTemp[] = rawurlencode(trim($v));
        }
        $output = rawurlencode(base64_encode(implode("`", $arrTemp)));

    }else{ // 将参数还原
        $strTemp = base64_decode(rawurldecode(trim($ipt)));
        $arrTemp = split ('`', $strTemp);
        $iLen = count($arrTemp);

        // 直接数据串加密
        if($iLen == 1) return rawurldecode($arrTemp[0]);

        $output = array();
        for($i = 0; $i < $iLen; ) $output[rawurldecode($arrTemp[$i++])] = rawurldecode($arrTemp[$i++]);

    }

    return $output;
}

	/**
	* 这一个部分是生成authcode的，用的是base64加密，分别能加密和解密。通过传入$operation = 'ENCODE'|'DECODE'来实现。
	* @para string $string 要加/解密的string
	* @para string $operation 方法(个人觉得用boolean比较好) 
	* @para string $key 用来加密的key
	* 
	* @return string
	*/
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

	$ckey_length = 4;

	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}

/**
 * 建立多级目录
 *
 * @return void
 */
function mk_dir($dir){
    $ap = split('[/]', $dir);
    foreach($ap as $v){
        if(!empty($v)){
            if(empty($path)) $path=$v;
            else $path.='/'.$v;
            file_exists(WEB_ROOT."/".$path) or @mkdir(WEB_ROOT."/".$path);
        }
    }
}

/**
 * 判断目录是否为空
 *
 * @return void
 */
function empty_dir($directory){
    $handle = opendir($directory);
    while (($file = readdir($handle)) !== false) {
        if ($file != "." && $file != ".."){
            closedir($handle);
            return false;
        }
    }
    closedir($handle);
    return true;
}


/**
 * 得到客户IP
 *
 * @return String IP地址
 */

function getClientIp(){
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return($ip);
}


/**
 * URL重定向
 *
 * @param String $url 路径
 * @param Integer $time 时间(秒)
 * @param String $msg 提示信息
 */
function redirect($url,$time=0,$msg='') {

    //多行URL地址支持
    $url = str_replace(array("\n", "\r"), '', $url);
    if(empty($msg)) {
        $msg = "系统将在{$time}秒之后自动跳转到{$url}！";
    }

    if (!headers_sent()) {
        // redirect text/html; charset=utf-8
        header("Content-Type:text/html; charset=utf-8");
        if(0===$time) {
            header("Location: ".$url);
        }else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    }else {
        $str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if($time!=0) {
            $str .= $msg;
        }
        exit($str);
    }
}

/**
 * 错误输出
 * 定向到指定的错误页面
 * @param mixed $error 错误信息 可以是数组或者字符串
 * 数组格式为异常类专用格式 不接受自定义数组格式
 * @return void
 */
function halt($error) {
	if(!DB_MSG){header("Location:".URL);}
	$errMsg = "";
	$arrErrors = array();
	if(!is_array($error)) {
        $aTrace = debug_backtrace();
		$errMsg = $error;
		$iCount = count($aTrace);
		$now = date("y-m-d H:i:m");
		for($i=1; $i<$iCount; $i++) {
			$_at = $aTrace[$i];
			$arrErrors[] = '['.$now.'] '.(str_replace(WEB_ROOT, DS, $_at['file'])).' (第 '.$_at['line'].' 行) ' . $_at['class'].$_at['type'].$_at['function']."()";
		}
    }else {
		$errMsg = implode($error, "<br/>");
        $arrErrors = $error;
    }
	include WEB_ROOT.'data/errors/exception.php';
    exit;
}

/**
 * 输出页面提示信息
 */
function page_msg($msg='',$isok=true,$url='',$time=5,$ajax=0,$other=''){
	include WEB_ROOT.'data/errors/msg.php';
    exit;
}

/**
 * 友情信息提示页
 * @param $msg 传入消息
 * @param $isok 判断输出成功或失败信息
 * @param $gourl 转向URL
 * @param $limittime 等待时间
 * @param $data 更多信息
 * */
function page_prompt($msg,$isok=true,$gourl,$limittime=3,$data='')
{
	global  $smarty;
	$smarty->assign('msg',$msg);
	$smarty->assign('gourl',$gourl);
	$smarty->assign('litime',$limittime);
	$smarty->assign('isok',$isok);
	$smarty->assign('data',$data);
	$smarty->show('brules/erro.tpl');exit;
}
function page_prompt1($msg,$isok=true,$gourl,$limittime=3,$data='')
{
    global  $smarty;
    $smarty->assign('msg',$msg);
    $smarty->assign('gourl',$gourl);
    $smarty->assign('litime',$limittime);
    $smarty->assign('isok',$isok);
    $smarty->assign('data',$data);
    $smarty->show('brules/erro.tpl');exit;
}

/**
 * 自定义异常处理
 *
 * @param String $msg
 */
function throw_exception($msg) {
	halt($msg);
}

/**
 * 字符串截取，支持中文和其他编码
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        return mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        return iconv_substr($str,$start,$length,$charset);
    }

    $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']	  = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']	  = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    if($suffix) return $slice."…";
    return $slice;
}

/**
 * 产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
 * @param string $len 长度
 * @param string $type 字串类型
 * 0 字母 1 数字 其它 混合
 * @param string $addChars 额外字符
 * @return string
 */
function rand_string($len=6, $type='', $addChars='') {
    $str ='';
    switch($type) {
        case 0:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
        case 1:
            $chars= str_repeat('0123456789',3);
            break;
        case 2:
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
            break;
        case 3:
            $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
            break;
         //case 4: // 中文字符串在此
        default :
            // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
            $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
            break;
    }

    if($len>10 ) {//位数过长重复字符串一定次数
        $chars = ($type==1) ? str_repeat($chars,$len) : str_repeat($chars,5);
    }

    if($type!=4) {
        $chars = str_shuffle($chars);
        $str = substr($chars,0,$len);
    }else{
        // 中文随机字
        for($i=0;$i<$len;$i++){
            $str.= msubstr($chars, floor(mt_rand(0,mb_strlen($chars,'utf-8')-1)),1);
        }
    }
    return $str;
}

//加指定符号
function addSign($str, $len, $sign='0'){
	if(strlen($str) >= $len) return $str;
	$str = $sign."".$str;
	return addSign($str,$len,$sign);
}

// xml编码
function xml_encode($data,$encoding='utf-8',$root="think") {
    $xml = '<?xml version="1.0" encoding="'.$encoding.'"?>';
    $xml.= '<'.$root.'>';
    $xml.= data_to_xml($data);
    $xml.= '</'.$root.'>';
    return $xml;
}

function data_to_xml($data) {
    if(is_object($data)) {
        $data = get_object_vars($data);
    }
    $xml = '';
    foreach($data as $key=>$val) {
        is_numeric($key) && $key="item id=\"$key\"";
        $xml.="<$key>";
        $xml.=(is_array($val)||is_object($val))?data_to_xml($val):$val;
        list($key,)=explode(' ',$key);
        $xml.="</$key>";
    }
    return $xml;
}

function xml_to_array($xml) {
	$xmlary = array();

	$reels = '/<(\w+)\s*([^\/>]*)\s*(?:\/>|>(.*)<\/\s*\\1\s*>)/s';
	$reattrs = '/(\w+)=(?:"|\')([^"\']*)(:?"|\')/';

	preg_match_all($reels, $xml, $elements);

	foreach ($elements[1] as $ie => $xx) {
		$xmlary[$ie]["name"] = $elements[1][$ie];

		if ($attributes = trim($elements[2][$ie])) {
			preg_match_all($reattrs, $attributes, $att);
			foreach ($att[1] as $ia => $xx)
				$xmlary[$ie]["attributes"][$att[1][$ia]] = $att[2][$ia];
			}

			$cdend = strpos($elements[3][$ie], "<");
			if ($cdend > 0) {
				$xmlary[$ie]["text"] = substr($elements[3][$ie], 0, $cdend - 1);
			}

			if (preg_match($reels, $elements[3][$ie]))
				$xmlary[$ie]["elements"] = xml2array($elements[3][$ie]);
			else if ($elements[3][$ie]) {
				$xmlary[$ie]["text"] = $elements[3][$ie];
			}
       }
	   return $xmlary;
}

/**
 * 读取文件内容
 * @copyright PHPWind
 * @param string $filename
 * @param string $method
 * @return string
 */
function readover($filename,$method="rb"){
	strpos($filename,'..')!==false && exit('Forbidden');
	if($handle=@fopen($filename,$method)){
		flock($handle,LOCK_SH);
		$filedata=fread($handle,filesize($filename));
		fclose($handle);
	}
	return $filedata;
}

/**
 * 将指定内容写入文件
 * @copyright PHPWind
 * @param string $filename 文件名
 * @param string $data 要写入的数据
 * @param string $method 操作方法
 * @param boolean $iflock 是否锁定
 */
function writeover($filename,$data,$method="rb+",$iflock=1,$check=1,$chmod=1){
	$check && strpos($filename,'..')!==false && exit('Forbidden');
	touch($filename);
	$handle=fopen($filename,$method);
	$iflock && flock($handle,LOCK_EX);
	if(@fwrite($handle,$data)=== FALSE){
		fclose($handle);
		return false;
	}
	//if($method=="rb+") ftruncate($handle,strlen($data));
	fclose($handle);
	$chmod && @chmod($filename,0777);
	return true;
}

/**
* 删除文件
* @access public
* @param string $file   删除的文件的路径(相对)
* @return boolean 删除成功否？
*/
function delete_file($file){
	if(empty($file)) return false;
	$file = WEB_ROOT.$file;
	if (! file_exists($file)) return false;
	return unlink($file);
}

/**
* 删除文件夹及其文件夹下所有文件
* @param string $dir   删除的文件夹的路径(相对)
* @return boolean 删除成功否？
*/
function delete_dir($dir) {
	//if (@rmdir($dir)==false && is_dir($dir)) { 
		if ($dp = opendir($dir)) { 
			while (($file=readdir($dp)) != false) {
				if ($file!='.' && $file!='..') { 
					$fullpath=$dir."/".$file;
					if(is_dir($fullpath)){
						delete_dir($fullpath); 
					} else {
						unlink($fullpath); 
					} 
				}
			} 
			closedir($dp);
			if(rmdir($dir)){
				return true;
			} else {
				return false;
			}
		} else { 
			exit('Not permission'); 
		} 
	//} 
}

/**
* 获取执行时间
* @access public
* @return float 时间秒
*/
function getmicrotime(){
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

/**
+----------------------------------------------------------
* 将日期字符串变成int
+----------------------------------------------------------
* @access public
+----------------------------------------------------------
* @param string $d    字符串的日期
* @param string $type 转换类型 st:从0开始的日期
+----------------------------------------------------------
* @return boolean 删除成功否？
+----------------------------------------------------------
*/
function date2int($d,$type="st"){
	if(empty($d) || !is_string($d) || strlen($d)<8) return 0;
	list($y, $m, $d) = split('[/.-]', $d);
	$iTime = 0;
	if($type == "st"){ //开始日期从0点0分起
		$iTime = mktime(0,0,0,$m,$d,$y);
	}else{
		$iTime = mktime(23,59,59,$m,$d,$y);
	}
	return $iTime;
}


/**
+----------------------------------------------------------
* 获取 Soap 对象
+----------------------------------------------------------
* @access public
+----------------------------------------------------------
* @return Object Soap 对象
+----------------------------------------------------------
*/
function getSoapClient(){
	$client = new SoapClient(WSDL_URL);
	return $client;
}


/**
+----------------------------------------------------------
* 组织 Soap SQL
+----------------------------------------------------------
* @access public
+----------------------------------------------------------
* @param string $tSql 对应 SQL 模板的 key $soapSqlConfig= array("key" => "sql" );
* @param array  $para 对应参数array("key"=>"value");
* @param string $flag 对应操作[insert, select]
+----------------------------------------------------------
* @return string 构造好的SQL语句
+----------------------------------------------------------
*/
function buildSqlString($tSql, $para = array(), $flag = 'select'){

	$sql="";

	$sql = $GLOBALS['soapSqlConfig'][$tSql];
	//$sql = iconv("UTF-8", "GBK", $sql);

	for ($i=0,$para_keys = array_keys($para), $m=sizeof($para_keys); $i<$m; $i++)
	{
		$para_key = $para_keys[$i];
		$para_val = $para[$para_key];

		$sql = str_ireplace("#". $para_key ."#", $para_val, $sql);

	}

	if($flag == 'select')
	{
		$sql="<?xml version=\"1.0\" encoding=\"GBK\" standalone=\"yes\"?><root xmlns=\"@http://www.cdrj.net.cn/xml\"   self=\"@execsql\"><sql>".base64_encode( $sql)."</sql></root>";
	}

	return $sql;
}

/**
+----------------------------------------------------------
* 解析 Soap 调用结果
+----------------------------------------------------------
* @access public
+----------------------------------------------------------
* @param string $tSql 对应 SQL 模板的 key $soapSqlConfig= array("key" => "sql" );
* @param array  $para 对应参数array("key"=>"value");
* @param string $flag 对应操作[insert, select]
+----------------------------------------------------------
* @return string 构造好的SQL语句
+----------------------------------------------------------
*/
function analysisSoapCallResult($tSql, $para = array()){
	$cvArray	= array();
	$metaarray	= array();
	$isError	= false;

	$sql = buildSqlString($tSql, $para,"select");

	$client = getSoapClient();
	$sResult= $client->__soapCall("doRequest",array($sql));


	if ($sResult){

		$doc = new DOMDocument();
		$doc->loadXML($sResult);

		$messages=$doc->getElementsByTagName("message");

		if($messages->length > 0){

			$msg = base64_decode($messages->item(0)->nodeValue);

			$isError=true;
			return "Read Soap Data Error[{$msg}]";
		}

		$issuccess=$doc->getElementsByTagName("issuccess");

		if($issuccess->length>0){
			$successmsg=base64_decode($issuccess->item(0)->nodeValue);
			$isError=false;
		}

		$metas	= $doc->getElementsByTagName("meta");
		$meta	= $metas->item(0);
		$fields	= $meta->getElementsByTagName("field");

		for($j=0;$j<$fields->length;$j++){

			$field=$fields->item($j);
			$fieldType=$field->getAttribute("fieldtype");
			$Name=$field->getAttribute("name");

			if (!empty($fieldType) && !array_key_exists($Name,$metaarray)) {
				$metaarray[$Name]=$fieldType;
			}
		}

		// 数据处理
		$rows=$doc->getElementsByTagName("row");

		for($i=0;$i<$rows->length;$i++){
			$eachRowValue=array();
			$row = $rows->item($i);
			$fields=$row->getElementsByTagName("field");

			for($j=0;$j<$fields->length;$j++){
				$field=$fields->item($j);
				$Name=$field->getAttribute("name");
				$value=$field->nodeValue;

				$value=iconv("GBK", "UTF-8", base64_decode($value));
				//$value = base64_decode($value);

				if($metaarray[$Name]=="VARCHAR"){
						$value=$value;
				}

				if($metaarray[$Name]=="INTEGER"){
					if(empty($value)){
						$value=0;
					}
				}

				if($metaarray[$Name]=="CHAR"){
					$value=$value;
				}

				if($metaarray[$Name]=="CHARACTER"){
					$value=$value;
				}

				if($metaarray[$Name]=="DATE"){

					$value=trim($value," ");

					if(empty($value)){
						$value='null';
					}
					else{
						$value=$value;
					}
				}

				if($metaarray[$Name]=="DECIMAL"){
					if(empty($value)){
						$value=0.00;
					}
				}
				if(!array_key_exists($Name,$eachRowValue)){
					$eachRowValue[$Name]=$value;
				}
			}

			$cvArray[] = array_change_key_case($eachRowValue);
		}

		return $cvArray;
	}
	else{
		return "Read Soap Data Error[Empty]";
	}

}
/**
* Ajax 相关的函数
*/
/**
* 当没有找到 PHP 内置的 JSON 扩展时，使用 PEAR::Service_JSON 来处理 JSON 的构造和解析
*
* 强烈推荐所有 PHP 用户安装 JSON 扩展，获得最好的性能表现。
*/

if (!function_exists('json_encode')) {
	/**
	* 将变量转换为 JSON 字符串
	*
	* @param mixed $value
	*
	* @return string
	*/
	function json_encode($value)
	{
		static $instance = array();
		if (!isset($instance[0])) {
			require_once('JSON.php');
			$instance[0] =& new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		}
		return $instance[0]->encode($value);
	}
}

if (!function_exists('json_decode')) {
	/**
	* 将 JSON 字符串转换为变量
	*
	* @param string $jsonString
	*
	* @return mixed
	*/
	function json_decode($jsonString)
	{
		static $instance = array();
		if (!isset($instance[0])) {
			require_once('JSON.php');
			$instance[0] =& new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		}
		return $instance[0]->decode($jsonString);
	}
}
/**
 * 验证码
 * */
function GetCkVdValue()
{
	@session_start();
	return isset($_SESSION['securimage_code_value']) ? $_SESSION['securimage_code_value'] : '';
}

//php某些版本有Bug，不能在同一作用域中同时读session并改注销它，因此调用后需执行本函数
function ResetVdValue()
{
	@session_start();
	$_SESSION['securimage_code_value'] = '';
}
/**
 * 价格处理 多个页面调用放在此处
 * @param	$layou_id	楼盘ID
 * @param	$table		查询单独物业类型数据
 * @param	$order		是否按照住宅->别墅->写字楼->商业排序
 * */
function GetPrice($layou_id,$table=NULL,$order=FALSE)
{
	global $pdo;
	if ($order) //排序
	{
		//$tb =array('22305'=>'home_layout_house','22301'=> 'home_layout_villa','22305'=> 'home_layout_facilities_inner','22304'=> 'home_layout_business');
		$tb = array();
		$res_array =array();
		$new = $pdo->getRow("SELECT	pm_type FROM home_layout_new WHERE id =  '$layou_id'");
		$new_array =explode(',',$new['pm_type']);
	
		foreach ($new_array as $k=>$v)
		{
			if (in_array('22308',$new_array))
			{
				array_push($tb,'home_layout_house');
			}
			if (in_array('22301',$new_array))
			{
				array_push($tb,'home_layout_villa');
			}
			if (in_array('22305',$new_array))
			{
				array_push($tb,'home_layout_facilities_inner');
			}
			if (in_array('22304',$new_array))
			{
				array_push($tb,'home_layout_business');
			}
		}

		foreach ($tb as $k=>$v)
		{
			$res = $pdo->getRow("SELECT	* FROM	$v	WHERE	layout_id =$layou_id");
			$res_array[] .=$res['price_average'];
		}
		$res_array=array_merge(array_filter($res_array));
		return @$res_array[0];
	}
	else 
	{
			$res_sql = $pdo->getRow("SELECT	*	FROM	$table	WHERE	layout_id =  '$layou_id'");
			if ($table=='home_layout_facilities_inner')
			{
					if (empty($res_sql['price_average']))
						return $res_sql['rent_price_average'];
					else 
						return  $res_sql['price_average'];
			
			}
			return  $res_sql['price_average'];
	}
}
/**
 * 消息处理函数 用于房产百科网
 * @param $msg 传入消息
 * @param $gourl 转向URL
 * @param $onlymsg 是否填出窗口
 * @param $limittime 等待时间
 * */
function ShowMsg($msg,$gourl,$onlymsg=0,$limittime=0)
{
	$url=GetCurUrl();
	//if(empty($GLOBALS['cfg_phpurl'])) $GLOBALS['cfg_phpurl'] = '..';

	$htmlhead  = "<html>\r\n<head>\r\n<title>".WEB_TITLE."--提醒你!</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
	$htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:160%;}</style></head>\r\n<body leftmargin='0' topmargin='0'>\r\n<center>\r\n<script>\r\n";
	$htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

	$litime = ($limittime==0 ? 1000 : $limittime);
	$func = '';

	if($gourl=='-1')
	{
		if($limittime==0) $litime = 5000;
		$gourl = "javascript:history.go(-1);";
	}

	if($gourl=='' || $onlymsg==1)
	{
		$msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
	}
	else
	{
		//当网址为:close::objname 时, 关闭父框架的id=objname元素
		if(eregi('close::',$gourl))
		{
			$tgobj = trim(eregi_replace('close::', '', $gourl));
			$gourl = 'javascript:;';
			$func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";
		}
		
		$func .= "      var pgo=0;
      function JumpUrl(){
        if(pgo==0){ location='$gourl'; pgo=1; }
      }\r\n";
		$rmsg = $func;
		$rmsg .= "document.write(\"<br /><div style='width:450px;padding:0px;border:1px solid #79b031;'>";
		$rmsg .= "<div style='padding:6px;font-size:12px;border-bottom:1px solid #79b031;background:#666666 url(/ui/newhouse/img/view/ts_title_bg.gif)';'><b style='color:#ffffff'>".WEB_TITLE."--提醒您！</b></div>\");\r\n";
		$rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");\r\n";
		$rmsg .= "document.write(\"".str_replace("\"","“",$msg)."\");\r\n";
		$rmsg .= "document.write(\"";
		
		if($onlymsg==0)
		{
			if( $gourl != 'javascript:;' && $gourl != '')
			{
				$rmsg .= "<br /><a href='{$gourl}'>如果你的浏览器没反应，请点击这里...</a>";
				$rmsg .= "<br/></div>\");\r\n";
				$rmsg .= "setTimeout('JumpUrl()',$litime);";
			}
			else
			{
				$rmsg .= "<br/></div>\");\r\n";
			}
		}
		else
		{
			$rmsg .= "<br/><br/></div>\");\r\n";
		}
		$msg  = $htmlhead.$rmsg.$htmlfoot;
	}
	echo $msg;exit;
}


//获得当前的脚本网址
function GetCurUrl()
{
	if(!empty($_SERVER["REQUEST_URI"]))
	{
		$scriptName = $_SERVER["REQUEST_URI"];
		$nowurl = $scriptName;
	}
	else
	{
		$scriptName = $_SERVER["PHP_SELF"];
		if(empty($_SERVER["QUERY_STRING"]))
		{
			$nowurl = $scriptName;
		}
		else
		{
			$nowurl = $scriptName."?".$_SERVER["QUERY_STRING"];
		}
	}
	return $nowurl;
}
/**
 * FckEdit编辑器处理函数
 * @param	$fname	接受名
 * @param	$fvalue	返回值
 * @param	$width	FckEdit宽
 * @param	$nheight	FckEdit高
 * @param	$etype	类型
 * @param	$gtype	普通或HTML
 * @param	$isfullpage	是否自动添加html标签
 * */
function GetFckEditor($fname,$fvalue,$width,$nheight="350",$style='default',$etype="Basic",$gtype=null,$isfullpage="false")
{
		$dirn  = dirname(__FILE__);
		require_once('./ui/fckeditor/fckeditor.php'); //加载fck类
		$fck = new FCKeditor($fname);
		$fck->BasePath		= './ui/fckeditor/' ; //定义fck目录
		$fck->Width		= $width ;
		$fck->Height		= $nheight ;
		$fck->ToolbarSet	= $etype ;
		$fck->Config['FullPage'] = $isfullpage;
		$fck->Config['EnableXHTML'] = 'true';
		$fck->Config['EnableSourceXHTML'] = 'true';
		$fck->Value = $fvalue ;
		if($gtype=="print")
		{
			return $fck->Create();
		}
		else
		{
			return $fck->CreateHtml();
		}
		
	
}

//根据id获取房型
if(!function_exists(getFitment))
{
	function getFitment($id) {
	    //详细信息
	    if (empty($id)) {
	    	return false;
	    }
	    $result = getPdo()->getRow("SELECT a.*,b.name FROM ".DB_PREFIX_HOME."esf as a left join ".DB_PREFIX_HOME."code_basic as b on a.fitment=b.code where a.id=$id");
	      //房型
	   $type=explode(',',sprintf(",%s室,%s厅,%s卫,%s阳台",$result['room'],$result['parlor'],$result['toilet'],$result['porch']));
	   $key = array_search('0室',$type);
	   $key1 = array_search('0厅',$type);
	   $key2 = array_search('0卫',$type);
	   $key3 = array_search('0阳台',$type);
	   if($key=='1' || $key1=='2' || $key2=='3' || $key3=='4')
	   {
	       unset($type[0]);
	       unset($type[$key]);
	       unset($type[$key1]);
	       unset($type[$key2]);
	       unset($type[$key3]);
	   }
	    $type = implode("'",$type);
	    $comma_separated = ereg_replace("'",'',$type);
	    return $comma_separated;
	}
}

/**
+----------------------------------------------------------
* 高亮
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function HighLight($para,$str)
{
	if(!empty($para))
	{
		$str = str_ireplace($para,'<span class="f_orange">'.$para.'</span>',$str) ;
	}
	
	return $str ;
}
/**
+----------------------------------------------------------
* 字符串长度
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function utf8_strlen($str=null)
{
	// 将字符串分解为单元
	preg_match_all("/./us", $str, $match);
	// 返回单元个数
	return count($match[0]);

}

function dimplode($array) {
    if(!empty($array)) {
        return "'".implode("','", is_array($array) ? $array : array($array))."'";
    } else {
        return 0;
    }
}
function showdistricts($values, $elems=array(), $container='districtbox', $showlevel=null,$istext=false,$textSplite='.') {
    $showlevel = !empty($showlevel) ? intval($showlevel) : count($values); 
    $showlevel = $showlevel <= 3 ? $showlevel : 3;
    $upids = array(1);
    for($i=0;$i<$showlevel;$i++) {
        if(!empty($values[$i])) {
            $upids[] = intval($values[$i]);
        } else {
            for($j=$i; $j<$showlevel; $j++) {
                $values[$j] = '';
            }
            break;
        }
    }  
    $options = array(1=>array(), 2=>array(), 3=>array(), 4=>array());
    $pdo = getPdo();
    $query = "SELECT * FROM dr_region WHERE parent_id IN (".dimplode($upids).')';
    $dinfo = $pdo->getAll($query);
    foreach($dinfo as $value) {
        $options[$value['region_type']][] = array($value['region_id'], $value['region_name']);
    }
    $names = array('province', 'city', 'district', 'community');
    for($i=0; $i<4;$i++) {
        $elems[$i] = !empty($elems[$i]) ? $elems[$i] : $names[$i];
    }
    $html = ''; 
    for($i=0;$i<$showlevel;$i++) {
        $level = $i+1;
        $jscall = "showdistricts('$container', ['$elems[0]', '$elems[1]', '$elems[2]', '$elems[3]'], $showlevel, $level)";
        $html .= '<select name="'.$elems[$i].'" id="'.$elems[$i].'" onchange="'.$jscall.'">';
        $html .= '<option value="">不限</option>';
        foreach($options[$level] as $option) {
            if($istext&&$option[0] == $values[$i])$text[] = $option[1];
            $selected = $option[0] == $values[$i] ? ' selected="selected"' : '';
            $html .= '<option did="'.$option[0].'" value="'.$option[0].'"'.$selected.'>'.$option[1].'</option>';
        }
        $html .= '</select>';
        $html .= '&nbsp;&nbsp;';
    } 
    $html = $istext ? implode($textSplite,$text) : $html;
    return $html;
}
function getHeaderNote()
{
	$pdo = getPdo();
	$id = 243;
	$res = $pdo->getAll(' select id,mid,cid,title,postdate from web_contentindex  where cid='.$id);
	
	 return $res;
}

function sendMess($content,$tel,$did)
{
            $sendurl = SEND_MESS_URL."numbers=$tel&msgContent=$content";
            $result = file_get_contents($sendurl);
            $result = explode(',',$result);
            if($result[0]=='1'){
                 
                $sql = "  insert into ".DB_PREFIX_DR."sms_log set did = '$did' , send_num = '1', send_mob = '$tel' , send_content = '$content' , status = '1' ,add_time = now() ";
                $query = getPdo()->execute($sql);
            }else{
                 $sql = "  insert into ".DB_PREFIX_DR."sms_log set did = '$did' , send_num = '1', send_mob = '$tel' , send_content = '$content' , status = '0' ,add_time = now() ";
                 $query = getPdo()->execute($sql);
            }
        
    
}

function getDateTypesConfig($startYear="1995",$endYear=null,$order='desc')
{
     $endYear = !empty($endYear) ? $endYear : date("Y") ;   
     $len = intval($endYear)-intval($startYear);
     for($i=0;$i<=$len;$i++)
     {
         $value = $order =='desc' ? $endYear-$i : $startYear+$i;
		 $data[$value] = $value ;
     }
     return $data;
}
?>