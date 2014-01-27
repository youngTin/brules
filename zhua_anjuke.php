<html>
<body>
<div id="show"></div>
<script type="text/javascript">function show($content){document.getElementById('show').innerHTML=$content}</script>

<?php
set_time_limit(0);
header('Content-Type:text/html;Charset=utf-8');
$url = "http://chengdu.anjuke.com/sale/";
//echo $url = "http://localhost/house_list.php?house_type=2";
echo "<script> show('正在打开网页,$url');</script>";
$content = file_get_contents($url);//print_r($content);
echo "<script> show('网页已打开,准备开始查找');</script>";
//echo $page = getRegularValue('<div class="current">','</div>',$content);

$page_rule = array(
	'<div class="current">',
	'</div>'
);
#文章地址
$house_rule = array(
	' href="',
	'" class="photo"'
);
#电话规则
$tel_rule = array(
	'<div class="number"><b>',
	'</b>'
);
//获取文章总页数
$page = getRegularValue($page_rule,$content);
$page = explode('/',$page[1]);
$pageNum = $page[1];
echo "<script> show('获取到文章列表总列数为\"$pageNum\"');</script>";




//开始查找页数
#如果存在cookie则显示已查找到那一页
$i = empty($_COOKIE['nowpage']) ? 1 : $_COOKIE['nowpage'];
for($i;$i<=3;$i++)
{
	$url = "http://chengdu.anjuke.com/sale/p".$i;
	$content = file_get_contents($url);
	$house_url = getRegularValue($house_rule,$content,1);
	$html = '';
	if(is_array($house_url[1]))
	{
		foreach ($house_url[1] as $key=>$homeUrl)
		{
			//ob_end_flush();
			$html .= "开始获取内容共".$pageNum."页,第{$i}页-第".($key+1)."条链接<br>";
			echo "<script> show('$html');</script>";
			//获取列表中的房源详细信息页面
			$house = file_get_contents($homeUrl);
			$tel = getRegularValue($tel_rule,$house);print_r($tel);
			ob_flush();
			flush();
			
			usleep(500000);
		}
	}
	//setcookie('nowpage',0,30*24*60*60);
}

function getPageUrl($page)
{}

function getRegularValue($rule,$content,$isAdd=false)
{
	if($isAdd)preg_match_all("/".regexencode($rule[0])."(.+)".regexencode($rule[1])."/U",$content,$value);
	else preg_match("/".regexencode($rule[0])."(.*)".regexencode($rule[1])."/i",$content,$value);
	return $value;
}
function regexencode($str){
	$str=str_replace("\\","\\\\",$str);
	$str=str_replace(".","\.",$str);
	$str=str_replace("[","\[",$str);
	$str=str_replace("]","\]",$str);
	$str=str_replace("(","\(",$str);
	$str=str_replace(")","\)",$str);
	//$str=str_replace("?","\?",$str);
	$str=str_replace("+","\+",$str);
	$str=str_replace("*","\*",$str);
	$str=str_replace("^","\^",$str);
	$str=str_replace("{","\{",$str);
	$str=str_replace("}","\}",$str);
	$str=str_replace("$","\$",$str);
	$str=str_replace("|","\|",$str);
	$str=str_replace("/","\/",$str);
	$str=str_replace("\(\*\)","[\s\S]*?",$str);
	return $str;
}
//print_r($content);
?>

</body>
</html>