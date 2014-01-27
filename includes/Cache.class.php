<?php
require_once('../sys_load.php');
require_once('../includes/BasePage.class.php');
/**
 * HBCMS缓存类
 * 本类负责生成所有页面缓存内容
 * @example $cache->config("mid:1;cid:1;num:1,10;where:photo!='';order:postdate DESC");
 * @copyright cdrj
 * @author luodong
 */

class Cache extends BasePage {
	var $cacheDir;

	function __construct(){
		parent::__construct();
		$this->cacheDir = WEB_ROOT.'data/cache/';
		if(!is_writeable($this->cacheDir)) throwError('cachedircannotwrite');
	}
	

	/**
	 * 更新缓存
     * @param array 函数名
	 */
	function update($array=''){
		$result = array(false,'');
		if(empty($array) || !is_array($array)){
			//if(!file_exists(WEB_ROOT.'data/cache/config.php')){
			//	return $this->web_config();
			//}
			$result[0] = $this->$array();
			$result[1] = $array.".php缓存文件更新成功！<br>";
		}else{
			foreach($array as $value){
				if($this->$value()){
					$result[0]=true;
					$result[1].=$value.".php缓存文件更新成功！<br>";
				}else{
					$result[1].="<span style='color:red'>".$value.".php缓存文件更新失败！</span><br>";
				}
			}
		}
		return $result;
	}

