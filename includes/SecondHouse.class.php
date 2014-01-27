<?php 
/**
 * Created on 2008-06-05
 * 二手房子租售
 * @since ".DB_PREFIX_HOME."V2008
 * @author like<like@fc114.com>
 * ChengDu CandorSoft Co., Ltd.
 * @version $Id: SecondHouse.class.php,v 1.1 2012/02/07 08:59:18 gfl Exp $
 */

require_once('BasePage.class.php');

class SecondHouse extends BasePage {

	public $total;
	/**
     * 构造函数
     * @access public 
     */
    public function __construct(){
        parent::__construct();
		$this->total = 0;
    }

    /**
    +----------------------------------------------------------
    * 查询所有出售二手房
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $flag  有效标志 [0:无效 1:有效]
    * @param  $page  当前页 
    * @param  $row   每页显示数
    * @param  $str   查询串
    * @param  $where  补充条件
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */
    public function getAllEsf($flag=1, $page=0, $row=10, $str="" ,  $where=""){
        $start = $page * $row;

       	$where .= empty($str) ? "" : " AND reside like '%". $str ."%'";

        $where = "flag={$flag}".$where;

        if($_SESSION['companyId'] > SYSTEM_ADMIN_COMPANY_ID && $_SESSION['isAdmin'])
        {
              $where  = "{$where} AND company_id={$_SESSION['companyId']} ";
        }
        elseif ($_SESSION['companyId'] != SYSTEM_ADMIN_COMPANY_ID )
        {
            $where = " {$where} AND user_id={$_SESSION['userId']} ";
        }
        //$fileds = "id, house_type, reside, address, borough, pright, company_id, total_area, price, updated_at, flag, create_at,user_id,hits,is_top,custom_id, is_recommend";
        //$fileds = "".DB_PREFIX_HOME."esf.*";
        //$arrEsf = $this->pdo->find(DB_PREFIX_HOME."esf", $where, $fileds, "is_top desc,updated_at desc", "{$start}, {$row}");
		
        //得到该分店下面所有的经济人
		$sql="select m.user_id,u.login_name,u.user_name from ".DB_PREFIX_HOME."member m left join ".DB_PREFIX_HOME."user u on m.user_id=u.user_id where m.parent_user_id=".$_SESSION['userId'];
		$user_id_list=$this->pdo->getAll($sql);
		$condition = "(".$_SESSION['userId'];
		foreach ($user_id_list as $item) {$condition.=','.$item['user_id'];}
		$condition.=") ";
        $sql="select e.*,u.login_name
from ".DB_PREFIX_HOME."esf as e left join ".DB_PREFIX_HOME."user as u on e.user_id=u.user_id
where e.house_type=2 and e.flag<>0 
and e.user_id in ".$condition." 
order by e.create_at desc limit {$start}, {$row}";
        $arrEsf = $this->pdo->getAll($sql);
		//echo $this->pdo->getLastSql();
        return $arrEsf;
    }


    /**
    +----------------------------------------------------------
    * 查询所有出租二手房
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $flag  有效标志 [0:无效 1:有效]
    * @param  $page  当前页 
    * @param  $row   每页显示数
    * @param  $str   查询串
    * @param  $where  补充条件
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */
    public function getAllEsfRent($flag=1, $page=0, $row=10, $str="" , $where=""){
        $start = $page * $row;
        $where .= empty($str) ? "" : " AND e.reside like '%". $str ."%'";
        $where = "e.flag={$flag}".$where;

        if($_SESSION['companyId'] > SYSTEM_ADMIN_COMPANY_ID and $_SESSION['isAdmin'])
        {
              $where  = "{$where} AND e.company_id={$_SESSION['companyId']} ";
        }
        elseif ($_SESSION['companyId'] != SYSTEM_ADMIN_COMPANY_ID )
        {
            $where = " {$where} AND e.user_id={$_SESSION['userId']} ";
        }

        //$fileds = "e.id, e.house_type, e.reside, e.address, e.borough, e.pright, e.company_id, e.total_area, e.price, e.updated_at, e.flag, r.rent_way, e.user_id, e.create_at,e.hits";
        //$arrEsf = $this->pdo->find(DB_PREFIX_HOME."esf e left join " .DB_PREFIX_HOME."esf_rent r on e.id = r.esf_id", $where, $fileds, "e.updated_at desc", "{$start}, {$row}");
        //得到该分店下面所有的经济人
		$sql="select m.user_id,u.login_name,u.user_name from ".DB_PREFIX_HOME."member m left join ".DB_PREFIX_HOME."user u on m.user_id=u.user_id where m.parent_user_id=".$_SESSION['userId'];
		$user_id_list=$this->pdo->getAll($sql);
		$condition = "(".$_SESSION['userId'];
		foreach ($user_id_list as $item) {$condition.=','.$item['user_id'];}
		$condition.=") ";
        $sql="select e.*,u.login_name
from ".DB_PREFIX_HOME."esf as e left join ".DB_PREFIX_HOME."user as u on e.user_id=u.user_id
where e.house_type=1 and e.flag<>0 
and e.user_id in ".$condition." 
order by e.create_at desc limit {$start}, {$row}";
        $arrEsf = $this->pdo->getAll($sql);
		//echo $this->pdo->getLastSql();
        return $arrEsf;
    }

