<?php
require_once("auth.php");
require_once("smarty.php");
require_once("/func/FiberSplice.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {		
	if ($_POST['mode'] == 1) {
		$id = $_POST['id'];
		$marking = $_POST['marking'];
		$manufacturer = $_POST['manufacturer'];
		$note = $_POST['note'];
		$res = FSOT_Mod($id,$marking,$manufacturer,$note);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=NetworkNodes.php");
	        $message = 'FSOT изменен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 2) {
		$marking = $_POST['marking'];
		$manufacturer = $_POST['manufacturer'];
		$note = $_POST['note'];
		$res = FSOT_Add($marking,$manufacturer,$note);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=NetworkNodes.php");
	        $message = 'FSOT добавлен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	ShowMessage($message,$error);
} else {
    if (!isset($_GET['mode'])) {
		$TypeId = $_GET['typeid'];
		$res = GetFSOTsInfo($_GET['sort']);

		$rows = $res['FSOTs']['rows'];
	  	$i = -1;
	  	while (++$i < $res['FSOTs']['count']) {	  		$cableline_arr[] = $rows[$i]['id'];
	  		$cableline_arr[] = $rows[$i]['marking'];
			$cableline_arr[] = $rows[$i]['manufacturer'];
			$cableline_arr[] = $rows[$i]['note'];
			$cableline_arr[] = $rows[$i]['FSOCount'];
			$cableline_arr[] = '<a href="FSOT.php?mode=change&fsotid='.$rows[$i]['id'].'">Изменить</a>';
			if ($rows[$i]['FSOCount'] == 0) {
				$cableline_arr[] = '<a href="FSOT.php?mode=delete&fsotid='.$rows[$i]['id'].'">Удалить</a>';
			} else {				$cableline_arr[] = ' ';
			}
	  	}
		$smarty->assign("data",$cableline_arr);
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['fsotid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			ShowMessage($message,0);
		}
    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['fsotid'];
    	$res = FSOT_SELECT('',$wr);
    	if ($res['count'] < 1) {
			$message = 'FSOT с таким ID не существует!<br />
						<a href="FSOT.php">Назад</a>';
			ShowMessage($message,0);
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("marking",$rows[0]['marking']);
		$smarty->assign("manufacturer",$rows[0]['manufacturer']);
		$smarty->assign("note",$rows[0]['note']);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			ShowMessage($message,0);
		}
		$smarty->assign("mode","add");
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['fsotid']))) {
		if ($_SESSION['class'] > 1)	{			$message = '!!!';
			ShowMessage($message,0);
		}		$wr['id'] = $_GET['fsotid'];
		FSOT_DELETE($wr);
    	header("Refresh: 2; url=FSOT.php");
		$message = "FSOT удален!";
		ShowMessage($message,0);
 	}

	$smarty->display('FSOT.tpl');
}
?>
