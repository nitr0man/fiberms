<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/NetworkNodes_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
				$nodeid= $_POST['id'];
//            	$id = $_POST['id'];
				$name = $_POST['name'];
		    	$NetworkBox = $_POST['boxes'];
		    	$note = $_POST['note'];
		    	$opengis = $_POST['OpenGIS'];
		    	if ($_POST['SettlementGeoSpatial'] == '') { $geospartial = 'NULL'; }
		    	if ($_POST['SettlementGeoSpatial'] != '') { $geospartial = $_POST['SettlementGeoSpatial']; }
		    	if ($_POST['Building'] == '') { $building = 'NULL'; }
		    	if ($_POST['Building'] != '') { $building = $_POST['Building']; }
		    	if ($_POST['Apartment'] == '') { $apartment = 'NULL'; }
		    	if ($_POST['Apartment'] != '') { $apartment = $_POST['Apartment']; }
		  //  	$apartment = $_POST['Apartment'];

            	if ($nodeid == '')
            	{
					print('nya?');
					die();
            	}
                else
                {
					$query = '"name"=\''.$name.'\',"NetworkBox"=\''.$NetworkBox.'\',"note"=\''.$note.'\',"OpenGIS"=\''.$opengis.'\',"SettlementGeoSpatial"='.$geospartial.',"Building"='.$building.',"Apartment"='.$apartment;
                }
                $upd['name'] = "'$name'";
                $upd['NetworkBox'] = "'$NetworkBox'";
                $upd['note'] = "'$note'";
                $upd['OpenGIS'] = "'$opengis'";
                $upd['SettlementGeoSpatial'] = "$geospartial";
                $upd['Building'] = "$building";
                $upd['Apartment'] = "$apartment";
                $wr['id'] = $nodeid;
            	//NetworkNode_UPDATE($query,'id='.$nodeid);
            	NetworkNode_UPDATE($upd,$wr);
            	header("Refresh: 2; url=NetworkNodes.php");
            	print('Ящик изменен!');
			}
		else
		if ($_POST['mode'] == 2)
			{
				//$nodeid = $_POST['nodeid'];
				$name = $_POST['name'];
		    	$networkbox = $_POST['boxes'];
		    	$note = $_POST['note'];
		    	$opengis = $_POST['OpenGIS'];
		    	if ($_POST['SettlementGeoSpatial'] == '') { $geospartial = 'NULL'; }
		    	if ($_POST['SettlementGeoSpatial'] != '') { $geospartial = $_POST['SettlementGeoSpatial']; }
		    	if ($_POST['Building'] == '') { $building = 'NULL'; }
		    	if ($_POST['Building'] != '') { $building = $_POST['Building']; }
		    	if ($_POST['Apartment'] == '') { $apartment = 'NULL'; }
		    	if ($_POST['Apartment'] != '') { $apartment = $_POST['Apartment']; }
		    	$ins['name'] = "'$name'";
                $ins['NetworkBox'] = "'$networkbox'";
                $ins['note'] = "'$note'";
                $ins['OpenGIS'] = "'$opengis'";
                $ins['SettlementGeoSpatial'] = "$geospartial";
                $ins['Building'] = "$building";
                $ins['Apartment'] = "$apartment";
                NetworkNode_INSERT($ins);
				header("Refresh: 2; url=NetworkNodes.php");
				print("Нода успешно добавлена!");
			}
	}
else
{
/*	if (isset($_GET['boxid']))
	{
		$smarty->assign("body",'<body onload="javascript: GetBoxInfo('.$_GET['boxid'].',1);">');
	}
	else
	{
		$smarty->assign("body",'<body onload="javascript: GetBoxInfo(0,1);">');
	}  */
    if (!isset($_GET['mode']))
    {
		require_once("functions.php");
		$nodeid = $_GET['nodeid'];
		if (!isset($_GET['nodeid']))
		{
			$res = NetworkNode_SELECT('','');
		}
		else
		{
    		$wr['id'] = $nodeid;
    		$res = NetworkNode_SELECT('',$wr);
    		if ($res['count'] < 1)
			{
				print('Нода с таким ID не существует!<br />
				<a href="NetworkBox.php">Назад</a>');
				die();
			}
		}
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
  		{
			$node_arr[] = $rows[$i]['id'];
			$node_arr[] = $rows[$i]['name'];
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
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['nodeid'])))
	{
		require_once("func/NetworkBoxType_func.php");

		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}

    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['nodeid'];
    	$res = NetworkNode_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('Ящика с таким ID не существует!<br />
			<a href="NetworkNodes.php">Назад</a>');
			die();
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
		while (++$i<$res['count'])
		{
			$combobox_box_values[] = $rows[$i]['id'];
			$combobox_box_text[] = $rows[$i]['inventoryNumber'];
		}
		$smarty->assign("combobox_box_values",$combobox_box_values);
		$smarty->assign("combobox_box_text",$combobox_box_text);
		$smarty->assign("combobox_boxtype_selected",$NetworkBox);
		/*while ($boxtype = pg_fetch_array($res))
		{
			$combobox_netnode_values[] = $boxtype['id'];
			$combobox_netnode_name[] = $boxtype['name'];
			//$combobox_netbox_text[] = $boxtype['marking'];
		}

		$smarty->assign("combobox_netnode_values",$combobox_netnode_values);
		$smarty->assign("combobox_netnode_name",$combobox_netnode_name);
		$smarty->assign("combobox_netnode_selected",$nodeinfo['id']);*/
	}
	elseif ($_GET['mode'] == 'add')
	{
		require_once("func/NetworkBoxType_func.php");

		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}

		$smarty->assign("mode","add");

		$res = NetworkBox_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_box_values[] = $rows[$i]['id'];
			$combobox_box_text[] = $rows[$i]['inventoryNumber'];
		}
		$smarty->assign("combobox_box_values",$combobox_box_values);
		$smarty->assign("combobox_box_text",$combobox_box_text);
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['nodeid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
		$wr['id'] = $_GET['nodeid'];
    	NetworkNode_DELETE($wr);
    	header("Refresh: 2; url=NetworkNodes.php");
		print("Нода удалена!");
		die();
 	}

	$smarty->display('NetworkNodes.tpl');
}
?>
