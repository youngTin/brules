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
    check_login();
    $smarty = new WebSmarty();
    $smarty->caching = false;
    $pdo=new MysqlPdo();
    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
        case 'index':index();break; //首页页面
        case 'save':save();break; 
        case 'resetpass':resetpass();break;
        case 'savepass':savepass();break;
        default:index();break;
    }
    
    /**
     * 首页
     * */
    function index()
    {
        global $smarty,$pdo,$member,$hb,$crecate_radio,$min_expectprice_option,$sex_radio;
        
        //$where = doRequestFilter($_GET);
        $uid = UID;
        $sql = " select * from ".DB_PREFIX_DR."user_drinfo where uid = '{$uid}' ";
        $info = $pdo->getRow($sql);
        $smarty->assign('info',$info);
        
        $values1 = $values2 = array(26,322,0,0);
        if(!empty($info['in_province']))$values1 = array($info['in_province'],$info['in_city'],$info['in_dist']);
        if(!empty($info['now_province']))$values2 = array($info['now_province'],$info['now_city'],$info['now_dist']);
        
        $elems = array('in_province', 'in_city', 'in_dist');
        $dist1 = '<span id="residedistrictbox">'.showdistricts($values1, $elems, 'residedistrictbox').'</span>';
       
        $elems = array('now_province', 'now_city', 'now_dist');
        $dist2 = '<span id="residedistrictbox2">'.showdistricts($values2, $elems, 'residedistrictbox2').'</span>';
        
        $smarty->assign('dist1',$dist1);
        $smarty->assign('dist2',$dist2);
        $smarty->assign('crecate_radio',$crecate_radio);
        $smarty->assign('min_expectprice_option',$min_expectprice_option);
        $smarty->assign('sex_radio',$sex_radio);
        
        $tpl = "brules/myinfo_index.tpl";
        $smarty->assign('seoTitle','会员中心-和睦家');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    }
    
    function save()
    {
        global $pdo;
    
        if(UTYPE!='2')InfoCheck($_POST);
        
        $_POST['addtime'] = time();
        $_POST['username'] = $_SESSION['home_username'];
        $_POST['uid'] = $_SESSION['home_userid'];
        //$_POST['licensdate'] = empty($_POST['licensdate']) ? '' : strtotime($_POST['licensdate']);
        $uid = UID;
        $userinfo = $pdo->find(DB_PREFIX_DR.'user_drinfo',"uid='$uid'",'count(*) as cnt ');
        if($userinfo['cnt']>0)
        {
            if($pdo->update($_POST,DB_PREFIX_DR.'user_drinfo','uid='.$uid)!==false)
            {
                page_prompt('修改信息成功！',true,'myinfo.shtml',3);
            }
            else
            {
                page_prompt('修改信息失败！',false,'myinfo.shtml',3);
            }
        }
        else
        {
            if($pdo->add($_POST,DB_PREFIX_DR.'user_drinfo','uid='.UID))
            {
                page_prompt('添加信息成功！',true,'myinfo.shtml',3);
            }
            else
            {
                page_prompt('添加信息失败！',false,'myinfo.shtml',3);
            }
        }
        
    }
    
    function resetpass()
    {
        global $smarty;
        $smarty->assign('resetpassword',false);
        $smarty->show('brules/myinfo_resetpass.tpl');
    }
    
    function savepass()
    {
        global $pdo;
        extract($_POST);
        $uid = UID;
        if (empty($uid) || !is_numeric($uid))
        {
            ShowMsg('对不起，请不要非法提交','login.shtml');exit();
        }
        
        if (!$upass || empty($upass))
        {
            ShowMsg('密码不能为空!',-1);exit();
        }
        if (!$password || empty($password) || !$repassword || empty($repassword) )
        {
            ShowMsg('新密码不能为空!',-1);
            exit();
        }
        if ($password != $repassword)
        {
            ShowMsg('新密码输入不一致',-1);exit();
        }
        //查询原始密码是否正确
        $member = new MemberLogin(30*24*60*60,"Session");
        $key = $member->key; //key值
        $pwd = md5(trim($upass).$key);
        $pass = $pdo->find('home_user',"password='$pwd'",'count(*) as cnt');
        if($pass['cnt']<1){
            ShowMsg('原始密码不正确','myinfo.shtml?action=resetpass',0,3000);exit();
        }
        $pwd = md5(trim($password).$key);
        if($pdo->execute("UPDATE `home_user` SET `password`='$pwd' WHERE (`uid`='$uid')")){
            $member->ExitLogin();
            ShowMsg('恭喜你,你已成功修改密码!请牢记你修改的新密码.请重新登录','login.php',0,3000);exit();
        } //更新home_user表密码
        
        ShowMsg('密码修改不成功!','login.shtml',0,3000);exit();
        
    }
    
    function  InfoCheck($post)
    {
        @extract($post);
        $url = 'myinfo.shtml';
        //联系人不能为空
        if(utf8_strlen($linkman)<2)page_prompt('联系人不能为空且大于1位',false,$url,3,$post);
        //联系人只能为汉字或英文,不能有数字
        if(!preg_match("/^(([\x81-\xfe][\x40-\xfe])+)||([a-zA-Z]+)$/",$linkman))page_prompt('联系人只能为中文或英文',false,$url,3,$post);
        //联系电话不能为空
        if(!preg_match("/^(1\d{10})|(((\d{3,4})(-)?)?[1-9]\d{6,7})$/",$tel))page_prompt('联系电话不正确',false,$url,3,$post);
        
    }
    
?>