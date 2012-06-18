<?php
session_start();
require_once("backend/functions.php");
require_once("smarty.php");

if (isset($_COOKIE['token']) && !isset($_SESSION['user'])) {
	$token = htmlspecialchars($_COOKIE['token']);
	$res = PQuery('SELECT "username","class" FROM "Users" WHERE "token"=\''.$token.'\'');
	if ($res['count'] < 1) {
		setcookie('token', '');
	}
	else {
		$_SESSION['user'] = $res['rows'][0]['username'];
		$_SESSION['class'] = $res['rows'][0]['class'];
	}
}
if (!isset($_SESSION['user'])) {	$smarty->assign('warning","<center><font color="red"><b>Нужно авторизоватся!</b></font></center>');
	$smarty->display('login.tpl');
	die();
}

?>