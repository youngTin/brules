<?php
/**
 * Created on 2008-03-06
 * Smarty配置类
 * @author jctr<jc@cdrj.net.cn>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: WebSmarty.class.php,v 1.1 2012/02/07 08:59:18 gfl Exp $
 */


// 加载Smarty类
require_once(WEB_ROOT.'includes/smarty/Smarty.class.php');

class WebSmarty extends Smarty  {

	/**
     * 构造函数
     * @access public
     * @param array $config 数据库配置数组
     */
    function __construct(){
		$this->Smarty();
		$this->template_dir = TPL_DIR;
		//$this->config_dir = TPL_CONFIG_DIR;
		$this->compile_dir = TPL_COMPILE_DIR;
		$this->cache_dir = TPL_CACHE_DIR;

		//$this->secure_dir = home_ROOT;

        //$smarty->force_compile = true; // 每次都重新生成缓存, 调试时用
        //$this->debugging = true; // 打开调试功能

		$this->register_function('fp', 'WebSmarty::_fp_');
		$this->register_function('cms', 'WebSmarty::cms');
		$this->register_block('dynamic', 'smarty_block_dynamic', false);
	}
	
    /**
     * 重写 display
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     */
    public function show($resource_name = "", $cache_id = null, $compile_id = null) {
		if(empty($resource_name)) {
			$resource_name = $_SERVER['PHP_SELF'];
			if(ereg("^[/\\]", $resource_name)) $resource_name = substr($resource_name, 1); // 去掉最前面的 "/"
			$resource_name = str_ireplace(".php", ".tpl", $resource_name);
		}
		$resource_name = str_ireplace("ct/", "", $resource_name);
        $this->fetch($resource_name, $cache_id, $compile_id, true);
    }
	
	/**
     * 扩展 cms
     *
     * @param array $params
	 *
     */
	static public function cms($params,&$smarty){
		$action = $params["action"];
		if(!$action){
			throw_exception("CMS:action没有定义");
		}
		/*if(!function_exists("content::$action")){
			throw_exception("CMS:找不到$action()的方法");
		}*/
		$returnName = isset($params["return"])?$params["return"]:'getList';
		$cms = new Cms();
		eval('$result = $cms->'.$action.'($params);');
		$smarty->assign($returnName,$result);
	}

	/**
	* 注入参数格式化方法
	* {fp sp=""}
	*/
	static public function _fp_($params, &$smarty){
		if(empty($params)) return "";
		return formatParameter($params);
	}
}

?>