    /**
    +----------------------------------------------------------
    * 统计所有出售的二手房
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $flag  有效标志 [0:无效 1:有效]
    * @param  $str   查询串
    +----------------------------------------------------------
    * @return int
    +----------------------------------------------------------
    */
    public function getCoumtAllEsf($flag=1, $str="", $where){
        $where .= empty($str) ? "" : " AND reside like '%". $str ."%'";
        $where = "flag={$flag}".$where;

        if($_SESSION['companyId'] > SYSTEM_ADMIN_COMPANY_ID and $_SESSION['isAdmin'])
        {
            	$where  = "{$where} AND company_id={$_SESSION['companyId']}";	 	
        }
        elseif ($_SESSION['companyId'] != SYSTEM_ADMIN_COMPANY_ID )
        {
            $where = " {$where} AND user_id={$_SESSION['userId']} ";
        }

        //$iLen = $this->pdo->countAll(DB_PREFIX_HOME."esf", $where);
        //得到该分店下面所有的经济人
		$sql="select m.user_id,u.login_name,u.user_name from ".DB_PREFIX_HOME."member m left join ".DB_PREFIX_HOME."user u on m.user_id=u.user_id where m.parent_user_id=".$_SESSION['userId'];
		$user_id_list=$this->pdo->getAll($sql);
		$condition = "(".$_SESSION['userId'];
		foreach ($user_id_list as $item) {$condition.=','.$item['user_id'];}
		$condition.=") ";
        $sql="select count(e.id) as cnt  
from ".DB_PREFIX_HOME."esf as e left join ".DB_PREFIX_HOME."user as u on e.user_id=u.user_id
where e.house_type=2 and e.flag<>0 
and e.user_id in ".$condition;
        $iLen = $this->pdo->getRow($sql);
        return $iLen['cnt'];
    }

	/**
    +----------------------------------------------------------
    * 统计所有出租的二手房
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $flag  有效标志 [0:无效 1:有效]
    * @param  $str   查询串
    +----------------------------------------------------------
    * @return int
    +----------------------------------------------------------
    */
    public function getCountAllEsfRent($flag=1, $str="", $where){
        $where .= empty($str) ? "" : " AND reside like '%". $str ."%'";
        $where = "flag={$flag}".$where;

        if($_SESSION['companyId'] > SYSTEM_ADMIN_COMPANY_ID and $_SESSION['isAdmin'])
        {
              $where  = "{$where} AND e.company_id={$_SESSION['companyId']} ";
        }
        elseif ($_SESSION['companyId'] != SYSTEM_ADMIN_COMPANY_ID )
        {
            $where = " {$where} AND e.user_id={$_SESSION['userId']} ";
        }

        //$iLen = $this->pdo->countAll(DB_PREFIX_HOME."esf e left join " .DB_PREFIX_HOME."esf_rent r on e.id = r.esf_id", $where, "e.id");
        //return $iLen;
        //得到该分店下面所有的经济人
		$sql="select m.user_id,u.login_name,u.user_name from ".DB_PREFIX_HOME."member m left join ".DB_PREFIX_HOME."user u on m.user_id=u.user_id where m.parent_user_id=".$_SESSION['userId'];
		$user_id_list=$this->pdo->getAll($sql);
		$condition = "(".$_SESSION['userId'];
		foreach ($user_id_list as $item) {$condition.=','.$item['user_id'];}
		$condition.=") ";
        $sql="select count(e.id) as cnt  
from ".DB_PREFIX_HOME."esf as e left join ".DB_PREFIX_HOME."user as u on e.user_id=u.user_id
where e.house_type=1  and e.flag<>0 
and e.user_id in ".$condition;
        $iLen = $this->pdo->getRow($sql);
        return $iLen['cnt'];
    }

    /**
    +----------------------------------------------------------
    * 添加二手房信息
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $flag     二手房状态 [0:已删除 1:有效]
    * @param  $house_type 房屋类别[1:出租 2:出售]
    +----------------------------------------------------------
    * //@return array
    +----------------------------------------------------------
    */

