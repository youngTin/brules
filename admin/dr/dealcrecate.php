<?php
/**
 * info
* @Created 2013-1-24 
* @name search.php
* @author QQ:279532103
* @version 1.0
* @version $Id: member_index.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
    session_start();
    require_once('../../sys_load.php');
    require_once('../../data/cache/base_code.php');
//    check_login();
    $smarty = new WebSmarty();
    $smarty->caching = false;
    $pdo=new MysqlPdo();
    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
    case 'index':index(); //首页页面
        exit;
    case 'show':showInfo();break;
    case 'del':del();break;  
    case 'save':saveInfo();break;
    case 'getInfoByUser':getInfoByUser();break;
    default:index();
        exit;
    }
    
    function index()
    {
        global $smarty,$min_expectprice_option,$score_option,$timeline_option,$type_radio,$crecate_radio,$revoke_option,$de_province,$pdo;
        
        $pageSize = 15;
        $offset = 0;
        $subPages=15;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        
       // $_GET['type'] = empty($_GET['type'])&&$_GET['type']!='1' ? 0 : 1;
        
        $values1 = $values2 = array(0,0,0,0);
        
        $elems = array('in_province', 'in_city', 'in_dist');
        $dist1 = '<span id="residedistrictbox">'.showdistricts($values1, $elems, 'residedistrictbox').'</span>';

        $where = doRequestFilter($_GET);
        $limit = " limit $offset,$pageSize ";
        $sql = " select * from ".DB_PREFIX_DR."mecity where $where $limit";
        $info = $pdo->getAll($sql);
        $count = $pdo->find(DB_PREFIX_DR.'mecity ',$where,'count(id) as count');
        $smarty->assign('info',$info);
        
        $page_info = "type={$_GET['type']}&";
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,2);
        $subPages=$page->get_page_html();
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('subPages',$subPages);
        //$elems = array('on_province', 'on_city', 'on_dist');
    //    $dist2 = '<span id="residedistrictbox2">'.showdistricts($values2, $elems, 'residedistrictbox2').'</span>';
        
        $smarty->assign('dist1',$dist1);
    //    $smarty->assign('dist2',$dist2);

        $smarty->assign('crecate_radio',$crecate_radio);
        $smarty->assign('score_option',$score_option);
        $smarty->assign('crecate',$crecate_radio);
        $smarty->assign('min_expectprice',$min_expectprice_option);
        $smarty->assign('type_radio',$type_radio);
        $smarty->assign('type',$_GET['type']);
        $tpl = 'admin/dr/dc_index.tpl';
        $smarty->show($tpl);
    }    
    
    function showInfo()
    {
        global $pdo,$smarty,$min_expectprice_option,$score_option,$timeline_option,$type_radio,$crecate_radio,$revoke_option,$de_province,$task_status;
        $values1 = array(26,322,0,0);  
        if($_GET['did']>0)
        {
             $where  = " id = '{$_GET['did']}' ";
            $sql = " select * from ".DB_PREFIX_DR."mecity where $where  ";
            $info = $pdo->getRow($sql);                                            
            $smarty->assign('info',$info);                  
            $values1 = array($info['province'],$info['city'],0,0);
            
        }  
        $elems = array('province', 'city','dist');  
        $dist1 = '<span id="residedistrictbox">'.showdistricts($values1, $elems, 'residedistrictbox').'</span>'; 
        $smarty->assign('dist1',$dist1);   
        $smarty->assign('crecate_radio',$crecate_radio);
        $smarty->assign('type_radio',$type_radio);
        $smarty->assign('score_option',$score_option);
        $smarty->assign('crecate',$crecate_radio);
        $smarty->assign('min_expectprice',$min_expectprice_option);
        $smarty->assign('task_status',$task_status);
        
        $smarty->show('admin/dr/dc_showInfo.tpl');
        
    }
    function saveInfo()
    {
        global $pdo ;
        InfoCheck($_POST);
    
        $_POST['addtime'] = time();
        
        extract($_POST);
       
        $id = $_POST['id'];
        
        if(!empty($id))
        {
            if($pdo->update($_POST,DB_PREFIX_DR.'mecity',"id='$id' "))
            {
                page_msg('修改信息成功！',3,'dealcrecate.php');
            }
            else
            {
                page_msg('修改信息失败！',3,'dealcrecate.php');
            }
        }
        else
        {
           if($pdo->add($_POST,DB_PREFIX_DR.'mecity'))
            {
                page_msg('添加信息成功！',3,'dealcrecate.php');
            }
            else
            {
                page_msg('添加信息失败！',3,'dealcrecate.php');
            } 
        }
    }
    function  InfoCheck($post)
    {
        @extract($post);
        $url = 'dealcrecate.php';

        if(!preg_match("/^(([1-9][0-9]+\|)+[1-9][0-9]+)?$/",$a1))page_msg('价格区间格式错误',3,$url);

    }
    function doRequestFilter($request)
    {
        $where  = '  1  ';
      //  $where .= " and type = '{$request['type']}'";
        if(!empty($request['on_province'])){
            $where .= " and on_province = '{$request['on_province']}'";
            if(!empty($request['on_city'])){
                $where .= " and on_city = '{$request['on_city']}'";
                if(!empty($request['on_dist'])){
                    $where .= " and on_dist = '{$request['on_dist']}'";
                }
            }
        }
        
        $where .=  !empty($request['crecate']) ? " and crecate = '{$request['crecate']}'" : '';
        if(!empty($request['score']))
        {
            $where .=   " and score >= '{$request['score']}' " ;
        }
        $where .=  !empty($request['min_expectprice']) ? " and min_expectprice <= '{$request['min_expectprice']}'" : '';
        $where .=  !empty($request['licensdate']) ? " and licensdate >= '".($request['licensdate'])."'" : '';
        return $where;
    }
    
    function getInfoById($id)
    {
        global $pdo;
        $info = $pdo->find(DB_PREFIX_DR.'mecity'," id = '$id' ");
        return $info;
    }
    

    function close()
    {
        global $pdo;
        if($_GET['id']<=0)page_msg('地址非法，重新提交',false);
        $info = getInfoById($_GET['id']);
        if($info['id']<=0)page_msg('该条信息不存在',false);
        $sql = " update  ".DB_PREFIX_DR."mecity set status = '0' where id = '{$info['id']}' ";
        if($pdo->execute($sql))page_msg('关闭成功',true);
        else page_msg('关闭失败，请稍后重试',false);
    }
    function del()
        {
            global $pdo;
            if($_GET['id']<=0)page_msg('地址非法，重新提交',false);
            $info = getInfoById($_GET['id']);
            if($info['id']<=0)page_msg('该条信息不存在',false);
            $sql = " delete from  ".DB_PREFIX_DR."mecity  where id = '{$info['id']}' ";
            if($pdo->execute($sql))page_msg('删除成功',true);
            else page_msg('删除失败，请稍后重试',false);
        }

?>