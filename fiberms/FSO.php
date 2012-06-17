<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/FiberSplice.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {		
	if ($_POST['mode'] == 1) {
		$id = $_POST['id'];
		$FSOT = $_POST['FSOT'];
		$res = FSO_Mod($id,$FSOT);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=FSO.php");
	        $message = 'Кассета изменена!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 2) {
		$FSOT = $_POST['FSOT'];
		$res = FSO_Add($FSOT);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=FSO.php");
	        $message = 'Кассета добавлена!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	ShowMessage($message,$error);
} else {
    if (!isset($_GET['mode'])) {
		if (!isset($_GET['page'])) {
			$page = 1;
		} else {
			$page = $_GET['page'];
		}
		$res = FSO_SELECT('','',$config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
		$pages = GenPages('FSO.php?',ceil($res['AllPages']/$config['LinesPerPage']),$page);

		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i < $res['count']) {	  		$FSO[] = $rows[$i]['id'];
	  		$FSO[] = $rows[$i]['FiberSpliceOrganizationType'];
			$FSO[] = '<a href="FSO.php?mode=change&fsoid='.$rows[$i]['id'].'">Изменить</a>';
			$FSO[] = '<a href="FSO.php?mode=delete&fsoid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$FSO);
		$smarty->assign("pages",$pages);
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['fsoid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			ShowMessage($message,0);
		}
    	$smarty->assign("mode","add_change");
		$smarty->assign("mod","1");

		$wr['id'] = $_GET['fsoid'];
    	$res = FSO_SELECT('',$wr);
    	if ($res['count'] < 1) {
			$message = 'Кассеты с таким ID не существует!<br />
						<a href="FSO.php">Назад</a>';
			ShowMessage($message,0);
		}
    	$rows = $res['rows'];
		$res = FSOT_SELECT('','');
		$rows2 = $res['rows'];
		$i = -1;
		while (++$i < $res['count']) {
			$FSOT_values[] = $rows2[$i]['id'];
			$FSOT_text[] = $rows2[$i]['marking'];
		}
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("FSOT_values",$FSOT_values);
		$smarty->assign("FSOT_text",$FSOT_text);
		$smarty->assign("FSOT_selected",$rows[0]['FiberSpliceOrganizationType']);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			ShowMessage($message,0);
		}
		$smarty->assign("mode","add_change");
		$smarty->assign("mod","2");
		
		$res = FSOT_SELECT('','');
		$rows2 = $res['rows'];
		$i = -1;
		while (++$i < $res['count']) {
			$FSOT_values[] = $rows2[$i]['id'];
			$FSOT_text[] = $rows2[$i]['marking'];
		}
		$smarty->assign("FSOT_values",$FSOT_values);
		$smarty->assign("FSOT_text",$FSOT_text);
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['fsotid']))) {
		if ($_SESSION['class'] > 1)	{			$message = '!!!';
			ShowMessage($message,0);
		}		$wr['id'] = $_GET['fsotid'];
		FSO_DELETE($wr);
    	header("Refresh: 2; url=FSOT.php");
		$message = "Кассета удалена!";
		ShowMessage($message,0);
 	}

	$smarty->display('FSO.tpl');
}
?>