    public function  addEsf($house_type, $post){

        $property = $_POST['property'];
        if(!empty($_POST['company_id']))
        {
            $company_id = isset($_POST['company_id'])?$_POST['company_id']:0;
        }
        else
        {
            $company_id = isset($_SESSION['companyId'])?$_SESSION['companyId']:0;
        }
        $name_cn = isset($_SESSION['companyFullName'])?$_SESSION['companyFullName']:'';
        $district_id= isset($_POST['district_id'])?$_POST['district_id']:'';
        $title = isset($_POST['title'])?$_POST['title']:'';
        $is_payed = isset($_POST['is_payed'])?$_POST['is_payed']:0;
        $code = 0;
        $address = isset($_POST['address'])?$_POST['address']:'';
		$address_hide = isset($_POST['address_hide'])?$_POST['address_hide']:'';
        $reside = isset($_POST['reside'])?$_POST['reside']:'';
        $first_char = 0; 
        $direction = isset($_POST['direction'])?$_POST['direction']:0;
        $region = 0; 
        $borough = isset($_POST['borough'])?$_POST['borough']:'';
        $circle = isset($_POST['circle'])?$_POST['circle']:0;
        $house_use = 0;
        $pright = isset($_POST['pright'])?$_POST['pright']:0;
        $porch = isset($_POST['porch'])?$_POST['porch']:0;
        $parlor = isset($_POST['parlor'])?$_POST['parlor']:0;
        $room = isset($_POST['room'])?$_POST['room']:0;
        $elevator = 0;
        $arch = isset($_POST['arch'])?$_POST['arch']:0;
        $hiber = 0; 
        $struct = 0;
        $toilet = isset($_POST['toilet'])?$_POST['toilet']:0;
        $total_floor = isset($_POST['total_floor'])?$_POST['total_floor']:0; 
        $current_floor = isset($_POST['current_floor'])?$_POST['current_floor']:0;
        $build_year = isset($_POST['build_year'])?$_POST['build_year']:0;
        $total_area = isset($_POST['total_area'])?$_POST['total_area']:0;
        $out_area = 0;
        $toward = isset($_POST['toward'])?$_POST['toward']:0;
		$area = isset($_POST['area'])?$_POST['area']:0;
        $fitment = isset($_POST['fitment'])?$_POST['fitment']:0;
        $fit_xj = 0; 
        $traffic =isset($_POST['traffic'])?$_POST['traffic']:0;
        $trade_circle = isset($_POST['trade_circle'])?$_POST['trade_circle']:0;
        $selling_point = isset($_POST['selling_point'])?$_POST['selling_point']:0;
        $costs = 0;
        $price = isset($_POST['price'])?$_POST['price']:0;
        $deposit = isset($_POST['deposit'])?$_POST['deposit']:0;
        $map_x = isset($_POST['map_x'])?$_POST['map_x']:0;;
        $map_y = isset($_POST['map_y'])?$_POST['map_y']:0;;
        $map_show = 0;
        $limit_day = 0;
        $user_id = $_SESSION['userId'];
        $publish_ip = $_SERVER['REMOTE_ADDR'];
        $create_at = $_SERVER['REQUEST_TIME']; 
        $editer = $_SESSION['userId'];
        $edit_ip = $_SERVER['REMOTE_ADDR'];
        $updated_at = $_SERVER['REQUEST_TIME'];
        $description = isset($_POST['description'])?$_POST['description']:'';
        $user_id = isset($_POST['userid'])?$_POST['userid']:0;
        $user_name = isset($_POST['username'])?$_POST['username']:0;
        $hits = 0;
		$custom_id = isset($_POST['custom_id'])?$_POST['custom_id']:0;
        $voucher = $_SESSION['userId'];
        $vouch_at = $_SERVER['REQUEST_TIME'];
        $vouch_ip = $_SERVER['REMOTE_ADDR'];
        $linkman = isset($_POST['linkman'])?$_POST['linkman']:'';
        $link_require =isset($_POST['link_require'])?$_POST['link_require']:'';
        $telphone = isset($_POST['telphone'])?$_POST['telphone']:'';
        $is_recommend = isset($_POST['recommend'])?$_POST['recommend']:0;
        $tube = isset($_POST['tube'])?$_POST['tube']:0;
		$rent_way = isset($_POST['rent_way'])?$_POST['rent_way']:0;
        $email = 0;
        $oicq = 0;
        $msn = 0;
        $flag = isset($_POST['flag']) ? $_POST['flag'] : 1; 
        $facilities = implode(":", isset($_POST['facilities'])?$_POST['facilities']:array());
		$live_date = isset($_POST['live_date'])?$_POST['live_date']:'立即入住';
          
        $arrCom = array(            
            'house_type' => $house_type,
            'district_id' => $district_id,
            'title' => $title,
            'company_id' => $company_id,
            'property' => $property,
            'code' => $code,
            'address' => $address,
			'address_hide' => $address_hide,
            'reside' => $reside,
            'first_char' => $first_char,
            'direction' => $direction,
            'region' => $region,
            'borough' => $borough,
            'circle' => $circle,
            'house_use' => $house_use,
            'pright' => $pright,
            'porch' => $porch,
            'parlor' => $parlor,
            'room' => $room,
            'toilet' => $toilet,
            'elevator' => $elevator,
            'arch' => $arch,
            'hiber' => $hiber,
            'struct' => $struct,
            'toilet' => $toilet,
            'total_floor' => $total_floor,
            'current_floor' => $current_floor,
            'build_year' => $build_year,
            'total_area' => $total_area,
            'out_area' => $out_area,
            'toward' => $toward,
			'area' => $area,
            'fitment' => $fitment,
            'fit_xj' => $fit_xj,
            'traffic' => $traffic,
            'trade_circle' => $trade_circle,
            'facilities' => $facilities,
            'selling_point' => $selling_point,
            'costs' => $costs,
            'price' => $price,
            'deposit' => $deposit,
            'map_x' => $map_x,
            'map_y' => $map_y,
            'map_show' => $map_show,
            'limit_day' => $limit_day,
            'user_id' => $user_id,
            'publish_ip' => $publish_ip,
            'create_at' => $create_at,
            'editer' => $editer,
            'edit_ip' => $edit_ip,
            'updated_at' => $updated_at,
            'description' => $description,
            'user_id' => $user_id,
            'user_name' => $user_name,
            'hits' => $hits,
            'voucher' => $voucher,
            'vouch_at' => $vouch_at,
            'vouch_ip' => $vouch_ip,
            'linkman' => $linkman,
            'link_require' => $link_require ,
            'telphone' => $telphone,
            'is_recommend' => $is_recommend,
            'email' => $email,
            'oicq' => $oicq,
            'msn' => $msn,
			'custom_id' => $custom_id,
            'flag' => $flag,
            'is_payed'=>$is_payed,    
            'name_cn'=>$name_cn,       
            'tube'=>$tube,
			'rent_way'=>$rent_way,
			'live_date'=>$live_date
        );
        
        $this->pdo->add($arrCom, DB_PREFIX_HOME."esf");
			//echo $this->pdo->getLastSQL(); 

        return $this->pdo->getLastInsID();   //返回最后ID号

    }

    /**
    +----------------------------------------------------------
    * 添加二手房出租信息
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $flag     二手房状态 [0:已删除 1:有效]
    +----------------------------------------------------------
    +----------------------------------------------------------
    */

    public function  addEsfRent($esfid, $rent_way, $time_limit, $pay_way, $deposit, $fees){
                    
        $arrEr = array(
            
                'esf_id' => $esfid,
                'rent_way' => $rent_way,
                'time_limit' => $time_limit,
                'pay_way' => $pay_way,
                'deposit' => $deposit,
                'fees' => $fees,
                        
        );
               
        $this->pdo->add($arrEr, DB_PREFIX_HOME."esf_rent");

        //return $this->pdo->getLastInsID();   //返回最后ID号

    }

