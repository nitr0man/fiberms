<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/CableType.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	if ($_POST['mode'] == 1) {
		$id = $_POST['id'];
		$OpenGIS = "'".$_POST['OpenGIS']."'";
		$CableLine = $_POST['cablelines'];
		$meterSign = $_POST['meterSign'];
		$NetworkNode = $_POST['networknodes'];
		$note = $_POST['note'];
		$Apartment = $_POST['Apartment'];
		$Building = $_POST['Building'];
		$SettlementGeoSpatial = $_POST['SettlementGeoSpatial'];
		$res = CableLinePoint_Mod($id,$OpenGIS,$CableLine,$meterSign,$NetworkNode,$note,$Apartment,$Building,$SettlementGeoSpatial);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=CableLine.php");
	        $message = 'CableLinePoint изменен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 2) {
		$OpenGIS = $_POST['OpenGIS'];
		$CableLine = $_POST['cablelines'];
		$meterSign = $_POST['meterSign'];
		$NetworkNode = $_POST['networknodes'];
		$note = $_POST['note'];
		$Apartment = $_POST['Apartment'];
		$Building = $_POST['Building'];
		$SettlementGeoSpatial = $_POST['SettlementGeoSpatial'];
		$res = CableLinePoint_Add($OpenGIS,$CableLine,$meterSign,$NetworkNode,$note,$Apartment,$Building,$SettlementGeoSpatial);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=CableLine.php");
	        $message = 'CableLinePoint добавлен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	ShowMessage($message,$error);
} else {
    if (!isset($_GET['mode'])) {
    	die();
		$typeid = $_GET['typeid'];
		$res = CableLinePoint_SELECT('','');
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i<$res['count']) {	  		$cableline_arr[] = $rows[$i]['id'];
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
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['cablelinepointid']))) {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			ShowMessage($message,0);
		}
		require_once("backend/NetworkNodes.php");
    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['cablelinepointid'];
    	$res = CableLinePoint_SELECT($wr);
    	if ($res['count'] < 1) {
			$message = 'CableLinePoint с таким ID не существует!<br />
			<a href="CableLinePoint.php">Назад</a>';
			ShowMessage($message,0);
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
		while (++$i<$res['count']) {
			$combobox_cableline_values[] = $rows[$i]['id'];
			$combobox_cableline_text[] = $rows[$i]['length'];
		}
		$smarty->assign("combobox_cableline_values",$combobox_cableline_values);
		$smarty->assign("combobox_cableline_text",$combobox_cableline_text);
		$smarty->assign("combobox_cableline_selected",$CableLineId);

		$res = NetworkNode_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_networknode_values[] = $rows[$i]['id'];
			$combobox_networknode_text[] = $rows[$i]['note'];
		}
		$smarty->assign("combobox_networknode_values",$combobox_networknode_values);
		$smarty->assign("combobox_networknode_text",$combobox_networknode_text);
		$smarty->assign("combobox_networknode_selected",$NetworkNodeId);
	} elseif ($_GET['mode'] == 'charac') {
		
	}
	elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			ShowMessage($message,0);
		}
		require_once("backend/NetworkNodes_func.php");		$smarty->assign("mode","add");

		$res = CableLine_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_cableline_values[] = $rows[$i]['id'];
			$combobox_cableline_text[] = $rows[$i]['length'];
		}
		$smarty->assign("combobox_cableline_values",$combobox_cableline_values);
		$smarty->assign("combobox_cableline_text",$combobox_cableline_text);
		$smarty->assign("combobox_cableline_selected",$CableLineId);

		$res = NetworkNode_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_networknode_values[] = $rows[$i]['id'];
			$combobox_networknode_text[] = $rows[$i]['name'];
		}
		$smarty->assign("combobox_networknode_values",$combobox_networknode_values);
		$smarty->assign("combobox_networknode_text",$combobox_networknode_text);
		$smarty->assign("combobox_networknode_selected",$NetworkNodeId);
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['cablelinepointid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';			ShowMessage($message,0);
		}		$wr['id'] = $_GET['cablelinepointid'];
		CableLine_DELETE($wr);
    	header("Refresh: 2; url=CableLinePoint.php");
		$message = "Точка удалена!";
		ShowMessage($message,0);
 	}

	$smarty->display('CableLinePoint.tpl');
}
?>
