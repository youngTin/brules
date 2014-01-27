<?php
 /**
　* 数据库PDO操作
　* @version 1.0
　* @author 罗东大侠
  * Created on 2009-01-23
  * Modify on 2009-01-23
　*/

class MysqlPdo {

    private $PDOStatement = null;
	/**
	* 数据库的连接参数配置
	* @var array
	* @access private
    */
	private $config = array();

	/**
    * 是否使用永久连接
    * @var bool
	* @access private
    */
	private $pconnect  = false;
	
	/**
	* 事务指令数
	*/
    private $transTimes = 0;

	/**
    * 错误信息
    * @var string
	* @access private
    */
    private $error = '';

	/**
	* 单件模式,保存MysqlPdo类唯一实例,数据库的连接资源
	* @var object
	* @access private
    */
	private $link;

	/**
    * 是否已经连接数据库
    * @var bool
	* @access private
    */
	private $connected = false;

	/**
    * 数据库版本
    * @var string
	* @access private
    */
    private $dbVersion = null;

	/**
    * 当前SQL语句
    * @var string
	* @access private
    */
	private $queryStr = '';

	/**
    * 最后插入记录的ID
    * @var integer
	* @access private
    */
    private $lastInsertId = null;

	/**
    * 返回影响记录数
    * @var integer
	* @access private
    */
    private $numRows = 0;

	/**
	 * 构造函数，
	 * @param $dbconfig 数据库连接相关信息，array('ServerName', 'UserName', 'Password', 'DefaultDb', 'DB_Port', 'DB_TYPE')
	 */
    public function __construct($dbConfig=''){
        if (!class_exists('PDO')) throw_exception("不支持:PDO");
        //若没有传输任何参数，则使用默认的数据定义
		if (!is_array($dbConfig)) {
			$dbConfig = array(
				'hostname' => DB_HOST,
				'username' => DB_USER,
				'password' => DB_PWD,
				'database' => DB_NAME,
				'hostport' => DB_PORT,
				'dbms'     => DB_TYPE,
				'dsn'      => DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME
			);
		}
        if(empty($dbConfig['hostname'])) throw_exception("没有定义数据库配置");
		$this->config = $dbConfig;
        if(empty($this->config['params'])) $this->config['params']	= array();
    }

    /**
    * 连接数据库方法
    * @access public
    * @throws ProgramException
    * @return PDO 连接
    */
    public function connect() {
        if (!isset($this->link) ) {
			$config	= $this->config;
			if($this->pconnect) {
				$config['params'][constant('PDO::ATTR_PERSISTENT')] = true;
			}

			try {
				$this->link = new PDO( $config['dsn'], $config['username'], $config['password'],$config['params']);
			} catch (PDOException $e) {
			   throw_exception($e->getMessage());
			   //exit('连接失败:'.$e->getMessage());   
			}

            if(!$this->link) {
                throw_exception('PDO CONNECT ERROR');
                return false;
            }
			$this->link->exec('SET NAMES utf8');
            $this->dbVersion = $this->link->getAttribute(constant("PDO::ATTR_SERVER_VERSION"));

            // 标记连接成功
			$this->connected = true;

            // 注销数据库连接配置信息
            unset($this->config);
        }
        return $this->link;
    }

    /**
    * 释放查询结果
    * @access public
    */
    public function free() {
        $this->PDOStatement = null;
    }

	/*********************************************************************************************************/
	/*                                             数据库操作 CRUD                                           */
	/*********************************************************************************************************/
	/**
    * 获得所有的查询数据
    * @access public
    * @return array
    */
    public function getAll($sql=null) {
        $this->query($sql);
        //返回数据集
		$result	= $this->PDOStatement->fetchAll(constant('PDO::FETCH_ASSOC'));
		return $result;
    }

	/**
    * 获得一条查询结果
    * @access public
    * @param string $sql  SQL指令
    * @param integer $seek 指针位置
    * @return array
    */
    public function getRow($sql=null) {
		$this->query($sql);
		// 返回数组集
		$result = $this->PDOStatement->fetch(constant('PDO::FETCH_ASSOC'),constant('PDO::FETCH_ORI_NEXT'));
		return $result;
    }

