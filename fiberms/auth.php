<?php
session_start();
require_once("/backend/functions.php");
require_once("smarty.php");
$smarty->assign("Queries",$Queries);
if (isset($_COOKIE['token']) && !isset($_SESSION['user']))
{
	$token = htmlspecialchars($_COOKIE['token']);
	$res = PQuery('SELECT "username","class" FROM "Users" WHERE "token"=\''.$token.'\'');
	//print_r($res);
	if ($res['count'] < 1)
	{
		setcookie('token', '');
	}
	else
	{
		//while ($row = pg_fetch_array)
		$_SESSION['user'] = /*pg_result($res, 0)*/ $res['rows'][0]['username'];
		$_SESSION['class'] = /*pg_result($res, 0, 1)*/ $res['rows'][0]['class'];
	}
	$smarty->assign("Queries",$Queries);
}
if (!isset($_SESSION['user']))
{//	header("Location: index.php");
	$smarty->assign("Queries",$Queries);
	$smarty->assign('warning","<center><font color="red"><b>Нужно авторизоватся!</b></font></center>');
	$smarty->display('index.tpl');
	die();
}

?>