<?php
if ($_POST['login'] == 'login')
{
	require_once("/backend/functions.php");
	require_once("design_func.php");
	require_once("smarty.php");
	
	$passwordHash = md5($_POST['password']);
	$login = $_POST['user'];
	if (!preg_match("/^\w{3,}$/", $login))
	{
		die('Неверный логин!');
	}
	$res = PQuery('SELECT id,"class" FROM "Users" WHERE "username"=\''.$login.'\' AND "password"=\''.$passwordHash.'\'');
	if ($res['count'] < 1)
	{
		$message = 'Такого пользователя не существует!';
		$error = 1;
		ShowMessage($message,$error);
	}
	session_start();
	$token = md5(time().$login);
	if ($_POST['remember'])
	{
		setcookie('token', $token, time() + 60 * 60 * 24 * 14);
	}
	PQuery('UPDATE "Users" SET "token"=\''.$token.'\' WHERE "username"=\''.$login.'\'');
    $_SESSION['user'] = $login;
    $_SESSION['class'] = $res['rows'][0]['class']; //pg_result($res, 0, 1);
	header("Location: NetworkBoxType.php");
}
else
{
	require_once("smarty.php");
	$smarty->display('index.tpl');
}
?>