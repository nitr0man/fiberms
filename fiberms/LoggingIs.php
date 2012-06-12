<?php
require_once("auth.php");
require_once("smarty.php");
require_once("/backend/LoggingIs.php");
//require_once("config.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	if ($_POST['mode'] == 1) {/*
		$id = $_POST['id'];
		$OpenGIS = $_POST['OpenGIS'];
	    $CableTypes = $_POST['cabletypes'];
		$length = $_POST['length'];
		$comment = $_POST['comment'];
		$res = CableLine_Mod($id,$OpenGIS,$CableTypes,$length,$comment);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=CableLine.php");
	        $message = 'Кабель изменен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}*/
	}
	elseif ($_POST['mode'] == 2) {
		/*$OpenGIS = $_POST['OpenGIS'];
		$CableTypes = $_POST['cabletypes'];
		$length = $_POST['length'];
		$comment = $_POST['comment'];
		$res = CableLine_Add($OpenGIS,$CableTypes,$length,$comment);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=CableLine.php");
	        $message = 'Кабель добавлен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}*/
	}
	//ShowMessage($message,$error);
}
else {
    if (!isset($_GET['mode'])) {
		global $config;
		if (!isset($_GET['page'])) {
			$page = 1;
		} else {
			$page = $_GET['page'];
		}		
		$res = LoggingIs_SELECT($config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
		$pages = GenPages('LoggingIs.php?',ceil($res['all']/$config['LinesPerPage']),$page);
		$rows = $res['rows'];
		for ($i = 0; $i < $res['count']; $i++) {
			$log_arr[] = $rows[$i]['id'];
			$log_arr[] = $rows[$i]['table'];
			$log_arr[] = $rows[$i]['record'];
			$log_arr[] = $rows[$i]['time'];
			$log_arr[] = $rows[$i]['action'];
			$log_arr[] = $rows[$i]['description'];
			$log_arr[] = $rows[$i]['username'].' ('.$rows[$i]['admin'].')';
		}
		$smarty->assign('data',$log_arr);
		$smarty->assign('pages',$pages);
	}
	$smarty->display('Log.tpl');
}
?>
