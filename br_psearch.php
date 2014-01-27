<?php
/**
 * 会员首页
* @Created 2010-5-27 上午11:25:03
* @name index.php
* @version $Id: member_index.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
    session_start();
    //require_once('./sys_load.php');
    require_once('./member_config.php');
    require_once('./data/cache/base_code.php');

    $smarty = new WebSmarty();
    $smarty->caching = false;
    $pdo=new MysqlPdo();
    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
    case 'index':index(); //首页页面
        exit;
    case 'mybrules':mybrules();//登录处理
        exit();
    case 'searchSave': searchSave(); //增加信息处理
        exit();
    case 'search': search(); //增加信息处理
        exit();
    case 'showTelBox': showTelBox(); //增加信息处理
        break;
    default:index();
        exit;
    }
    
    
    /**
     * 首页
     * */
    function index()
    {
    }
    
    function search()
    {
        global $smarty,$pdo,$br_car_type;
        $uid = UID == null ? '0' : UID ;
        $did = $_GET['id'] ;
       // if($did  <= 0)page_prompt('传入地址不正确',true,'psearch.shtml?action=search',3);
        $brinfo = $pdo->getRow("select * from ".DB_PREFIX_DR."brules_info  where uid='$uid' and id = '$did'");
        //if(empty($brinfo['lpp']))page_prompt('该号码不存在，或来源错误！',true,'peccancy.shtml',3);
        $smarty->assign('brinfo',$brinfo);
       
        $pageSize = 500;
        $offset = 0;
        $subPages=15;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        
        //$limit = " limit $offset,$pageSize ";
        $where =  " bid = '{$did}'  ";
        
        $sql = "select * from ".DB_PREFIX_DR."brules_content  where $where order by id desc $limit ";
        $countsql = "select count(*) as count from ".DB_PREFIX_DR."brules_content  where $where order by id desc ";
        $count = $pdo->getRow($countsql);
        if($count['count']>0)
        {
            $info = $pdo->getAll($sql);
            $smarty->assign('info',$info);
        }
        
        
        
        
        //$page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,3);
        //$splitPageStr=$page->get_page_html();
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('splitPageStr', $splitPageStr);
       
        $tpl = "brules/psearch_index.tpl";
        $smarty->assign('seoTitle','会员中心-驾照888');
        $smarty->assign('br_car_type',$br_car_type);
        $smarty->show($tpl);
    } 
    
    function searchSave()
    {
        global $pdo ;
        extract($_POST);
        $vpp = '/^[A-Za-z0-9]{6}$/';
        $veno = '/^[A-Za-z0-9\-]{6}$/';
        $msg['res']= '1';
		$msg['msg'] = "违章数据查询提交失败，请稍后重试!";
        if(utf8_strlen($lpno)!=6||!preg_match($vpp,$lpno)){showEroos("车牌号码不正确");}
        if(utf8_strlen($cno)!=6||!preg_match($vpp,$cno))showEroos('车架号不正确');
        if(utf8_strlen($engno)!=6||!preg_match($vpp,$engno))showEroos('发动机不正确');
        #查询改车牌是否存在 存在则只需修改 不需重新插入
        $sql = " select * from ".DB_PREFIX_DR."brules_info where lpp = '$lpp' and lpno = '$lpno' and  chassisno = '$cno' and engno = '$engno'   ";
        $res = $pdo->getRow($sql);
      
        if($res['id']>0) $_POST['uptime'] = time(); else $_POST['addtime'] = time();
        $_POST['username'] = USERNAME == null ? '0' : USERNAME ;
        $_POST['uid'] = UID == null ? '0' : UID ;
        $_POST['exists'] = '1';
        $_POST['user_type'] = UTYPE ;
        $_POST['province'] = 26 ;
        $_POST['telephone'] = $_POST['s-tel'] ;
        $_POST['chassisno'] = $cno ;
        if($res['id']>0) 
        $result = $pdo->update($_POST,DB_PREFIX_DR.'brules_info','id='.$res['id']);
        else $result = $pdo->add($_POST,DB_PREFIX_DR.'brules_info');
        $id = $pdo->getLastInsId() > 0 ?  $pdo->getLastInsId() : $res['id']; 
        if($result)
        {
            $msg['res']= '0';
            $msg['msg'] = "查询数据提交成功，请等待10秒~&nbsp;&nbsp;&nbsp;<br>也可直接进入查看页面，<a href='/psearch.shtml?action=search&id=$id'>进入</a>&nbsp;";
            $msg['id'] = $id;
        }
       echo json_encode($msg);exit;
    }

    function showTelBox()
    {
        global $smarty,$pdo;
        $lpno = $_GET['sp'] ;
        $cno = $_GET['cno'] ;
        $engno = $_GET['engno'] ;
        $sql = " select * from ".DB_PREFIX_DR."brules_info where lpp = '川' and lpno = '$lpno'   ";
        $res = $pdo->getRow($sql); 
        $smarty->assign('tel',$res['telephone']);
        $smarty->show("brules/psearch_telbox.tpl");
    }
    
	function getInfoById($id,$uid)
	{
		global $pdo ;
		$sql = " select * from ".DB_PREFIX_DR."brules_info where id = '$id' and uid = '$uid' ";
		$info = $pdo->getRow($sql);
		return $info;
	}
    
    function showEroos($msg){
        $msg['res'] = '1' ;
        $msg['msg'] = $msg ;
        echo json_encode($msg);exit;
    }

?>
