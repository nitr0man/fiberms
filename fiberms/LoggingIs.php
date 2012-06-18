<?php
require_once("auth.php");
require_once("smarty.php");
require_once("backend/LoggingIs.php");
require_once("design_func.php");

if (!isset($_GET['page'])) {
	$page = 1;
} else {
	$page = $_GET['page'];
}		
$res = LoggingIs_SELECT($config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
$pages = GenPages('LoggingIs.php?',ceil($res['AllPages']/$config['LinesPerPage']),$page);
$rows = $res['rows'];
for ($i = 0; $i < $res['count']; $i++) {
	$log_arr[] = $rows[$i]['id'];
	$log_arr[] = $rows[$i]['name'];
	$log_arr[] = $rows[$i]['record'];
	$log_arr[] = $rows[$i]['time'];
	$log_arr[] = $rows[$i]['action'];
	$log_arr[] = $rows[$i]['description'];
	$log_arr[] = $rows[$i]['username'].' ('.$rows[$i]['admin'].')';
	}
$smarty->assign('data',$log_arr);
$smarty->assign('pages',$pages);
$smarty->display('Log.tpl');
?>
