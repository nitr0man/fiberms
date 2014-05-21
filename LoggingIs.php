<?php
require_once("auth.php");
require_once("smarty.php");
require_once("backend/LoggingIs.php");
require_once("design_func.php");

$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$res = loggingIs_SELECT($config['LinesPerPage'], ($page-1)*$config['LinesPerPage']);
$pages = genPages('LoggingIs.php?', ceil($res['allPages']/$config['LinesPerPage']), $page);
$rows = $res['rows'];
$log_arr = array();
for ($i = 0; $i < $res['count']; $i++) {
	$log_arr[] = $rows[$i]['id'];
	$log_arr[] = $rows[$i]['name'];
	$log_arr[] = $rows[$i]['record'];
	$log_arr[] = $rows[$i]['time'];
	$log_arr[] = $rows[$i]['action'];
	$log_arr[] = $rows[$i]['description'];
	$log_arr[] = $rows[$i]['username'].' ('.$rows[$i]['admin'].')';
	}
$smarty->assign('data', $log_arr);
$smarty->assign('pages', $pages);
$smarty->display('Log.tpl');
?>
