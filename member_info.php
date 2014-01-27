<?php
/**
* 会员信息修改
* @Created 2010-6-21上午09:09:33
* @name member_info.php
* @author 304260440@qq.com
* @version 1.0
* ChengDu CandorSoft Co., Ltd.
* @version $Id: member_info.php,v 1.1 2012/02/07 09:02:32 gfl Exp $
*/
	session_start();
	require_once('./member_config.php');
	check_login();
	$smarty = new WebSmarty();
	$smarty->caching = false;
	$pdo=new MysqlPdo();
	$user_type = $_SESSION['home_usertype'];
	$user_name = uname;
	$smarty->assign('user_name',uname);
	$smarty->assign('user_type',utype);
	
	switch(isset($_GET['action'])?$_GET['action']:'index')
	{
	case 'index':index(); //首页页面
		exit;
	case 'edit_info':edit_info();//信息修改
		exit();	
	case 'edit_pwd': edit_pwd();//密码修改
		exit();
	case 'save': save(); //信息保存
		exit();
	default:index();
		exit;
	}
	
	function index()
	{
		ShowMsg("参数错误!..",'javascript:history.back(-1)',0,3000);
		exit();
	}
	
	/**
	    * 
	    * 修改修改
	    * function edit_info
	    * @access public 
	    * @param 
	    */
	function edit_info()
	{
		global $pdo,$smarty,$member,$user_name,$user_type;
		extract($_GET);
		$res = $pdo->getRow("select * from home_user where username like '$user_name'");
		
		$smarty->assign('res',$res);
		if ($do=='info') //信息修改
		{
			//if ($user_type=='个人')
			  $tpl = "member/p_editinfo.tpl";
			//else
			//  $tpl = "member/p_editcompany.tpl" ;
			 
			$smarty->assign('seoTitle','修改个人资料-和睦家');
		}
		elseif ($do=='pwd') //密码修改
		{
			$tpl = "member/p_editpwd.tpl";
			$smarty->assign('seoTitle','修改密码-和睦家');
		}
		elseif ($do=='card_cert') //身份认证
		{
			if ($user_type=='个人')
				{
					//ShowMsg("个人用户无此功能!3秒后将自动返回..",'javascript:history.back(-1)',0,3000);
					//exit();
				}
			$tpl = "member/p_editcert.tpl";
		}
		elseif ($do=='prc_cert') //执业认证
		{
			if ($user_type=='个人')
				{
					//ShowMsg("个人用户无此功能!3秒后将自动返回..",'javascript:history.back(-1)',0,3000);
					//exit();
				}
			$tpl='member/p_editprccert.tpl';
		}
		else 
		{
			ShowMsg("参数错误!..",'javascript:history.back(-1)',0,3000);
			exit();
		}
		$smarty->show($tpl);
	}
	
	function save()
	{
		global $pdo,$user_name,$user_type,$member;
		 
		extract($_POST);
		$user_type="个人";
		if($user_type!="个人"){
			$Error = $_FILES['file1']['error']; //处理上传图片
			switch ($Error)
			{
				case 1:
					ShowMsg("上传图片超过了系统限制大小",-1);
					exit();
				case 2:
					ShowMsg("上传图片超过了系统限大小",-1);
					exit();
				case 3:
					ShowMsg("图片未上传完毕",-1);
					exit();
				case 4:
					ShowMsg("上传图片失败",-1);
					exit();
			}
			if ($_FILES['file1']['size']>200000)
			{
				ShowMsg("图片最大只允许200K以内",-1);
				exit();
			}
			$pt = strpos($_FILES['file1']['name'],'.');
			$file_post =substr($_FILES['file1']['name'],$pt+1);
			if ($file_post!='gif' && $file_post!='jpg' )
			{
				ShowMsg("图片只能为GIF或JPG格式",-1);
				exit();
			}
		}
		if ($do=='edit_info') //信息修改
		{
			if ($user_type=='个人')
			{
				$telephone = trim($telephone);
				if (empty($telephone))
				{
					ShowMsg("联系电话不能为空!请重新填写..",'javascript:history.back(-1)',0,3000);
					exit();
				}	
				preg_match("/\b0?(13\d{9})|(15[89]\d{8})\b/",$telephone,$test_tel1);//手机号码验证
				preg_match("/\b(0\d{2,3}(?<char>[- ]?)) ?\d{7,8}(\k<char>\d{4})?\b/",$telephone,$test_tel2);//固定号码验证
				if (Count($test_tel1)<1 && Count($test_tel2)<1)
				{
					ShowMsg("联系电话格式错误!请重新填写..",'javascript:history.back(-1)',0,3000);
					exit();
				}
				if (!ereg("(.*)@(.*)\.(.*)",$email) || empty($email))
				{
					ShowMsg("邮箱格式错误!请重新填写..",'javascript:history.back(-1)',0,3000);
					exit();
				}
				
				$sql =  "UPDATE `home_user` SET `telephone`='$telephone', `email`='$email' WHERE (`username`='$user_name')";
				if ($pdo->execute($sql))
				{
					ShowMsg("成功修改个人信息资料..",'javascript:history.back(-1)',0,3000);
					exit();
				}
			} //个人
			elseif ($user_type=='独立经纪人')
			{
				//@todo
				extract($_POST);
				$name = strip_tags($_POST['name']);
				$company_name = strip_tags($_POST['company_name']);
				if (!ereg("(.*)@(.*)\.(.*)",$email) || empty($email))
				{
					ShowMsg("邮箱格式错误!请重新填写..",'javascript:history.back(-1)',0,3000);
					exit();
				}
				$user_name=uname;
			
				if ($_FILES['file1']['name']) //头像上传
				{
					
					$up = new UploadFile($_FILES['file1']);
		            $iCount = $up->upload();
		            $aInfo = $up->getSaveInfo();
		            $ps = ",`photo_url`='".$aInfo[0]['url']."'";
		            
				}
			
				$sql = "UPDATE `home_user` SET `name`='$name',`company_name`='$company_name',`email`='$email',`qq`='$qq' $ps WHERE (`username`='$user_name')";
				if ($pdo->execute($sql))
				{
						ShowMsg("成功修改个人信息资料..",'javascript:history.back(-1)',0,3000);
						exit();
				}
				else
				{
						ShowMsg("上传图片失败!..",'javascript:history.back(-1)',0,3000);
						exit();
				}
			}
			
		}
		elseif ($do=='edit_pwd') //修改密码
		{
			foreach ($_POST as $k=>$v)
			{
				if (empty($v))
				{
					ShowMsg("请将信息填写完整..",'javascript:history.back(-1)',0,3000);
					exit();
				}
			}
			$pwd = ereg_replace("[^0-9a-zA-Z]","",$pwd);//原密码
			$m_info = $pdo->getRow("select username,password from home_user where username='$user_name'");
			if (md5($pwd.$member->key)!=$m_info['password'])
			{
				ShowMsg("原密码错误!请重新填写!..",'javascript:history.back(-1)',0,3000);
				exit();
			}
			if (!ereg("[0-9a-zA-Z]",$n_pwd) || !ereg("[0-9a-zA-Z]",$n_tpwd))
			{
				ShowMsg("新密码只能为数字.字母!请重新填写!..",'javascript:history.back(-1)',0,3000);
				exit();
			}
			if ($n_pwd!=$n_tpwd)
			{
				ShowMsg("密码不相同!请重新填写!..",'javascript:history.back(-1)',0,3000);
				exit();
			}
			$password = md5($n_pwd.$member->key);
			$sql = "UPDATE `home_user` SET `password`='$password' WHERE (`username`='$user_name')";
			if ($pdo->execute($sql)) //修改成功 重新登录系统
			{
				$member->ExitLogin();
				ShowMsg("密码修改成功!3秒后将自动跳转..",'login.php',0,3000);
				exit();
			}
			else 
			{
				ShowMsg("密码修改失败!3秒后将自动跳转..",'javascript:history.back(-1)',0,3000);
				exit();
			}
		}
		elseif($do=='edit_cert')
		{
			
			$card_num=preg_replace("/[^a-zA-Z0-9]/","",$card_num)	;
			 if(!eregi("^[1-9]([0-9a-zA-Z]{17}|[0-9a-zA-Z]{14})$",$card_num))
			 {
			  		ShowMsg("身份证格式错误!3秒后将自动跳转..",'javascript:history.back(-1)',0,3000);
					exit();
			 }
			 if (strlen($card_num)!=18 && strlen($card_num)!=15) 
			 {
			 	ShowMsg("身份证长度错误!3秒后将自动跳转..",'javascript:history.back(-1)',0,3000);
					exit();
			 }
			
			if ($_FILES['file1']['name']) //头像上传
			{
				$up = new UploadFile($_FILES['file1']);
	            $iCount = $up->upload();
	            $aInfo = $up->getSaveInfo();
	            $ps = ",`cert_url`='".$aInfo[0]['url']."'";
	            
			}
		
			$sql = "UPDATE `home_user` SET `card_num`='$card_num' $ps WHERE (`username`='$user_name')";
			if ($pdo->execute($sql))
				{
					ShowMsg("成功上传身份认证,请等待审核..",'javascript:history.back(-1)',0,3000);
					exit();
				}
				else
				{
					ShowMsg("资料未修改,请修改后提交..",'javascript:history.back(-1)',0,3000);
					exit();
				}
		}
		elseif($do=='edit_prc') //执业认证
		{

			if ($_FILES['file1']['name']) //头像上传
			{
				$up = new UploadFile($_FILES['file1']);
	            $iCount = $up->upload();
	            $aInfo = $up->getSaveInfo();
	            $ps = ",`prc_url`='".$aInfo[0]['url']."'";
	            
			}
			$prc_name = addslashes(strip_tags($prc_name));
			$sql = "UPDATE `home_user` SET `prc_name`='$prc_name' $ps WHERE (`username`='$user_name')";
			if ($pdo->execute($sql))
				{
					ShowMsg("成功上传执业认证,请等待审核..",'javascript:history.back(-1)',0,3000);
					exit();
				}
				else
				{
					ShowMsg("资料未修改,请修改后提交..",'javascript:history.back(-1)',0,3000);
					exit();
				}
		}
		
	}
	
?>