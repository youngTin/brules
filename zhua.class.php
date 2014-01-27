<?php
/**
* FILE_NAME : zhua.class.php   FILE_PATH : E:\zhua.class.php
* ….CURL抓取多页多条链接
* @author younglly@163.com
* ChengDu CandorSoft Co., Ltd.
* @version 1.0 Thu May 03 09:32:02 CST 2012
*/ 

class zhua{
	public $useragent;
	public $url_list;
	public $url;
	public $pageRule;
	public $rule;
	public $isAdd = false;
	public $content;
	public $max_connections = 10; //最大并发数
	public $pageNum;//页数
	public $active = null;
	public $totalName = 0;
	public $mh;
	public $ch;
	public $mrc;
	public $result='';
	static $index =0;
	/**
	+----------------------------------------------------------
	* 初始化
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param $url_list 分页连接，一维数组
	* @param $rule 需要查询的字符串前后html标签等,如$tel_a_rule = array(
																'" target="_blank">',
																'</a></span><br />'
															);
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function __construct($url_list,$rule){
		set_time_limit(0);
		$this->url_list = $url_list;
		$this->rule = $rule;
//		if(!is_array($url_list))$this->url = $this->url_list;
//		else $this->url = $this->url_list[self::$index];
		
		//$this->setInit();
	}
	
	public function zhuago()
	{
		$this->useragent = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.162 Safari/535.19";
		$this->mh = curl_multi_init(); //初始化CURL
		$all = count($this->url_list);
		$this->max_connections = $all >$this->max_connections ? $this->max_connections : $all;
		//初始并发10条
		for ($i=-0;$i<$this->max_connections;$i++)
		{
			$this->ch[$i] =$this->addHandle(); 
		}
		$this->dohandle();
		$this->getInfo();
		return $this->result;
	}
	
	public function dohandle()
	{
		//初始处理
		do{
			$this->mrc = curl_multi_exec($this->mh,$this->active);
		}while ($this->mrc == CURLM_CALL_MULTI_PERFORM);
	}
	public function addHandle()
	{
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$this->url_list[self::$index]);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_multi_add_handle($this->mh,$ch);
		self::$index++;
		return $ch;
	}
	
	public function getInfo()
	{
		while ($this->active&&$this->mrc==CURLM_OK) {
			//有活动连接
			if(curl_multi_select($this->mh)!='-1')
			{
				$this->dohandle();
				if($mhinfo = curl_multi_info_read($this->mh))
				{
					//连接正常结束
					$chinfo = curl_getinfo($mhinfo['handle']);//print_r($mhinfo['handle']);
					$ch_key = array_search($mhinfo['handle'],$this->ch);
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
						$content = curl_multi_getcontent($this->ch[$ch_key]);
						//开始查询连接
						if(is_array($this->rule[0]))
						{
							$s = array();
							foreach ($this->rule as $info)
							{
								$this->isAdd = 1;
								$res = $this->getRegularValue($info,$content);
								$res = $res[1];
								$s[] = $res;
							}
							$this->result[] = $this->resetArray($s);
						}
						else 
						{
							$this->isAdd = 1;
							$res = $this->getRegularValue($info,$content);
							$res = $res[1];
							$s[] = $res;
							$this->result[] = $this->resetArray($s);
						}
						//$this->result = $result;//print_r($s);
						/*
						if(is_array($nameList[1]))
						{
							foreach ($nameList[1] as $k=>$val)
							{
								//insertRei($telList[1][$k],$val);
								$totalName ++ ;
								echo  "开始获取内容共".$pageNum."页,第".($ch_key+1)."页-第".($k+1)."条链接$totalName<br>";
								
							}
						}
						*/
						$next = self::$index++;
						if(is_array($this->url_list)&&array_key_exists($next,$this->url_list))
						{
							$this->ch[$next]=$this->addHandle();
						}
						//移除句柄
						curl_multi_remove_handle($this->mh,$mhinfo['handle']);
						curl_close($mhinfo['handle']);
					}
					else 
					{
						$working_urls[] = $chinfo['url'];
					}
					
				}
			}
		}
		$this->closemulti();
	}
	public function closemulti()
	{
		curl_multi_close($this->mh);
	}
	/**
	+----------------------------------------------------------
	* 重组数组
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function resetArray($arr)
	{
		foreach($arr[0] as $key=>$val)
		{
			$newarr[$key] = array($arr[0][$key],$arr[1][$key]);
		}
		return $newarr;
	}
	/**
	+----------------------------------------------------------
	* 过滤、转义规则
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function regexencode($str){
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
	/**
	+----------------------------------------------------------
	* 正则匹配
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function getRegularValue($rule,$content)
	{
		if($this->isAdd)
		{
			preg_match_all("/".$this->regexencode($rule[0])."(.+)".$this->regexencode($rule[1])."/U",$content,$value);
		}
		else
		{
			preg_match("/".$this->regexencode($rule[0])."(.*)".$this->regexencode($rule[1])."/i",$content,$value);
		}
		return $value;
	}
}

header('Content-Type:text/html;Charset=utf-8');
$url = "http://chengdu.anjuke.com/tycoon/";
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
$rule = array($tel_a_rule,$name_a_rule);
$zhua = new zhua($url_list,$rule);
$result = $zhua->zhuago() ;
print_r($result);
?>