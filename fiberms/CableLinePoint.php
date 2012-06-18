<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/CableType.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	$back = $_POST['back'];
	if ($_POST['mode'] == 1) {
		$id = $_POST['id'];
		$OpenGIS = $_POST['OpenGIS'];
		$CableLine = /*$_POST['cablelines']*/'';
		$meterSign = $_POST['meterSign'];
		$networkNode = $_POST['networknodes'];
		$note = $_POST['note'];
		$Apartment = $_POST['Apartment'];
		$Building = $_POST['Building'];
		$SettlementGeoSpatial = $_POST['SettlementGeoSpatial'];
		$res = CableLinePoint_Mod($id,$OpenGIS,$CableLine,$meterSign,$networkNode,$note,$Apartment,$Building,$SettlementGeoSpatial);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=".$back);
	        $message = 'Точка изменена!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 2) {
		$OpenGIS = $_POST['OpenGIS'];
		$CableLine = $_POST['cablelineid'];
		$meterSign = $_POST['meterSign'];
		$networkNode = $_POST['networknodes'];
		$note = $_POST['note'];
		$Apartment = $_POST['Apartment'];
		$Building = $_POST['Building'];
		$SettlementGeoSpatial = $_POST['SettlementGeoSpatial'];
		$res = CableLinePoint_Add($OpenGIS,$CableLine,$meterSign,$networkNode,$note,$Apartment,$Building,$SettlementGeoSpatial);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=".$back);
	        $message = 'Точка добавлена!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	showMessage($message,$error);
} else {
    if (!isset($_GET['mode'])) {
    	die();
		$typeId = $_GET['typeid'];
		$res = CableLinePoint_SELECT('','');
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i < $res['count']) {	  		$cableLine_arr[] = $rows[$i]['id'];
	  		$cableLine_arr[] = $rows[$i]['OpenGIS'];
	  		$cableLine_arr[] = $rows[$i]['CableLine'];
	  		$cableLine_arr[] = $rows[$i]['meterSign'];
			$cableLine_arr[] = $rows[$i]['NetworkNode'];
			$cableLine_arr[] = $rows[$i]['note'];
			$cableLine_arr[] = $rows[$i]['Apartment'];
			$cableLine_arr[] = $rows[$i]['Building'];
			$cableLine_arr[] = $rows[$i]['SettlementGeoSpatial'];
			$cableLine_arr[] = '<a href="CableLinePoint.php?mode=change&cablelinepointid='.$rows[$i]['id'].'">Изменить</a>';
			$cableLine_arr[] = '<a href="CableLinePoint.php?mode=delete&cablelinepointid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$cableLine_arr);
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['cablelinepointid']))) {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			showMessage($message,0);
		}
		require_once("backend/NetworkNode.php");
    	$smarty->assign("mode","add_change");
		$smarty->assign("disabled","disabled");
		$smarty->assign("mod","1");
		$smarty->assign("cablelineid",$_GET['cablelineid']);
		$smarty->assign("back",getenv("HTTP_REFERER"));

		$wr['id'] = $_GET['cablelinepointid'];
    	$res = CableLinePoint_SELECT($wr);
    	if ($res['count'] < 1) {
			$message = 'Точки с таким ID не существует!<br />
			<a href="CableLinePoint.php">Назад</a>';
			showMessage($message,0);
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("OpenGIS",$rows[0]['OpenGIS']);
		$cableLineId = $rows[0]['CableLine'];
		$networkNodeId = $rows[0]['NetworkNode'];
		if ($networkNodeId == '') {
			$networkNodeId = 'NULL';
		}
		$smarty->assign("meterSign",$rows[0]['meterSign']);
		$smarty->assign("note",$rows[0]['note']);
		$smarty->assign("Apartment",$rows[0]['Apartment']);
		$smarty->assign("Building",$rows[0]['Building']);
		$smarty->assign("SettlementGeoSpatial",$rows[0]['SettlementGeoSpatial']);

		$res = CableLine_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i < $res['count']) {
			$comboBox_CableLine_Values[] = $rows[$i]['id'];
			$comboBox_CableLine_Text[] = $rows[$i]['length'];
		}
		$smarty->assign("combobox_cableline_values",$comboBox_CableLine_Values);
		$smarty->assign("combobox_cableline_text",$comboBox_CableLine_Text);
		$smarty->assign("combobox_cableline_selected",$cableLineId);

		$res = NetworkNode_SELECT(0,'','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i < $res['count']) {
			$comboBox_NetworkNode_Values[] = $rows[$i]['id'];
			$comboBox_NetworkNode_Text[] = $rows[$i]['name'];
		}
		$comboBox_NetworkNode_Values[] = 'NULL';
		$comboBox_NetworkNode_Text[] = 'Нет';
		$smarty->assign("combobox_networknode_values",$comboBox_NetworkNode_Values);
		$smarty->assign("combobox_networknode_text",$comboBox_NetworkNode_Text);
		$smarty->assign("combobox_networknode_selected",$networkNodeId);
	} elseif ($_GET['mode'] == 'charac') {
		
	}
	elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			showMessage($message,0);
		}
		require_once("backend/NetworkNode.php");
				$smarty->assign("mode","add_change");
		$smarty->assign("mod","2");
		$smarty->assign("cablelineid",$_GET['cablelineid']);
		$smarty->assign("back",getenv("HTTP_REFERER"));

		/*$res = CableLine_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$comboBox_CableLine_Values[] = $rows[$i]['id'];
			$comboBox_CableLine_Text[] = $rows[$i]['length'];
		}
		$smarty->assign("combobox_cableline_values",$comboBox_CableLine_Values);
		$smarty->assign("combobox_cableline_text",$comboBox_CableLine_Text);
		$smarty->assign("combobox_cableline_selected",$cableLineId);*/

		$res = NetworkNode_SELECT(0,'','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i < $res['count']) {
			$comboBox_NetworkNode_Values[] = $rows[$i]['id'];
			$comboBox_NetworkNode_Text[] = $rows[$i]['name'];
		}
		$comboBox_NetworkNode_Values[] = 'NULL';
		$comboBox_NetworkNode_Text[] = 'Нет';
		$smarty->assign("combobox_networknode_values",$comboBox_NetworkNode_Values);
		$smarty->assign("combobox_networknode_text",$comboBox_NetworkNode_Text);
		$smarty->assign("combobox_networknode_selected",$networkNodeId);
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['cablelinepointid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';			showMessage($message,0);
		}		$wr['id'] = $_GET['cablelinepointid'];
		CableLinePoint_DELETE($wr);
    	header("Refresh: 2; url=".getenv("HTTP_REFERER"));
		$message = "Точка удалена!";
		showMessage($message,0);
 	}

	$smarty->display('CableLinePoint.tpl');
}
?>
