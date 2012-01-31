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
	$res = PQuery('SELECT id,"class" FROM "Users" WHERE "username"=\''.$login.'\' AND "password"=\''.$passwordHash.'\'');
	if (pg_num_rows($res) < 1)
	{
		die('Такого пользователя не существует!');
	}
	session_start();
	$token = md5(time().$login);
	if ($_POST['remember'])
	{
		setcookie('token', $token, time() + 60 * 60 * 24 * 14);
	}
	PQuery('UPDATE "Users" SET "token"=\''.$token.'\' WHERE "username"=\''.$login.'\'');
//	session_start();
    $_SESSION['user'] = $login;
    $_SESSION['class'] = pg_result($res, 0, 1);
	header("Location: NetworkBoxType.php");
}
else
{
	require_once("smarty.php");
	$smarty->display('index.tpl');
}
?>