<?php
require_once("auth.php");
require_once("smarty.php");
require_once("/func/NetworkNode.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	if ($_POST['mode'] == 1) {
		$id = $_POST['id'];
		$name = $_POST['name'];
	   	$NetworkBox = $_POST['boxes'];
	   	$note = $_POST['note'];
	   	$OpenGIS = $_POST['OpenGIS'];
	   	if ($_POST['SettlementGeoSpatial'] == '') { $SettlementGeoSpatial = 'NULL'; }
	   	if ($_POST['SettlementGeoSpatial'] != '') { $SettlementGeoSpatial = $_POST['SettlementGeoSpatial']; }
	   	if ($_POST['Building'] == '') { $building = 'NULL'; }
	   	if ($_POST['Building'] != '') { $building = $_POST['Building']; }
	   	if ($_POST['Apartment'] == '') { $apartment = 'NULL'; }
	   	if ($_POST['Apartment'] != '') { $apartment = $_POST['Apartment']; }

		$res = NetworkNode_Mod($id,$name,$NetworkBox,$note,$OpenGIS,$SettlementGeoSpatial,$building,$apartment);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=NetworkNodes.php");
	        $message = 'Узел изменен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 2) {
		$name = $_POST['name'];
		$NetworkBox = $_POST['boxes'];
		$note = $_POST['note'];
		$OpenGIS = $_POST['OpenGIS'];
		if ($_POST['SettlementGeoSpatial'] == '') { $SettlementGeoSpatial = 'NULL'; }
		if ($_POST['SettlementGeoSpatial'] != '') { $SettlementGeoSpatial = $_POST['SettlementGeoSpatial']; }
		if ($_POST['Building'] == '') { $building = 'NULL'; }
		if ($_POST['Building'] != '') { $building = $_POST['Building']; }
		if ($_POST['Apartment'] == '') { $apartment = 'NULL'; }
		if ($_POST['Apartment'] != '') { $apartment = $_POST['Apartment']; }
		$res = NetworkNode_Add($name,$NetworkBox,$note,$OpenGIS,$SettlementGeoSpatial,$building,$apartment);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=NetworkNodes.php");
	        $message = 'Узел добавлен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	ShowMessage($message,$error);
} else {
    if (!isset($_GET['mode'])) {
		$NodeId = $_GET['nodeid'];
		if (!isset($_GET['nodeid'])) {
			$res = NetworkNode_SELECT($_GET['sort'],$_GET['FSort'],'');
		}
		else {
    		$wr['id'] = $NodeId;
    		$res = NetworkNode_SELECT($_GET['sort'],$_GET['FSort'],$wr);
		}
		if ($res['count'] < 1) {
			$message = 'Узла с таким ID не существует!<br />
			<a href="NetworkBox.php">Назад</a>';
			ShowMessage($message,0);
		}
		$rows = $res['rows'];
		$i = -1;
		while (++$i < $res['count']) {
			$node_arr[] = $rows[$i]['id'];
			$node_arr[] = '<a href="NetworkNodes.php?mode=charac&nodeid='.$rows[$i]['id'].'">'.$rows[$i]['name'].'</a>';
		    $node_arr[] = $rows[$i]['NetworkBox'];
		    $node_arr[] = $rows[$i]['note'];
		    $node_arr[] = $rows[$i]['OpenGIS'];
		    $node_arr[] = $rows[$i]['SettlementGeoSpatial'];
		    $node_arr[] = $rows[$i]['Building'];
		    $node_arr[] = $rows[$i]['Apartment'];
			$node_arr[] = '<a href="NetworkNodes.php?mode=change&nodeid='.$rows[$i]['id'].'">Изменить</a>';
			$node_arr[] = '<a href="NetworkNodes.php?mode=delete&nodeid='.$rows[$i]['id'].'">Удалить</a>';

	  	}
		$smarty->assign("data",$node_arr);
	} elseif (($_GET['mode'] == 'charac') and (isset($_GET['nodeid']))) {		$smarty->assign("mode","charac");
		$NodeId = $_GET['nodeid'];
		$res = GetNetworkNodeInfo($NodeId);
		$rows = $res['NetworkNode']['rows'][0];
		$ClpRows = $res['NetworkNode']['CableLinePoints']['rows'];

		$i = -1;
	  	while (++$i < $res['NetworkNode']['CableLinePoints']['count']) {
	  		$cableline_arr[] = $ClpRows[$i]['id'];
	  		$cableline_arr[] = $ClpRows[$i]['OpenGIS'];
	  		$cableline_arr[] = $ClpRows[$i]['CableLine'];
	  		$cableline_arr[] = $ClpRows[$i]['meterSign'];
			$cableline_arr[] = $ClpRows[$i]['NetworkNode'];
			$cableline_arr[] = $ClpRows[$i]['note'];
			$cableline_arr[] = $ClpRows[$i]['Apartment'];
			$cableline_arr[] = $ClpRows[$i]['Building'];
			$cableline_arr[] = $ClpRows[$i]['SettlementGeoSpatial'];
			$cableline_arr[] = '<a href="CableLinePoint.php?mode=change&cablelinepointid='.$ClpRows[$i]['id'].'">Изменить</a>';
			$cableline_arr[] = '<a href="CableLinePoint.php?mode=delete&cablelinepointid='.$ClpRows[$i]['id'].'">Удалить</a>';
	  	}

		$smarty->assign("data",$cableline_arr);
		$smarty->assign("id",$rows['id']);
		$smarty->assign("name",$rows['name']);
    	$smarty->assign("NetworkBox",$rows['NetworkBox']);
    	$smarty->assign("note",$rows['note']);
    	$smarty->assign("OpenGIS",$rows['OpenGIS']);
    	$smarty->assign("SettlementGeoSpatial",$rows['SettlementGeoSpatial']);
    	$smarty->assign("Building",$rows['Building']);
    	$smarty->assign("Apartment",$rows['Apartment']);
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['nodeid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			ShowMessage($message,0);
		}

    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['nodeid'];
    	$res = NetworkNode_SELECT(0,'',$wr);
    	if ($res['count'] < 1) {
			$message = 'Ящика с таким ID не существует!<br />
						<a href="NetworkNodes.php">Назад</a>';
			ShowMessage($message,0);
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("name",$rows[0]['name']);
    	$smarty->assign("NetworkBox",$rows[0]['NetworkBox']);
    	$smarty->assign("note",$rows[0]['note']);
    	$smarty->assign("OpenGIS",$rows[0]['OpenGIS']);
    	$smarty->assign("SettlementGeoSpatial",$rows[0]['SettlementGeoSpatial']);
    	$smarty->assign("Building",$rows[0]['Building']);
    	$smarty->assign("Apartment",$rows[0]['Apartment']);
    	$NetworkBox = $rows[0]['NetworkBox'];

    	$res = NetworkBox_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_box_values[] = $rows[$i]['id'];
			$combobox_box_text[] = $rows[$i]['inventoryNumber'];
		}
		$smarty->assign("combobox_box_values",$combobox_box_values);
		$smarty->assign("combobox_box_text",$combobox_box_text);
		$smarty->assign("combobox_boxtype_selected",$NetworkBox);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1)
		{
			$message = '!!!';
			ShowMessage($message,0);
		}

		$smarty->assign("mode","add");

		$res = NetworkBox_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_box_values[] = $rows[$i]['id'];
			$combobox_box_text[] = $rows[$i]['inventoryNumber'];
		}
		$smarty->assign("combobox_box_values",$combobox_box_values);
		$smarty->assign("combobox_box_text",$combobox_box_text);
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['nodeid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			ShowMessage($message,0);
		}
		$wr['id'] = $_GET['nodeid'];
    	NetworkNode_DELETE($wr);
    	header("Refresh: 2; url=NetworkNodes.php");
		$message = "Узел удален!";
		ShowMessage($message,0);		
 	}

	$smarty->display('NetworkNodes.tpl');
}
?>
