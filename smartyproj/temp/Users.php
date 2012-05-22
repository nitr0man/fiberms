<?php
require_once("auth.php");
require_once("smarty.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require "func/Users_func.php";
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
				$userid = $_POST['userid'];
				if ($userid == 0)
					{
						$res = Users_SELECT('id LIMIT 1','');
						$userid = $res['rows'][0]['id'];/*  					    while ($row = pg_fetch_array($res)) {  					    	$userid = $row['id'];
  					    }*/
					}
				$wr['id'] = $userid;
				$res = Users_SELECT('',$wr);
				$rows = $res['rows'];

				$smarty->assign("id",$rows[0]['id']);
				$smarty->assign("login",$rows[0]['username']);
				$class = $rows[0]['class'];
/*				$res = PQuery('SELECT id, "marking" FROM "NetworkBoxType"');*/
				$res = Users_SELECT('','');
				$rows = $res['rows'];
				$i = -1;
				while (++$i<$res['count'])
				{
					$combobox_users_values[] = $rows[$i]['id'];
					$combobox_users_text[] = $rows[$i]['username'];
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
		    		$wr['id'] = $id;
		    		$upd['username'] = "'$login'";
		    		$upd['class'] = "'$group'";
		    		if ($password != '')
		    		{
		    			$upd['password'] = "'".md5($password)."'";		    		}
				   	Users_UPDATE($upd,$wr);
				   	print("Пользователь изменен!<br />
					<a href=\"Users.php\">Назад</a>");
				}
				else
				{
					$wr['username'] = "'$login'";
					$res = Users_SELECT('',$wr);
					if ($res['count'] > 0)
					{
						print("Пользователь с такими логином существует!<br />
						<a href=\"Users.php\">Назад</a>");
						die();
					}
					$ins['username'] = "'$login'";
					$ins['password'] = "'".md5($password)."'";
		    		$ins['class'] = "'$group'";					Users_INSERT($ins);
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