<?php
require_once("BasePage.class.php");

class Resold extends BasePage
{
	public function __construct()
	{
		parent::__construct();
	}

	# 取得一条房源
	public function getOneById($rId) {
		$sql = "SELECT * FROM %s WHERE id = %d";
		$sql = sprintf($sql, DB_PREFIX_HOME."esf", $rId);

		$arr = $this->pdo->getRow($sql);
		$arr['facilities_item'] = explode(":", $arr['facilities']);
		//$this->pdo->getLastSQL();
		return $arr;
	}

	# 保存或更新
	public function saveOrUpdate($params)
	{
		//$arr = $this->getIssueValue();
		$arr = $_POST;
		$arr['house_type'] = $params['house_type'];
		if(!isset($arr["updated_at"]) || $arr["updated_at"]=="" ){
			$arr["updated_at"]=$this->now;
		}
		if(isset($_POST['facilities'])) {
			$arr['facilities'] = implode(":", $arr['facilities']);
		}
		if(!isset($params['rId']) || $params['rId'] <= 0 ){
			$_arr = array(
				"user_id"	=> $_SESSION['userId'],
				"user_name"	=> $_SESSION['userName'],
				"name_cn"	=> isset($_SESSION['companyFullName'])?$_SESSION['companyFullName']:'',
				"publish_ip"=> $_SERVER['REMOTE_ADDR'],
				"create_at"	=> $this->now,
				"editer"	=> $_SESSION['userId'],
				"edit_ip"	=> $_SERVER['REMOTE_ADDR'],
				"updated_at"=> time($arr["updated_at"]),
				"edit_at"=> $this->now,
				"voucher"	=> $this->now,
				"voucher"	=> $_SESSION['userId'],
				"vouch_ip"	=> $_SERVER['REMOTE_ADDR'],
				"is_payed" => isset($params["is_payed"])?$params["is_payed"]:0
				);
			
			$arr = array_merge($arr, $_arr);
			# 添加
			$arr['create_at'] = $this->now;
			
			$this->pdo->add($arr, DB_PREFIX_HOME . "esf");
			//echo $this->pdo->getLastSQL();exit;
			$rId = $this->pdo->getLastInsID();
		}else{
			$_arr = array(
				"editer"	=> $_SESSION['userId'],
				"edit_ip"	=> $_SERVER['REMOTE_ADDR'],
				"edit_at"=> $this->now,
				"updated_at"=> time($arr["updated_at"]),
				"is_payed" => isset($params["is_payed"])?$params["is_payed"]:0,
				"flag"=>isset($arr["flag"])?$arr["flag"]:1,
				);
			$arr = array_merge($arr, $_arr);
			$rId	= $params['rId'];
			$this->pdo->update($arr, DB_PREFIX_HOME . "esf", "id='{$rId}'");
			
		}
		return $rId;
	}

	# 为楼盘添加附件
	public function appendAttach($rId)
	{
		if(!isset($_FILES['file1'])) return;
		$up		= new UploadFile($_FILES['file1']);
		$iCnt	= $up->upload();
		$aInf	= $up->getSaveInfo();

		for($i=0; $i<$iCnt; $i++)
		{
			$arr = $aInf[$i];

			#写到附件表
			$this->pdo->add(
				array(
					"name"=>$arr['name'],
					"url"=>$arr['url'], 
					"type"=>$arr['type'],
					"size"=>$arr['size'], 
					"checksum"=>$arr['checksum'],
					"update_at"=>$this->now), DB_PREFIX_HOME."esf_attach");

			#加附件与文件关联
			$this->pdo->add(
				array(
				"esf_id"=>$rId, 
				"code"=>0, 
				"title"=>'', 
				"description"=>'', 
				"title"=>'',
				"is_default"=>1, 
				"attach_id"=>$this->pdo->getLastInsID()), DB_PREFIX_HOME."esf_pic");
		}
	}

	# 删除图片
	public function removePic($aId) 
	{
		$arrAttach = $this->getOneAttachById($aId);
		$this->pdo->remove("id={$aId}", DB_PREFIX_HOME."esf_attach");
		$this->pdo->remove("attach_id={$aId}", DB_PREFIX_HOME."esf_pic");
		if(trim($arrAttach['url'])) 
		{
			$attach = realpath(WEB_ROOT . $arrAttach['url']);
			
			@unlink($attach);
			@unlink(str_replace(".", "_s.", $attach));
			@unlink(str_replace(".", "_m.", $attach));
		}

		return 1;
	}