    /**
    +----------------------------------------------------------
    * 数据处理
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    //* @param  $esfId  ID
    //* @param  $type   处理类型
    +----------------------------------------------------------
    * @return int
    +----------------------------------------------------------
    */
    public function houseHandle($esfId, $type){
        if(empty($esfId) || empty($type))  throw_exception("参数传入错误!");
        $msg = ""; //提示信息
        switch ($type) {
            case "edit_admin" : // 管理员编辑
                redirect("house_write.php?sp=".formatParameter(array("esfId"=>$esfId)));
                break;
            case "edit_company" : // 中介二手房出售编辑
                redirect("secondHouse_write.php?sp=".formatParameter(array("esfId"=>$esfId)));
                break;
            case "edit_rent" : // 中介二手房出租编辑
                redirect("rentHouse_write.php?sp=".formatParameter(array("esfId"=>$esfId)));
                echo "OK";
                break;
            case "edit_require" : // 中介二手房出租编辑
                redirect("rent_write.php?sp=".formatParameter(array("reqId"=>$esfId)));
                echo "OK";
                break;
            case "dele" : // 删除二手房，设为无效
                $msg = $this->pdo->setField("flag", 0, DB_PREFIX_HOME."esf", "id={$esfId}");
                break;
            case "dele_require" : // 删除求租求购信息，这里的esfID为求租求购ID
                $this->RemoveEsfReq($esfId);
                break;
			case 'valid_admin':
				redirect("house_valid.php?sp=".formatParameter(array("esfId"=>$esfId)));
				break;
        }

        return $msg;
    }



    /**
    +----------------------------------------------------------
    * 删除二手房数据（设为无效）
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    //* @param  $id  二手房
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */    
    public function deleteRecord($id) {
            $this->pdo->setField("flag", 0, DB_PREFIX_HOME."esf", "id={$id}");
            return "删除成功!";
    }

    /**
    +----------------------------------------------------------
    * 根据二手房ID查询二手房详情
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $esfId  二手房ID
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */    
    public function getEsfById($esfId) {
		$sql = "SELECT 
		   *
		 FROM
		   %s
		 WHERE 
		   id = %d AND flag <> 0";
		$sql = sprintf($sql, DB_PREFIX_HOME."esf", $esfId);
		return $this->pdo->getRow($sql);
    }

    /**
    +----------------------------------------------------------
    * 根据二手房ID查询二手房租房详情
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $esfId  二手房ID
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */    
    public function getEsfRentById($esfId) {
		$sql = "SELECT 
		   *
		 FROM
		   %s
		 WHERE 
		   e.id = %d";
		$sql = sprintf($sql, DB_PREFIX_HOME."esf e left join " .DB_PREFIX_HOME."esf_rent r on e.id = r.esf_id", $esfId);
		
		return $this->pdo->getRow($sql);
    }

    /**
    +----------------------------------------------------------
    * 修改二手房出售数据
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param array $post    表单数据
    +----------------------------------------------------------
    */
    public function UpdateEsf($post){
    	$_POST = $post;
        $esfId = $_POST['hidEsfId'];
        if(!empty($_POST['company_id'])){
            $company_id = isset($_POST['companyId'])?$_POST['companyId']:0;
        }
        else {
            $company_id = isset($_SESSION['companyId'])?$_SESSION['companyId']:0;
        }
        $title = isset($_POST['title'])?$_POST['title']:'';
		$district_id= isset($_POST['district_id'])?$_POST['district_id']:'';
        $property = isset($_POST['property'])?$_POST['property']:'';
        $address = isset($_POST['address'])?$_POST['address']:'';
		$address_hide = isset($_POST['address_hide'])?$_POST['address_hide']:'';
        $reside = isset($_POST['reside'])?$_POST['reside']:'';
        $borough = isset($_POST['borough'])?$_POST['borough']:'';
        $pright = isset($_POST['pright'])?$_POST['pright']:'';
        $porch = isset($_POST['porch'])?$_POST['porch']:'';
        $parlor =isset($_POST['parlor'])?$_POST['parlor']:'';
        $room = isset($_POST['room'])?$_POST['room']:'';
        $arch = isset($_POST['arch'])?$_POST['arch']:'';
        $toilet = isset($_POST['toilet'])?$_POST['toilet']:'';
        $total_floor = isset($_POST['total_floor'])?$_POST['total_floor']:'';
        $current_floor = isset($_POST['current_floor'])?$_POST['current_floor']:'';
        $build_year = isset($_POST['build_year'])?$_POST['build_year']:'';
        $total_area = isset($_POST['total_area'])?$_POST['total_area']:'';
        $toward =isset($_POST['toward'])?$_POST['toward']:'';
        $direction = isset($_POST['direction'])?"{$_POST['direction']}":0;
		$area =isset($_POST['area'])?$_POST['area']:'';
        $fitment = isset($_POST['fitment'])?$_POST['fitment']:'';
        $traffic =isset($_POST['traffic'])?$_POST['traffic']:'';
		$trade_circle = isset($_POST['trade_circle'])?$_POST['trade_circle']:'';
        $circle = isset($_POST['circle'])?$_POST['circle']:0;
        $selling_point = isset($_POST['selling_point'])?$_POST['selling_point']:'';
        $price =isset($_POST['price'])?$_POST['price']:'';
        $editer = $_SESSION['userId'];
        $edit_ip = $_SERVER['REMOTE_ADDR'];
        $edit_at = $this->now;
        $description = isset($_POST['description'])?$_POST['description']:'';
        $linkman =isset($_POST['linkman'])?$_POST['linkman']:'';
        $link_require =isset($_POST['link_require'])?$_POST['link_require']:'';
        $telphone = isset($_POST['telphone'])?$_POST['telphone']:'';
        $is_recommend = isset($_POST['recommend'])?$_POST['recommend']:0;
        $tube = isset($_POST['tube'])?$_POST['tube']:0;
        $flag = isset($_POST['flag'])?$_POST['flag']:1;
		$custom_id = isset($_POST['custom_id'])?$_POST['custom_id']:'';
		$facilities = isset($_POST['facilities'])?$_POST['facilities']:'';
        $facilities = empty($facilities) ? '' : implode(":", $facilities);

        $arrEsf = array(       
            'district_id' => $district_id,
            'title' => $title,
            'property' => $property,
            'address' => $address,
			'address_hide' => $address_hide,
            'reside' => $reside,
            'borough' => $borough,
            'pright' => $pright,
            'porch' => $porch,
            'parlor' => $parlor,
            'room' => $room,
            'toilet' => $toilet,
            'arch' => $arch,
            'toilet' => $toilet,
            'total_floor' => $total_floor,
            'current_floor' => $current_floor,
            'build_year' => $build_year,
            'total_area' => $total_area,
            'toward' => $toward,
			'area' => $area,
			'direction' => $direction,
            'fitment' => $fitment,
            'traffic' => $traffic,
			'trade_circle'=>$trade_circle,
            'circle' => $circle,
            'facilities' => $facilities,
            'selling_point' => $selling_point,
            'price' => $price,
            'edit_ip' => $edit_ip,
            'edit_at' => $edit_at,
            'description' => $description,
            'linkman' => $linkman,
            'link_require' => $link_require ,
            'telphone' => $telphone,
            'is_recommend' => $is_recommend,
            'flag' => $flag,
			'custom_id' => $custom_id,
            'facilities' => $facilities,
            'map_x'=>$_POST['map_x'],
            'map_y'=>$_POST['map_y'],
            'tube'=>$tube,
        );

        if(!empty($esfId)) { //修改
        	//print_r($arrEsf);exit;
           if($this->pdo->update($arrEsf, DB_PREFIX_HOME."esf", "id=".$esfId))
           {
           		$this->countHouseImages((int)$esfId);return true;
           }
		   
        }

        return false;
  }

