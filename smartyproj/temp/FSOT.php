<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/FS_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
				$id = $_POST['id'];
				$marking = $_POST['marking'];
		    	$manufacturer = $_POST['manufacturer'];
		    	$note = $_POST['note'];
				$upd['marking'] = "'$marking'";
	    		$upd['manufacturer'] = "'$manufacturer'";
	    		$upd['note'] = "'$note'";
	    		$wr['id'] = $id;
			   	FSOT_UPDATE($upd,$wr);
            	header("Refresh: 2; url=FSOT.php");
            	print('FSOT изменен!');
			}
		else
		if ($_POST['mode'] == 2)
			{
				$marking = $_POST['marking'];
		    	$manufacturer = $_POST['manufacturer'];
		    	$note = $_POST['note'];
				$ins['marking'] = "'$marking'";
	    		$ins['manufacturer'] = "'$manufacturer'";
	    		$ins['note'] = "'$note'";
	    		FSOT_INSERT($ins);
				header("Refresh: 2; url=FSOT.php");
				print("FSOT добавлен!");
			}
	}
else
{
    if (!isset($_GET['mode']))
    {
//		require_once("functions.php");
		$typeid = $_GET['typeid'];
		$res = FSOT_SELECT('','');

		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i<$res['count'])
	  	{	  		$cableline_arr[] = $rows[$i]['id'];
	  		$cableline_arr[] = $rows[$i]['marking'];
			$cableline_arr[] = $rows[$i]['manufacturer'];
			$cableline_arr[] = $rows[$i]['note'];
			$cableline_arr[] = '<a href="FSOT.php?mode=change&fsotid='.$rows[$i]['id'].'">Изменить</a>';
			$cableline_arr[] = '<a href="FSOT.php?mode=delete&fsotid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$cableline_arr);
	}
/*	elseif (($_GET['mode'] == 'charac') and (isset($_GET['cablelineid'])))
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
	} */
	elseif (($_GET['mode'] == 'change') and (isset($_GET['fsotid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['fsotid'];
    	$res = FSOT_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('FSOT с таким ID не существует!<br />
			<a href="FSOT.php">Назад</a>');
			die();
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("marking",$rows[0]['marking']);
		$smarty->assign("manufacturer",$rows[0]['manufacturer']);
		$smarty->assign("note",$rows[0]['note']);
	}
	elseif ($_GET['mode'] == 'add')
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
		$smarty->assign("mode","add");
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

	$smarty->display('FSOT.tpl');
}
?>
