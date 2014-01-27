<html>
<head>
	<title>CURL</title>
</head>
<body></body>
</html>
<?php
/**
* FILE_NAME : zhua_anjuke1.php   FILE_PATH : E:\home+\zhua_anjuke1.php
* ….、抓取安居客信息CURL
* @author younglly@163.com
* ChengDu CandorSoft Co., Ltd.
* @version 1.0 Wed May 02 10:51:03 CST 2012
*/ 

set_time_limit(0);
header('Content-Type:text/html;Charset=utf-8');
require_once('sys_load.php');
$url = "http://chengdu.anjuke.com/tycoon/";
$useragent = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.162 Safari/535.19";
$max_connections = 5;//最大并发数
$active = null;
$page_rule = array(
	'<div class="current">',
	'</div>'
);
#文章地址
$house_rule = array(
	' href="',
	'" class="photo"'
);
#内链接电话规则
$tel_rule = array(
	'<div class="number"><b>',
	'</b>'
);
#经纪人页电话规则
$tel_a_rule = array(
	'" target="_blank">',
	'</a></span><br />'
);
#经纪人姓名规则
$name_a_rule = array(
	'" class="name" target="_blank">',
	'</a>'
);
$pageNum = 50;
for($i=1;$i<=$pageNum;$i++)
{
	$url_list[] = $url.'p'.$i."-st1";
}
$mh = curl_multi_init(); //初始化CURL
$all = count($url_list);
$max_connections = $all >$max_connections ? $max_connections : $all;
for($i=0;$i<$max_connections;$i++)
{
	//$ch[$i] = add_url_to_multi_handle($mh,$url_list,$i);
	$ch[$i] = curl_init();
	curl_setopt($ch[$i],CURLOPT_URL,$url_list[$i]);
	curl_setopt($ch[$i],CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch[$i],CURLOPT_FOLLOWLOCATION,1);
	curl_multi_add_handle($mh,$ch[$i]);
}

//初始处理
do{
	$mrc = curl_multi_exec($mh,$active);
}while ($mrc == CURLM_CALL_MULTI_PERFORM);
$totalName = 0;
//
while ($active&&$mrc==CURLM_OK) {
	$key = 0;
	//有活动连接
	if(curl_multi_select($mh)!='-1')
	{
		do{
			$mrc = curl_multi_exec($mh,$active);
		}while ($mrc == CURLM_CALL_MULTI_PERFORM);
		if($mhinfo = curl_multi_info_read($mh))
		{
			//连接正常结束
			$chinfo = curl_getinfo($mhinfo['handle']);//print_r($mhinfo['handle']);
			$ch_key = array_search($mhinfo['handle'],$ch);
			//print_r($chinfo);
			if(!$chinfo['http_code'])
			{
				$dead_urls[] = $chinfo['url'];
			}elseif($chinfo['http_code']==404)
			{
				$not_found_urls[] = $chinfo['url'];
			}
			elseif ($chinfo['http_code'] == 200)
			{
				$content = curl_multi_getcontent($ch[$ch_key]);
				//开始查询连接
				$nameList = getRegularValue($name_a_rule,$content,1);
				$telList = getRegularValue($tel_a_rule,$content,1);
				if(is_array($nameList[1]))
				{
					foreach ($nameList[1] as $k=>$val)
					{
						insertRei($telList[1][$k],$val);
						$totalName ++ ;
						echo  "开始获取内容共".$pageNum."页,第".($ch_key+1)."页-第".($k+1)."条链接$totalName<br>";
					}
				}
				
				/**
				 * 以下为内连接地址页面信息检索
				if(is_array($house_url[1]))
				{
					foreach ($house_url[1] as $key=>$homeUrl)
					{
						//ob_end_flush();
						//$npage = $ch_key == 0 ? 1 : intval($ch_key)+1;
						echo  "开始获取内容共".$pageNum."页,第".($ch_key+1)."页-第".($key+1)."条链接<br>";
						//echo $homeUrl;
						$hch = curl_init();
						curl_setopt($hch,CURLOPT_URL,$homeUrl);
						curl_setopt($hch,CURLOPT_RETURNTRANSFER,1);
						curl_setopt($hch,CURLOPT_FOLLOWLOCATION,1);
						$hchinfo = curl_exec($hch);
						$hmhinfo = curl_getinfo($hch); echo "总耗时".$hmhinfo['total_time'].'秒';
						if($hmhinfo['http_code']==200)
						{
							
							//获取列表中的房源详细信息页面
							$tel = getRegularValue($tel_rule,$hchinfo);
						}
						
						
					}
				}
				*/
				$next = $i++;
				/*
				if($ch[$next]=add_url_to_multi_handle($mh,$url_list,$next))
				{
					do{
						$mrc = curl_multi_exec($mh,$active);
					}while ($mrc == CURLM_CALL_MULTI_PERFORM);
				}
				*/
				if(array_key_exists($next,$url_list))
				{
					$ch[$next] = curl_init();
					curl_setopt($ch[$next],CURLOPT_URL,$url_list[$next]);
					curl_setopt($ch[$next],CURLOPT_RETURNTRANSFER,1);
					curl_setopt($ch[$next],CURLOPT_FOLLOWLOCATION,1);
					curl_multi_add_handle($mh,$ch[$next]);
				}
				//移除句柄
				curl_multi_remove_handle($mh,$mhinfo['handle']);
				curl_close($mhinfo['handle']);
			}
			else 
			{
				$working_urls[] = $chinfo['url'];
			}
			
		}
	}
//	ob_flush();
//	flush();
//	usleep(200000);//读取完一页延迟
}
curl_multi_close($mh);
function add_url_to_multi_handle($mh,$url,$index)
{
	if($url[$index]&&$index<count($url))
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url[$index]);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_multi_add_handle($mh,$ch);
		return curl_exec($ch);
	}
	else 
	{
		return false;
	}
}

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
function insertRei($tel,$name)
{
	if(!isExeistTelName($tel,$name))
	{
		$time = time();
		$sql = " insert into  ".DB_PREFIX_HOME."rei set name = '$name' , telephone = '$tel' , addtime = '$time' ";
		return getPdo()->execute($sql);
	}
	else {
		echo '已存在';
	}
	
}
function isExeistTelName($tel,$name)
{
	return getPdo()->find(DB_PREFIX_HOME.'rei'," telephone='$tel' and name='$name' ");
}
?>