    /**
    +----------------------------------------------------------
    * 修改二手房出租数据
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param array $post    表单数据
    +----------------------------------------------------------
    */
    public function UpdateEsfRent($post){
        $esfId = isset($_POST['hidEsfId'])?$_POST['hidEsfId']:0;
        $rent_way =  isset($_POST['rent_way'])?$_POST['rent_way']:0;
        $time_limit =isset($_POST['time_limit'])?$_POST['time_limit']:0;
        $pay_way = isset($_POST['w'])?$_POST['w']:0;
        $deposit = isset($_POST['deposit'])?$_POST['deposit']:0;
        $fees = isset($_POST['fees'])?$_POST['fees']:0;
        $title = isset($_POST['title'])?$_POST['title']:'';
        
        //二手房出租相关信息
        $arrEr = array(            
                'rent_way' => $rent_way,
                'title' => $title,
                'time_limit' => $time_limit,
                'pay_way' => $pay_way,
                'deposit' => $deposit,
                'fees' => $fees                     
        );

        if(!empty($esfId)) { //修改
           $this->pdo->update($arrEr, DB_PREFIX_HOME."esf_rent", "esf_id=".$esfId);    // update

		   $this->countHouseImages((int)$esfId);
        }

        return true;
	 }

    /**
    +----------------------------------------------------------
    * 保存图片附件内容
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param integer $esfId    二手房ID
    * @param array   $arrFile  文件
    +----------------------------------------------------------
    * @return array 返回添加附件的ID数组
    +----------------------------------------------------------
    */
    public function addEsfAttach($esfId,$reside, $arrFile){
        if(!empty($arrFile)){
            $upload = new UploadFile($arrFile);
            $iCount = $upload->upload();
            $aInfo = $upload->getSaveInfo();

            for($i=0; $i<$iCount; $i++){
                $arrInfo = $aInfo[$i];

                // 加附件
                $this->pdo->add(array(
                    "name"=>$arrInfo['name'], 
                    "url"=>$arrInfo['url'], 
                    "type"=>$arrInfo['type'], 
                    "size"=>$arrInfo['size'], 
                    "checksum"=>$arrInfo['checksum'],
                    "update_at"=>$this->now), DB_PREFIX_HOME."esf_attach");

                // 加附件与文件关联
                $this->pdo->add(array("esf_id"=>$esfId, "code"=>0, "title"=>$reside, "description"=>0, "is_default"=>1, "attach_id"=>$this->pdo->getLastInsID()), DB_PREFIX_HOME."esf_pic");
            }
        }
    }
    
    /**
    +----------------------------------------------------------
    * 保存图片附件内容2  使用SESSION
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param integer $esfId    二手房ID
    * @param array   $arrFile  文件
    +----------------------------------------------------------
    * @return array 返回添加附件的ID数组
    +----------------------------------------------------------
    */
    public function addEsfAttach2($esfId,$reside, $arrFile){
        if(!empty($arrFile)&&is_array($arrFile)){

            foreach($arrFile as $arrInfo){
                // 加附件
                $this->pdo->add(array(
                    "name"=>$arrInfo['name'], 
                    "url"=>$arrInfo['url'], 
                    "type"=>$arrInfo['type'], 
                    "size"=>$arrInfo['size'], 
                    "checksum"=>$arrInfo['checksum'],
                    "update_at"=>$this->now), DB_PREFIX_HOME."esf_attach");

                // 加附件与文件关联
                $this->pdo->add(array("esf_id"=>$esfId, "code"=>$arrInfo['pic_type'], "title"=>$reside, "description"=>0, "is_default"=>0, "attach_id"=>$this->pdo->getLastInsID()), DB_PREFIX_HOME."esf_pic");
            }
            return true;
        }else return false;
    }

