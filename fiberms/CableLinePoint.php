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
			header("Refresh: 3; url=".$back);
	        $message = 'Точка добавлена!';
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
			ShowMessage($message,0);
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("OpenGIS",$rows[0]['OpenGIS']);
		$CableLineId = $rows[0]['CableLine'];
		$NetworkNodeId = $rows[0]['NetworkNode'];
		if ($NetworkNodeId == '') {
			$NetworkNodeId = 'NULL';
		}
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

		$res = NetworkNode_SELECT(0,'','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_networknode_values[] = $rows[$i]['id'];
			$combobox_networknode_text[] = $rows[$i]['name'];
		}
		$combobox_networknode_values[] = 'NULL';
		$combobox_networknode_text[] = 'Нет';
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
		require_once("backend/NetworkNode.php");
				$smarty->assign("mode","add_change");
		$smarty->assign("mod","2");
		$smarty->assign("cablelineid",$_GET['cablelineid']);
		$smarty->assign("back",getenv("HTTP_REFERER"));

		/*$res = CableLine_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_cableline_values[] = $rows[$i]['id'];
			$combobox_cableline_text[] = $rows[$i]['length'];
		}
		$smarty->assign("combobox_cableline_values",$combobox_cableline_values);
		$smarty->assign("combobox_cableline_text",$combobox_cableline_text);
		$smarty->assign("combobox_cableline_selected",$CableLineId);*/

		$res = NetworkNode_SELECT(0,'','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_networknode_values[] = $rows[$i]['id'];
			$combobox_networknode_text[] = $rows[$i]['name'];
		}
		$combobox_networknode_values[] = 'NULL';
		$combobox_networknode_text[] = 'Нет';
		$smarty->assign("combobox_networknode_values",$combobox_networknode_values);
		$smarty->assign("combobox_networknode_text",$combobox_networknode_text);
		$smarty->assign("combobox_networknode_selected",$NetworkNodeId);
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['cablelinepointid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';			ShowMessage($message,0);
		}		$wr['id'] = $_GET['cablelinepointid'];
		CableLinePoint_DELETE($wr);
    	header("Refresh: 2; url=".getenv("HTTP_REFERER"));
		$message = "Точка удалена!";
		ShowMessage($message,0);
 	}

	$smarty->display('CableLinePoint.tpl');
}
?>