	/**
    * 执行sql语句，自动判断进行查询或者执行操作
    * @access public
    * @param string  $sql SQL指令
    * @return mixed
    */
    public function doSql($sql='') {// echo $sql.'<br />' ;
        if($this->isMainIps($sql)) {
        	return $this->execute($sql);
        }else {
			return $this->getAll($sql);
        }
    }

	/**
    +----------------------------------------------------------
    * 统计记录 
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param string  $tables  数据表名
    * @param string  $fields  字段名
    * @param mixed   $where   查询条件
    +----------------------------------------------------------
    * @return ArrayObject
    +----------------------------------------------------------
    */
    public function countAll($tables, $where="", $field='id') {
        $sql = 'SELECT count(%s) as cnt FROM %s %s';
        $arr = $this->getRow(sprintf($sql, $field, $tables, $this->parseWhere($where)));
        $cnt = empty($arr['cnt']) ? 0 : $arr['cnt'];
        return $cnt;
    }

    /**
    * 根据指定ID查找表中记录(仅用于单表操作)
    * @access public
    * @param integer $priId  主键ID
    * @param string $tables  数据表名
    * @param string $fields  字段名
    * @return ArrayObject 表记录
    */
	public function findById($tabName,$priId,$fields='*'){
        $sql = 'SELECT %s FROM %s WHERE id=%d';
        return $this->getRow(sprintf($sql, $this->parseFields($fields), $tabName, $priId));
    }

    /**
    * 查找记录
    * @access public
    * @param string  $tables  数据表名
    * @param mixed   $where   查询条件
    * @param string  $fields  字段名
    * @param string  $order   排序
    * @param string  $limit   取多少条数据
    * @param string  $group   分组
    * @param string  $having
    * @param boolean $lock    是否加锁
    * @return ArrayObject
    */
    public function find($tables,$where="",$fields='*',$order=null,$limit=null,$group=null,$having=null) {
		$sql = 'SELECT '.$this->parseFields($fields)
						.' FROM '.$tables
						.$this->parseWhere($where)
						.$this->parseGroup($group)
						.$this->parseHaving($having)
						.$this->parseOrder($order)
						.$this->parseLimit($limit);
		$dataAll = $this->getAll($sql);
		if(count($dataAll)==1){$rlt=$dataAll[0];}else{$rlt=$dataAll;}
        return $rlt;
    }

    /**
     * 插入（单条）记录
     * @access public
     * @param mixed  $data   数据
     * @param string $table 数据表名
     * @return false | integer
     */
    public function add($data,$table) {
		//过滤提交数据
		$data=$this->filterPost($table,$data);
		foreach ($data as $key=>$val){
			if(is_array($val) && strtolower($val[0]) == 'exp') {
				$val = $val[1];	// 使用表达式   ???
			}elseif (is_scalar($val)){
				$val = $this->fieldFormat($val);
			}else{
				// 去掉复合对象
				continue;
			}
			$data[$key]	= $val;
		}
        $fields = array_keys($data);
        array_walk($fields, array($this, 'addSpecialChar'));
        $fieldsStr = implode(',', $fields);
        $values = array_values($data);
        $valuesStr = implode(',', $values);
     	$sql = 'INSERT INTO '.$table.' ('.$fieldsStr.') VALUES ('.$valuesStr.')';
		return $this->execute($sql);
    }

	/**
    * 更新记录
    * @access public
    * @param mixed  $sets 数据
    * @param string $table  数据表名
    * @param string $where  更新条件
    * @param string $limit
    * @param string $order
    * @return false | integer
    */
    public function update($sets,$table,$where,$limit=0,$order='') {
		$sets = $this->filterPost($table,$sets);
        $sql = 'UPDATE '.$table.' SET '.$this->parseSets($sets).$this->parseWhere($where).$this->parseOrder($order).$this->parseLimit($limit);
        return $this->execute($sql);
    }
	
