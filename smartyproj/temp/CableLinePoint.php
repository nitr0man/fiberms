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
				$CableLine = $_POST['cabletypes'];
				$meterSign = $_POST['meterSign'];
				$NetworkNode = $_POST['networknodes'];
				$note = $_POST['note'];
				$Apartment = $_POST['Apartment'];
				$Building = $_POST['Building'];
				$SettlementGeoSpatial = $_POST['SettlementGeoSpatial'];
				$upd['OpenGIS'] = "$OpenGIS";
				$upd['CableLine'] = "$CableLine";
				$upd['meterSign'] = "$meterSign";
				$upd['NetworkNode'] = "$NetworkNode";
				$upd['note'] = "'$note'";
				$upd['Apartment'] = "NULL";
				$upd['Building'] = "NULL";
				$upd['SettlementGeoSpatial'] = "NULL";
	    		$wr['id'] = $id;
			   	CableLinePoint_UPDATE($upd,$wr);
            	header("Refresh: 2; url=CableLinePoint.php");
            	print('CableLinePoint изменен!');
			}
		else
		if ($_POST['mode'] == 2)
			{
				$OpenGIS = $_POST['OpenGIS'];
				$CableLine = $_POST['cabletypes'];
				$meterSign = $_POST['meterSign'];
				$NetworkNode = $_POST['networknodes'];
				$note = $_POST['note'];
				$Apartment = $_POST['Apartment'];
				$Building = $_POST['Building'];
				$SettlementGeoSpatial = $_POST['SettlementGeoSpatial'];
				$ins['OpenGIS'] = "'$OpenGIS'";
				$ins['CableLine'] = "$CableLine";
				$ins['meterSign'] = "$meterSign";
				$ins['NetworkNode'] = "$NetworkNode";
				$ins['note'] = "'$note'";
				$ins['Apartment'] = "NULL";
				$ins['Building'] = "NULL";
				$ins['SettlementGeoSpatial'] = "NULL";
	    		CableLinePoint_INSERT($ins);
				header("Refresh: 2; url=CableLinePoint.php");
				print("CableLinePoint добавлен!");
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
		$res = CableLinePoint_SELECT('','');
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i<$res['count'])
	  	{	  		$cableline_arr[] = $rows[$i]['id'];
	  		$cableline_arr[] = $rows[$i]['OpenGIS'];
	  		$cableline_arr[] = $rows[$i]['CableLine'];
	  		$cableline_arr[] = $rows[$i]['meterSign'];
			$cableline_arr[] = $rows[$i]['NetworkNode'];
			$cableline_arr[] = $rows[$i]['note'];
			$cableline_arr[] = $rows[$i]['Apartment'];
			$cableline_arr[] = $rows[$i]['Building'];
			$cableline_arr[] = $rows[$i]['SettlementGeoSpatial'];
			$cableline_arr[] = '<a href="CableLinePoint.php?mode=change&cablelinepointid='.$rows[$i]['id'].'">Изменить</a>';
			$cableline_arr[] = '<a href="CableLinePoint.php?mode=delete&cablelinepointid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$cableline_arr);
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['cablelinepointid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
		require_once("func/NetworkBoxType_func.php");
    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['cablelinepointid'];
    	$res = CableLinePoint_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('CableLinePoint с таким ID не существует!<br />
			<a href="CableLinePoint.php">Назад</a>');
			die();
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("OpenGIS",$rows[0]['OpenGIS']);
		$CableLineId = $rows[0]['CableLine'];
		$NetworkNodeId = $rows[0]['NetworkNode'];
		$smarty->assign("meterSign",$rows[0]['meterSign']);
		$smarty->assign("note",$rows[0]['note']);
		$smarty->assign("Apartment",$rows[0]['Apartment']);
		$smarty->assign("Building",$rows[0]['Building']);
		$smarty->assign("SettlementGeoSpatial",$rows[0]['SettlementGeoSpatial']);

		$res = CableLine_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_cableline_values[] = $rows[$i]['id'];
			$combobox_cableline_text[] = $rows[$i]['length'];
		}
		$smarty->assign("combobox_cableline_values",$combobox_cableline_values);
		$smarty->assign("combobox_cableline_text",$combobox_cableline_text);
		$smarty->assign("combobox_cableline_selected",$CableLineId);

		$res = NetworkBox_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_networknode_values[] = $rows[$i]['id'];
			$combobox_networknode_text[] = $rows[$i]['inventoryNumber'];
		}
		$smarty->assign("combobox_networknode_values",$combobox_networknode_values);
		$smarty->assign("combobox_networknode_text",$combobox_networknode_text);
		$smarty->assign("combobox_networknode_selected",$NetworkNodeId);
	}
	elseif ($_GET['mode'] == 'add')
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
		require_once("func/NetworkNodes_func.php");		$smarty->assign("mode","add");

		$res = CableLine_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_cableline_values[] = $rows[$i]['id'];
			$combobox_cableline_text[] = $rows[$i]['length'];
		}
		$smarty->assign("combobox_cableline_values",$combobox_cableline_values);
		$smarty->assign("combobox_cableline_text",$combobox_cableline_text);
		$smarty->assign("combobox_cableline_selected",$CableLineId);

		$res = NetworkNode_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_networknode_values[] = $rows[$i]['id'];
			$combobox_networknode_text[] = $rows[$i]['name'];
		}
		$smarty->assign("combobox_networknode_values",$combobox_networknode_values);
		$smarty->assign("combobox_networknode_text",$combobox_networknode_text);
		$smarty->assign("combobox_networknode_selected",$NetworkNodeId);
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['cablelinepointid'])))
	{
		if ($_SESSION['class'] > 1)
		{			die("!!!");
		}//    	NetworkBox_DELETE('id='.$_GET['boxid']);
		$wr['id'] = $_GET['cablelinepointid'];
		CableLine_DELETE($wr);
    	header("Refresh: 2; url=CableLinePoint.php");
		print("Точка удалена!");
		die();
 	}

	$smarty->display('CableLinePoint.tpl');
}
?>
