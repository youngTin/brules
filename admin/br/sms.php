<?php
    require_once('../../sys_load.php');
    require_once('../../data/cache/base_code.php');
    new Verify();
    $smarty = new WebSmarty;
    //$smarty->caching = FALSE;
    $pdo = new MysqlPdo();

    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
    case 'index':index(); //首页页面
        exit;
    case 'send': send(); //增加信息处理
        exit();
    case 'add': add(); //增加信息处理
        exit();
    case 'info': info(); //增加信息处理
        break;
    case 'deal': deal(); //增加信息处理
        break; 
    case 'open': open(); //增加信息处理
        break;
    case 'close': close(); //增加信息处理
        break; 
    case 'getInfoByUser': getInfoByUser(); //增加信息处理
        break;
    case 'showInfo': showInfo(); //增加信息处理
        break;
    case 'sendone': sendone(); //增加信息处理
        break;
    case 'sendOnlyOne': sendOnlyOne(); //增加信息处理
        break;
    default:index();
        exit;
    }
   
    
    /**
    *处理传值 
    */
    function doRequestFilter($request)
    {
        $where  = '  1 and time_limit > 0 ';
        if(!empty($request['province'])){
            $where .= " and province = '{$request['province']}'";
        }
        
        $where .=  !empty($request['crecate']) ? " and crecate = '{$request['crecate']}'" : '';
        if(!empty($request['lpp']))
        {
            $where .=   " and lpp = '{$request['lpp']}' " ;
        }
        if(!empty($request['lpno']))
        {
            $where .=   " and lpno = '{$request['lpno']}' " ;
        }
        if(!empty($request['chassisno']))
        {
            $where .=   " and chassisno = '{$request['chassisno']}' " ;
        }
        if(!empty($request['telephone']))
                {
                    $where .=   " and telephone = '{$request['telephone']}' " ;
                }
        if(!empty($request['username']))
                {
                    $where .=   " and username = '{$request['username']}' " ;
                }


        return $where;
    }
    
    
     function index()
    {
        global $smarty,$pdo,$br_push_status,$open_area,$open_dist,$br_br_dist;

        $pageSize = 15;
        $offset = 0;
        $subPages=15;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        
        $values1  = array(0);
        
        $elems = array('province');
        $dist1 = '<span id="residedistrictbox">'.showdistricts($values1, $elems, 'residedistrictbox').'</span>';
        
        $where = doRequestFilter($_GET);
        
        $uid = UID;
        $limit = " limit $offset,$pageSize ";
        
        $sql = "select * from ".DB_PREFIX_DR."brules_info  where $where order by id desc $limit ";
        $countsql = "select count(*) as count from ".DB_PREFIX_DR."brules_info  where $where order by id desc ";
        $count = $pdo->getRow($countsql);
        if($count['count']>0)
        {
            $info = $pdo->getAll($sql);
            $smarty->assign('info',$info);
        }
        
        
        
        
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,3);
        $splitPageStr=$page->get_page_html();
        

        
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('splitPageStr', $splitPageStr);
        $smarty->assign('br_push_status',$br_push_status);
        $smarty->assign('province',$open_dist);
        $smarty->assign('dist1',$dist1);
        $smarty->assign('br_br_dist',$br_br_dist);
        
        $smarty->show('admin/br/sms_index.tpl');
    }
    
    
    function sendone()
    {
        global $smarty,$pdo;
        if($_GET['did']>0)
        {
            $sql = " select * from ".DB_PREFIX_DR."brules_info where id ='{$_GET['did']}' ";
            $info = $pdo->getRow($sql);
            $sms = "[车司令]提醒：";
            $tel ="13980801180";
            if($info['user_type'] == '2')
            {
                $aginfo = getagInfo($info['uid']);
                $sms = "[{$aginfo['agperson']}]提醒：";
                $tel = $aginfo['agtelephone'];
            }
            $sms .= "您的车牌{$info['lpp']}{$info['lpno']}，";
            $sms .= "总违章条数{$info['brnum']},";
            $sms .= "新增违章{$info['newnum']}，扣分{$item['newscore']}"  ;
            $sms .=",更多信息登录www.jiazhao999.com或来电".$tel;
        }
        
        
        $smarty->assign('id',$info['id']);
        $smarty->assign('sms',$sms);
        $smarty->assign('tel',$info['telephone']);
        $smarty->display('admin/br/sendone.tpl');
        
    }
    
    function sendOnlyOne()
    {
        global $pdo;
        extract($_POST);
        if(!empty($tel)&&!empty($content))
        {
           @sendMess($content,$tel,$id);
           updateLastSend($id); 
        }
        
        echo '发送成功';
    }
    
    function send()
    {
        //set_time_limit(0);
        global $pdo ; 
        #查询拥有服务期限的车牌
        $now = strtotime(date("Y-m-d"));
        $extime = $now - (24*60*60) ;
        $sql = " select * from  ".DB_PREFIX_DR."brules_info where time_limit > $now and flag = 0 and last_send < $extime  ";
        $allList = $pdo->getAll($sql);
        for($i=0;$i<10000;$i++)
        {
            $allList[$i] = $allList[0];
        }
        //print_r($allList);
        echo '请不要关闭浏览器，正在发送。。。<br />';
        $count = count($allList);
        foreach($allList as $key=>$item)
        {
            
            $sms = "[车司令]提醒：";
            $tel ="13980801180";
            if($item['user_type'] == '2')
            {
                $aginfo = getagInfo($item['uid']);
                $sms = "[{$aginfo['agperson']}]提醒：";
                $tel = $aginfo['agtelephone'];
            }
            $sms .= "您的车牌{$item['lpp']}{$item['lpno']}，";
            if(!empty($_POST['sendtnum'])){
                $sms .= "总违章条数{$item['brnum']},";
            }

            $sms .= !empty($_POST['sendnewnum']) ? "新增违章{$item['newnum']}，扣分{$item['newscore']}" : '' ;
            $sms .=",更多信息登录www.jiazhao999.com或来电".$tel;
            @sendMess($sms,$item['telephone'],$item['id']);
            updateLastSend($item['id']);
            //$int = ($key+1);
            //$infos =  "当前第{$int}条,共{$count}条<br />";
            //echo $infos ;
        }
        
        echo "发送成功";
    }
    
    function getagInfo($uid)
    {
        global $pdo;
        $sql = " select agperson,agtelephone from ".DB_PREFIX_DR."user_drinfo where uid = $uid ";
        return $pdo->getRow($sql);
    }
    
    function updateLastSend($id)
    {
        global $pdo ;
        if(empty($id))return false;
        $time = time();
        $sql = " update  ".DB_PREFIX_DR."brules_info set last_send = '$time'  where id = $id ";
        $pdo->execute($sql);
    }
    
    function add()
    {
         global $smarty,$pdo,$br_car_type,$br_br_dist,$open_area,$open_dist;
        
        $values1 = array(26);
        if(!empty($_GET['did'])&&is_numeric($_GET['did']))
        {
            $info = getInfoById($_GET['did'],$_SESSION['home_userid']);
            $values1 = array($info['province']);
            $smarty->assign('info',$info);
            $smarty->assign('isbond',1);
        }
        elseif(!empty($_POST))
        {
            $values1 = array($_POST['province']);
            $smarty->assign('info',$_POST);
        }

        
        $elems = array('province');
        $dist1 = '<span id="residedistrictbox">'.showdistricts($values1, $elems, 'residedistrictbox').'</span>';

        $count = $pdo->find(DB_PREFIX_DR.'user_invite '," in_uid = '".UID."' ",'count(id) as count , sum(gold) as tgold');
        $smarty->assign('tgold',$count['tgold']);
        $tpl = "admin/br/add.tpl";
        $smarty->assign('br_car_type',$br_car_type);
        $smarty->assign('br_br_dist',$br_br_dist);
        $smarty->assign('dist1',$dist1);
        $smarty->assign('province',$values1);
        $smarty->assign('seoTitle','会员中心-驾照888');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    }
    
    
     function save()
    {
        global $pdo;
    
        if($_POST['id']<=0)InfoCheck($_POST);
        
        $url = "index.php?action=add&did=".$_POST['id'];
        $_POST['uid'] = getUserInfo($_POST['username']);
        if($_POST['uid']<=0)page_msg('用户不存在',false,$url,3);
        $_POST['exists'] = '1';
        $_POST['uptime'] = '0';
        //$_POST['licensdate'] = empty($_POST['licensdate']) ? '' : strtotime($_POST['licensdate']);

        
        if($_POST['id']>0)
        {
            $_POST['time_limit'] = empty($_POST['time_limit']) ? '0' : strtotime($_POST['time_limit']);
            $info = getInfoById($_POST['id'],UID);
            $_POST['addtime'] = $info['addtime'] > 0 ? $info['addtime'] : time();
            if($info['id']<=0)page_prompt('该信息不存在或出现错误！',true,'peccancy.shtml',3);
            if($pdo->update($_POST,DB_PREFIX_DR.'brules_info','id='.$_POST['id']))
            {
                page_msg('修改信息成功！',true,$url,3);
            }
            else
            {
                page_msg('修改信息失败！',false,$url,3);
            }
        }
        else
        {
            if($pdo->add($_POST,DB_PREFIX_DR.'brules_info'))
            {
                page_msg('添加信息成功！',true,$url,3);
            }
            else
            {
                page_msg('添加信息失败！',false,$url,3);
            }
        }
            
        
        
    }
    
    function info()
    {
        global $smarty,$pdo,$br_car_type,$br_br_dist,$open_area,$open_dist;
        
        $values1 = array(26);
        if(!empty($_GET['did'])&&is_numeric($_GET['did']))
        {
            $info = getInfoById($_GET['did'],$_SESSION['home_userid']);
            $values1 = array($info['province']);
            $smarty->assign('info',$info);
            $smarty->assign('isbond',1);
        }
        elseif(!empty($_POST))
        {
            $values1 = array($_POST['province']);
            $smarty->assign('info',$_POST);
        }

        
        $elems = array('province');
        $dist1 = '<span id="residedistrictbox">'.showdistricts($values1, $elems, 'residedistrictbox','',true).'</span>';

        $count = $pdo->find(DB_PREFIX_DR.'user_invite '," in_uid = '".UID."' ",'count(id) as count , sum(gold) as tgold');
        $smarty->assign('tgold',$count['tgold']);
        $tpl = "admin/br/info.tpl";
        $smarty->assign('br_car_type',$br_car_type);
        $smarty->assign('br_br_dist',$br_br_dist);
        $smarty->assign('dist1',$dist1);
        $smarty->assign('province',$values1);
        $smarty->assign('seoTitle','会员中心-驾照888');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    }
    
    function getInfoByUser()
    {
        global $smarty,$pdo,$br_push_status,$open_area,$open_dist,$br_br_dist;
        $uid=$_GET['uid'];
        //$pageSize =2;
//        $offset = 0;
//        $subPages=15;//每次显示的页数
//        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
//        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
//        $limit = " limit $offset,$pageSize ";
        $where  = " uid = '$uid' ";
        $sql = " select * from ".DB_PREFIX_DR."brules_info where $where $limit ";
        $info = $pdo->getAll($sql);
        $count = $pdo->find(DB_PREFIX_DR.'brules_info ',$where,'count(id) as count');
        $smarty->assign('info',$info);
        
        //$page_info = "action=getInfoByUser&uid=$uid&";
//        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,2);
//        $subPages=$page->get_page_html();
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('splitPageStr', $splitPageStr);
        $smarty->assign('br_push_status',$br_push_status);
        $smarty->assign('province',$open_dist);
        $smarty->assign('dist1',$dist1);
        $smarty->assign('br_br_dist',$br_br_dist);
        
        $smarty->show('admin/br/info_foruser.tpl');
    }
    
    function showInfo()
    {
        global $smarty,$pdo,$br_push_status;
        
        $did = $_GET['did'] ;
        $url = "index.php?action=showInfo&did=".$did;
        if($did  <= 0)page_msg('传入地址不正确',true,$url,3);
        $brinfo = $pdo->getRow("select lpp,lpno from ".DB_PREFIX_DR."brules_info  where  id = '$did'");
        if(empty($brinfo['lpp']))page_msg('该号码不存在，或来源错误！',true,$url,3);
        $smarty->assign('brinfo',$brinfo);
        
        $pageSize = 15;
        $offset = 0;
        $subPages=15;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        
        $uid = UID;
        $limit = " limit $offset,$pageSize ";
        $where =  " bid = '{$did}'  ";
        
        $sql = "select * from ".DB_PREFIX_DR."brules_content  where $where order by id desc $limit ";
        $countsql = "select count(*) as count from ".DB_PREFIX_DR."brules_content  where $where order by id desc ";
        $count = $pdo->getRow($countsql);
        if($count['count']>0)
        {
            $info = $pdo->getAll($sql);
            $smarty->assign('info',$info);
        }
        
        
        
        $page_info = "action=showInfo&did=2&";
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,2);
        $splitPageStr=$page->get_page_html();
       
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('subPages', $splitPageStr);
        
        $smarty->show('admin/br/info_forcar.tpl');
    }
    
   
    function getInfoById($id)
    {
        global $pdo ;
        $sql = " select * from ".DB_PREFIX_DR."brules_info where id = '$id' ";
        $info = $pdo->getRow($sql);
        return $info;
    } 
    
    function getUserInfo($username)
    {
        global $pdo ;
        $sql = " select uid from home_user where username = '$username' ";
        $info = $pdo->getRow($sql);
        return $info;
    }
    
    
?>