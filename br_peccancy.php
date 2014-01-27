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
    check_login();
    $smarty = new WebSmarty();
    $smarty->caching = false;
    $pdo=new MysqlPdo();
    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
    case 'index':index(); //首页页面
        exit;
    case 'mybrules':mybrules();//登录处理
        exit();
    case 'save': save(); //增加信息处理
        exit();
    case 'search': search(); //增加信息处理
        exit();
    case 'showInfo': showInfo(); //增加信息处理
        break;
    case 'showHandle': showHandle(); //增加信息处理
        break;
    case 'doHandle': doHandle(); //增加信息处理
        break;
    case 'myban': myban(); //增加信息处理
        break;
    default:index();
        exit;
    }
    
    
    /**
     * 首页
     * */
    function index()
    {
        global $smarty,$pdo,$br_car_type,$br_br_dist,$open_area,$open_dist;
        
        $values1 = 26;
        if(!empty($_GET['did'])&&is_numeric($_GET['did']))
        {
            $info = getInfoById($_GET['did'],$_SESSION['home_userid']);
            $values1 = $info['province'];
            $smarty->assign('info',$info);
            $smarty->assign('isbond',1);
        }
        elseif(!empty($_POST['province']))
        {
            $values1 = $_POST['province'];
            $smarty->assign('info',$_POST);
        }
        elseif(!empty($_GET['c'])&&array_key_exists($_GET['c'],$open_area)){$values1 = $open_area[$_GET['c']];}

        $dist1 = $open_dist[$values1];

        $count = $pdo->find(DB_PREFIX_DR.'user_invite '," in_uid = '".UID."' ",'count(id) as count , sum(gold) as tgold');
        $smarty->assign('tgold',$count['tgold']);
        $tpl = "brules/peccancy_index.tpl";
        $smarty->assign('br_car_type',$br_car_type);
        $smarty->assign('br_br_dist',$br_br_dist);
        $smarty->assign('dist1',$dist1);
        $smarty->assign('province',$values1);
        $smarty->assign('seoTitle','会员中心-驾照888');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    }
    
    function search()
    {
        global $smarty,$pdo,$member,$hb,$de_province,$crecate_radio,$type_radio,$min_expectprice_option,$score_option;
        
        $elems = array('on_province', 'on_city', 'on_dist');
        $dist2 = '<span id="residedistrictbox2">'.showdistricts($de_province, $elems, 'residedistrictbox2').'</span>';
        $smarty->assign('dist2',$dist2);
        
        $smarty->assign('type_radio',$type_radio);
        $smarty->assign('crecate_radio',$crecate_radio);
        $smarty->assign('min_expectprice_option',$min_expectprice_option);
        $smarty->assign('score_option',$score_option);
        $tpl = "brules/index_search.tpl";
        $smarty->assign('seoTitle','会员中心-驾照888');
        $smarty->assign('description',$hb['metadescrip']);
        $smarty->show($tpl);
    } 
    
    function searchSave()
    {
        extract($_POST);
        $vpp = '/^[A-Za-z0-9]{6}$/';
        $veno = '/^[A-Za-z0-9\-]{6}$/';
        
        if(utf8_strlen($lpno)!=6||!preg_match($vpp,$lpno))page_prompt('车牌号码不正确',false,"/peccancy.shtml?action=search",3,$_POST);
        if(utf8_strlen($cno)!=6||!preg_match($vpp,$cno))page_prompt('车架号不正确',false,"/peccancy.shtml?action=search",3,$_POST);
        if(utf8_strlen($engno)!=6||!preg_match($vpp,$engno))page_prompt('发动机不正确',false,"/peccancy.shtml?action=search",3,$_POST);
        
        
    }
    
    function save()
    {
        global $pdo;
    
        if($_POST['id']<=0)InfoCheck($_POST);
        
        $_POST['addtime'] = time();
        $_POST['username'] = USERNAME;
        $_POST['uid'] = UID;
        $_POST['exists'] = '1';
        $_POST['uptime'] = '0';
        $_POST['user_type'] = UTYPE ;
        //$_POST['licensdate'] = empty($_POST['licensdate']) ? '' : strtotime($_POST['licensdate']);
        $uid = UID;
        $userinfo = $pdo->find(DB_PREFIX_DR.'brules_info',"uid='$uid'",'count(*) as cnt '); 
        if($userinfo['cnt']>=1&&UTYPE!=2)
        {
            page_prompt('您只能添加三条信息',true,'peccancy.shtml',3);
        }
        else
        {
			if($_POST['id']>0)
			{
				$info = getInfoById($_POST['id'],UID);
				if($info['id']<=0)page_prompt('该信息不存在或出现错误！',true,'peccancy.shtml',3);
				if($pdo->update($_POST,DB_PREFIX_DR.'brules_info','id='.$_POST['id']))
				{
					page_prompt('修改信息成功！',true,'peccancy.shtml',3);
				}
				else
				{
					page_prompt('修改信息失败！',false,'peccancy.shtml',3);
				}
			}
			else
			{
				if($pdo->add($_POST,DB_PREFIX_DR.'brules_info'))
				{
					page_prompt('添加信息成功！',true,'peccancy.shtml',3);
				}
				else
				{
					page_prompt('添加信息失败！',false,'peccancy.shtml',3);
				}
			}
            
        }
        
    }
    
    function  InfoCheck($post)
    {
        @extract($post);
        $url = 'peccancy.shtml';
        //违章省份必选
        if($province<=0)page_prompt('违章省份必须选择一个',false,$url,3,$post);
        //车牌号码必须填写
        if(utf8_strlen($lpno)!=6)page_prompt('车牌号码必须填写',false,$url,3,$post);
        //联系电话不能为空
        if(!preg_match("/^(1\d{10})|(((\d{3,4})(-)?)?[1-9]\d{6,7})$/",$telephone))page_prompt('手机号码不正确',false,$url,3,$post);
        
    }
    
    function mybrules()
    {
        global $smarty,$pdo,$br_push_status;
        $pageSize = 15;
        $offset = 0;
        $subPages=15;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        
        $uid = UID;
        $limit = " limit $offset,$pageSize ";
        $where =  " uid = '{$uid}' ";
        
        $sql = "select * from ".DB_PREFIX_DR."brules_info  where $where order by id desc $limit ";
        $countsql = "select count(*) as count from ".DB_PREFIX_DR."brules_info  where $where order by id desc ";
        $count = $pdo->getRow($countsql);
        if($count['count']>0)
        {
            $info = $pdo->getAll($sql);
            $smarty->assign('info',$info);
        }
        
        
        
        
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,'action=mybrules&',3);
        $splitPageStr=$page->get_page_html();
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('splitPageStr', $splitPageStr);
        $smarty->assign('br_push_status',$br_push_status);
        
        $smarty->show('brules/peccancy_mybrules.tpl');
    }   
    
    
    function showInfo()
    {
        global $smarty,$pdo,$br_push_status;
        
        $uid = UID ;
        $did = $_GET['did'] ;
        if($did  <= 0)page_prompt('传入地址不正确',true,'peccancy.shtml',3);
        $brinfo = $pdo->getRow("select lpp,lpno from ".DB_PREFIX_DR."brules_info  where uid='$uid' and id = '$did'");
        if(empty($brinfo['lpp']))page_prompt('该号码不存在，或来源错误！',true,'peccancy.shtml',3);
        $smarty->assign('brinfo',$brinfo);
        
        $pageSize = 15;
        $offset = 0;
        $subPages=15;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        
        $uid = UID;
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
        
        
        
        
        $page=new Page($pageSize,$count['count'],$currentPage,$subPages,$page_info,3);
        $splitPageStr=$page->get_page_html();
        
        $smarty->assign('num',$count['count']);
        $smarty->assign('pagesize',$pageSize);
        $smarty->assign('splitPageStr', $splitPageStr);
        
        $smarty->show('brules/peccancy_list.tpl');
    }
    
    function showHandle()
    {
       global $smarty;
       
       $smarty->assign('sp',$_GET['sp']);
       $smarty->show('brules/ajax_taskbox.tpl');
    }
    
    function doHandle()
    {
       global $smarty,$pdo;
       
       #判断传值
       $ids = $_GET['sp'];
       $id_arr = explode('-',$ids);
       $ids = str_replace('-',',',$ids);
       $uid = UID;
       #判断是否为该用户自己的违章信息
       $sql = " select bi.province,bi.lpno,bi.lpp,bc.fine,bc.marking from  ".DB_PREFIX_DR."brules_content bc left join ".DB_PREFIX_DR."brules_info bi on bi.id = bc.bid where bc.id in ($ids) and bi.uid = $uid and bi.flag = 0 and bc.flag=0  ";
        $cnt = $pdo->getAll($sql);
        if(count($cnt)!=count($id_arr))page_msg('提交有误！请重新提交',false,'peccancy.shtml?action=mybrules',5,1);
        #服务费 
        $sf = '150';
        $tnum = count($id_arr) ; 
        foreach($cnt as $item)
        {
            $fine += $item['fine'];
            $marking += $item['marking'];
            $sefine += ($sf*$item['marking']) ;
        }
        $totalfee = $fine+$sefine ;
        $time = time();
        $lpno = $cnt[0]['lpp'].$cnt[0]['lpno'];
        #添加代办信息
        $sql = " insert into  ".DB_PREFIX_DR."agency_brules set province = '{$cnt[0]['province']}' , lpno = '{$lpno}' ,sname = '{$_GET['pname']}' , telephone = '{$_GET['tel']}' , brnum = '$tnum' ,marking = '$marking' , fine = '$fine' , sefine = '$sefine' , totalfee = '$totalfee' ,addtime = '$time' , uid = '".UID."' , username = '".USERNAME."' ";
        if($pdo->execute($sql))
        {
            #更新状态
            //upFlagInBc($ids);
             $res['fine'] = $fine ;
            $res['marking'] = $marking;
            $res['sefine'] = $sefine;
            $res['totalfine'] = $totalfee ; 
            $res['tnum'] = $tnum ;
            $smarty->assign('info',$res);
           $smarty->show('brules/ajax_bansuccess.tpl');
        }
        else page_msg('办理失败！请重新提交',false,'peccancy.shtml?action=mybrules',5,1);
    }

    function myban()
    {
        global $smarty,$pdo,$br_push_status;
        $pageSize = 15;
        $offset = 0;
        $subPages=15;//每次显示的页数
        $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        if($currentPage>0) $offset=($currentPage-1)*$pageSize;
        
        $uid = UID;
        $limit = " limit $offset,$pageSize ";
        $where =  " uid = '{$uid}' and flag = 0 ";
        
        $sql = "select * from ".DB_PREFIX_DR."agency_brules  where $where order by id desc $limit ";
        $countsql = "select count(*) as count from ".DB_PREFIX_DR."agency_brules  where $where order by id desc ";
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
        
        $smarty->show('brules/peccancy_myban.tpl');
    }   
    
    
	function getInfoById($id,$uid)
	{
		global $pdo ;
		$sql = " select * from ".DB_PREFIX_DR."brules_info where id = '$id' and uid = '$uid' ";
		$info = $pdo->getRow($sql);
		return $info;
	}
    
    function upFlagInBc($ids)
    {
        global $pdo ; 
        $sql = " update ".DB_PREFIX_DR."brules_content set flag = 1 where bc.id in ($ids) ";
        return $pdo->execute($sql) ;
    }
?>