	function web_config(){
		$sql_config = "select * from config";
		$web_config = $this->pdo->getAll($sql_config);
		$config = array();
		foreach($web_config as $row){
			$config[$row['db_name']]=$row['db_value'];
		}

		$const="";
		$cache="<?php\n";
		$cache_array = "\$hb = array(\n";
		foreach($web_config as $row){
			$key_name = addslashes(substr($row['db_name'],3));
			$cache_array .= "\t'$key_name'=>".self::pw_var_export($row['db_value'],0,"\t").",\n";
			if($key_name=='title'){
				$const.="//定义网站title"."\n"."define('WEB_TITLE',".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='debug'){
				$const.="//数据库是否抛出异常错误信息,本地调试设置为TRUE"."\n"."define('DB_MSG',".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='ckwater'){
				$const.="//是否开启水印"."\n"."define('CK_WATER','".$row['db_value']."');\n";
			}
			if($key_name=='watertype'){
				$const.="//使用水印类型"."\n"."define('WATER_TYPE',".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='waterimg'){
				$const.="//定义水印图片"."\n"."define('WATER_PIC_PATH',WEB_ROOT.DS.'/admin/images'.DS.'water'.DS.".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='watertext'){
				$const.="//定义水印文字"."\n"."define('WATER_TEXT',".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='watertextlib'){
				$const.="//定义水印字体"."\n"."define('FONTFACE_PATH',WEB_ROOT.DS.'includes'.DS.'encode'.DS.".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='waterfont'){
				$const.="//定义水印字体大小"."\n"."define('FONT_SIZE',".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='watercolor'){
				$const.="//定义水印字体颜色"."\n"."define('FONT_COLOR',".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='waterpct'){
				$const.="//定义水印透明度"."\n"."define('WATER_PCT',".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='waterpos'){
				$const.="//定义水印位置"."\n"."define('WATER_POS',".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='url'){
				$const.="//定义网站域名"."\n"."define('URL',".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
			if($key_name=='default_tplpath'){
				$const.="//定义网站UI"."\n"."define('UI','/ui/".substr($row['db_value'],4)."');\n";
			}
			if($key_name=='borough'){
				$const.="//定义区域"."\n"."define('BOROUGH',".self::pw_var_export($row['db_value'],0,"\t").");\n";
			}
		}
		$cache_array .= ");\n".$const;
		$cache .= $cache_array."?>";
		$result = writeover($this->cacheDir.'web_config.php',$cache);
		return $result;
	}

	/**
	 * select选择缓存
	 */
	function select(){
		global $db;
		$cache = "<?php\n\$selectdb=array(\n";
		$rs = $db->query("SELECT * FROM web_select");
		while ($s = $db->fetch_array($rs)) {
			$cache.="'$s[selectid]'=>array(\n";
			$cache.="\t'selectid'=>'$s[selectid]',\n";
			$cache.="\t'selectname'=>'".addslashes($s['selectname'])."',\n";
			$cache.="),\n";
		}
		$cache.=");\n?>";
		writeover($this->cacheDir.'select.php',$cache);
	}

	/**
	 * 倘若一个缓存类没有被实例化，被静态调用时，则使用此方法
	 *
	 * @param string $cachetype
	 */
	function writeCache($cachetype){
		$cache = new Cache();
		$cache->$cachetype();
	}

	/**
	 * 根据数组来格式化缓存内容
	 *
	 * @param Array $array
	 * @return String
	 */
	function getCache($array){
		$cache = '';
		foreach ($array as $key=>$value){
			!is_numeric($value) && $value = addslashes($value);
			$cache.="\t'$key'=>'$value',\n";
		}
		return $cache;
	}

	function writeVar($varname,$arrayvalue){
		$msg="\$$varname=array(\n";
		$i=0;
		foreach ($arrayvalue as $v){
			$i++;
			$msg.="\t'$i'=>array(\n";
			foreach ($v as $key=>$val) {
				$val=addslashes($val);
				$msg.="\t\t'$key'\t=>'$val',\n";
			}
			$msg.="\t),\n";
		}
		$msg.=");\n";
		return $msg;
	}

	/**
	 * 跟新站点配置
	 */
	function sql($setting=array()){
		global $db;
		require GetLang('dbset');
		include D_P.'data/sql_config.php';

		empty($pconnect) && $pconnect=0;

		if($setting && is_array($setting)){
			$setting['user'] && $manager = $setting['user'];
			$setting['pwd'] && $manager_pwd = $setting['pwd'];
		}
		$modulearray='';
		$rs = $db->query("SELECT * FROM cms_module");
		while ($mod = $db->fetch_array($rs)) {
			$modinfo[$mod['mid']] = $mod;
		}
		$modinfo['-2'] = array(
		'mid'=>'-2',
		'mname'=>"$lang[modbbs]",
		);
		$modinfo['-1'] = array(
		'mid'=>'-1',
		'mname'=>"$lang[modblog]",
		);
		foreach($modinfo as $key=>$value){
			$modulearray.="\t'$key'=>array(\n";
			foreach($value as $k => $val){
				$val = addslashes($val);
				$modulearray.="\t\t'$k'=>'$val',\n";
			}
			$modulearray.="\t),\n";
		}

		$writetofile=
		"<?php
/**
* $lang[info]
*/
\$dbhost\t\t=\t'$dbhost';\t\t// $lang[dbhost]
\$dbuser\t\t=\t'$dbuser';\t\t// $lang[dbuser]
\$dbpw\t\t=\t'$dbpw';\t\t// $lang[dbpw]
\$dbname\t\t=\t'$dbname';\t\t// $lang[dbname]
\$database\t=\t'mysql';\t\t// $lang[database]
\$_pre\t\t=\t'$_pre';\t\t// $lang[PW]
\$pconnect\t=\t'$pconnect';\t\t//$lang[pconnect]

/*
$lang[charset]
*/
\$charset\t\t=\t\t'$charset';

/**
* $lang[ma_info]
*/
\$manager\t\t=\t\t'$manager';\t\t//$lang[manager_name]
\$manager_pwd\t=\t\t'$manager_pwd';\n//$lang[manager_pwd]

/**
* $lang[module]
*/
\$moduledb=array(
$modulearray
);
".'?>';
		writeover(D_P.'data/sql_config.php',$writetofile);
	}


	/**
	 * 清除站点缓存
	 */
	function cacheclean() {
		$fp = opendir(D_P.'data/cache');
		while ($filename = readdir($fp)) {
			if($filename=='..' || $filename=='.' || $filename=='index.html') continue;
			@unlink(D_P.'data/cache/'.$filename);
		}
		closedir($fp);
	}
	
	/**
	 * 清除smarty缓存
	 */
	function templateclean() {
		$fp = opendir(D_P.'data/tpl_cache');
		while ($filename = readdir($fp)) {
			if($filename=='..' || $filename=='.' || $filename=='index.html') continue;
			@unlink(D_P.'data/tpl_cache/'.$filename);
		}
		closedir($fp);
	}
	

	function pw_var_export($input,$f = 1,$t = null) {
		$output = '';
		if(is_array($input)){
			$output .= "array(\n";
			foreach($input as $key => $value){
				$output .= $t."\t".pw_var_export($key,$f,$t."\t").' => '.pw_var_export($value,$f,$t."\t");
				$output .= ",\n";
			}
			$output .= $t.')';
		} elseif(is_int($input) || is_double($input)){
			$output .= "$input";
		} elseif(is_string($input) && strlen($input)>0){
			$output .= $f ? "'".str_replace(array("\\","'"),array("\\\\","\'"),$input)."'" : "'$input'";
		} elseif(is_bool($input)){
			$output .= $input ? 'true' : 'false';
		} else{
			$output .= 'NULL';
		}
		return $output;
	}
}
?>