    /**
    +----------------------------------------------------------
    * 根据二手房ID查询所有相关图片信息
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */
    public function getAttachIDByEsfID($esfId){
        $where = "esf_id={$esfId}";

        $fileds = "attach_id";

        $arrEsf = $this->pdo->find(DB_PREFIX_HOME."esf_pic", $where, $fileds);
        return $arrEsf;
    }

    /**
    +----------------------------------------------------------
    * 根据附件号查询路径
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $attachId  附件号
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */    
    public function getEsfPicByatId($attachId) {
		$sql = "SELECT 
		   id, url
		 FROM
		   %s
		 WHERE 
		   id = %d";
		$sql = sprintf($sql, DB_PREFIX_HOME."esf_attach", $attachId);
		return $this->pdo->getRow($sql);
    }



    /**
    +----------------------------------------------------------
    * 删除图片数据
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $atId  附件ID
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */    
    public function delEsfPic($atId) {
             $this->pdo->remove("id={$atId}", DB_PREFIX_HOME."esf_attach");
             $this->pdo->remove("attach_id={$atId}", DB_PREFIX_HOME."esf_pic");
            return "删除成功!";
    }

    
    /**
    +----------------------------------------------------------
    * 根据二手房ID查询附件
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $attachId  附件号
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */    
    public function getAttachByEsfId($esfId) {
		$sql = "SELECT 
		   a.id, a.url, e.esf_id
		 FROM
		   %s
		 WHERE 
		   e.esf_id = %d and a.id = e.attach_id";
        
		$sql = sprintf($sql, DB_PREFIX_HOME."esf_attach a, " .DB_PREFIX_HOME."esf_pic e", $esfId);

		return $this->pdo->getAll($sql);
    }


    /**
    +----------------------------------------------------------
    * 根据二手房ID查询附件
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $attachId  附件号
    +----------------------------------------------------------
    * 返回最后ID号
    +----------------------------------------------------------
    */    
    public function countEsfAttach($esfId) {

		 $where= "e.esf_id = {$esfId} and a.id = e.attach_id";
        
		//$sql = sprintf($sql, DB_PREFIX_HOME."attach a, " .DB_PREFIX_HOME."esf_pic e", $esfId);

        $iLen = $this->pdo->countAll(DB_PREFIX_HOME."esf_attach a, " .DB_PREFIX_HOME."esf_pic e", $where, 'a.id');

        return $iLen;

    }

    /**
    +----------------------------------------------------------
    * 添加二手房求租、求购信息
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $flag     二手房状态 [0:已删除 1:有效]
    * @param  $house_type 房屋类别[1:出租 2:出售]
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */

    public function  addEsfRequire($post){

        $type = $_POST['catid'];
        $user_id = $_SESSION['userId'];
        $company_id = $_SESSION['companyId'];
        $create_at = $_SERVER['REQUEST_TIME']; 
        $create_ip = $_SERVER['REMOTE_ADDR'];
        $editor_id = $_SESSION['userId'];
        $edit_at = $_SERVER['REQUEST_TIME']; 
        $edit_ip = $_SERVER['REMOTE_ADDR'];
        $hits = 0;
        $title = $_POST['title'];
        $price_show = $_POST['pdisp'];
        $price_unit = $_POST['punit'];
        if($price_unit == '万'){
            $price = 10000*$price_show;
        }
        else if($price_unit == '元')
        {
            $price = $price_show;
        }
        $term = 0;
        $linkman = $_POST['linkman'];
        $link_tel = $_POST['linktel'];
        $link_im = $_POST['linkim'];
        $link_email = $_POST['linkemail'];
        $content = $_POST['content'];
        $is_remove = 0;
        $remove_at = 0;
                
        $arrCom = array(
            
                'type' => $type,
                'user_id' => $user_id,
                'company_id' => $company_id,
                'create_at' => $create_at,
                'create_ip' => $create_ip,
                'editor_id' => $editor_id,
                'edit_at' => $edit_at,
                'edit_ip' => $edit_ip,
                'hits' => $hits,
                'title' => $title,
                'price_show' => $price_show,
                'price_unit' => $price_unit,
                'price' => $price,
                'term' => $term,
                'linkman' => $linkman,
                'link_tel' => $link_tel,
                'link_im' => $link_im,
                'link_email' => $link_email,
                'content' => $content,
                'is_remove' => $is_remove,
                'remove_at' => $remove_at,            
        );
        
        $this->pdo->add($arrCom, DB_PREFIX_HOME."esf_require");

        return $this->pdo->getLastInsID();   //返回最后ID号

    }

    /**
    +----------------------------------------------------------
    * 查询所有求租求购信息
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $is_remove  有效标志 [0:有效 1:无效]
    * @param  $page  当前页 
    * @param  $row   每页显示数
    * @param  $str   查询串
    * @param  $where  补充条件
    +----------------------------------------------------------
    * @return arrEsf
    +----------------------------------------------------------
    */
    public function getAllEsfReq($is_remove=0, $page=0, $row=10, $str="" ,  $where=""){
        $start = $page * $row;
        $where .= empty($str) ? "" : " AND title like '%". $str ."%'";
        $where = "is_remove={$is_remove}".$where;

        if($_SESSION['companyId'] > SYSTEM_ADMIN_COMPANY_ID and $_SESSION['isAdmin'])
        {
              $where  = "{$where} AND company_id={$_SESSION['companyId']} ";
        }
        elseif ($_SESSION['companyId'] != SYSTEM_ADMIN_COMPANY_ID )
        {
            $where = " {$where} AND user_id={$_SESSION['userId']} ";
        }

        $fileds = "id, title, type, price_show, price_unit, linkman, edit_at";

        $arrEsf = $this->pdo->find(DB_PREFIX_HOME."esf_require", $where, $fileds, "edit_at desc", "{$start}, {$row}");
        return $arrEsf;
    }