	/**
    * 保存某个字段的值
    * @access public 
    * @param string $field 要保存的字段名
    * @param string $value  字段值
    * @param string $table  数据表
    * @param string $where 保存条件  
    * @param boolean $asString 字段值是否为字符串
    * @return void
    */
	public function setField($field, $value, $table, $condition="", $asString=false) {
        // 如果有'(' 视为 SQL指令更新 否则 更新字段内容为纯字符串
        if(false === strpos($value,'(') || $asString)  $value = '"'.$value.'"';
		$sql	= 'UPDATE '.$table.' SET '.$field.'='.$value.$this->parseWhere($condition);
        return $this->execute($sql);
	}

    /**
    * 删除记录
    * @access public
    * @param mixed  $where 为条件Map、Array或者String
    * @param string $table  数据表名
    * @param string $limit
    * @param string $order
    * @return false | integer
    */
    public function remove($where,$table,$limit='',$order='') {
        $sql = 'DELETE FROM '.$table.$this->parseWhere($where).$this->parseOrder($order).$this->parseLimit($limit);;
        return $this->execute($sql);
    }

    /**
    +----------------------------------------------------------
    * 修改或保存数据(仅用于单表操作)
    * 有主键ID则为修改，无主键ID则为增加
    * 修改记录：
    +----------------------------------------------------------
    * @access public
    +----------------------------------------------------------
    * @param $tabName  表名
    * @param $aPost    提交表单的 $_POST
    * @param $priId    主键ID
    * @param $aNot     要排除的一个字段或数组
    * @param $aCustom  自定义的一个数组，附加到数据库中保存
    * @param $isExits  是否已经存在 存在：true, 不存在：false
    +----------------------------------------------------------
    * @return Boolean 修改或保存是否成功
    +----------------------------------------------------------
    */
	public function saveOrUpdate($tabName, $aPost, $priId="", $aNot="", $aCustom="", $isExits=false) {
		if(empty($tabName) || !is_array($aPost) || is_int($aNot)) return false;
		if(is_string($aNot) && !empty($aNot)) $aNot = array($aNot);
		if(is_array($aNot) && is_int(key($aNot))) $aPost = array_diff_key($aPost, array_flip($aNot));
		if(is_array($aCustom) && is_string(key($aCustom))) $aPost = array_merge($aPost,$aCustom);

		if (empty($priId) && !$isExits) { //新增
			$aPost = array_filter($aPost, array($this, 'removeEmpty'));
            return $this->add($aPost, $tabName);
		} else { //修改
            return $this->update($aPost, $tabName, "id=".$priId);
		}
	}

    /**
    * 获取最近一次查询的sql语句
    * @access public
    * @param
    * @return String 执行的SQL
    */
	public function getLastSql() {
		return $this->queryStr;
	}

    /**
    * 获取最后插入的ID
    * @access public
    * @param
    * @return integer 最后插入时的数据ID
    */
	public function getLastInsId(){
		return $this->lastInsertId;
	}
	
	/**
    * 获取DB版本
    * @access public
    * @param
    * @return string
    */
    public function getDbVersion(){
        return $this->dbVersion;
    }

    /**
    * 取得数据库的表信息
    * @access public
    * @return array
    */
    public function getTables() {
        $info = array();
        //$result = $this->_query('SHOW TABLES');
        if($this->_query("SHOW TABLES")) {
            $result = $this->getAll();
            foreach ($result as $key => $val) {
                $info[$key] = current($val);
            }
        }
        return $info;
    }

