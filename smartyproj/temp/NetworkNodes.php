<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/NetworkNodes_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
				$nodeid= $_POST['nodeid'];
//            	$id = $_POST['id'];
				$name = $_POST['name'];
		    	$NetworkBox = $_POST['NetworkBox'];
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
					print('nya?');//$query = '"inventoryNumber"='.$invnum;
            	}
                else
                {
					$query = '"name"=\''.$name.'\',"NetworkBox"=\''.$NetworkBox.'\',"note"=\''.$note.'\',"OpenGIS"=\''.$opengis.'\',"SettlementGeoSpatial"='.$geospartial.',"Building"='.$building.',"Apartment"='.$apartment;
                	//$query = '"NetworkBoxType"='.$boxtypeid.', "inventoryNumber"='.$invnum;
                }
            	NetworkNode_UPDATE($query,'id='.$nodeid);
            	header("Refresh: 2; url=NetworkNodes.php");
            	print('Ящик изменен!');
			}
		else
		if ($_POST['mode'] == 2)
			{
				//$nodeid = $_POST['nodeid'];
				$name = $_POST['name'];
		    	$networkbox = $_POST['NetworkBox'];
		    	$note = $_POST['note'];
		    	$opengis = $_POST['OpenGIS'];
		    	if ($_POST['SettlementGeoSpatial'] == '') { $geospartial = 'NULL'; }
		    	if ($_POST['SettlementGeoSpatial'] != '') { $geospartial = $_POST['SettlementGeoSpatial']; }
		    	if ($_POST['Building'] == '') { $building = 'NULL'; }
		    	if ($_POST['Building'] != '') { $building = $_POST['Building']; }
		    	if ($_POST['Apartment'] == '') { $apartment = 'NULL'; }
		    	if ($_POST['Apartment'] != '') { $apartment = $_POST['Apartment']; }
		    	//$geospartical = $_POST['SettlementGeoSpatial'];
		    	//$building = $_POST['Building'];
		    	//$Apartment = $_POST['Apartment'];
				//$boxtype = $_POST['networkboxtypes'];
				//$invnum = $_POST['invnum'];
				//NetworkBox_INSERT('("NetworkBoxType", "inventoryNumber") VALUES ('.$boxtype.', '.$invnum.')');
				NetworkNode_INSERT('(name, "NetworkBox", note, "OpenGIS", "SettlementGeoSpatial", "Building", "Apartment") VALUES (\''.$name.'\', '.$networkbox.', \''.$note.'\', \''.$opengis.'\', '.$geospartial.', '.$building.', '.$apartment.')');
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
			$res = NetworkNode_SELECT('*','','');
		}
		else
		{
    		$res = NetworkNode_SELECT('*','','"id"='.$nodeid);
    		if (pg_num_rows($res) < 1)
			{
				print('Нода с таким ID не существует!<br />
				<a href="NetworkBox.php">Назад</a>');
				die();
			}
		}
		while ($boxrow = pg_fetch_array($res))
  		{
				$box_arr[] = $boxrow['id'];
				$box_arr[] = $boxrow['name'];
		    	$box_arr[] = $boxrow['NetworkBox'];
		    	$box_arr[] = $boxrow['note'];
		    	$box_arr[] = $boxrow['OpenGIS'];
		    	$box_arr[] = $boxrow['SettlementGeoSpatial'];
		    	$box_arr[] = $boxrow['Building'];
		    	$box_arr[] = $boxrow['Apartment'];
				$box_arr[] = '<a href="NetworkNodes.php?mode=change&nodeid='.$boxrow['id'].'">Изменить</a>';
				$box_arr[] = '<a href="NetworkNodes.php?mode=delete&nodeid='.$boxrow['id'].'">Удалить</a>';

		/*	$box_arr[] = $boxrow['id'];
			$box_arr[] = $boxrow['NetworkBoxType'];
			$box_arr[] = $boxrow['inventoryNumber'];
			$box_arr[] = '<a href="NetworkBox.php?mode=change&boxid='.$boxrow['id'].'">Изменить</a>';
			$box_arr[] = '<a href="NetworkBox.php?mode=delete&boxid='.$boxrow['id'].'">Удалить</a>';*/
	  	}
		$smarty->assign("data",$box_arr);
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['nodeid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}

    	$smarty->assign("mode","change");

    	$res = NetworkNode_SELECT('*','','id='.$_GET['nodeid']);
		while ($nodeinfo = pg_fetch_array($res))
		{
				$smarty->assign("id",$nodeinfo['id']);
		//		$smarty->assign("invNum",$boxinfo['inventoryNumber']);	
				$smarty->assign("name",$nodeinfo['name']);
		    	$smarty->assign("NetworkBox",$nodeinfo['NetworkBox']);
		    	$smarty->assign("note",$nodeinfo['note']);
		    	$smarty->assign("OpenGIS",$nodeinfo['OpenGIS']);
		    	$smarty->assign("SettlementGeoSpatial",$nodeinfo['SettlementGeoSpatial']);
		    	$smarty->assign("Building",$nodeinfo['Building']);
		    	$smarty->assign("Apartment",$nodeinfo['Apartment']);
		}
		if (pg_num_rows($res) < 1)
		{
			print('Ящика с таким ID не существует!<br />
			<a href="NetworkNodes.php">Назад</a>');
			die();
		}
    	$res = NetworkNode_SELECT('id, "name"','','');
		while ($boxtype = pg_fetch_array($res))
		{
			$combobox_netnode_values[] = $boxtype['id'];
			$combobox_netnode_name[] = $boxtype['name'];
			//$combobox_netbox_text[] = $boxtype['marking'];
		}

		$smarty->assign("combobox_netnode_values",$combobox_netnode_values);
		$smarty->assign("combobox_netnode_name",$combobox_netnode_name);
		$smarty->assign("combobox_netnode_selected",$nodeinfo['id']);
	}
	elseif ($_GET['mode'] == 'add')
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}

		$smarty->assign("mode","add");

    /*	$res = NetworkNode_SELECT('id, "name"','','');
		while ($boxtype = pg_fetch_array($res))
		{
			$combobox_netbox_values[] = $boxtype['id'];
			$combobox_netbox_invnum[] = $boxtype['inventoryNumber'];
			
			//$combobox_netbox_text[] = $boxtype['marking'];
		}
        $smarty->assign("name",$nodeinfo['name']);
		$smarty->assign("NetworkBox",$nodeinfo['NetworkBox']);
		$smarty->assign("note",$nodeinfo['note']);
		$smarty->assign("OpenGIS",$nodeinfo['OpenGIS']);
		$smarty->assign("SettlementGeoSpatial",$nodeinfo['SettlementGeoSpatial']);
		$smarty->assign("Building",$nodeinfo['Building']);
		$smarty->assign("Apartment",$nodeinfo['Apartment']);
		*/    	
		//$smarty->assign("combobox_netbox_values",$combobox_netbox_values);
		//$smarty->assign("combobox_netbox_text",$combobox_netbox_text);
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['boxid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
    	NetworkNode_DELETE('id='.$_GET['nodeid']);
    	header("Refresh: 2; url=NetworkNodes.php");
		print("Нода удалена!");
		die();
 	}

	$smarty->display('NetworkNodes.tpl');
}
?>
