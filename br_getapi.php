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
    if(USERNAME!="younglly001")exit('0');
    $smarty = new WebSmarty();
    $smarty->caching = false;
    $pdo=new MysqlPdo();
    switch(isset($_GET['action'])?$_GET['action']:'index')
    {
    case 'index':index(); //首页页面
        exit;
    case 'form':formIndex();//
        exit();
    case 'save': save(); //增加信息处理
        exit();
    default:index();
        exit;
    }
    
    
    /**
     * 首页
     * */
    function index()
    {
        global $pdo,$br_car_type;
        $now = time();
        $t = $now - (12*60*60) ;
        $where = " where uptime < $t or uptime is null ";
        $sql = " select * from  ".DB_PREFIX_DR."brules_info $where ";
        $res = $pdo->getAll($sql);
        foreach($res  as $key=>$item)
        {
           $result[$key]['no'] = $item['lpp'].$item['lpno'];
           $result[$key]['bno'] = $item['id'];
           $result[$key]['chassisno'] = $item['chassisno'];
           $result[$key]['engno'] = $item['engno'];
           $result[$key]['type'] = $br_car_type[$item['vtype']];
           $result[$key]['hasBase'] = !empty($item['brand']) ? 1 : 0;
		   //$result[$key]['hasBase'] =  0;
        }

        echo json_encode($result);
    }
    

    /**
    *提交页面 
    */

    function formIndex()
    {
        global $smarty ;
        
        $smarty->show("brules/getapi_form.tpl");
        
    }
    
    /**
    *保存方法 
    */
    function save()
    {
        global $pdo;
        //require_once('includes/log.class.php');
       // print_r($_POST);
      //  Log::write(json_encode($_POST));exit;
        $msg['issuccess'] = 0;//$row=1;//$_POST['brtime'] = 0 ;
        extract($_POST);
        $no = $_POST['no'];
        $bno = $_POST['bno'];
        if(empty($bno)||!is_numeric($bno))showErroMsg('唯一号必填');
        if(empty($no))showErroMsg('车牌号码必填');
        $sql = " select id  from ".DB_PREFIX_DR."brules_info where CONCAT(`lpp`,`lpno`) = '$no'  and id = '$bno'  ";
        $info = $pdo->getRow($sql);
        $bid = $info['id'];
        $newNum = $newScore = 0 ;
		//Log::write("bid=".$bid."====5556666--------------".$bid);
		$time = time();
        if($bid>0)
        {// var_dump($info) ;exit;
		 Log::write("bid=".$bid."====121212121--------------".$sql);
            if($row==1){
                #启动事物
                $pdo->startTrans();
                $sql = " select count(*) as cnt  from ".DB_PREFIX_DR."brules_content where bid = '$bid'  ";
                $list = $pdo->getRow($sql);
                if($list['cnt']>0)
                {
                    #如果存在车牌信息 ，则应该将远系统信息读取 
                    $sql = " select brtime from ".DB_PREFIX_DR."brules_content where bid = '$bid' ";
                    $info = $pdo->getAll($sql);
                    foreach($info as $item)
                    {
                        $oldData[] = $item['brtime'];
                    }
                    #如果存在该车牌号信息，则先删除该车牌号的违章信息
                    //2013-07-10 避免服务器返回信息为0条时 不处理改车牌的违章信息，改为手动处理
                    if(count($_POST['brtime'])>0&&!empty($_POST['brtime'][0])){
                        $pdo->doSql(" delete from ".DB_PREFIX_DR."brules_content where bid = '$bid' ");
                    }
                }
               // Log::write("11111--------------".$sql);
                #插入违章信息
                if(count($_POST['brtime'])>0&&!empty($_POST['brtime'][0]))
                {
                    foreach($_POST['brtime'] as $key=>$item)
                    {
                        #判断新增时间不在原信息中则累加
                        if(!in_array($item,$oldData)){
                            $newNum++;
                            $newScore += intval($_POST['marking'][$key]) ;
                        }
                        $sql = " insert into  ".DB_PREFIX_DR."brules_content 
                                    set bid = '$bid',
                                        brtime = '$item' ,
                                        braddress = '{$_POST['braddress'][$key]}',
                                        brreason = '{$_POST['brreason'][$key]}',
                                        marking = '{$_POST['marking'][$key]}',
                                        fine = '{$_POST['fine'][$key]}',
                                        addtime = '$time'
                                ";
                        $pdo->doSql($sql);
						    
 //Log::write("22222--------------".$sql);
					    $tscore += intval($_POST['marking'][$key]);
                    }
				    
					$cn = count($_POST['brtime']);
                    if(!empty($brand))
                    $sql = " update ".DB_PREFIX_DR."brules_info 
                            set brnum = '$cn' ,
                             newnum = '$newNum',
                             newscore = '$newScore',
                             brand = '$brand' ,
                             reg_first = '$reg_first' ,
                             check_last = '$check_last' ,
                             valid = '$valid' ,
                             end_insure = '$end_insure' ,
                             uptime = '$time',
                             totalscore = '$tscore',
                             flag = '0'
                            where id = '$bid' 
                            ";
                    else
                    $sql = " update ".DB_PREFIX_DR."brules_info 
                            set brnum = '$cn' ,
                             newnum = '$newNum',
                             newscore = '$newScore',
                             uptime = '$time',
                             totalscore = '$tscore',
                             flag = '0'
                            where id = '$bid' 
                            ";
					$pdo->doSql($sql);
				    
				   Log::write("33333--------------".$sql);
                }
                else
                {
                    // * 由于采集服务器可能出现无法采集 会返回无违章信息，故不再更新 主表违章信息 。。。
                   /* $sql = " update ".DB_PREFIX_DR."brules_info 
                                set brnum = '$cn' ,
                                 newnum = '$newNum',
                                 newscore = '$newScore',
                                 uptime = '$time',
                                 exists = '0'
                                where id = '$bid' 
                                ";
                   */
				   if(!empty($brand))$set = " ,brand = '$brand' ,
                             reg_first = '$reg_first' ,
                             check_last = '$check_last' ,
                             valid = '$valid' ,
                             end_insure = '$end_insure'  ";
					$sql = " update ".DB_PREFIX_DR."brules_info set uptime = '$time',flag = '2' $set where id = '$bid' ";
					$pdo->doSql($sql);
                }
                // Log::write("444444--------------".$sql);
                if($pdo->commit())
                {
                    $msg['issuccess'] = 1;
                }
                //else{
//                    $msg['issuccess'] = 0;
//                }
            }
            
        }
        
        echo json_encode($msg);
        exit;
    }
    
    function showErroMsg($msgs)
    {
        $msg['issuccess'] = 0;
        $msg['msg'] = $msgs ;
        echo json_encode($msg);
        exit;
    }

?>
