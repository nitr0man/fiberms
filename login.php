<?php
if ($_POST['login'] == 'login')
{
	require_once("backend/functions.php");
	require_once("design_func.php");
	require_once("smarty.php");
	
	$passwordHash = md5($_POST['password']);
	$login = $_POST['user'];
	if (!preg_match("/^\w{3,}$/", $login)) {
		$message = 'Неверный логин!';
		$error = 1;
		showMessage($message,$error);
	}
	$res = PQuery('SELECT id, "class" FROM "Users" WHERE "username"=\''.$login.'\' AND "password"=\''.$passwordHash.'\'');
	if ($res['count'] < 1) {
		$message = 'Такого пользователя не существует!';
		$error = 1;
		showMessage($message, $error);
	}
	session_start();
	$token = md5(time().$login);
	if ($_POST['remember']) {
		setcookie('token', $token, time() + 60 * 60 * 24 * 14);
	}
	PQuery('UPDATE "Users" SET "token"=\''.$token.'\' WHERE "username"=\''.$login.'\'');
    $_SESSION['user'] = $login;
    $_SESSION['class'] = $res['rows'][0]['class'];
	header("Location: ".getenv("HTTP_REFERER"));
}
else
{
	require_once("smarty.php");
	$smarty->display('login.tpl');
}
?>