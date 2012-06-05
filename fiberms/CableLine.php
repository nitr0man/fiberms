<?php
require_once("auth.php");
require_once("smarty.php");
require_once("/func/CableType.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	if ($_POST['mode'] == 1) {
		$id = $_POST['id'];
		$OpenGIS = $_POST['OpenGIS'];
	    $CableTypes = $_POST['cabletypes'];
		$length = $_POST['length'];
		$comment = $_POST['comment'];
/*		$upd['OpenGIS'] = "NULL";
	    $upd['CableType'] = "$cabletypes";
	    $upd['length'] = "$length";
	    $upd['comment'] = "'$comment'";
	    $wr['id'] = $id;
		CableLine_UPDATE($upd,$wr); */
		$res = CableLine_Mod($id,$OpenGIS,$CableTypes,$length,$comment);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=CableLine.php");
	        $message = 'Кабель изменен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	elseif ($_POST['mode'] == 2) {
		$OpenGIS = $_POST['OpenGIS'];
		$CableTypes = $_POST['cabletypes'];
		$length = $_POST['length'];
		$comment = $_POST['comment'];
/*		$ins['OpenGIS'] = "NULL";
	    $ins['CableType'] = "$cabletypes";
	    $ins['length'] = "$length";
	    $ins['comment'] = "'$comment'";
	    CableLine_INSERT($ins);*/
		$res = CableLine_Add($OpenGIS,$CableTypes,$length,$comment);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=CableLine.php");
	        $message = 'Кабель добавлен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	ShowMessage($message,$error);
}
else {
    if (!isset($_GET['mode'])) {
		$typeid = $_GET['typeid'];
		if (!isset($_GET['typeid'])) {
			$res = CableLine_SELECT('','');
		} else {
			$wr['CableType'] = $typeid;
			$res = CableLine_SELECT('',$wr);
    		if ($res['count'] < 1) {
				$message = 'Кабелей с таким типом ID не существует!<br />
				<a href="CableLine.php">Назад</a>';
				ShowMessage($message,0);
			}
		}
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i < $res['count']) {
	  		$cableline_arr[] = $rows[$i]['OpenGIS'];
			$cableline_arr[] = $rows[$i]['CableType'];
			$cableline_arr[] = $rows[$i]['length'];
			$cableline_arr[] = $rows[$i]['comment'];
			$cableline_arr[] = '<a href="CableLine.php?mode=change&cablelineid='.$rows[$i]['id'].'">Изменить</a>';
			$cableline_arr[] = '<a href="CableLine.php?mode=delete&cablelineid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$cableline_arr);
	} elseif (($_GET['mode'] == 'charac') and (isset($_GET['cablelineid']))) {
	    $smarty->assign("mode","charac");

		$CableLineId = $_GET['cablelineid'];
		$res = CableLine_Info($CableLineId);
		$rows = $res['CableLine']['rows'];
		if ($res['CableLine']['count'] < 1) {
			<a href="CableType.php">Назад</a>';
			ShowMessage($message,0)
		}
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("OpenGIS",$rows[0]['OpenGIS']);
		$smarty->assign("CableType",$rows[0]['CableTypeMarking']);
		$smarty->assign("length",$rows[0]['length']);
		$smarty->assign("comment",$rows[0]['comment']);
		if ($res['CableLinePoints']['count'] > 0) {
		  	while (++$i < $res['CableLinePoints']['count']) {
		  		$CableLine_arr[] = $rows2[$i]['OpenGIS'];
	  			$CableLine_arr[] = $rows2[$i]['CableLine'];
	  			$CableLine_arr[] = $rows2[$i]['meterSign'];
				$CableLine_arr[] = $rows2[$i]['NetworkNode'];
				$CableLine_arr[] = $rows2[$i]['note'];
				$CableLine_arr[] = $rows2[$i]['Apartment'];
				$CableLine_arr[] = $rows2[$i]['Building'];
				$CableLine_arr[] = $rows2[$i]['SettlementGeoSpatial'];
				$CableLine_arr[] = '<a href="CableLinePoint.php?mode=change&cablelinepointid='.$rows2[$i]['id'].'">Изменить</a>';
				$CableLine_arr[] = '<a href="CableLinePoint.php?mode=delete&cablelinepointid='.$rows2[$i]['id'].'">Удалить</a>';
		  	}
			$smarty->assign("data",$CableLine_arr);
			$smarty->assign("AddPoint",'<a href="CableLinePoint.php?mode=add">Добавить точку</a>');
		}
//        print_r($res);
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
		$smarty->assign("data",$cableline_arr); */
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['cablelineid']))) {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			ShowMessage($message,0)
		}


		$wr['id'] = $_GET['cablelineid'];
    	$res = CableLine_SELECT('',$wr);
    	if ($res['count'] < 1) {
			$message = 'Кабеля с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>';
			ShowMessage($message,0)
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
		while (++$i<$res['count']) {
			$combobox_cabletype_values[] = $rows[$i]['id'];
			$combobox_cabletype_text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_cabletype_values",$combobox_cabletype_values);
		$smarty->assign("combobox_cabletype_text",$combobox_cabletype_text);
		$smarty->assign("combobox_cabletype_selected",$cabletypeid);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			ShowMessage($message,0)
		}


		$res = CableType_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_cabletype_values[] = $rows[$i]['id'];
			$combobox_cabletype_text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_cabletype_values",$combobox_cabletype_values);
		$smarty->assign("combobox_cabletype_text",$combobox_cabletype_text);
		$smarty->assign("combobox_cabletype_selected",$cabletypeid);
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['cablelineid']))) {
		if ($_SESSION['class'] > 1)	{
		}
		$wr['id'] = $_GET['cablelineid'];
		CableLine_DELETE($wr);
    	header("Refresh: 2; url=CableLine.php");
		$message = "Тип удален!";
		ShowMessage($message,0);
 	}

	$smarty->display('CableLine.tpl');
}
?>