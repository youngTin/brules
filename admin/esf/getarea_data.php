<?
	$code_id = isset($_GET['code'])?$_GET['code']:exit;
	require_once('../../sys_load.php');
	$code = new BaseCode();
	$Data = $code->getPidByType($code_id);
	echo json_encode($Data);
	exit;
?>