	# 删除一个附件
	public function getAttachesById($rId)
	{
		$sql = "
			Select a.* 
			From " . DB_PREFIX_HOME . "esf_pic p Left Join " . DB_PREFIX_HOME . "esf_attach a On p.attach_id = a.id
			Where 1 and p.esf_id = '{$rId}'
			";
		return $this->pdo->getAll($sql);
	}

	#取得一个附件信息
	public function getOneAttachById($aId)
	{
		$sql = "Select  * From %s Where id = %d";
		$sql = sprintf($sql, DB_PREFIX_HOME."esf_attach", $aId);
		return $this->pdo->getRow($sql);
	}

	# 取得一条用户信息
	public function getUserById($userId) {
		$sql = "SELECT * FROM %s WHERE user_id = %d";
		$sql = sprintf($sql,"home_user", $userId);
		return $this->pdo->getRow($sql);
	}

	# 统计房源对应的图片数量
	public function countImages($esfid)
	{
		$sql = "
			Update `".DB_PREFIX_HOME."esf` e 
			Set e.images = (
				Select count(id) as num 
				From `".DB_PREFIX_HOME."esf_pic` p 
				Where p.esf_id = e.id) 
			Where 1 and e.id = '{$esfid}'";

		return $this->pdo->execute($sql);
	}

	# 添加记忆搜索
	public function appendMemoryWord()
	{
		$sql = "select id from ".DB_PREFIX_HOME."search_remember where value='{$_POST['reside']}'";
		$arr = $this->pdo->getRow($sql);

		if ($arr['id'] == '') {

			$sets = array ('value' => $_POST['reside']);

			return $this->pdo->add($sets,"".DB_PREFIX_HOME."search_remember");
		}

		return 1;
	}

	#  计算房源数量
	public function countNumByTel($telephone, $type)
	{
		$where = "telphone='{$telephone}' AND house_type='{$type}' AND flag=1";
		
		$iLen = $this->pdo->countAll(DB_PREFIX_HOME."esf", $where);
		
		return $iLen;
	}

	# 许可的发布数量
	public function issueNumLimit($type)
	{
		# 个人会员只允许发布3套
		if($_SESSION['userType']==1 && empty($_SESSION['companyId']))
		{
			if($this->countNumByTel($telephone, $type) >= 3)
			{
				redirect("secondHouse_list.php", 2, "只能添加三套二手房!");
			}
		}

		if($_SESSION['userType']==4 && empty($_SESSION['companyId']))
		{
			$sql = "
				Select count(e.id) as cnt 
				From ".DB_PREFIX_HOME."esf as e Left Join ".DB_PREFIX_HOME_LAYOUT."member as m On e.user_id=m.user_id 
				Where m.user_type='4' 
					And e.user_id='{$_SESSION['userId']}' 
					And e.house_type=2 
					And e.flag=1";

			#$count = count($pdo -> getAll($sql));
			$temp = $pdo->getRow($sql);
			
			$allow = $this->getAllowIssueNum($_SESSION['userId']);

			if($count >= $allow['']){
				redirect("secondHouse_list.php", 2, "只能添加{$allow['']}套二手房!");
			}
		}
	}

	# 查询指定用户许可发布的房源数
	public function getAllowIssueNum($user, $type)
	{
		$sql = "
			Select * 
			From `". DB_PREFIX_HOME ."`member 
			Where 1 and user_id='{$user}' ";

		return $this->pdo->getRow($sql);
	}

	# 如果是管理员
	# 只能从剩余条数中选取
	# 如果是成员则直接读取

####-(Private )---------------------------------------------------------------------####
	##    | 
	##    V


	# 提取表单提交的数据
	private function getIssueValue()
	{
		$_sField = "id,reside,property,pright,address,address_hide,total_area,price,current_floor,total_floor,room,parlor,toilet,porch,borough,circle,arch,facilities,company_id,linkman,telphone,file1,custom_id,build_year,direction,area,toward,fitment,selling_point,traffic,description,updated_at,flag";

		$arr	 = array();
		$fields	 = explode(",", $_sField);

		$_POST['id'] = $_POST['rId'];

		for($i=0, $m=sizeof($fields); $i<$m; $i++)
		{
			if($fields[$i] == 'facilities' && isset($_POST['facilities'])) $arr[$fields[$i]] = implode(":", $_POST['facilities']);
			else $arr[$fields[$i]] = $_POST[$fields[$i]];
		}

		$arr['is_subway'] = isset($_POST['is_subway']) ? 1 : 0;

		#print_r($_POST);

		return $arr;
	}

}
?>