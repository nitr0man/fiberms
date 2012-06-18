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
	    $CableTypes = $_POST['cabletypes'];
		$length = $_POST['length'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		$res = CableLine_Mod($id,$OpenGIS,$CableTypes,$length,$name,$comment);
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
		$OpenGIS = $_POST['OpenGIS'];
		$CableTypes = $_POST['cabletypes'];
		$length = $_POST['length'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		$res = CableLine_Add($OpenGIS,$CableTypes,$length,$name,$comment);
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
	ShowMessage($message,$error);
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
			$res = GetCableLineList($sort,'',$config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
		} else {
			$wr['CableType'] = $_GET['typeid'];
			$res = GetCableLineList($sort,$wr,$config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
    		if ($res['count'] < 1) {
				$message = 'Кабелей с таким типом ID не существует!<br />
				<a href="CableLine.php">Назад</a>';
				ShowMessage($message,0);
			}
		}
		$pages = GenPages('CableLine.php?sort='.$sort.'&',ceil($res['AllPages']/$config['LinesPerPage']),$page);
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i < $res['count']) {	  		$cableline_arr[] = '<a href="CableLine.php?mode=charac&cablelineid='.$rows[$i]['id'].'">'.$rows[$i]['name'].'</a>';	  		
			$cableline_arr[] = '<a href="CableType.php?mode=change&cabletypeid='.$rows[$i]['CableType'].'">'.$rows[$i]['marking'].'</a>';
			$cableline_arr[] = $rows[$i]['manufacturer'];
			$cableline_arr[] = $rows[$i]['length'];
			$cableline_arr[] = $rows[$i]['OpenGIS'];
			$cableline_arr[] = '<a href="CableLine.php?mode=change&cablelineid='.$rows[$i]['id'].'">Изменить</a>';
			$wr['CableLine'] = $rows[$i]['id'];
			$res2 = CableLinePoint_SELECT($wr);
			if ($res2['count'] == 0) {
				$cableline_arr[] = '<a href="CableLine.php?mode=delete&cablelineid='.$rows[$i]['id'].'">Удалить</a>';
			} else {
				$cableline_arr[] = '';
			}
	  	}
		$smarty->assign("data",$cableline_arr);
		$smarty->assign("pages",$pages);
	} elseif (($_GET['mode'] == 'charac') and (isset($_GET['cablelineid']))) {
	    $smarty->assign("mode","charac");

		$CableLineId = $_GET['cablelineid'];
		$res = CableLine_Info($CableLineId);
		$rows = $res['CableLine']['rows'];
		if ($res['CableLine']['count'] < 1) {			$message = 'Кабеля с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>';
			ShowMessage($message,0);
		}
		$ChangeDelete = '<a href="CableLine.php?mode=change&cablelineid='.$CableLineId.'">Изменить</a>';
		$wr['CableLine'] = $CableLineId;
		$res2 = CableLinePoint_SELECT($wr);
		if ($res2['count'] == 0) {
			$ChangeDelete .= '<br><a href="CableLine.php?mode=change&cablelineid='.$CableLineId.'">Удалить</a>';
		}
		
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("OpenGIS",$rows[0]['OpenGIS']);
		$smarty->assign("CableType",'<a href="CableType.php?mode=charac&cabletypeid='.$rows[0]['CableTypeId'].'">'.$rows[0]['CableTypeMarking'].'</a>');
		$smarty->assign("manufacturer",$rows[0]['CableTypeManufacturer']);
		$smarty->assign("length",$rows[0]['length']);
		$smarty->assign("name",$rows[0]['name']);
		$smarty->assign("comment",nl2br($rows[0]['comment']));
		$smarty->assign("ChangeDelete",$ChangeDelete);
		$smarty->assign("AddPoint",'<a href="CableLinePoint.php?mode=add&cablelineid='.$CableLineId.'">Добавить точку</a>');			
		
		if ($res['CableLinePoints']['count'] > 0) {			$rows2 = $res['CableLinePoints']['rows'];			$i = -1;
		  	while (++$i < $res['CableLinePoints']['count']) {		  		$CableLine_arr[] = $rows2[$i]['id'];
		  		$CableLine_arr[] = $rows2[$i]['OpenGIS'];
	  			$CableLine_arr[] = $rows2[$i]['meterSign'];
				$CableLine_arr[] = '<a href="NetworkNodes.php?mode=charac&nodeid='.$rows2[$i]['NetworkNode'].'">'.$rows2[$i]['name'].'</a>';
				$CableLine_arr[] = $rows2[$i]['Apartment'];
				$CableLine_arr[] = $rows2[$i]['Building'];
				$CableLine_arr[] = $rows2[$i]['SettlementGeoSpatial'];
				$CableLine_arr[] = '<a href="CableLinePoint.php?mode=change&cablelinepointid='.$rows2[$i]['id'].'&cablelineid='.$CableLineId.'">Изменить</a>';
				$CableLine_arr[] = '<a href="CableLinePoint.php?mode=delete&cablelinepointid='.$rows2[$i]['id'].'">Удалить</a>';
		  	}
			$smarty->assign("data",$CableLine_arr);			
		}
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['cablelineid']))) {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			ShowMessage($message,0);
		}
    	$smarty->assign("mode","add_change");
		$smarty->assign("mod","1");
		$smarty->assign("back",getenv("HTTP_REFERER"));

		$wr['id'] = $_GET['cablelineid'];
    	$res = CableLine_SELECT('',$wr);
    	if ($res['count'] < 1) {
			$message = 'Кабеля с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>';
			ShowMessage($message,0);
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("OpenGIS",$rows[0]['OpenGIS']);
		$cabletypeid = $rows[0]['CableType'];
		$smarty->assign("length",$rows[0]['length']);
		$smarty->assign("comment",$rows[0]['comment']);
		$smarty->assign("name",$rows[0]['name']);

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
			ShowMessage($message,0);
		}
		$smarty->assign("mode","add_change");
		$smarty->assign("mod","2");
		$smarty->assign("back",getenv("HTTP_REFERER"));

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
		if ($_SESSION['class'] > 1)	{			die("!!!");
		}		$wr['id'] = $_GET['cablelineid'];
		CableLine_DELETE($wr);
    	header("Refresh: 2; url=".getenv("HTTP_REFERER"));
		$message = "Кабель удален!";
		ShowMessage($message,0);
 	}

	$smarty->display('CableLine.tpl');
}
?>
