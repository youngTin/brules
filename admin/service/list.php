<?php
    require_once('../../sys_load.php');
    require_once('../../data/cache/base_code.php');
    new Verify();
    $smarty = new WebSmarty;
    //$smarty->caching = FALSE;
    $pdo = new MysqlPdo();

    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
        case 'index':index(); break;//首页页面
        case 'editSave':editSave(); break;
        case 'doHand':doHand(); break;
        case 'comp':comp(); break;
        case 'deal':deal(); break;
    }
  

function doRequestFilter($request)
    {
        $where  = '  1  ';
        if(!empty($request['name'])){
            $where .= " and name = '{$request['name']}'";
        }
        
        if(!empty($request['marks']))
        {
            $where .=   " and srvmarks = '{$request['marks']}' " ;
        }
        if(!empty($request['phone']))
        {
            $where .=   " and phone = '{$request['phone']}' " ;
        }
        if(!empty($request['username']))
        {
            $where .=   " and username = '{$request['username']}' " ;
        }
        if(!empty($request['telephone']))
                {
                    $where .=   " and telephone = '{$request['telephone']}' " ;
                }
        

        return $where;
    }
  
function index()
{
    
    global $smarty,$pdo,$yearMonth,$serv_Marks,$serv_Status,$serv_Types;
     
    $sql = " select * from dr_service_user  "; 
    $info = $pdo->getAll($sql);

    //$info = dhtmlspecialchars_decode($info);
    
    $pageSize = 15;
    $offset = 0;
    $subPages=15;//每次显示的页数
    $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
    if($currentPage>0) $offset=($currentPage-1)*$pageSize;
    
    $where = doRequestFilter($_GET);
        
    $uid = UID;
    $limit = " limit $offset,$pageSize ";
    
    $sql = "select * from ".DB_PREFIX_DR."service_user  where $where order by id desc $limit ";
    $countsql = "select count(*) as count from ".DB_PREFIX_DR."service_user  where $where order by id desc ";
    $count = $pdo->getRow($countsql);
    if($count['count']>0)
    {
        $info = $pdo->getAll($sql);
        $smarty->assign('info',$info);
    }
    
    
    
    
    $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,2);
    $subPages=$page->get_page_html();
    $smarty->assign('num',$count['count']);
    $smarty->assign('pagesize',$pageSize);
    $smarty->assign('subPages', $subPages);
     
    $smarty->assign('serv_Types',$serv_Types);
    $smarty->assign('serv_Status',$serv_Status);
        
    $smarty->show('admin/service/list_index.tpl');
} 

function editSave()
{
    global $smarty,$pdo;
    
    //$_POST['title'] = htmlspecialchars($_POST['title']);
    $url = "/admin/service/index.php?id=".$_POST['id'];
    foreach($_POST['labels'] as $key=>$item)
    {
        $sets[$key]['labels'] =$item;
        $sets[$key]['type'] = $_POST['type'][$key];
        $type = $_POST['type'][$key];
        if(!empty($_POST['type'][$key]))
        {
            foreach($_POST[$type.$key] as $k=>$dates)
            {
                 $sets[$key]['list'][$k]['name'] = $dates ;
                 $sets[$key]['list'][$k]['fee'] = $_POST[$type.$key."_fee"][$k] ;
                 $sets[$key]['list'][$k]['default'] = $_POST[$type.$key."_default"][$k] == $k+1 ? '1' : '0' ;
            }
        }
    }
   // print_r($_POST);exit;
    $sets = serialize($sets);
    $sql = " update dr_service set  title = '{$_POST['title']}' , basicfee = '{$_POST['basicfee']}' , sets = '$sets' where id = '{$_POST['id']}' ";
    if($pdo->execute($sql)!==false)
    {
         page_msg('修改信息成功！',true,$url,3);
    }
    else page_msg('修改信息失败！',false,$url,3);
} 


function info()
    {
        global $smarty,$pdo,$br_car_type,$br_br_dist,$open_area,$open_dist;

       // $info = getInfoById($_GET['did'],$_SESSION['home_userid']);
//        $smarty->assign('info',$info);
//
//        
//        $smarty->assign('tgold',$count['tgold']);
//        $tpl = "admin/br/info.tpl";
//        $smarty->assign('br_car_type',$br_car_type);
//        $smarty->assign('br_br_dist',$br_br_dist);
//        $smarty->assign('dist1',$dist1);
//        $smarty->assign('province',$values1);
//        $smarty->assign('seoTitle','会员中心-驾照888');
//        $smarty->assign('description',$hb['metadescrip']);
//        $smarty->show($tpl);
    }
    
    
    
    function doHand()
    {
        global $pdo;
        if($_GET['did']<=0)page_msg('地址非法，重新提交',false);
        $info = getInfoById($_GET['did']);
        if($info['id']<=0)page_msg('该条信息不存在',false);
        
        $pdo->startTrans();
        $sql = " update  ".DB_PREFIX_DR."service_user set status = '1'  where id = '{$info['id']}' ";
        $pdo->doSql($sql);
        if($pdo->commit())page_msg('处理成功',true);
        else page_msg('处理失败，请稍后重试',false);
    }
    
    function comp()
    {
        global $pdo;
        if($_GET['did']<=0)page_msg('地址非法，重新提交',false);
        $info = getInfoById($_GET['did']);
        if($info['id']<=0)page_msg('该条信息不存在',false);
        
        $pdo->startTrans();
        $sql = " update  ".DB_PREFIX_DR."service_user set status = '2'  where id = '{$info['id']}' ";
        $pdo->doSql($sql);
        if($pdo->commit())page_msg('完成成功',true);
        else page_msg('完成失败，请稍后重试',false);
    }
    
    function deal()
    {
        global $pdo;
        if($_GET['did']<=0)page_msg('地址非法，重新提交',false);
        $info = getInfoById($_GET['did']);
        if($info['id']<=0)page_msg('该条信息不存在',false);
        
        $pdo->startTrans();
        $sql = " delete from  ".DB_PREFIX_DR."service_user  where id = '{$info['id']}' ";
        $pdo->doSql($sql);
        if($pdo->commit())page_msg('删除成功',true);
        else page_msg('删除失败，请稍后重试',false);
    }
    
    function getInfoById($id)
    {
        global $pdo ;
        $sql = " select * from ".DB_PREFIX_DR."service_user where id = '$id' ";
        $info = $pdo->getRow($sql);
        return $info;
    } 


?>