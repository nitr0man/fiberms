<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/FiberSplice.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {		
	$back = $_POST['back'];
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
			header("Refresh: 3; url=".$back);
	        $message = 'Тип кассеты изменен!';
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
			header("Refresh: 3; url=".$back);
	        $message = 'Тип кассеты добавлен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	showMessage($message,$error);
} else {
    if (!isset($_GET['mode'])) {
		if (isset($_GET['sort'])) {
			$sort = $_GET['sort'];
		} else {
			$sort = 0;
		}
		if (!isset($_GET['page'])) {
			$page = 1;
		} else {
			$page = $_GET['page'];
		}
		$res = getFSOTsInfo($sort,$config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
		$pages = genPages('FSOT.php?sort='.$sort.'&',ceil($res['FSOTs']['allPages']/$config['LinesPerPage']),$page);

		$rows = $res['FSOTs']['rows'];
	  	$i = -1;
	  	while (++$i < $res['FSOTs']['count']) {	  		$cableLine_arr[] = $rows[$i]['id'];
	  		$cableLine_arr[] = $rows[$i]['marking'];
			$cableLine_arr[] = $rows[$i]['manufacturer'];
			$cableLine_arr[] = $rows[$i]['FSOCount'];
			$cableLine_arr[] = '<a href="FSOT.php?mode=change&fsotid='.$rows[$i]['id'].'">Изменить</a>';
			if ($rows[$i]['FSOCount'] == 0) {
				$cableLine_arr[] = '<a href="FSOT.php?mode=delete&fsotid='.$rows[$i]['id'].'">Удалить</a>';
			} else {				$cableLine_arr[] = ' ';
			}
	  	}
		$smarty->assign("data",$cableLine_arr);
		$smarty->assign("pages",$pages);
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['fsotid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			showMessage($message,0);
		}
    	$smarty->assign("mode","add_change");
		$smarty->assign("mod","1");
		$smarty->assign("back",getenv("HTTP_REFERER"));

		$wr['id'] = $_GET['fsotid'];
    	$res = FSOT_SELECT('',$wr);
    	if ($res['count'] < 1) {
			$message = 'Типа кассеты с таким ID не существует!<br />
						<a href="FSOT.php">Назад</a>';
			showMessage($message,0);
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("marking",$rows[0]['marking']);
		$smarty->assign("manufacturer",$rows[0]['manufacturer']);
		$smarty->assign("note",$rows[0]['note']);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			showMessage($message,0);
		}
		$smarty->assign("mode","add_change");
		$smarty->assign("mod","2");
		$smarty->assign("back",getenv("HTTP_REFERER"));
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['fsotid']))) {
		if ($_SESSION['class'] > 1)	{			$message = '!!!';
			showMessage($message,0);
		}		$wr['id'] = $_GET['fsotid'];
		FSOT_DELETE($wr);
    	header("Refresh: 2; url=".getenv("HTTP_REFERER"));
		$message = "Тип кассеты удален!";
		showMessage($message,0);
 	}

	$smarty->display('FSOT.tpl');
}
?>
