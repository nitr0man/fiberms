<?php
session_start();
require_once("functions.php");
require_once("smarty.php");
if (isset($_COOKIE['token']) && !isset($_SESSION['user']))
{
	$token = htmlspecialchars($_COOKIE['token']);
	$res = PQuery('SELECT "username","class" FROM "Users" WHERE "token"=\''.$token.'\'');
	if (pg_num_rows($res) < 1)
	{
		setcookie('token', '');
	}
	else
	{
		$_SESSION['user'] = pg_result($res, 0);
		$_SESSION['class'] = pg_result($res, 0, 1);
	}
}
if (!isset($_SESSION['user']))
{//	header("Location: index.php");
	$smarty->assign('warning","<center><font color="red"><b>Нужно авторизоватся!</b></font></center>');
	$smarty->display('index.tpl');
	die();
}

?>