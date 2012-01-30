<?php
if ($_POST['login'] == 'login')
{
	require_once("functions.php");
	$passwordHash = md5($_POST['password']);
	$login = $_POST['user'];
	if (!preg_match("/^\w{3,}$/", $login))
	{
		die('Неверный логин!');
	}
	$res = PQuery('SELECT id FROM "Users" WHERE "username"=\''.$login.'\' AND "password"=\''.$passwordHash.'\'');
	if (pg_num_rows($res) < 1)
	{
		die('Такого пользователя не существует!');
	}
	$token = md5(time().$login);
	if ($_POST['remember'])
	{
		setcookie('token', $token, time() + 60 * 60 * 24 * 14);
	}
	PQuery('UPDATE "Users" SET "token"=\''.$token.'\' WHERE "username"=\''.$login.'\'');
	header("Location: NetworkBoxType.php");
}
else
{
	require_once("smarty.php");
	$smarty->display('index.tpl');
}
?>