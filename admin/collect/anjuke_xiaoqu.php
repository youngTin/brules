<?php
/**
* 抓取安居客小区
*/
echo '小区数据已经抓取！';exit;
require_once('../../data/cache/base_code.php');
require_once('../../sys_load.php');
$verify = new Verify();
$verify->validate_category();
header('Content-Type:text/html;Charset=utf-8');
$code = 10000;
$nummmm = 1;
function data($url) {
	global $borough_option_del,$code;
	$pdo = getPdo();
	//echo $url;
	$result = file_get_contents($url); // $result 获取 url 链接内容
	//$pattern = '/<li><span class="box_r">.+<\/span><a href="([^"]+)"  title=".+" >.+<\/a><\/li>/Usi'; // 取得内容 url 的匹配正则
	$pattern = '/<div class="property2"(.*)<li/Usi';
	preg_match_all($pattern, $result, $arr); // 把内容 分配给数组$arr(二维数组)
	//print_r($arr);
	foreach ($arr[0] as $val) {
		$pa = '/<img class="thumbnail"(.+)[^>]<h4>(.+)<\/h4>[^Simsun">](.+)<\/span>[^#](.+)<\/a>[^<p class="date">](.+)<\/p>/Usi'; // 取得文章内容的正则
		preg_match_all($pa, $val, $array); // 把取到的内容分配到数组 $array
		//print_r($array);
		$data = array();
		//小区标题
		$data['reside'] = stripAuthorTag($array[2][0]);
		//小区坐标
		$map = explode("l1=",$array[4][0]);
		$map = explode("&",$map[1]);
		$map_y = $map[0];
		$map_x = substr($map[1],3);
		
		//小区片区
		$area = explode("[",$array[3][0]);
		$area = explode("&nbsp;",$area[1]);
		$chilren_area = explode("]",$area[1]);
		$data['area'] = $chilren_area[0];
		//小区地址
		$data['address'] = $chilren_area[1];
		//地区代码
		$borough = $area[0];
		foreach($borough_option_del as $key=>$val){
			if($val==$borough){
				$data['borough'] = $key;
				break;
			}else{
				$data['borough'] = 0;
			}
		}
		//竣工时间
		$completed_date = stripDateTag($array[5][0]);
		//print_r(stripDateTag($array[5][0]));echo "<br>";

		$sql_area = "select * from home_code_basic where pid=".$data['borough']." and name like '%".$chilren_area[0]."%'";
		$area_row = $pdo->getRow($sql_area);
		if(count($area_row)>1){
			//向小区数据库插入数据
			$data['property'] = 20301;
			if($map_y=='')$map_y=0;
			if($map_x=='')$map_x=0;
			$data['map_y'] = $map_y;
			$data['map_x'] = $map_x;
			$data['tube']=0;
			$data['circle']=0;
			$data['completed_date']=$completed_date;
			//判断该小区是否存在
			$sql_is = "select count(id) as cut from home_esf_district where reside='".$data['reside']."'";
			$isr = $pdo->getRow($sql_is);
			if($isr['cut']>0){
				echo '....<br />';
			}else{
				//print_r($data);
				echo "成功导入:".$nummmm."条";
				echo '<br />';
				$pdo->add($data,'home_esf_district');
			}
		}else{
			//向`home`.`home_code_basic` 表插入小片区
			//$code_base = array('code'=>$code++,'name'=>$chilren_area[0],'type'=>0,'pid'=>$data['borough'],'flag'=>1,'top'=>0);
			//$pdo->add($code_base,'home_code_basic');
			//print_r($chilren_area);echo '<hr />';
		}
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
		data("http://chengdu.anjuke.com/community/W0QQpZ".$i);
	}
}
init(1, 681); #程序入口

?>