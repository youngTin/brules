<?
	require_once('../../sys_load.php');
	$pdo = new MysqlPdo();
	$smarty = new WebSmarty;
	switch(isset($_POST['action'])?$_POST['action']:'') //出售房源
	{
		case '删除选中':delall();
			break;
	    case '重新发布':deleflu(1);
			break;
	}
	switch(isset($_GET['action_secondhouse'])?$_GET['action_secondhouse']:'') //get方式删除二手房
	{
		case 'del_secondhouse':delall(); //删除二手房数据
			break;
	}
	switch(isset($_POST['action_rent'])?$_POST['action_rent']:'') //出租房源
	{
		case '删除选中':delall_rent();
			break;
	    case '重新发布':deleflu(2);
			break;
	}	
	switch(isset($_GET['action'])?$_GET['action']:'')
	{
		case 'del_user_3':del_user_3(); //删除等级3用户
			break;
		case 'del_user_2':del_user_2(); //删除等级2用户
			break;
		case 'deleflu':deleflu();
			break;
	}

	/**
	 * *删除等级三的用户
	 *
	 */
	function del_user_3() 
	{
		global $pdo,$smarty;
		$aPara = formatParameter($_GET['sp'], "out");
		$resold	= new Resold;
		$sql = "select * from home_member where user_id={$aPara['user_id']}"; //获取删除用户信息
		$deluserInfo = $pdo->getRow($sql);
		if($_SESSION['userId'] == $aPara['user_pid']){
			 $del1_sql = "delete from webuser where id = {$aPara['member_id']}"; //删除webuser表
			 $del2_sql = "delete from home_user where user_id = {$aPara['user_id']}"; //删除home_user表
			 $del3_sql = "delete from home_member where user_id = {$aPara['user_id']}"; //删除home_member表
			 $del4_sql = "select home_esf_pic.* from home_esf,home_esf_pic where home_esf.user_id= {$aPara['user_id']} and home_esf_pic.esf_id=home_esf.id";//删除home_esf_pic中用户发布的房源附件
			 $picInfo = $pdo->getAll($del4_sql);
			 foreach($picInfo as $itme){
				$resold->removePic($itme['attach_id']);
			}
			 
			 $del5_sql = "delete home_esf from home_esf where home_esf.user_id= {$aPara['user_id']}";//删除home_esf中用户发布的房源
			 $del6_sql = "update home_member set allow_publish= allow_publish+{$deluserInfo['allow_publish']} where user_id = {$aPara['user_pid']}";
			 $msg = "删除成功!"; 
		}else{
			$sql="select parent_user_id from home_member where user_id = {$aPara['user_pid']}";
			$userInfo = $pdo->getRow($sql);
			if($userInfo['parent_user_id'] == $_SESSION['userId']){
				 $del1_sql = "delete from webuser where id = {$aPara['member_id']}"; //删除webuser表
				 $del2_sql = "delete from home_user where user_id = {$aPara['user_id']}"; //删除home_user表
				 $del3_sql = "delete from home_member where user_id = {$aPara['user_id']}"; //删除home_member表
				$del4_sql = "select home_esf_pic.* from home_esf,home_esf_pic where home_esf.user_id= {$aPara['user_id']} and home_esf_pic.esf_id=home_esf.id";//删除home_esf_pic中用户发布的房源附件
			 	$picInfo = $pdo->getAll($del4_sql);
				foreach($picInfo as $itme){
					$resold->removePic($itme['attach_id']);
				}
				 
				 $del5_sql = "delete home_esf from home_esf where home_esf.user_id= {$aPara['user_id']}";//删除home_esf中用户发布的房源
				 $del6_sql = "update home_member set allow_publish= allow_publish+{$deluserInfo['allow_publish']} where user_id = {$aPara['user_pid']}";
				 $msg = "删除成功!"; 
			}
			else{
				$msg = "删除失败,您无权删除该用户!"; 
				}
			}
			@$pdo->execute($del1_sql);
			@$pdo->execute($del2_sql);
			@$pdo->execute($del3_sql);
			//@$pdo->execute($del4_sql);
			@$pdo->execute($del5_sql);
			@$pdo->execute($del6_sql);
			page_msg($msg,$isok=false,$url=$_SERVER['HTTP_REFERER']);
		}
		/**
		 * 删除分店
		 *
		 */
		function del_user_2()
		{
			global $pdo,$smarty;
			$aPara = formatParameter($_GET['sp'], "out");
			$resold	= new Resold;
			$sql = "select count(*) as cnt from home_member where parent_user_id={$aPara["user_id"]}";//查询该分店下是否还有经纪人存在
			$cnt = $pdo->getRow($sql);
			if($cnt["cnt"]==0 && $_SESSION["userId"]==$aPara["user_pid"]){
				$sql = "select * from home_member where user_id={$aPara['user_id']}"; //获取删除用户信息
				$deluserInfo = $pdo->getRow($sql);
				$del1_sql = "delete from webuser where id = {$aPara['member_id']}"; //删除webuser表
				$del2_sql = "delete from home_user where user_id = {$aPara['user_id']}"; //删除home_user表
				$del3_sql = "delete from home_member where user_id = {$aPara['user_id']}"; //删除home_member表
				$del4_sql = "select home_esf_pic.* from home_esf,home_esf_pic where home_esf.user_id= {$aPara['user_id']} and home_esf_pic.esf_id=home_esf.id";//删除home_esf_pic中用户发布的房源附件
			 	$picInfo = $pdo->getAll($del4_sql);
				foreach($picInfo as $itme){
					$resold->removePic($itme['attach_id']);
				}				
				
				$del5_sql = "delete home_esf from home_esf where home_esf.user_id= {$aPara['user_id']}";//删除home_esf中用户发布的房源
				$del6_sql = "update home_member set allow_publish= allow_publish+{$deluserInfo['allow_publish']} where user_id = {$aPara['user_pid']}";
				//删除店店信息
				$del7_sql = "delete from home_esf_branch where branch_id={$aPara['user_id']}";
				@$pdo->execute($del1_sql);
				@$pdo->execute($del2_sql);
				@$pdo->execute($del3_sql);
				//@$pdo->execute($del4_sql);
				@$pdo->execute($del5_sql);
				@$pdo->execute($del6_sql);
				@$pdo->execute($del7_sql);
				$_SESSION['allow_publish'] = $_SESSION['allow_publish']+$deluserInfo['allow_publish'];
				$msg = "删除成功!"; 
			}
			else $msg = "删除失败!请先删除该店下所以的经济人!"; 
			page_msg($msg,$isok=false,$url=$_SERVER['HTTP_REFERER']);
		}

	
	/**
	 * 执行多项删除
	 */
	function delall()
	{
		global $pdo,$smarty;
		if($_POST)
			$Id = isset($_POST['ids']) ? $_POST['ids'] : array();
		if(isset($_GET['sp'])){
			$aPara = formatParameter($_GET['sp'], "out");
			$Id = array($aPara['id']);
		}
		$count = count($Id);
	
		if($count != 0){
			$sql = "select attach_id from home_esf_pic where esf_id IN (". implode(",", $Id) .")";
			$picInfo = $pdo->getAll($sql);
			$resold	= new Resold;
			foreach($picInfo as $itme){
				$resold->removePic($itme['attach_id']);
			}
		    $query = " DELETE FROM home_esf WHERE `Id` IN (". implode(",", $Id) .")";
			$pdo->execute($query);
			$msg = "删除成功";
		}
		else{ $msg = "删除失败,请勾选要删除的房源"; }
		page_msg($msg,$isok=false,$url=$_SERVER['HTTP_REFERER']);
	}
	
	
	function deleflu($house_type = 1)
	{
		global $pdo,$smarty;;
		
		$Id = isset($_POST['ids']) ? $_POST['ids'] : array();
		$aPara = formatParameter($_GET['sp'], "out");
		if($aPara["id"]) {
			$Id = array($aPara["id"]); 
			$house_type = $aPara["house_type"];
		}
		//查询可用房源数量
		$sql="select allow_publish,is_payed,total_allow_sells,total_allow_time,total_sells_count from home_member where user_id='{$_SESSION['userId']}'";
		$userInfo = $pdo->getRow($sql);
		$allow = $userInfo["total_allow_sells"];
		$today = $userInfo["total_sells_count"];
		$i = count($Id);
		if($i != 0){
			if($i < ($allow-$today)){//如果需发布条数大于可发布条数
				$sql = "update home_esf set updated_at = '".time()."',flag = 1 where id in (". implode(",", $Id) .")";
				$pdo->execute($sql);
				$refreshed_cnt = $i;
				$sy = $allow-$today-$i;
			}
			else{
				for($j=0;$j<$allow-$today;$j++){
				    $sql = "update home_esf set updated_at = '".time()."',flag = 1  where id= {$Id[$j]}";
					$pdo->execute($sql);
				}
				$refreshed_cnt = $allow-$today;
				$sy = 0;
			}
			$sql = "update home_member set total_sells_count = total_sells_count + $refreshed_cnt where user_id= ".$_SESSION["userId"];
			$pdo->execute($sql);
			
			$Total = new Total();
			if($house_type==1)
				$Total->setTotalRefresh($i);
			elseif ($house_type==2)
				$Total->setTotalRentRefresh($i);
			
			//$query = " DELETE FROM home_esf WHERE `Id` IN (". implode(",", $Id) .")";
			//$pdo->execute($query);
			//redirect($_SERVER['HTTP_REFERER'],0,'删除成功，1秒后返回');
			$msg = "刷新成功,共刷新房源 $refreshed_cnt 套,剩余刷新量 $sy 套";
		}
		else{ $msg = "刷新失败,请勾选要刷新的房源"; }
		page_msg($msg,$isok=false,$url=$_SERVER['HTTP_REFERER']);
	}

	/**
	 * 执行多项删除
	 */
	function delall_rent()
	{
		global $pdo,$smarty;
		$Id = isset($_POST['ids']) ? $_POST['ids'] : array();
		$count = count($Id);
		if(count($Id) != 0){
		    $query = " DELETE FROM home_esf WHERE `Id` IN (". implode(",", $Id) .")";
			$pdo->execute($query);
			$query = " DELETE FROM home_esf_rent WHERE `esf_id` IN (". implode(",", $Id) .")";
			$pdo->execute($query);
			//删除附件
			$sql = "select attach_id from home_esf_pic where esf_id IN (". implode(",", $Id) .")";
			$picInfo = $pdo->getAll($sql);
			$resold	= new Resold;
			foreach($picInfo as $itme){
				$resold->removePic($itme['attach_id']);
			}
			
		    $query = " DELETE FROM home_esf WHERE `Id` IN (". implode(",", $Id) .")";
			$pdo->execute($query);
			//redirect($_SERVER['HTTP_REFERER'],0,'删除成功，1秒后返回');
			$query = " DELETE FROM home_esf_pic WHERE `esf_id` IN (". implode(",", $Id) .")";

			$pdo->execute($query);


			$msg = "删除成功";
		}
		else{ $msg = "删除失败,请勾选要删除的房源"; }
		page_msg($msg,$isok=false,$url=$_SERVER['HTTP_REFERER']);
	}
	
	
?>