<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/CableType.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	$back = $_POST['back'];
	if ($_POST['mode'] == 1) {
		$id = $_POST['id'];		
	    $CableTypes = $_POST['cabletypes'];
		$length = $_POST['length'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		$res = CableLine_Mod($id, $CableTypes, $length, $name, $comment);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=".$back);
	        $message = 'Кабель изменен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	elseif ($_POST['mode'] == 2) {
		$CableTypes = $_POST['cabletypes'];
		$length = $_POST['length'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		$res = CableLine_Add($CableTypes, $length, $name, $comment);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=".$back);
	        $message = 'Кабель добавлен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	showMessage($message, $error);
}
else {
    if (!isset($_GET['mode'])) {
		if (isset($_GET['sort'])) {
			$sort = $_GET['sort'];
		} else {
			$sort = 0;
		}
		if (!isset($_GET['page'])) {
			$page = 1;
		} else {
			$page = $_GET['page'];
		}
		if (!isset($_GET['typeid'])) {
			$res = getCableLineList($sort, '', $config['LinesPerPage'], ($page-1)*$config['LinesPerPage']);
		} else {
			$wr['CableType'] = $_GET['typeid'];
			$res = getCableLineList($sort, $wr, $config['LinesPerPage'], ($page-1)*$config['LinesPerPage']);
    		if ($res['count'] < 1) {
				$message = 'Кабелей с таким типом ID не существует!<br />
				<a href="CableLine.php">Назад</a>';
				showMessage($message, 0);
			}
			$pagesLink = 'typeid='.$_GET['typeid'];
		}
		$pagesLink = 'CableLine.php?sort='.$sort.'&'.$pagesLink.'&';
		//$pages = genPages('CableLine.php?sort='.$sort.'&', ceil($res['allPages'] / $config['LinesPerPage']), $page);
		$pages = genPages($pagesLink, ceil($res['allPages'] / $config['LinesPerPage']), $page);
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i < $res['count']) {	  		$cableLine_arr[] = '<a href="CableLine.php?mode=charac&cablelineid='.$rows[$i]['id'].'">'.$rows[$i]['name'].'</a>';	  		
			$cableLine_arr[] = '<a href="CableType.php?mode=charac&cabletypeid='.$rows[$i]['CableType'].'">'.$rows[$i]['marking'].'</a>';
			$cableLine_arr[] = $rows[$i]['manufacturer'];
			$cableLine_arr[] = $rows[$i]['length'];
			$cableLine_arr[] = '<a href="CableLine.php?mode=change&cablelineid='.$rows[$i]['id'].'">Изменить</a>';
			unset($wr);
			$wr['CableLine'] = $rows[$i]['id'];
			$res2 = CableLinePoint_SELECT($wr);
			if ($res2['count'] == 0) {
				$cableLine_arr[] = '<a href="CableLine.php?mode=delete&cablelineid='.$rows[$i]['id'].'">Удалить</a>';
			} else {
				$cableLine_arr[] = '';
			}
	  	}
		$smarty->assign("data", $cableLine_arr);
		$smarty->assign("pages", $pages);
	} elseif (($_GET['mode'] == 'charac') and (isset($_GET['cablelineid']))) {
	    $smarty->assign("mode", "charac");

		$cableLineId = $_GET['cablelineid'];
		$res = CableLine_Info($cableLineId);
		$rows = $res['CableLine']['rows'];
		if ($res['CableLine']['count'] < 1) {			$message = 'Кабеля с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>';
			showMessage($message, 0);
		}
		$changeDelete = '<a href="CableLine.php?mode=change&cablelineid='.$cableLineId.'">Изменить</a>';
		$wr['CableLine'] = $cableLineId;
		$res2 = CableLinePoint_SELECT($wr);
		if ($res2['count'] == 0) {
			$changeDelete .= '<br><a href="CableLine.php?mode=delete&cablelineid='.$cableLineId.'">Удалить</a>';
		}
		
		$smarty->assign("id", $rows[0]['id']);
		$smarty->assign("CableType", '<a href="CableType.php?mode=charac&cabletypeid='.$rows[0]['CableTypeId'].'">'.$rows[0]['CableTypeMarking'].'</a>');
		$smarty->assign("manufacturer", $rows[0]['CableTypeManufacturer']);
		$smarty->assign("length", $rows[0]['length']);
		$smarty->assign("name", $rows[0]['name']);
		$smarty->assign("comment", nl2br($rows[0]['comment']));
		$smarty->assign("ChangeDelete", $changeDelete);
		$smarty->assign("AddPoint", '<a href="CableLinePoint.php?mode=add&cablelineid='.$cableLineId.'">Добавить точку</a>');			
		
		if ($res['CableLinePoints']['count'] > 0) {			$rows2 = $res['CableLinePoints']['rows'];			$i = -1;
		  	while (++$i < $res['CableLinePoints']['count']) {		  		$cableLine_arr[] = $rows2[$i]['id'];
	  			//$cableLine_arr[] = $rows2[$i]['meterSign'];
				//$cableLine_arr[] = '<a href="NetworkNodes.php?mode=charac&nodeid='.$rows2[$i]['NetworkNode'].'">'.$rows2[$i]['name'].'</a>';
				$cableLine_arr[] = $rows2[$i]['OpenGIS'];
				//$cableLine_arr[] = $rows2[$i]['Apartment'];
				//$cableLine_arr[] = $rows2[$i]['Building'];
				//$cableLine_arr[] = $rows2[$i]['SettlementGeoSpatial'];
				$cableLine_arr[] = '<a href="CableLinePoint.php?mode=change&cablelinepointid='.$rows2[$i]['id'].'&cablelineid='.$cableLineId.'">Изменить</a>';
				$cableLine_arr[] = '<a href="CableLinePoint.php?mode=delete&cablelinepointid='.$rows2[$i]['id'].'">Удалить</a>';
		  	}
			$smarty->assign("data", $cableLine_arr);			
		}
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['cablelineid']))) {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			showMessage($message, 0);
		}
    	$smarty->assign("mode", "add_change");
		$smarty->assign("mod", "1");
		$smarty->assign("back", getenv("HTTP_REFERER"));

		$wr['id'] = $_GET['cablelineid'];
    	$res = CableLine_SELECT('', $wr);
    	if ($res['count'] < 1) {
			$message = 'Кабеля с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>';
			showMessage($message, 0);
		}
    	$rows = $res['rows'];
		$smarty->assign("id", $rows[0]['id']);
		$cableTypeId = $rows[0]['CableType'];
		$smarty->assign("length", $rows[0]['length']);
		$smarty->assign("comment", $rows[0]['comment']);
		$smarty->assign("name", $rows[0]['name']);

		$res = CableType_SELECT('', '');
		$rows = $res['rows'];
		$i = -1;
		while (++$i < $res['count']) {
			$comboBox_CableType_Values[] = $rows[$i]['id'];
			$comboBox_CableType_Text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_cabletype_values", $comboBox_CableType_Values);
		$smarty->assign("combobox_cabletype_text", $comboBox_CableType_Text);
		$smarty->assign("combobox_cabletype_selected", $cableTypeId);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			showMessage($message, 0);
		}
		$smarty->assign("mode", "add_change");
		$smarty->assign("mod", "2");
		$smarty->assign("back", getenv("HTTP_REFERER"));

		$res = CableType_SELECT('', '');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$comboBox_CableType_Values[] = $rows[$i]['id'];
			$comboBox_CableType_Text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_cabletype_values", $comboBox_CableType_Values);
		$smarty->assign("combobox_cabletype_text", $comboBox_CableType_Text);
		$smarty->assign("combobox_cabletype_selected", $cableTypeId);
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['cablelineid']))) {
		if ($_SESSION['class'] > 1)	{			die("!!!");
		}		$wr['id'] = $_GET['cablelineid'];
		CableLine_DELETE($wr);
    	header("Refresh: 2; url=".getenv("HTTP_REFERER"));
		$message = "Кабель удален!";
		showMessage($message, 0);
 	}

	$smarty->display('CableLine.tpl');
}
?>
