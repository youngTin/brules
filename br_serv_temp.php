<?php
/**
 * 会员首页
* @Created 2013-1-24 
* @name search.php
* @author QQ:279532103
* @version 1.0
* @version $Id: member_myinfo.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
    session_start();
    //require_once('./sys_load.php');
    require_once('./member_config.php');
    require_once('./data/cache/base_code.php');
    //check_login();
    $smarty = new WebSmarty();
    $smarty->caching = false;
    $smarty->assign('curmenu','proxy');
    $pdo=new MysqlPdo();
    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
        case 'index':index();break; //首页页面
        case 'save':save();break; 
        case 'resetpass':resetpass();break;
        case 'savepass':savepass();break;
        case 'banBox':banBox();break;
        default:index();break;
    }
    
    /**
     * 首页
     * */
    function index()
    { 
        global $smarty,$pdo,$member,$hb,$crecate_radio,$min_expectprice_option,$sex_radio,$serv_sMarks;
        
        //$where = doRequestFilter($_GET);
        $type = array_key_exists($_GET['type'],$serv_sMarks) ? $serv_sMarks[$_GET['type']] : 'yearhelp' ;

        $uid = UID;
        $sql = " select * from ".DB_PREFIX_DR."service where marks = '$type' ";
        $info = $pdo->getRow($sql);
        
        $info = dhtmlspecialchars_decode($info);
    
    
        $list = unserialize($info['sets']); 
    
        $year = getDateTypesConfig();
        $month = getDateTypesConfig(1,12,'asc');
                   
        $smarty->assign('info',$info);
        $smarty->assign('list',$list);
        $smarty->assign('year',$year);
        $smarty->assign('month',$month);
        $smarty->assign('type',$type);
        if($type=='yearhelp')$smarty->show("service/yearCheck.tpl");
        else  $smarty->show("service/allTemp.tpl");
    }
    
    function banBox()
    {
        global $smarty ,$member;
        if (!$member->IsLogin())
        {
            $smarty->show("ajax_login.tpl");exit;
        }
        $smarty->show("service/banBox.tpl");
    }
    
    function save()
    {
        global $pdo;
    
        InfoCheck($_POST);
        
        
        $_POST['addtime'] = time();
        $_POST['username'] = $_SESSION['home_username'];
        $_POST['uid'] = $_SESSION['home_userid'];
        $_POST['srvmarks'] = $_GET['type'] ;
        $data = $_POST['data'] ;
        $data = explode('##',$data);
        foreach($data as $item)
        {
            $datas[] = str_ireplace('@@','',$item);
        }
        $_POST['project'] = serialize($datas) ;
        
        $uid = UID;
        
        if($pdo->add($_POST,DB_PREFIX_DR.'service_user'))
        {
            showInfoErro('提交信息成功！',true);
        }
        else
        {
            showInfoErro('提交信息失败！',false);
        }
        
        
    }
    

    
    function  InfoCheck($post)
    {
        @extract($post);
        $url = 'serv_yearCheck.shtml';
        //联系人不能为空
        if(utf8_strlen($name)<2)showInfoErro('车主不能为空且大于1位');
        //联系人只能为汉字或英文,不能有数字
        if(!preg_match("/^(([\x81-\xfe][\x40-\xfe])+)||([a-zA-Z]+)$/",$name))showInfoErro('车主只能为中文或英文');
        //联系电话不能为空
        if(!preg_match("/^(1\d{10})|(((\d{3,4})(-)?)?[1-9]\d{6,7})$/",$phone))showInfoErro('联系电话不正确');
        
    }
    function  showInfoErro($msg,$res=false)
    {
        $result['res'] = $res ? 1 : 0;
        $result['msg'] = $msg;
        echo json_encode($result);
        exit;
    }
    
?>