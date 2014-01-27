<?php 
/**
* 二手房  
* @Created 2010-6-10下午04:56:50
* @name esf_pub.php
* @author 304260440@qq.com
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_pub.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
session_start(); 
require_once('./member_config.php');

require_once('./data/cache/base_code.php');
check_login();
$smarty = new WebSmarty();
$resold	= new Resold;
$pdo=new MysqlPdo();

#不受限用户
//$IS_ADMIN =false;
if(in_array($_SESSION['home_username'],$NO_ALLOW_USER))
{
	define('IS_ADMIN',1);
}

switch($_GET['action'])
	{
	case 'index':index(); //首页页面
		break;
	case 'save': save(); //保存信息
		break;
    case 'deal':deal();break;
    case 'getMe':getMeInDb();break;
	default:index();
		break;
	}

function index()
{
    global $smarty,$min_expectprice_option,$score_option,$timeline_option,$type_radio,$crecate_radio,$revoke_option,$de_province;
    
    $type = $_GET['type']=='1' ? '1' : '0';
    $values1 = $values2 = array(26,322,0,0);
    if(!empty($_GET['did'])&&is_numeric($_GET['did']))
    {
        $info = getInfoById($_GET['did'],$_SESSION['home_userid']);
        $values1 = array($info['in_province'],$info['in_city'],$info['in_dist']);
        $values2 = array($info['on_province'],$info['on_city'],$info['on_dist']);
        $type = $info['type'] == '1' ? '1' : '0';
        $smarty->assign('info',$info);
    }
    if($type=='1')$values1= array(0,0,0,0);
    $elems = array('in_province', 'in_city', 'in_dist');
    $dist1 = '<span id="residedistrictbox">'.showdistricts($values1, $elems, 'residedistrictbox').'</span>';
   
    $elems = array('on_province', 'on_city', 'on_dist');
    $dist2 = '<span id="residedistrictbox2">'.showdistricts($values2, $elems, 'residedistrictbox2').'</span>';
    
    
    $smarty->assign('type_radio',$type_radio);
    $smarty->assign('crecate_radio',$crecate_radio);
    $smarty->assign('revoke_option',$revoke_option);
    $smarty->assign('min_expectprice_option',$min_expectprice_option);
    $smarty->assign('score_option',$score_option);
    $smarty->assign('timeline_option',$timeline_option);
    $smarty->assign('dist1',$dist1);
    $smarty->assign('dist2',$dist2);
    $smarty->assign('type',$type);
    $tpl = 'mydr/pubEdit.tpl';
    if($type=='1')$tpl = 'mydr/pubEdit_buy.tpl';
    $smarty->show($tpl);
}	

function getMeInDb()
{
    global $pdo,$crecate_db;
    $oid = $_POST['oid'] ; $city = $_POST['city'];
    $type = $_POST['type'];
    $result = 'none';
    if($oid>0&&$city>0&&($type==0||$type==1))
    { 
        $column = $crecate_db[$oid];             
        $info = $pdo->getRow(" select $column from ".DB_PREFIX_DR."mecity where city = '$city' and type = '$type' and status = '1' ");
        if(!empty($info[$column]))
        {
            $option = $info[$column];
            $option = explode('|',$option);
            if(is_array($option))
            {
                foreach($option as $item)
                {
                    $options .= "<option value='{$item}'>{$item}/分</option>";
                }
            }
            else $options = "<option value='{$option}'>{$option}/分</option>";
            
            $result = $options ;
        }
    }
    echo $result;
}

function save()
{
    global $pdo;
    
    InfoCheck($_POST);
    
    $_POST['addtime'] = time();
    $_POST['username'] = USERNAME;
    $_POST['uid'] = UID;
    
    extract($_POST);
    if($type=='1')
    {
        if($othersc=='1')
        {
            $_POST['score'] = empty($scorceNew) ? $_POST['score'] : $scorceNew;
        }
        
    }
    $id = $_POST['id'];
    unset($_POST['scorceNew'],$_POST['othersc'],$_POST['id']);
    
    //print_r($_POST);exit;
    if(!empty($id))
    {
        $info = isThisUserOwn(UID,$id);
        if($info['id']>0)
        {
            if($pdo->update($_POST,DB_PREFIX_DR.'info',"id='$id' and uid = '".UID."'"))
            {
                page_prompt('修改信息成功！',true,'mytask.html',3);
            }
            else
            {
                page_prompt('修改信息失败！',false,'mytask.html',3);
            }
        }
    }
    else
    {
       if($pdo->add($_POST,DB_PREFIX_DR.'info'))
        {
            page_prompt('添加信息成功！',true,'mytask.html',3);
        }
        else
        {
            page_prompt('添加信息失败！',false,'mytask.html',3);
        } 
    }
}

function deal(){
    global $pdo;
    extract($_GET);
    if(!isThisUserOwn(UID,$did))page_prompt('改任务不存在或已更改！',false,'mytask.html');
    if($pdo->execute(" delete from ".DB_PREFIX_DR."info where id = '$did' and uid = '".UID."' "))
    {
        page_prompt('删除信息成功！',true,'mytask.html',3);
    }
    else page_prompt('删除信息失败！',false,'mytask.html',3);
}

function getInfoById($id,$uid)
{
    global $pdo;
    $info = $pdo->find(DB_PREFIX_DR.'info'," id = '$id' and uid = '$uid' ");
    return $info;
}


function isThisUserOwn($userid,$eid)
{
	return getPdo()->find(DB_PREFIX_DR.'info',"uid='$userid' and id = '$eid'  ");
}
/**
+----------------------------------------------------------
* 提交信息Check
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function  InfoCheck($post)
{
    @extract($post);
    $url = 'member_pub.php';
    //联系人不能为空
    if(utf8_strlen($linkman)<2)page_prompt('联系人不能为空且大于1位',false,$url,3,$post);
    //联系人只能为汉字或英文,不能有数字
    if(!preg_match("/^(([\x81-\xfe][\x40-\xfe])+)||([a-zA-Z]+)$/",$linkman))page_prompt('联系人只能为中文或英文',false,$url,3,$post);
    //联系电话不能为空
    if(!preg_match("/^(1\d{10})|(((\d{3,4})(-)?)?[1-9]\d{6,7})$/",$tel))page_prompt('联系电话不正确',false,$url,3,$post);
    
//    (((\d{3,4})|(\d{3,4}-))?[1-9]\d{6,7})
}
/**
+----------------------------------------------------------
* 提交信息Check
+----------------------------------------------------------
* @access public 
+----------------------------------------------------------
* @param 
+----------------------------------------------------------
* @return 
+----------------------------------------------------------
*/
function  InfoCheck1($post)
{
	@extract($post);
	$url = 'member_pub.php?action=esf_add&house_type='.$house_type ;
	//标题不能为空 且25字
	if(empty($title)||utf8_strlen($title)>25)page_prompt('标题不能为空，且长度小于25位',false,$url,3,$post);
	//标题必须含有中文
	if(!preg_match("/^.*([\x81-\xfe][\x40-\xfe])+.*$/",$title))page_prompt('标题必须含有至少一个汉字',false,$url,3,$post);
	//小区不能为空 且要大于2位 小于20位
	if(utf8_strlen($reside)<2||utf8_strlen($reside)>20)page_prompt('小区不能为空，且长度大于2位',false,$url,3,$post);
	//房源地址不能为空 
	if(utf8_strlen($address)<3)page_prompt('房源地址不能为空且大于3位',false,$url,3,$post);
	//房源地址必须含有中文
	if(!preg_match("/^.*([\x81-\xfe][\x40-\xfe])+.*$/",$address))page_prompt('房源地址必须含有至少一个汉字',false,$url,3,$post);
	//总价不能为空 且只能为整数
	if($price!='面议'&&(strlen($price)<1||!is_numeric($price)||$price<1))page_prompt('价格不能为空且不能小于1',false,$url,3,$post);
	//总价格式
	if($price!='面议'&&(!preg_match("/^[1-9]\d{1,10}(\.\d{1,2})?$/",$price)))page_prompt('价格格式不正确，只能为整数或2位小数',false,$url,3,$post);
	//楼层
	if((!empty($current_floor)&&!ctype_digit($current_floor))||(!empty($total_floor)&&!ctype_digit($total_floor)))page_prompt('楼层必须为数字',false,$url,3,$post);
	//区县不能为0
	if(empty($borough))page_prompt('区县必须选择',false,$url,3,$post);
	//建筑面积不能为空
	if($total_area<=1||!is_numeric($total_area))page_prompt('建筑面积必填且为数字',false,$url,3,$post);
	//联系人不能为空
	if(utf8_strlen($linkman)<2)page_prompt('联系人不能为空且大于1位',false,$url,3,$post);
	//联系人只能为汉字或英文,不能有数字
	if(!preg_match("/^(([\x81-\xfe][\x40-\xfe])+)||([a-zA-Z]+)$/",$linkman))page_prompt('联系人只能为中文或英文',false,$url,3,$post);
	//联系电话不能为空
	if(!preg_match("/^(1\d{10})|(((\d{3,4})(-)?)?[1-9]\d{6,7})$/",$telphone))page_prompt('联系电话不正确',false,$url,3,$post);
	
//	(((\d{3,4})|(\d{3,4}-))?[1-9]\d{6,7})
}
