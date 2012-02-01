<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/NetworkBoxType_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
            	$boxtypeid = $_POST['networkboxtypes'];
            	$boxid = $_POST['boxid'];
            	$invnum = $_POST['invnum'];
            	if ($boxid == '')
            	{					$query = '"inventoryNumber"='.$invnum;
            	}
                else
                {                	$query = '"NetworkBoxType"='.$boxtypeid.', "inventoryNumber"='.$invnum;
                }
            	NetworkBox_UPDATE($query,'id='.$boxid);
            	header("Refresh: 2; url=NetworkBox.php");
            	print('Ящик изменен!');
			}
		else
		if ($_POST['mode'] == 2)
			{
				$boxtype = $_POST['networkboxtypes'];
				$invnum = $_POST['invnum'];
				NetworkBox_INSERT('("NetworkBoxType", "inventoryNumber") VALUES ('.$boxtype.', '.$invnum.')');
				header("Refresh: 2; url=NetworkBox.php");
				print("Ящик успешно добавлен!");
			}
	}
else
{
/*	if (isset($_GET['boxid']))
	{
		$smarty->assign("body",'<body onload="javascript: GetBoxInfo('.$_GET['boxid'].',1);">');
	}
	else
	{		$smarty->assign("body",'<body onload="javascript: GetBoxInfo(0,1);">');
	}  */
    if (!isset($_GET['mode']))
    {
		require_once("functions.php");
		$typeid = $_GET['typeid'];
		if (!isset($_GET['typeid']))
		{
			$res = NetworkBox_SELECT('*','','');
		}
		else
		{
    		$res = NetworkBox_SELECT('*','','"NetworkBoxType"='.$typeid);
    		if (pg_num_rows($res) < 1)
			{
				print('Ящиков с таким ID не существует!<br />
				<a href="NetworkBox.php">Назад</a>');
				die();
			}
		}
		while ($boxrow = pg_fetch_array($res))
  		{
			$box_arr[] = $boxrow['id'];
			$box_arr[] = $boxrow['NetworkBoxType'];
			$box_arr[] = $boxrow['inventoryNumber'];
			$box_arr[] = '<a href="NetworkBox.php?mode=change&boxid='.$boxrow['id'].'">Изменить</a>';
			$box_arr[] = '<a href="NetworkBox.php?mode=delete&boxid='.$boxrow['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$box_arr);
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['boxid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
    	$smarty->assign("mode","change");

    	$res = NetworkBox_SELECT('*','','id='.$_GET['boxid']);
		while ($boxinfo = pg_fetch_array($res))
		{
			$smarty->assign("id",$boxinfo['id']);
			$boxtypeid = $boxinfo['NetworkBoxType'];
			$smarty->assign("invNum",$boxinfo['inventoryNumber']);
		}
		if (pg_num_rows($res) < 1)
		{
			print('Ящика с таким ID не существует!<br />
			<a href="NetworkBox.php">Назад</a>');
			die();
		}
    	$res = NetworkBoxType_SELECT('id, "marking"','','');
		while ($boxtype = pg_fetch_array($res))
		{
			$combobox_boxtype_values[] = $boxtype['id'];
			$combobox_boxtype_text[] = $boxtype['marking'];
		}

		$smarty->assign("combobox_boxtype_values",$combobox_boxtype_values);
		$smarty->assign("combobox_boxtype_text",$combobox_boxtype_text);
		$smarty->assign("combobox_boxtype_selected",$boxtypeid);
	}
	elseif ($_GET['mode'] == 'add')
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
		$smarty->assign("mode","add");

		$res = NetworkBoxType_SELECT('id, "marking"','','');
		while ($boxtype = pg_fetch_array($res))
		{
			$combobox_boxtype_values[] = $boxtype['id'];
			$combobox_boxtype_text[] = $boxtype['marking'];
		}
		$smarty->assign("combobox_boxtype_values",$combobox_boxtype_values);
		$smarty->assign("combobox_boxtype_text",$combobox_boxtype_text);
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['boxid'])))
	{
		if ($_SESSION['class'] > 1)
		{			die("!!!");
		}    	NetworkBox_DELETE('id='.$_GET['boxid']);
    	header("Refresh: 2; url=NetworkBox.php");
		print("Ящик удален!");
		die();
 	}

	$smarty->display('NetworkBox.tpl');
}
?>
