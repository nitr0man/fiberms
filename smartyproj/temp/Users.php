<?php
require_once("auth.php");
require_once("smarty.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require "functions/Users_func.php";
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
				$userid = $_POST['userid'];
				if ($userid == 0)
					{
						$res = Users_SELECT('id','ORDER BY id LIMIT 1','');/*						$res = PQuery('SELECT id
						  FROM "NetworkBoxType" ORDER BY id LIMIT 1');*/
  					    while ($row = pg_fetch_array($res)) {  					    	$userid = $row['id'];
  					    }
					}
				$res = Users_SELECT('id,"username","class"','','id='.$userid);
				while ($usersrow = pg_fetch_array($res)) {					$smarty->assign("id",$usersrow['id']);
					$smarty->assign("login",$usersrow['username']);
					$class = $usersrow['class'];
				}
/*				$res = PQuery('SELECT id, "marking" FROM "NetworkBoxType"');*/
				$res = Users_SELECT('id, "username"','','');
				while ($mybox = pg_fetch_array($res)) {
//					print("<option value=\"".$mybox['id']."\">".$mybox['marking']."</option>");
					$combobox_users_values[] = $mybox['id'];
					$combobox_users_text[] = $mybox['username'];
				}
				$smarty->assign("combobox_users_values",$combobox_users_values);
				$smarty->assign("combobox_users_text",$combobox_users_text);
				$smarty->assign("combobox_users_selected",$userid);
				$smarty->assign("combobox_usergroup_values",array("1","2"));
				$smarty->assign("combobox_usergroup_text",array("Админ","ReadOnly"));
				$smarty->assign("combobox_usergroup_selected",$class);
				$smarty->display('Users_content.tpl');
			}
		else
		if ($_POST['mode'] == 2)
			{
				$id = $_POST['userid'];				$login = $_POST['login'];
		    	$password = $_POST['password'];
		    	$group = $_POST['group'];
		    	if ($_POST['rb'] == 'true')
		    	{
		    		$query = '"username"=\''.$login.'\',"class"=\''.$group.'\'';
		    		if ($password != '')
		    			{		    				$query = $query.',"password"=\''.md5($password).'\'';
		    			}
				   	Users_UPDATE($query,'id='.$id);
				   	print("Пользователь успешно изменен!<br />
					<a href=\"Users.php\">Назад</a>");
				}
				else
				{
					$res = Users_SELECT('id','','"username"=\''.$login.'\'');
					if (pg_num_rows($res) > 0)
					{
						print("Пользователь с таким логином существует!<br />
						<a href=\"Users.php\">РќР°Р·Р°Рґ</a>");
					}					Users_INSERT('(username, password, class) VALUES (\''.$login.'\', \''.md5($password).'\', \''.$group.'\')');
					print("Пользователь добавлен!<br />
					<a href=\"Users.php\">Назад</a>");
				}
			}
	}
else
{
	$smarty->display('Users.tpl');
}
?>