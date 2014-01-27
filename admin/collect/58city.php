<?php
/**
* 抓取58个人房源数据
*/
require_once('../../data/cache/base_code.php');
require_once('../../sys_load.php');
$verify = new Verify();
$verify->validate_category();
header('Content-Type:text/html;Charset=utf-8');

function data($url) {
	$house_arr = array();
	$result = file_get_contents($url); //$result 获取 url 链接内容
	$pattern = '/<a[^>]+class=\"t\".*<\/a>/Usi';
	preg_match_all($pattern, $result, $arr); // 把内容 分配给数组$arr(二维数组)
	$arr = $arr[0];
	//获取每套房源信息
	for($i=0;$i<count($arr);$i++){
		//echo $arr[$i]."\n";
		$pattern = "|http:\/\/.*\.shtml|U";
		preg_match($pattern, $arr[$i], $url);
		//echo $url[0]."\n";
		//$house_str = file_get_contents($url[0]);
		$house_str = file_get_contents("http://cd.58.com/ershoufang/10372448937094x.shtml");
		$house_str=preg_replace("/\n+/", "", $house_str); //过滤多余回车

		//获取title
		$title = explode("<h1>",$house_str);
		$title = explode("</h1>",$title[1]);
		$house_arr['title'] = $title[0];

		//获取发布日期data 2012-06-30
		$pattern = "|2012.*[0-9]{2}.*[0-9]{2}|U";
		preg_match($pattern,$house_str,$date);
		$house_arr['date'] = $date[0];

		//获取房源描述describe 
		$pattern = '/<div[^>]+class=\"maincon\".*<\/div>/Usi';
		preg_match($pattern,$house_str,$describe);
		$house_arr['describe'] = $describe[0];

		//获取房源图片
		$pattern = '|img_list.push\(\"(.*)\"\);|Usi';
		preg_match_all($pattern,$house_str,$pic);
		$house_arr['pic'] = $pic[1];

		//获取房源信息-1
		$pattern = "/<ul[^>]+class=\"info\">(.*)<\/ul>/Usi";
		preg_match($pattern,$house_str,$content);

		//获取房东姓名
		
		
		$house_arr['content'] = $content[0];
		print_r($house_arr);
		exit;

	}
}
/**
 * stripOfficeTag($v)
 * @param string $v
 * @return string
 */
function stripContentTag($v){
	$v = str_replace('<p> </p>', '', $v);
    $v = str_replace('<p />', '', $v);
    $v = preg_replace('/<a href=".+" target="\_blank"><strong>(.+)<\/strong><\/a>/Usi', '\1', $v);
    $v = preg_replace('%(<span\s*[^>]*>(.*)</span>)%Usi', '\2', $v);
    $v = preg_replace('%(\s+class="Mso[^"]+")%si', '', $v);
    $v = preg_replace('%( style="[^"]*mso[^>]*)%si', '', $v);
    $v = preg_replace('/<b><\/b>/', '', $v);
    return $v;
}

function stripDateTag($v){
	$v = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$v);  
	$v = preg_replace('/.+([0-9]{4})/Usi','\1' ,$v);
	//$vc = explode("年",$vc);
	$vc['year'] = msubstr($v,0,4);
	$vc['moth'] = msubstr($v,5,2);
	$lastday = mktime(0, 0, 0, $vc['moth'], 0, $vc['year']);
	//echo intval($lastday);echo '<br>';
	//$vc = preg_match_all('/^[x7f-xff]+/Usi',$v,$vc);
	return $lastday;
}

/**
 * stripTitleTag($title)
 * @param string $v
 * @return string
 */
function stripAuthorTag($v) {
	//$v = preg_replace('/<a href=".+" target="\_blank">(.+)<\/a>/Usi', '\1', $v);
	$v = preg_replace('/<a id=".+" href=".+" target="\_blank">(.+)<\/a>/Usi', '\1', $v);
	$v = preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/","",$v);   
	return $v;
}

/**
 * mysqlString($str) 过滤数据
 * @param string $str
 * @return string
 */
function mysqlString($str) {
	return addslashes(trim($str));
}

/**
 * init($min, $max) 入口程序方法，从 $min 页开始取，到 $max 页结束
 * @param int $min 从 1 开始
 * @param int $max
 * @return string 返回 URL 地址
 */
function init($min=1, $max) {
	for ($i=$min; $i<=$max; $i++) {
		data("http://cd.58.com/ershoufang/0/");
	}
}
init(1, 1); #程序入口

?>