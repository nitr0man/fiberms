<?php
function ShowMessage($message,$error) {
	global $smarty;
	if ($error == 1) {
		$result = '<font color="red"><u>Ошибка</u>: <b>'.$message.'</b></font>';
	} else {
		$result = $message;
	}
	$smarty->assign("message",$result);
	$smarty->display("message.tpl");
	die();
}
?>