    /**
    * 取得数据表的字段信息
    * @access public
    * @return array
    */
    public function getFields($tableName) {
		// 获取数据库联接
		$link = $this->connect();
        $sql = "SELECT
			   ORDINAL_POSITION ,COLUMN_NAME, COLUMN_TYPE, DATA_TYPE,
               IF(ISNULL(CHARACTER_MAXIMUM_LENGTH), (NUMERIC_PRECISION +  NUMERIC_SCALE), CHARACTER_MAXIMUM_LENGTH) AS MAXCHAR,
               IS_NULLABLE, COLUMN_DEFAULT, COLUMN_KEY, EXTRA, COLUMN_COMMENT
			FROM
			   INFORMATION_SCHEMA.COLUMNS
			WHERE
			  TABLE_NAME = '".$tableName."' AND TABLE_SCHEMA='".DB_NAME."'";
		//$this->queryStr = sprintf($sql, $tableName);
        //$sth = $link->prepare($sql);
        //$sth->bindParam(':tabName', $tableName);
		//$sth->execute();
		//$result = $sth->fetchAll(constant('PDO::FETCH_ASSOC'));
        $this->query($sql);
		$result	= $this->PDOStatement->fetchAll(constant('PDO::FETCH_ASSOC'));
		$info = array();
        foreach ($result as $key => $val) {
            $info[$val['COLUMN_NAME']] = array(
                'postion' => $val['ORDINAL_POSITION'],
                'name'    => $val['COLUMN_NAME'],
                'type'    => $val['COLUMN_TYPE'],
                'd_type'  => $val['DATA_TYPE'],
                'length'  => $val['MAXCHAR'],
                'notnull' => (strtolower($val['IS_NULLABLE']) == "no"),
                'default' => $val['COLUMN_DEFAULT'],
                'primary' => (strtolower($val['COLUMN_KEY']) == 'pri'),
                'autoInc' => (strtolower($val['EXTRA']) == 'auto_increment'),
                'comment' => $val['COLUMN_COMMENT']
            );
        }

        // 有错误则抛出异常
        $this->haveErrorThrowException();

        return $info;
    }
	
	/*
	try{
		//$dbh=new PDO('mysql:host=localhost;dbname=house_v2009;','root','');
		$pdo->startTrans();
		$pdo->execute("delete from home_layout_dynamic where id=4208");
		$pdo->execute("delete from home_layout_dynamic where id=4209");
		$pdo->commit();
	}catch(PDOException $e){
		$pdo->rollBack();
		echo ('Error:'.$e->getMessage());
	}
	*/
	/**
    +----------------------------------------------------------
    * 启动事务
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @return void
    +----------------------------------------------------------
    */
	public function startTrans() {
		$this->link = $this->connect();
        //数据rollback 支持
		if ($this->transTimes == 0) {
			$this->link->beginTransaction();
		}
		$this->transTimes++;
		return ;
	}

    /**
    +----------------------------------------------------------
    * 用于非自动提交状态下面的查询提交
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @return boolen
    +----------------------------------------------------------
    */
    public function commit() {
        if ($this->transTimes > 0) {
            $result = $this->link->commit();
            $this->transTimes = 0;
            if(!$result){
                throw_exception($this->error());
                return false;
            }
        }
        return true;
    }

    /**
    +----------------------------------------------------------
    * 事务回滚
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @return boolen
    +----------------------------------------------------------
    */
    public function rollback() {
        if ($this->transTimes > 0) {
            $result = $this->link->rollback();
            $this->transTimes = 0;
            if(!$result){
                throw_exception($this->error());
                return false;
            }
        }
        return true;
    }

    /**
    * 关闭数据库
    * @access public
    */
    public function close() {
        $this->link = null;
    }

    /**
    * SQL指令安全过滤
    * @access public
    * @param string $str  SQL指令
    * @return string
    */
    public function escape_string($str) {
		return addslashes($str);
    }

    /*********************************************************************************************************/
    /*                                             内部操作方法                                              */
    /*********************************************************************************************************/
    /**
    * 有出错抛出异常
    * @access private
    * @return
    */
    private function haveErrorThrowException() {
		$obj = empty($this->PDOStatement) ? $this->link : $this->PDOStatement;
        $arrError = $obj->errorInfo();
        if(count($arrError) > 1) { // 有错误信息
            //$this->rollback();
            $this->error = $arrError[2]. "<br/><br/> [ SQL语句 ] : ".$this->queryStr;
            throw_exception($this->error);
            return false;
        }
		//主要针对execute()方法抛出异常
		if($this->queryStr=='')throw_exception('Query was empty<br/><br/>[ SQL语句 ] :');

    }
   
