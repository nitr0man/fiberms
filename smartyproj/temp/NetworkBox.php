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
            	{					$upd['inventoryNumber'] = $invnum;
            	}
                else
                {
                	$upd['NetworkBoxType'] = $boxtypeid;
                	$upd['inventoryNumber'] = $invnum;                }
                $wr['id'] = $boxid;
            	NetworkBox_UPDATE($upd,$wr);
            	header("Refresh: 2; url=NetworkBox.php");
            	print('Ящик изменен!');
			}
		else
		if ($_POST['mode'] == 2)
			{
				$boxtype = $_POST['networkboxtypes'];
				$invnum = $_POST['invnum'];
				$ins['NetworkBoxType'] = $boxtype;
				$ins['inventoryNumber'] = $invnum;
				NetworkBox_INSERT($ins);
//				NetworkBox_INSERT('("NetworkBoxType", "inventoryNumber") VALUES ('.$boxtype.', '.$invnum.')');
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
//			$res = NetworkBox_SELECT('*','','');
			$res = NetworkBox_SELECT('','');
		}
		else
		{
//    		$res = NetworkBox_SELECT('*','','"NetworkBoxType"='.$typeid);
			$wr['NetworkBoxType'] = $typeid;
			$res = NetworkBox_SELECT('',$wr);
    		if ($res['count'] < 1)
			{
				print('Ящиков с таким ID не существует!<br />
				<a href="NetworkBox.php">Назад</a>');
				die();
			}
		}
		$rows = $res['rows'];
/*		while ($boxrow = pg_fetch_array($res))
  		{
			$box_arr[] = $boxrow['id'];
			$box_arr[] = $boxrow['NetworkBoxType'];
			$box_arr[] = $boxrow['inventoryNumber'];
			$box_arr[] = '<a href="NetworkBox.php?mode=change&boxid='.$boxrow['id'].'">Изменить</a>';
			$box_arr[] = '<a href="NetworkBox.php?mode=delete&boxid='.$boxrow['id'].'">Удалить</a>';
	  	} */
	  	$i = -1;
	  	while (++$i<$res['count'])
	  	{	  		$box_arr[] = $rows[$i]['id'];
	  		$box_arr[] = $rows[$i]['NetworkBoxType'];
			$box_arr[] = '<a href="NetworkBox.php?mode=charac&boxid='.$rows[$i]['id'].'">'.$rows[$i]['inventoryNumber'].'</a>';
			$box_arr[] = '<a href="NetworkBox.php?mode=change&boxid='.$rows[$i]['id'].'">Изменить</a>';
			$box_arr[] = '<a href="NetworkBox.php?mode=delete&boxid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$box_arr);
	}
	elseif (($_GET['mode'] == 'charac') and (isset($_GET['boxid'])))
	{		$smarty->assign("mode","charac");
		require_once("func/NetworkNodes_func.php");

		$wr['id'] = $_GET['boxid'];
    	$res = NetworkBox_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('Ящика с таким ID не существует!<br />
			<a href="NetworkBox.php">Назад</a>');
			die();
		}
    	$rows = $res['rows'];
//		$smarty->assign("id",$rows[0]['id']);
//		$boxtypeid = $rows[0]['NetworkBoxType'];
		$smarty->assign("invNum",$rows[0]['inventoryNumber']);
		unset($wr);
		$wr['id'] = $rows[0]['NetworkBoxType'];
		$res = NetworkBoxType_SELECT('',$wr);
		$smarty->assign("boxtype",$res['rows'][0]['marking']);
		unset($wr);
		$wr['NetworkBox'] = $_GET['boxid'];
		$res = NetworkNode_SELECT('',$wr);
		$smarty->assign("nodename",$res['rows'][0]['name']);

/*		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_boxtype_values[] = $rows[$i]['id'];
			$combobox_boxtype_text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_boxtype_values",$combobox_boxtype_values);
		$smarty->assign("combobox_boxtype_text",$combobox_boxtype_text);
		$smarty->assign("combobox_boxtype_selected",$boxtypeid);*/
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['boxid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['boxid'];
    	$res = NetworkBox_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('Ящика с таким ID не существует!<br />
			<a href="NetworkBox.php">Назад</a>');
			die();
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$boxtypeid = $rows[0]['NetworkBoxType'];
		$smarty->assign("invNum",$rows[0]['inventoryNumber']);
		$res = NetworkBoxType_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_boxtype_values[] = $rows[$i]['id'];
			$combobox_boxtype_text[] = $rows[$i]['marking'];
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

		$res = NetworkBoxType_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_boxtype_values[] = $rows[$i]['id'];
			$combobox_boxtype_text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_boxtype_values",$combobox_boxtype_values);
		$smarty->assign("combobox_boxtype_text",$combobox_boxtype_text);
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['boxid'])))
	{
		if ($_SESSION['class'] > 1)
		{			die("!!!");
		}//    	NetworkBox_DELETE('id='.$_GET['boxid']);
		$wr['id'] = $_GET['boxid'];
		NetworkBox_DELETE($wr);
    	header("Refresh: 2; url=NetworkBox.php");
		print("Ящик удален!");
		die();
 	}

	$smarty->display('NetworkBox.tpl');
}
?>
