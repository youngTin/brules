 <?php   
 /**
 * FILE_NAME : rei_report.php   FILE_PATH : E:\home+\admin\esf\rei_report.php
 * 中介举报
 * @author younglly@163.com
 * ChengDu CandorSoft Co., Ltd.
 * @version 1.0 Wed Feb 29 13:51:08 CST 2012
 */ 
    require_once('../../sys_load.php');
    
    $pdo = new MysqlPdo();
    $smarty = new WebSmarty();
    $verify = new Verify();
    
    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
        case 'add' : add() ; break;
        case 'info' : info(); break;
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
 /*  暂时未用到搜索     
 		if(isset($_GET))
        {
//        	@extract($_GET);
//        	if(!empty($name))
//        	{
//        		$where .= " and name like '%{$name}%' ";
//        		$page_info .= "name={$name}&";
//        	}
//        	if(!empty($telphone))
//        	{
//        		$where .= " and telphone like '%{$telphone}%' ";
//        		$page_info .= "telphone={$telphone}&";
//        	}
//        	if (!empty($address))
//        	{
//        		$where .= " and address like '%{$telphone}%' ";
//        		$page_info .= "address={$address}&";
//        	}
        }*/
        $sql = " select rr.*,u.username as username,e.house_type,e.user_name,e.linkman as name,e.telphone as telephone from ".DB_PREFIX_HOME."rei_report as rr  " ;
        $sql .= " left join ".DB_PREFIX_HOME."esf as e on e.id = rr.page_id  ";
        $sql .= " left join ".DB_PREFIX_HOME."user as u on u.uid = rr.uid ";
        $limit = " limit $offset,$pageSize ";
        $res = getPdo()->getAll($sql.$where); 
        $count = getPdo()->getRow(" select count(id) as count from ".DB_PREFIX_HOME.'rei'.$where); 
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,"?".$page_info."p=",2);
		$splitPageStr=$page->get_page_html();
		
        $smarty->assign('reilist',$res);
        $smarty->assign('splitPageStr', $splitPageStr);
    	
    	$smarty->show('admin/esf/rei_report_list.tpl');
    }
    
    function info(){
    	global $smarty;
    	$para = formatParameter($_GET["sp"], "out");
    	$Id = isset($para['Id']) ? $para['Id'] : 1;
    	$sql = " select rr.*,u.username as username,e.house_type,e.user_name as rusername,e.linkman as name,e.telphone as telephone from ".DB_PREFIX_HOME."rei_report as rr  " ;
        $sql .= " left join ".DB_PREFIX_HOME."esf as e on e.id = rr.page_id  ";
        $sql .= " left join ".DB_PREFIX_HOME."user as u on u.uid = rr.uid ";
    	$info = getPdo()->getRow($sql." where rr.Id = '$Id'");
		
    	//该用户最新房源
    	$sql = " select e.*,e.telphone as telephone from ".DB_PREFIX_HOME."esf as e where e.user_name = '{$info['rusername']}' order by create_at desc ";
    	$list = getPdo()->getAll($sql);

    	$smarty->assign('reiInfo',$info);
    	$smarty->assign('reilist',$list);
    	$smarty->show('admin/esf/rei_report_info.tpl');
    }
    
    function save(){
    	$url=$_SERVER['HTTP_REFERER'] ;
    	$isok = 0;
    	if (isset($_POST['id'])){
    		$id = intval($_POST['id']);
    		if($Info=getPdo()->findById(DB_PREFIX_HOME.'rei_report',$id)){
    			$Data['updtime'] = time();
    			$Data['is_pass'] = $_POST['is_pass'] == 1 ? 1:0 ;
    			if($Info['is_add_scores']=='0'){$Data['is_add_scores'] = '1';}
    			if($Info['is_add_rei']=='0'){$Data['is_add_rei'] = '1';}
    			if(getPdo()->update($Data , DB_PREFIX_HOME."rei_report", "Id=".$id)){
    				//将黑名单信息添加到黑名单库中
    				if($Info['is_add_rei']=='0'){
	    				$sql = " select rr.*,u.username as username,e.user_name as rusername,e.linkman as name,e.telphone as telephone from ".DB_PREFIX_HOME."rei_report as rr  " ;
				        $sql .= " left join ".DB_PREFIX_HOME."esf as e on e.id = rr.page_id  ";
				        $sql .= " left join ".DB_PREFIX_HOME."user as u on u.uid = rr.uid ";
				    	$reiinfo = getPdo()->getRow($sql." where rr.Id = '$id'");
				    	$time =time();
				    	$sql = " insert into  ".DB_PREFIX_HOME."rei set name='{$reiinfo['name']}',telephone='{$reiinfo['telephone']}',address='{$reiinfo['address']}',remark='{$reiinfo['reason']}',addtime = '$time' ";
				    	getPdo()->execute($sql);
			    		
			    	}
    				//用户积分添加 - 只能增加一次
    				// 暂时未用户积分库
    				if($Info['is_add_scores']=='0'){
    					$pname = '举报中介所得积分'; //名称
	    				$type = 'report_scores';$operation="增加";
						$time = time(); //交易时间
						$scores = REPORT_SCORES;$money =0;$uid = $Info['uid'];
						//更新总积分 总金额
						$sql = "Update `home_member` set total_integral=total_integral+{$scores} ,total_money=total_money+{$money} where uid='$uid' ; ";
						$res = getPdo()->execute($sql);
						
						//更新详细记录
						getPdo()->execute("INSERT INTO `home_user_operation` (`uid`, `pname`, `product`, `operation`, `score`,`traderid`, `time`, `sta`)
							 VALUES ('$uid', '$pname', '$type', '$operation', '$scores','系统管理员', '$time', '1')");
    				}
	    				
	    				
			    	
					$msg = '修改成功';
					$isok = 1 ;
				}else{
					$msg = '修改失败';
				}
    		} else {
				$msg = '修改失败';
				
			}
    	}else {
    		$msg = '传入地址丢失';
    	}
    	page_msg($msg,$isok,$url);
    }
    
    function delone(){
		$para = formatParameter($_GET["sp"], "out");
		$id = isset($para['Id']) ? intval($para['Id']) : 0;
		$msg = '删除失败';
		$isok = 0;
		if(getPdo()->findById(DB_PREFIX_HOME.'rei_report',$id)){
			if(getPdo()->execute(" delete from ".DB_PREFIX_HOME.'rei_report'." where id = $id ")){
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
				$query = " DELETE FROM ".DB_PREFIX_HOME."rei_report WHERE `id` IN (". implode(",", $id) .")";
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

?>