    /**
    * where分析
    * @access private
    * @param mixed $where 查询条件
    * @return string
    */
	private function parseWhere($where) {
		$whereStr = '';
		if(is_string($where) || is_null($where)) {
            $whereStr = $where;
        }
        return empty($whereStr)?'':' WHERE '.$whereStr;
	}

    /**
    * order分析
    * @access private
    * @param mixed $order 排序
    * @return string
    */
    private function parseOrder($order) {
        $orderStr = '';
        if(is_array($order))
            $orderStr .= ' ORDER BY '.implode(',', $order);
        else if(is_string($order) && !empty($order))
            $orderStr .= ' ORDER BY '.$order;
        return $orderStr;
	}


    /**
    * limit分析
    * @access private
    * @param string $limit
    * @return string
    */
    private function parseLimit($limit) {
        $limitStr = '';
        if(is_array($limit)) {
            if(count($limit)>1)
                $limitStr .= ' LIMIT '.$limit[0].' , '.$limit[1].' ';
            else
                $limitStr .= ' LIMIT '.$limit[0].' ';
        } else if(is_string($limit) && !empty($limit))  {
            $limitStr .= ' LIMIT '.$limit.' ';
        }
        return $limitStr;
	}

    /**
    * group分析
    * @access private
    * @param mixed $group
    * @return string
    */
    private function parseGroup($group) {
        $groupStr = '';
        if(is_array($group))
            $groupStr .= ' GROUP BY '.implode(',', $group);
        else if(is_string($group) && !empty($group))
            $groupStr .= ' GROUP BY '.$group;
        return empty($groupStr)?'':$groupStr;
	}

    /**
    * having分析
    * @access private
    * @param string $having
    * @return string
    */
    private function parseHaving($having)  {
        $havingStr = '';
        if(is_string($having) && !empty($having))
            $havingStr .= ' HAVING '.$having;
        return $havingStr;
    }

    /**
    * fields分析
    * @access private
    * @param mixed $fields
    * @return string
    */
    private function parseFields($fields) {
	    if(is_array($fields)) {
            array_walk($fields, array($this, 'addSpecialChar'));
            $fieldsStr = implode(',', $fields);
        }else if(is_string($fields) && !empty($fields)) {
            if( false === strpos($fields,'`') ) {
                $fields = explode(',',$fields);
                array_walk($fields, array($this, 'addSpecialChar'));
                $fieldsStr = implode(',', $fields);
            }else {
            	$fieldsStr = $fields;
            }
        }else $fieldsStr = '*';
        return $fieldsStr;
	}

    /**
    * sets分析,在更新数据时调用
    * @access private
    * @param mixed $values
    * @return string
    */
    private function parseSets($sets) {
        $setsStr  = '';
        if(is_array($sets)){
            foreach ($sets as $key=>$val){
				$key = $this->addSpecialChar($key);
				$val = $this->fieldFormat($val);
				$setsStr .= "$key = ".$val.",";
            }
            $setsStr = substr($setsStr,0,-1);
        }else if(is_string($sets)) {
            $setsStr = $sets;
        }
        return $setsStr;
	}

    /**
    * 字段格式化
    * @access private
    * @param mixed $value
    * @return mixed
    */
    private function fieldFormat(&$value) {
        if(is_int($value)) {
            $value = intval($value);
        } else if(is_float($value)) {
            $value = floatval($value);
        } elseif(preg_match('/^\(\w*(\+|\-|\*|\/)?\w*\)$/i',$value)){
			// 支持在字段的值里面直接使用其它字段
			// 例如 (score+1) (name) 必须包含括号
			$value = $value;
		}else if(is_string($value)) {
            $value = '\''.$this->escape_string($value).'\'';
        }
        return $value;
	}

