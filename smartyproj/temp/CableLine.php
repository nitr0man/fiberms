<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/CableType_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
				$id = $_POST['id'];
				$OpenGIS = $_POST['OpenGIS'];
		    	$cabletypes = $_POST['cabletypes'];
		    	$length = $_POST['length'];
		    	$comment = $_POST['comment'];
				$upd['OpenGIS'] = "NULL";
	    		$upd['CableType'] = "$cabletypes";
	    		$upd['length'] = "$length";
	    		$upd['comment'] = "'$comment'";
	    		$wr['id'] = $id;
			   	CableLine_UPDATE($upd,$wr);
            	header("Refresh: 2; url=CableLine.php");
            	print('Кабель изменен!');
			}
		else
		if ($_POST['mode'] == 2)
			{
				$OpenGIS = $_POST['OpenGIS'];
		    	$cabletypes = $_POST['cabletypes'];
		    	$length = $_POST['length'];
		    	$comment = $_POST['comment'];
				$ins['OpenGIS'] = "NULL";
	    		$ins['CableType'] = "$cabletypes";
	    		$ins['length'] = "$length";
	    		$ins['comment'] = "'$comment'";
	    		CableLine_INSERT($ins);
				header("Refresh: 2; url=CableLine.php");
				print("Кабель добавлен!");
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
			$res = CableLine_SELECT('','');
		}
		else
		{
			$wr['CableType'] = $typeid;
			$res = CableLine_SELECT('',$wr);
    		if ($res['count'] < 1)
			{
				print('Кабелей с таким типом ID не существует!<br />
				<a href="CableLine.php">Назад</a>');
				die();
			}
		}
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i<$res['count'])
	  	{	  		$cableline_arr[] = '<a href="CableLine.php?mode=charac&cablelineid='.$rows[$i]['id'].'">'.$rows[$i]['id'].'</a>';
	  		$cableline_arr[] = $rows[$i]['OpenGIS'];
			$cableline_arr[] = $rows[$i]['CableType'];
			$cableline_arr[] = $rows[$i]['length'];
			$cableline_arr[] = $rows[$i]['comment'];
			$cableline_arr[] = '<a href="CableLine.php?mode=change&cablelineid='.$rows[$i]['id'].'">Изменить</a>';
			$cableline_arr[] = '<a href="CableLine.php?mode=delete&cablelineid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$cableline_arr);
	}
	elseif (($_GET['mode'] == 'charac') and (isset($_GET['cablelineid'])))
	{
	    $smarty->assign("mode","charac");
    	$wr['id'] = $_GET['cablelineid'];
    	$res = CableLine_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('Кабеля с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>');
			die();
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("OpenGIS",$rows[0]['OpenGIS']);
		$cabletypeid = $rows[0]['CableType'];
		$smarty->assign("length",$rows[0]['length']);
		$smarty->assign("comment",$rows[0]['comment']);

		$res = CableType_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_cabletype_values[] = $rows[$i]['id'];
			$combobox_cabletype_text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_cabletype_values",$combobox_cabletype_values);
		$smarty->assign("combobox_cabletype_text",$combobox_cabletype_text);
		$smarty->assign("combobox_cabletype_selected",$cabletypeid);

		unset($wr);
		$wr['CableLine'] = $_GET['cablelineid'];
		$res = CableLinePoint_SELECT('',$wr);
        $rows = $res['rows'];
	  	$i = -1;
	  	while (++$i<$res['count'])
	  	{
	  		$cableline_arr[] = $rows[$i]['id'];
	  		$cableline_arr[] = $rows[$i]['OpenGIS'];
			$cableline_arr[] = $rows[$i]['CableLine'];
			$cableline_arr[] = $rows[$i]['meterSign'];
			$cableline_arr[] = '<a href="NetworkNode?mode=charac&nodeid='.$rows[$i]['NetworkNode'].'">'.$rows[$i]['NetworkNode'].'</a>';
			$cableline_arr[] = $rows[$i]['note'];
			$cableline_arr[] = $rows[$i]['Apartment'];
			$cableline_arr[] = $rows[$i]['Building'];
			$cableline_arr[] = $rows[$i]['SettlementGeoSpatial'];
			$cableline_arr[] = '<a href="CableLine.php?mode=change&cablelineid='.$rows[$i]['id'].'">Изменить</a>';
			$cableline_arr[] = '<a href="CableLine.php?mode=delete&cablelineid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$cableline_arr);
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['cablelineid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['cablelineid'];
    	$res = CableLine_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('Кабеля с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>');
			die();
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("OpenGIS",$rows[0]['OpenGIS']);
		$cabletypeid = $rows[0]['CableType'];
		$smarty->assign("length",$rows[0]['length']);
		$smarty->assign("comment",$rows[0]['comment']);

		$res = CableType_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_cabletype_values[] = $rows[$i]['id'];
			$combobox_cabletype_text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_cabletype_values",$combobox_cabletype_values);
		$smarty->assign("combobox_cabletype_text",$combobox_cabletype_text);
		$smarty->assign("combobox_cabletype_selected",$cabletypeid);
	}
	elseif ($_GET['mode'] == 'add')
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
		$smarty->assign("mode","add");

		$res = CableType_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_cabletype_values[] = $rows[$i]['id'];
			$combobox_cabletype_text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_cabletype_values",$combobox_cabletype_values);
		$smarty->assign("combobox_cabletype_text",$combobox_cabletype_text);
		$smarty->assign("combobox_cabletype_selected",$cabletypeid);
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['cablelineid'])))
	{
		if ($_SESSION['class'] > 1)
		{			die("!!!");
		}//    	NetworkBox_DELETE('id='.$_GET['boxid']);
		$wr['id'] = $_GET['cablelineid'];
		CableLine_DELETE($wr);
    	header("Refresh: 2; url=CableLine.php");
		print("Тип удален!");
		die();
 	}

	$smarty->display('CableLine.tpl');
}
?>
