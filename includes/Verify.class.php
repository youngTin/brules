<?php
// 加载系统函数
//require_once('functions.php');

class Verify extends BasePage {
   private $controller;
   private $action;

   private $userAllowCategoryList;
   private $http_post;      //  www.ld.com
   private $php_self;       //  /admin/column/content2.php
   private $query_string;   //  action=index&cid=21
   private $http_referer;   //  http://www.ld.com/admin.php?action=index
  
   function __construct(){
    	if(!isset($_SESSION['userId'])){
    		page_msg('您还没有登陆，请返回登录',$isok=false,URL.'/admin/admin.php');
    	}else{
			parent::__construct();
			
			//定义控制方法
			$_SESSION['allow']=false;
			$_SESSION['add']=false;
			$_SESSION['edit']=false;
			$_SESSION['save']=false;
			$_SESSION['index']=false;
			$_SESSION['delete']=false;

			$sql = "select a.*,b.name,b.url from admin_category as a left join category as b on a.category_id=b.id where a.uid=".$_SESSION['userId'];
			$category =  $this->pdo->getAll($sql);
			$this->userAllowCategoryList = array();
			foreach($category as $item){
				$this->userAllowCategoryList[]=$item['category_id'];
			}

			//获取域名或主机地址 www.ld.com
			//@$this->http_post =  $_SERVER['HTTP_HOST']; 
			//获取网页地址 /admin/column/content2.php
			//@$this->php_self =  $_SERVER['PHP_SELF']; 
			//获取网址参数 action=index&cid=21
			//@$this->query_string =  $_SERVER["QUERY_STRING"]; 
			//来源网页的详细地址 http://www.ld.com/admin.php?action=index
			//@$this->http_referer =  $_SERVER['HTTP_REFERER']; 
		}
    }
	/**
    * 访问验证网站栏目内容、编辑  
    * @access public 
    */
    public function validate_column() {
		//通过网页参数,获得栏目category_id
		//$pos = strpos($this->query_string, 'cid', 0);
		//$cid = substr($this->query_string, $pos+4,2);
		$cid = intval(isset($_GET['cid']) ? $_GET['cid'] : $_POST['cid']);
		//纵向控制
		if(in_array($cid,$this->userAllowCategoryList)){
			//横向方法控制 52=栏目内容编辑,53=栏目内容管理,55=栏目审核
			if(in_array(53,$this->userAllowCategoryList)){
				$_SESSION['index']=true;
				$_SESSION['delete']=true;
			}
			if(in_array(52,$this->userAllowCategoryList)){
				$_SESSION['add']=true;
				$_SESSION['edit']=true;
				$_SESSION['save']=true;
			}
			if(in_array(55,$this->userAllowCategoryList)){
				$_SESSION['option']=true;
				$_SESSION['destroy']=true;
			}
			$_SESSION['allow']=true;
		}

		if(!$_SESSION['allow']){
	    	page_msg('你没有权限访问',$isok=false,$_SERVER['HTTP_REFERER']);
	    	exit;
		}
    }
	/**
    * 访问验证网站栏目分类
    * @access public 
    */
    public function validate_category() {
		//51=栏目分类管理
		if(in_array(51,$this->userAllowCategoryList)){
			$_SESSION['allow']=true;
			$_SESSION['del']=true;
			$_SESSION['add']=true;
			$_SESSION['edit']=true;
			$_SESSION['save']=true;
		}

		if(!$_SESSION['allow']){
	    	page_msg('你没有权限访问',$isok=false,$_SERVER['HTTP_REFERER']);
	    	exit;
		}
    }
	/**
    * 访问验证回收站
    * @access public 
    */
    public function validate_recycle() {
    	if(in_array(54,$this->userAllowCategoryList)){
			$_SESSION['allow']=true;
		}
		if(!$_SESSION['allow']){
	    	page_msg('你没有权限访问',$isok=false,$_SERVER['HTTP_REFERER']);
	    	exit;
		}
    }
	/**
    * 访问验证文件上传
    * @access public 
    */
    public function validate_file_attach() {
    	if(in_array(62,$this->userAllowCategoryList)){
			$_SESSION['allow']=true;
			$_SESSION['save']=true;
		}
		if(in_array(61,$this->userAllowCategoryList)){
			$_SESSION['allow']=true;
			$_SESSION['index']=true;
		}
		if(!$_SESSION['allow']){
	    	page_msg('你没有权限访问',$isok=false,$_SERVER['HTTP_REFERER']);
	    	exit;
		}
    }
	/**
    * 访问验证站点全局设置
    * @access public 
    */
    public function validate_set_config() {
		$_SESSION['save']=true;
		$_SESSION['index']=true;
    }

	/**
    * 访问验证站点图片编辑
    * @access public 
    */
    public function validate_pic_edit() {
		$_SESSION['save']=true;
		$_SESSION['add']=true;
		$_SESSION['order']=true;
    }

	/**
	* 生产该用户能访问页面
	* @access public
	* @return array
	*/
	public function control(){
		return $this->page_html;
	}
	

	/*
	* __destruct析构函数，当类不在使用的时候调用，该函数用来释放资源。
	*/
	function __destruct(){
		unset($_SESSION['allow']);
		unset($_SESSION['add']);
		unset($_SESSION['edit']);
		unset($_SESSION['save']);
		unset($_SESSION['index']);
		unset($_SESSION['delete']);
	}

}
?>
