 <?php  
 /**
  * FILE_NAME : rei_list.php   FILE_PATH : E:\home+\admin\esf\rei_list.php
  * 中介黑名单
  * @author younglly@163.com
  * ChengDu CandorSoft Co., Ltd.
  * @version 1.0 Wed Feb 29 13:50:17 CST 2012
  */  
    require_once('../../sys_load.php');
    
    $pdo = new MysqlPdo();
    $smarty = new WebSmarty();
    $verify = new Verify();
    
    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
        case 'add' : add() ; break;
        case 'edit' : edit(); break;
        case 'save' : save(); break;
        case 'delone' : delone(); break;
        case 'deleteall' : deleteall(); break;
        default: index() ; break;
    }
    
    function index(){
        global $smarty;
        
        $pageSize = 15;
        $offset = 0;
        $subPages=5;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        $where = ' where 1 ';
        if(isset($_GET))
        {
        	@extract($_GET);
        	if(!empty($name))
        	{
        		$where .= " and name like '%{$name}%' ";
        		$page_info .= "name={$name}&";
        	}
        	if(!empty($telphone))
        	{
        		$where .= " and telephone like '%{$telphone}%' ";
        		$page_info .= "telphone={$telphone}&";
        	}
        	if (!empty($address))
        	{
        		$where .= " and address like '%{$telphone}%' ";
        		$page_info .= "address={$address}&";
        	}
        }
        $sql = " select * from ".DB_PREFIX_HOME."rei   ".$where ;
        $limit = " limit $offset,$pageSize ";
        $res = getPdo()->getAll($sql.$limit);
        $count = getPdo()->getRow(" select count(id) as count from ".DB_PREFIX_HOME.'rei'.$where); 
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,2);
		$splitPageStr=$page->get_page_html();
		
        $smarty->assign('reilist',$res);
        $smarty->assign('splitPageStr', $splitPageStr);
        $smarty->show();
    }
    
    function add(){
    	global $smarty;
    	
    	$smarty->assign("EditOption" , 'new');
    	$smarty->show("admin/esf/rei_add.tpl");
    }
    
    function edit(){
    	global $smarty; 
    	$para = formatParameter($_GET["sp"], "out");
    	$Id = isset($para['Id']) ? $para['Id'] : 1;
    	$ValueList = getPdo()->getRow("select * from ".DB_PREFIX_HOME."rei where Id = '$Id'");
    	
    	$smarty->assign('reiInfo',$ValueList);
    	$smarty->assign("EditOption" , 'Edit');
    	$smarty->show("admin/esf/rei_add.tpl");
    }
    
    function save(){
    	$url=$_SERVER['HTTP_REFERER'] ;
    	if(isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'new'){
    		$Data  = filter($_POST);
    		$Data['addtime'] = time() ; 
    		if(isset($Data)&&getPdo()->add($Data,DB_PREFIX_HOME.'rei')){
    			$msg = "保存成功";
    			$url = '?';
    		}else{
    			$msg = "保存失败";
    		}
    	}
    	elseif (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'edit' and isset($_POST['Id'])){
    		$Data  = filter($_POST); 
    		$Data['updtime'] = time();
    		if (isset($Data)) {
				if(getPdo()->update($Data , DB_PREFIX_HOME."rei", "Id=".$_POST['Id'])){
					$msg = '修改成功';
				}else{
					$msg = '修改失败';
				}
				
			} else {
				$msg = '修改失败';
				
			}
    	}else {
    		$msg = '保存失败';
    	}
    	page_msg($msg,$isok=true,$url);
    }
    
    function delone(){
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['Id']) ? intval($para['Id']) : 0;
		$msg = '删除失败';
		$isok = 0;
		if(getPdo()->findById(DB_PREFIX_HOME.'rei',$id)){
			if(getPdo()->execute(" delete from ".DB_PREFIX_HOME.'rei'." where id = $id ")){
				$msg = '删除成功';
				$isok = 1;
			}
		}
		page_msg($msg,$isok,$url=$_SERVER['HTTP_REFERER']);
    }
    
    function deleteall(){
    	if (isset($_POST['EditOption']) and strtolower($_POST['EditOption']) == 'deleteall'){ 
			$id = isset($_POST['ids']) ? $_POST['ids'] : array();
			$count = count($id);
			if($count != 0){
				$query = " DELETE FROM ".DB_PREFIX_HOME."rei WHERE `id` IN (". implode(",", $id) .")";
				if(getPdo()->execute($query)){
					$msg = '多项删除删除成功';
					$isok = 1;
				}else {
					$isok = 0;
					$msg = '多项删除删除失败';
				}
				
			}
		}
		else
		{
			$isok =0 ;
			$msg = '多项删除删除失败';	
		}
		page_msg($msg,$isok,$url=$_SERVER['HTTP_REFERER']);
    }
    
    function filter($Data){
    	$ValueList = array();
		$ValueList['name'] = is_key_exists('name',$Data,1);
		$ValueList['telphone'] = is_key_exists('telphone',$Data,1);
		$ValueList['address'] = is_key_exists('address',$Data,1);
		$ValueList['remark'] = is_key_exists('remark',$Data,1);
		return $ValueList;
    }
    
    function is_key_exists($value,$Data,$is_allow_null=0){
    	if(array_key_exists($value,$Data))
    	{
    		if($is_allow_null==1){
    			if(empty($Data[$value])){
    				page_msg("提交的必填项不能为空",false,$url=$_SERVER['HTTP_REFERER']);exit;
    			}
    		}
    		return  htmlspecialchars($Data[$value]);
    	}
    	
    }
?>