    /**
    +----------------------------------------------------------
    * 统计所有求租求购信息
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $is_remove  有效标志 [0:有效 1:无效]
    * @param  $str   查询串
    +----------------------------------------------------------
    * @return iLen
    +----------------------------------------------------------
    */
    public function getCoumtAllEsfReq($is_remove=0, $str="", $where=""){
        $where .= empty($str) ? "" : " AND title like '%". $str ."%'";
        $where = "is_remove={$is_remove}".$where;
        $iLen = $this->pdo->countAll(DB_PREFIX_HOME."esf_require", $where);
        return $iLen;
    }

    /**
    +----------------------------------------------------------
    * 根据ID查询求租求购详情
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $reqId  求租求购ID
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */    
    public function getEsfReqById($reqId) {
		$sql = "SELECT 
		   *
		 FROM
		   %s
		 WHERE 
		   id = %d";
		$sql = sprintf($sql, DB_PREFIX_HOME."esf_require", $reqId);
		return $this->pdo->getRow($sql);
    }

    /**
    +----------------------------------------------------------
    * 删除求租求购数据（设为无效）
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param array $post    表单数据
    +----------------------------------------------------------
    */
    public function RemoveEsfReq($reqId){
        
        $is_remove = 1;
        $remove_at = $_SERVER['REQUEST_TIME']; 
        $editor_id = $_SESSION['userId'];
        $edit_at = $_SERVER['REQUEST_TIME']; 
        $edit_ip = $_SERVER['REMOTE_ADDR'];
        //二手房出租相关信息
        $arrEr = array(
            
                'editor_id' => $editor_id,
                'edit_at' => $edit_at,
                'edit_ip' => $edit_ip,
                'is_remove' => $is_remove,
                'remove_at' => $remove_at                     
        );

        if(!empty($reqId)) { //修改
           $this->pdo->update($arrEr, DB_PREFIX_HOME."esf_require", "id=".$reqId);   // update
        }

        return true;
  }

    /**
    +----------------------------------------------------------
    * 修改求租求购数据
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param array $post    表单数据
    //* @param array $arrFile 文件
    +----------------------------------------------------------
    //* @return boolean 新增成功与否
    +----------------------------------------------------------
    */
    public function UpdateEsfReq($post){   
        $reqId = $_POST['hidReqId'];
        $type = $_POST['catid'];
        $user_id = $_SESSION['userId'];
        $editor_id = $_SESSION['userId'];
        $edit_at = $_SERVER['REQUEST_TIME']; 
        $edit_ip = $_SERVER['REMOTE_ADDR'];
        $title = $_POST['title'];
        $price_show = $_POST['pdisp'];
        $price_unit = $_POST['punit'];
        if($price_unit == '万'){
            $price = 10000*$price_show;
        }
        else if($price_unit == '元')
        {
            $price = $price_show;
        }
        $linkman = $_POST['linkman'];
        $link_tel = $_POST['linktel'];
        $link_im = $_POST['linkim'];
        $link_email = $_POST['linkemail'];
        $content = $_POST['content'];
        $is_remove = $_POST['is_remove'];
        if($is_remove==1){
        $remove_at = $_SERVER['REQUEST_TIME'];
        }
        else{
        $remove_at = 0;
        }


        //二手房出租相关信息
        $arrEr = array(
            
                'type' => $type,
                'user_id' => $user_id,
                'editor_id' => $editor_id,
                'edit_at' => $edit_at,
                'edit_ip' => $edit_ip,
                'title' => $title,
                'price_show' => $price_show,
                'price_unit' => $price_unit,
                'price' => $price,
                'linkman' => $linkman,
                'link_tel' => $link_tel,
                'link_im' => $link_im,
                'link_email' => $link_email,
                'content' => $content,
                'is_remove' => $is_remove,
                'remove_at' => $remove_at,                    
        );

        if(!empty($reqId)) { //修改
           $this->pdo->update($arrEr, DB_PREFIX_HOME."esf_require", "id=".$reqId);
           // update
        }

        return true;
  }

      /**
    +----------------------------------------------------------
    * 根据userID查询用户信息
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @param  $userId  用户ID
    +----------------------------------------------------------
    * @return array
    +----------------------------------------------------------
    */    
    public function getUserById($userId) {
		$sql = "SELECT 
		   *
		 FROM
		   %s
		 WHERE 
		   uid = %d";
		$sql = sprintf($sql, DB_PREFIX_HOME."user", $userId);
		return $this->pdo->getRow($sql);
    }

    /**
    +----------------------------------------------------------
    * 统计所有个人会员二手房发布数量
    +----------------------------------------------------------
    * @access public 
    +----------------------------------------------------------
    * @return int
    +----------------------------------------------------------
    */
    public function getCoumtUserEsf($telphone, $housetype){
        $where = "telphone='{$telphone}' AND house_type='{$housetype}' AND flag=1";

        $iLen = $this->pdo->countAll(DB_PREFIX_HOME."esf", $where);
        return $iLen;
    }

	/**
	* 统计房源对应的图片数量
	*/
	public function countHouseImages($esfid)
	{
		return $this->pdo->execute("update `".DB_PREFIX_HOME."esf` e set e.images = (select count(id) as num From `".DB_PREFIX_HOME."esf_pic` p Where p.esf_id = e.id) where 1 and e.id = '{$esfid}'");
	}

	/*
	* 设置超时一个月的房源
	*/
	public function setValidTimeout($t = 2592000)
	{
		if((int)$t <=0 ) $t = 2592000;

		$time = time() - $t;
		$sql = "
			Update `".DB_PREFIX_HOME."esf` 
			Set valid_at=0, is_top = 0 
			Where 1 and valid_at <='{$time}'
		";
		$this->pdo->execute($sql);
	}

