<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/NetworkNode.php");
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
		if ($_POST['OpenGIS'] == '') { $OpenGIS = 'NULL'; }
		if ($_POST['OpenGIS'] != '') { $OpenGIS = $_POST['OpenGIS']; }
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
		require_once('backend/CableType.php');
		
		if (!isset($_GET['page'])) {
			$page = 1;
		} else {
			$page = $_GET['page'];
		}
		if (isset($_GET['sort'])) {
			$sort = $_GET['sort'];
		} else {
			$sort = 0;
		}
		$NodeId = $_GET['nodeid'];
		if (!isset($_GET['nodeid'])) {
			$res = GetNetworkNodeList_NetworkBoxName($sort,$_GET['FSort'],'',$config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
		}
		else {
    		$wr['id'] = $NodeId;
			$res = GetNetworkNodeList_NetworkBoxName($sort,$_GET['FSort'],$wr,$config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
		}
		if ($res['count'] < 1) {
			$message = 'Узла с таким ID не существует!<br />
			<a href="NetworkBox.php">Назад</a>';
			ShowMessage($message,0);
		}
		$pages = GenPages('NetworkNodes.php?sort='.$sort.'&',ceil($res['AllPages']/$config['LinesPerPage']),$page);
		$rows = $res['rows'];
		$i = -1;
		while (++$i < $res['count']) {
			$node_arr[] = $rows[$i]['id'];
			$node_arr[] = '<a href="NetworkNodes.php?mode=charac&nodeid='.$rows[$i]['id'].'">'.$rows[$i]['name'].'</a>';
			$node_arr[] = '<a href="NetworkBox.php?mode=charac&boxid='.$rows[$i]['NetworkBox'].'">'.$rows[$i]['inventoryNumber'].'</a>';
		    $node_arr[] = $rows[$i]['OpenGIS'];
		    $node_arr[] = $rows[$i]['SettlementGeoSpatial'];
		    $node_arr[] = $rows[$i]['Building'];
		    $node_arr[] = $rows[$i]['Apartment'];
			$node_arr[] = '<a href="NetworkNodes.php?mode=change&nodeid='.$rows[$i]['id'].'">Изменить</a>';
			$wr['NetworkNode'] = $rows[$i]['id'];
			$res2 = CableLinePoint_SELECT($wr);
			if ($res2['count'] == 0) {
				$node_arr[] = '<a href="NetworkNodes.php?mode=delete&nodeid='.$rows[$i]['id'].'">Удалить</a>';
			} else {
				$node_arr[] = '';
			}

	  	}
		$smarty->assign("data",$node_arr);
		$smarty->assign("pages",$pages);
	} elseif (($_GET['mode'] == 'charac') and (isset($_GET['nodeid']))) {		$smarty->assign("mode","charac");
		require_once("backend/FS.php");
		$NodeId = $_GET['nodeid'];
		$res = GetNetworkNodeInfo($NodeId);
		$rows = $res['NetworkNode']['rows'][0];
		$ClpRows = $res['NetworkNode']['CableLinePoints']['rows'];

		$i = -1;
	  	while (++$i < $res['NetworkNode']['CableLinePoints']['count']) {
	  		$cableline_arr[] = $ClpRows[$i]['id'];
	  		$cableline_arr[] = $ClpRows[$i]['OpenGIS'];
	  		$cableline_arr[] = '<a href="CableLine.php?mode=charac&cablelineid='.$ClpRows[$i]['CableLine'].'">'.$ClpRows[$i]['clname'].'</a>';
	  		$cableline_arr[] = $ClpRows[$i]['meterSign'];
			$cableline_arr[] = '<a href="CableLinePoint.php?mode=change&cablelinepointid='.$ClpRows[$i]['id'].'">Изменить</a>';
			$FiberSpliceCount = GetFiberSpliceCount($ClpRows[$i]['id']);
			if ($FiberSpliceCount == 0) {
				$cableline_arr[] = '<a href="CableLinePoint.php?mode=delete&cablelinepointid='.$ClpRows[$i]['id'].'">Удалить</a>';
			} else {
				$cableline_arr[] = '';
			}
	  	}
		$FiberSpliceCount = GetFiberSpliceCount_NetworkNode($NodeId);
		$ChangeDelete = '<br><a href="NetworkNodes.php?mode=change&nodeid='.$NodeId.'">Изменить</a>';
		$wr['NetworkNode'] = $NodeId;
		$res2 = CableLinePoint_SELECT($wr);
		if ($res2['count'] == 0) {
			$ChangeDelete .= '<br><a href="NetworkNodes.php?mode=delete&nodeid='.$NodeId.'">Удалить</a>';
		}
		
		$smarty->assign("data",$cableline_arr);
		$smarty->assign("id",$rows['id']);
		$smarty->assign("name",$rows['name']);
    	$smarty->assign("NetworkBox",$rows['inventoryNumber']);
		$smarty->assign("FiberSpliceCount",$FiberSpliceCount);
    	$smarty->assign("note",nl2br($rows['note']));
    	$smarty->assign("OpenGIS",$rows['OpenGIS']);
    	$smarty->assign("SettlementGeoSpatial",$rows['SettlementGeoSpatial']);
    	$smarty->assign("Building",$rows['Building']);
    	$smarty->assign("Apartment",$rows['Apartment']);
		$smarty->assign("ChangeDelete",$ChangeDelete);
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['nodeid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			ShowMessage($message,0);
		}

    	$smarty->assign("mode","add_change");
		$smarty->assign("mod","1");

		$wr['id'] = $_GET['nodeid'];
    	$res = NetworkNode_SELECT(0,'',$wr);
    	if ($res['count'] < 1) {
			$message = 'Узла с таким ID не существует!<br />
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

		$res = GetFreeNetworkBoxes($rows[0]['NetworkBox']);
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

		$smarty->assign("mode","add_change");
		$smarty->assign("mod","2");

		$res = GetFreeNetworkBoxes(-1);
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
