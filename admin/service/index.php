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
        case 'addSave':addSave(); break;
    }
  
function index()
{
    
    global $smarty,$pdo,$yearMonth,$serv_Types;
     
    $type = $_GET['type'] ;
    $marks = array_key_exists($type,$serv_Types) ? $type : 'yearhelp' ; 
    $sql = " select * from dr_service where marks = '$marks' "; 
    $info = $pdo->getRow($sql);

    //$info['title'] = dhtmlspecialchars($info['title']);  
    
    $list = unserialize($info['sets']);

    $smarty->assign('info',$info);
    $smarty->assign('yearMonth',$yearMonth);
    $smarty->assign('list',$list);
     
    $smarty->assign('br_br_dist',$br_br_dist);
    $smarty->assign('type',$type);
    if($marks == 'yearhelp')  
    $smarty->show('admin/service/'.$marks.'.tpl');
    else $smarty->show('admin/service/allTemp.tpl');
} 

function editSave()
{
    global $smarty,$pdo;

    $_POST['title'] = dhtmlspecialchars($_POST['title']);
	$_POST['note'] = dhtmlspecialchars($_POST['note']);
    $url = "/admin/service/index.php?type=".$_GET['type']."&id=".$_POST['id'];
    foreach($_POST['labels'] as $key=>$item)
    {
        if(!empty($item))
        {
            $sets[$key]['labels'] =$item;
            $sets[$key]['one'] = !empty($_POST['select'.$key.'one']) ? 1 : 0 ;
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
        
    }
    $sets = array_values($sets);
    //print_r($_POST);exit;
    $sets = serialize($sets);
    $sql = " update dr_service set  title = '{$_POST['title']}' , basicfee = '{$_POST['basicfee']}' , sets = '$sets' , note = '{$_POST['note']}' where id = '{$_POST['id']}' ";
    if($pdo->execute($sql)!==false)
    {
         page_msg('修改信息成功！',true,$url,3);
    }
    else page_msg('修改信息失败！',false,$url,3);
} 

function addSave()
{
    global $smarty,$pdo,$serv_Types;
    
    //$_POST['title'] = htmlspecialchars($_POST['title']);
    $url = "/admin/service/index.php?type=".$_GET['type']."&id=".$_POST['id'];
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
    $name = $serv_Types[$_GET['type']] ;
    $sql = " insert into dr_service set marks ='{$_GET['type']}' , name = '$name' , title = '{$_POST['title']}' , basicfee = '{$_POST['basicfee']}' , sets = '$sets'  ";
    if($pdo->execute($sql)!==false)
    {
         page_msg('添加信息成功！',true,$url,3);
    }
    else page_msg('添加信息失败！',false,$url,3);
} 



?>