	/*
	* 提取最新的X条验证房源
	*/
	public function getLatestValid($nums = 10)
	{
		if((int)$nums <=0 ) $nums = 10;

		$sql = "
			Select 
				e.id as esfid, e.parlor, e.room, e.toilet, e.total_area,e.price
			From 
				`".DB_PREFIX_HOME."esf` e 
			Where 1 
				and e.valid_at > 0 and e.flag=1
			Order By valid_at desc, updated_at desc
			Limit 0,{$nums} 
		";

		return $this->pdo->getAll($sql);
	}

	/* 浏览二手房 */
	public function getLatestResold(&$aPara)
	{
		$aPara['start'] = '0';
		$aPara['nums']	= '1';

		#$this->_browse($aPara, $where, $order, $rent, $count, $page, $image, group);
		return $this->_browse($aPara, 
			" and e.house_type = '2' and e.flag=1 ", 
			"e.is_top desc, e.is_payed desc, e.updated_at desc " , false, false, false, false, false);
	}


	/* 浏览出租房 */
	public function getLatestRent(&$aPara)
	{
		$aPara['start'] = '0';
		$aPara['nums']	= '40';

		return $this->_browse($aPara, 
			" and e.is_recommend != 1 and e.is_payed = 1  and e.house_type = '1' and e.flag=1 ", 
			" e.is_payed desc, e.edit_at desc " , false, false, false, false, false);
	}

	/* 浏览精品二手房 */
	public function getExtractResold(&$aPara)
	{
		$aPara['start'] = '0';
		$aPara['nums']	= '40';

		return $this->_browse($aPara,
			" and e.is_recommend = 1   and e.house_type = '2' and m.is_payed=1  and m.company_id > 0 ",
			" e.edit_at desc " , false, false, false, true, true);
	}

	/* 浏览精品出租房 */
	public function getExtractRent(&$aPara)
	{
		$aPara['start'] = '0';
		$aPara['nums']	= '40';
		# 有图, 非系统, 出租; 付费, 验证, 更新
		return $this->_browse($aPara, 
			" and e.images >0 and e.company_id <> 0  and e.house_type = '1' and e.is_payed =1  and e.flag=1 ", 
			" e.updated_at desc ", false, false, false, true, true);
	}

	/*
	* @param house_order默认为更新时间
	* @parma isRent		默认取二手房
	* @parma getImaes	默认不取图
	*/
	private function _browse(&$aPara, 
				$houseWhere	= "", 
				$houseOrder	= " updated_at desc ", 
				$isRent		= false,
				$isCount	= false,
				$isPage		= false,
				$getImages	= false,
				$group	= 0)
	{
		$house = $_house = array();

		$houseTable	= DB_PREFIX_HOME . "esf e ";
		$houseFields= "
			e.id as esfid, e.reside, e.house_type, e.parlor, e.room, e.toilet, e.company_id, e.total_area,
			e.price, e.address, e.current_floor, e.create_at, e.valid_keepno, e.valid_area, e.selling_point, e.images, is_top, 
			e.valid_at, e.valid_owner, e.valid_addr, e.valid_year, e.valid_seal, e.valid_debt,e.company_id ,e.updated_at,
			m.user_type, c.name_cn,u.user_name";

		if($isRent)
		{
			//$houseTable	.= " Inner Join ".DB_PREFIX_HOME."esf_rent er ON er.esf_id = e.id  ";
			$houseFields.= ",er.rent_way, er.time_limit, er.pay_way, er.deposit, er.fees ";
		}

		$sql = "
			Select %s 
			From %s 
				Left Join " . DB_PREFIX_HOME . "company c on c.id=e.company_id 
				Left Join " . DB_PREFIX_HOME . "member m on m.user_id=e.user_id 
				Left Join " . DB_PREFIX_HOME . "user u on m.user_id=u.user_id 
			Where 1 %s 
			Order By %s";
		$sql = sprintf($sql, $houseFields, $houseTable, $houseWhere, $houseOrder) . " Limit {$aPara['start']}, {$aPara['nums']}";
		$house	= $this->pdo->getAll($sql);

		//echo $this->pdo->getLastSql() . "<br />";
		
		$this->total = 0;
		if($isPage) $this->total = $this->pdo->countAll($sql, " e.id ", $houseTable, $houseWhere, $houseOrder);

		# 如果要提取图片
		if($getImages && !empty($house))
		{
			for ($i=0, $m=sizeof($house); $i<$m; $i++)
			{
				$url= array("url"=>"");
				$sql = "
					Select 
						a.url 
					From 
						`".DB_PREFIX_HOME."esf_pic` p
							Left Join `".DB_PREFIX_HOME."esf_attach` a On p.attach_id = a.id
					Where 
						p.esf_id = '{$house[$i]['esfid']}'
					Order By 
						a.id
						";
				$url		= $this->pdo->getRow($sql);
				$house[$i]['url']	= $url['url'];
				if($group) $_house[floor($i/4)][] = $house[$i];
			}

			if($group) $house = $_house;
		}

		return $house;
	}
	
	/**
	+----------------------------------------------------------
	* 更新一张图片设为默认图
	+----------------------------------------------------------
	* @access public 
	+----------------------------------------------------------
	* @param 
	+----------------------------------------------------------
	* @return 
	+----------------------------------------------------------
	*/
	public function toDeImg($eid,$uid=0,$username=0)
	{
		$sql="SELECT home_esf_attach.url,home_esf_attach.id,home_esf_pic.esf_id FROM home_esf_attach
						Inner Join home_esf_pic ON home_esf_attach.id = home_esf_pic.attach_id WHERE home_esf_pic.esf_id =  '$eid' limit 1 ";
		$result = $this->pdo->getRow($sql);
		return $this->pdo->execute("UPDATE `home_esf` SET `image_path`='".$result['url']."'  WHERE (`id`='$eid')");	//默认图片
		
	}
}
?>