    /**
    * 字段和表名添加` 符合
    * 保证指令中使用关键字不出错 针对mysql
    * @access private
    * @param mixed $value
    * @return mixed
    */
    private function addSpecialChar(&$value) {
        if( '*' == $value ||  false !== strpos($value,'(') || false !== strpos($value,'.') || false !== strpos($value,'`')) {
            //如果包含* 或者 使用了sql方法 则不作处理
        } elseif(false === strpos($value,'`') ) {
            $value = '`'.trim($value).'`';
        }
        return $value;
    }

    /**
    +----------------------------------------------------------
    * 去掉空元素
    +----------------------------------------------------------
    * @access private
    +----------------------------------------------------------
    * @param mixed $value
    +----------------------------------------------------------
    * @return mixed
    +----------------------------------------------------------
    */
    private function removeEmpty($value){
        return !empty($value);
    }

	/**
    * 执行查询 主要针对 SELECT, SHOW 等指令
    * @access private
    * @param string $sql sql指令
    * @return mixed
    */
    private function query($sql='') {
		// 获取数据库联接
		$link = $this->connect();
        if ( !$link ) return false;
        $this->queryStr = $sql;
        //释放前次的查询结果
        if ( !empty($this->PDOStatement) ) $this->free();

        $this->PDOStatement = $link->prepare($this->queryStr);
        $bol = $this->PDOStatement->execute();

        // 有错误则抛出异常
        $this->haveErrorThrowException();
        return $bol;
    }
    /**
    * 数据库操作方法
    * @access public
    * @param string  $sql  执行语句
    * @param boolean $lock  是否锁定(默认不锁定)
    * @return void
    
    public function execute($sql='',$lock=false) {
        if(empty($sql)) $sql  = $this->queryStr;
        return $this->_execute($sql);
    }*/
    
	/**
    * 执行语句 针对 INSERT, UPDATE 以及DELETE
    * @access private
    * @param string $sql  sql指令
    * @return integer
    */
    public function execute($sql='') {
		// 获取数据库联接
		$link = $this->connect();
        if ( !$link ) return false;
        $this->queryStr = $sql;
        //释放前次的查询结果
        if ( !empty($this->PDOStatement) ) $this->free();

		$result = $link->exec($this->queryStr);

        // 有错误则抛出异常
        $this->haveErrorThrowException();

        if ( false === $result) {
            return false;
        } else {
			$this->numRows = $result;
            $this->lastInsertId = $link->lastInsertId();
            return $this->numRows;
        }
    }

	/**
    * 是否为数据库更改操作
    * @access private
    * @param string $query  SQL指令
    * @return boolen 如果是查询操作返回false
    */
    private function isMainIps($query) {
        $queryIps = 'INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|LOAD DATA|SELECT .* INTO|COPY|ALTER|GRANT|REVOKE|LOCK|UNLOCK';
        if (preg_match('/^\s*"?(' . $queryIps . ')\s+/i', $query)) {
            return true;
        }
        return false;
    }

	/**
     * 过滤POST提交数据
     * @access private
     * @param mixed  $data   POST提交数据
     * @param string $table 数据表名
     * @return  mixed $newdata
     */
     private function filterPost($table,$data) {
		$table_column = $this->getFields($table);
		$newdata=array();
		foreach ($table_column as $key=>$val){
			//if(array_key_exists($key,$data) && ($data[$key])!==''){
			if(array_key_exists($key,$data)){
					if(isset($data[$key])){
						if($table_column[$key]["d_type"]=="decimal" || $table_column[$key]["d_type"]=="double"){
							$newdata[$key] = doubleval($data[$key]);
						}elseif($table_column[$key]["d_type"]=="int" || $table_column[$key]["d_type"]=="smallint" || $table_column[$key]["d_type"]=="tinyint"|| $table_column[$key]["d_type"]=="mediumint"|| $table_column[$key]["d_type"]=="bigint"){
							$newdata[$key] = intval($data[$key]);
						}elseif($table_column[$key]["d_type"]=="float"){
							$newdata[$key] = floatval($data[$key]);
						}else{
							$newdata[$key] = $data[$key];
						}
					}
				}
		}
		return $newdata;
     }

}
?>