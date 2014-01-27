<?php 
/**
 * Created on 2008-03-06
 * 系统基类 抽象类
 * @author ld<luodongdaxia@163.com>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: BasePage.class.php,v 1.1 2012/02/07 08:59:18 gfl Exp $
 */

abstract class BasePage {

	// 数据库连接
	protected $pdo;
  
    // 当前时间
    protected $now;

    // 用户IP
    protected $clientIp;


	/**
     * 构造函数
     * @access public 
     */
    public function __construct(){

        // 初始化DB连接
        $this->pdo = getPdo();
        
        // 当前时间(秒)
        $this->now = time();

        // 得到客户端IP地址
        $this->clientIp = getClientIp();
    }

    /**
     * 自动变量设置
     * @access public 
     * @param $name   属性名称
     * @param $value  属性值
     */
    public function __set($name ,$value) {
        if(property_exists($this,$name)){
            $this->$name = $value;
        }
    }

    /**
     * 自动变量获取
     * @access public 
     * @param $name 属性名称
     * @return mixed
     */
    public function __get($name) {
        if(isset($this->$name)){
            return $this->$name;
        }else {
            return null;
        }
    }



}

?>