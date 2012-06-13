<?php
require_once("auth.php");
require_once("smarty.php");
require_once("backend/functions.php");

$stat = GetStat();

$smarty->assign("version",$config['version']);
$smarty->assign("users_all",$stat['Users']['All']);
$smarty->assign("users_admin",$stat['Users']['Admin']);
$smarty->assign("FiberSplice_NetworkNodesCount",$stat['FiberSplice']['NetworkNodesCount']);
$smarty->assign("FiberSplice_FiberSpliceCount",$stat['FiberSplice']['FiberSpliceCount']);
$smarty->assign("CableLinePointCount",$stat['CableLinePoint']['Count']);
$smarty->assign("NetworkNodesCount",$stat['NetworkNode']['Count']);
$smarty->assign("NetworkBoxesCount",$stat['NetworkBox']['Count']);

$smarty->display("index.tpl");
?>