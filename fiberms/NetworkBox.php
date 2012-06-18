<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/NetworkBoxType.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	$back = $_POST['back'];
	if ($_POST['mode'] == 1) {
		$boxTypeId = $_POST['networkboxtypes'];
        $id = $_POST['boxid'];
        $invNum = $_POST['invnum'];
		$res = NetworkBox_Mod($id,$boxTypeId,$invNum);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=".$back);
	        $message = 'Ящик изменен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 2) {
		$boxTypeId = $_POST['networkboxtypes'];
		$invNum = $_POST['invnum'];
		$res = NetworkBox_Add($boxTypeId,$invNum);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=".$back);
	        $message = 'Ящик добавлен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	showMessage($message,$error);
} else {
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
		$typeId = $_GET['boxtypeid'];
		if (!isset($typeId)) {			$res = getNetworkBoxList($_GET['sort'],'',$config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
		} else {			$wr['NetworkBoxType'] = $typeId;
			$res = getNetworkBoxList($_GET['sort'],$wr,$config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
		}
		if ($res['count'] < 1) {			$message = 'Ящиков с таким ID/Типом не существует!<br />
						<a href="NetworkBox.php">Назад</a>';
			showMessage($message,0);
		}
		$pages = genPages('NetworkBox.php?sort='.$sort.'&',ceil($res['allPages']/$config['LinesPerPage']),$page);
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i < $res['count']) {	  		$box_arr[] = '<a href="NetworkBox.php?mode=charac&boxid='.$rows[$i]['id'].'">'.$rows[$i]['inventoryNumber'].'</a>';
	  		$box_arr[] = '<a href="NetworkBoxType.php?mode=charac&boxtypeid='.$rows[$i]['NetworkBoxType'].'">'.$rows[$i]['marking'].' ('.$rows[$i]['NetworkBoxType'].')</a>';			
			$box_arr[] = '<a href="NetworkNodes.php?mode=charac&nodeid='.$rows[$i]['NNid'].'">'.$rows[$i]['NNname'].'</a>';
			$box_arr[] = '<a href="NetworkBox.php?mode=change&boxid='.$rows[$i]['id'].'">Изменить</a>';
			$box_arr[] = '<a href="NetworkBox.php?mode=delete&boxid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$box_arr);
		$smarty->assign("pages",$pages);
	} elseif (($_GET['mode'] == 'charac') and (isset($_GET['boxid']))) {		$smarty->assign("mode","charac");

		$networkBoxId = $_GET['boxid'];
		$res = getNetworkBoxInfo($networkBoxId);
		if ($res['NetworkBox']['count'] < 1) {			$message = 'Ящика с таким ID не существует!<br />
			<a href="NetworkBox.php">Назад</a>';
			showMessage($message,0);
		}
		$rows = $res['NetworkBox']['rows'][0];
		$networkNodeName = '<a href="NetworkNodes.php?mode=charac&nodeid='.$rows['NetworkNode']['id'].'">'.$rows['NetworkNode']['name'].'</a>';
		if (!isset($networkNodeName)) {
			$networkNodeName = 'None';
			$changeDelete = '<a href="NetworkBox.php?mode=change&boxid='.$rows['id'].'">Изменить</a><br>
							 <a href="NetworkBox.php?mode=delete&boxid='.$rows['id'].'">Удалить</a>';
			$smarty->assign("ChangeDelete",$changeDelete);
		}
		$changeDelete = '<a href="NetworkBox.php?mode=change&boxid='.$networkBoxId.'">Изменить</a>';
		$wr['NetworkBox'] = $networkBoxId;
		$res2 = NetworkNode_SELECT(0,'',$wr);
		if ($res2['count'] == 0) {
			$changeDelete .= '<br><a href="NetworkBox.php?mode=delete&boxid='.$networkBoxId.'">Удалить</a>';
		}

		$smarty->assign("invNum",$rows['inventoryNumber']);
		$smarty->assign("boxtype",'<a href="NetworkBoxType.php?mode=charac&boxtypeid='.$rows['NetworkBoxType']['id'].'">'.$rows['NetworkBoxType']['marking'].'</a>');
		$smarty->assign("nodename",$networkNodeName);
		$smarty->assign("ChangeDelete",$changeDelete);
    	
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['boxid']))) {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			showMessage($message,0);
		}
    	$smarty->assign("mode","add_change");
		$smarty->assign("mod","1");
		$smarty->assign("back",getenv("HTTP_REFERER"));

		$wr['id'] = $_GET['boxid'];
    	$res = NetworkBox_SELECT('',$wr);
    	if ($res['count'] < 1) {
			$message = 'Ящика с таким ID не существует!<br />
						<a href="NetworkBox.php">Назад</a>';
			showMessage($message,0);
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$boxTypeId = $rows[0]['NetworkBoxType'];
		$smarty->assign("invNum",$rows[0]['inventoryNumber']);
		$res = NetworkBoxType_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i < $res['count']) {
			$comboBox_BoxType_Values[] = $rows[$i]['id'];
			$comboBox_BoxType_Text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_boxtype_values",$comboBox_BoxType_Values);
		$smarty->assign("combobox_boxtype_text",$comboBox_BoxType_Text);
		$smarty->assign("combobox_boxtype_selected",$boxTypeId);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			showMessage($message,0);
		}
		$smarty->assign("mode","add_change");
		$smarty->assign("mod","2");
		$smarty->assign("back",getenv("HTTP_REFERER"));

		$res = NetworkBoxType_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i < $res['count']) {
			$comboBox_BoxType_Values[] = $rows[$i]['id'];
			$comboBox_BoxType_Text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_boxtype_values",$comboBox_BoxType_Values);
		$smarty->assign("combobox_boxtype_text",$comboBox_BoxType_Text);
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['boxid']))) {
		if ($_SESSION['class'] > 1)	{			$message = '!!!';
			showMessage($message,0);
		}		$wr['id'] = $_GET['boxid'];
		NetworkBox_DELETE($wr);
    	header("Refresh: 2; url=".getenv("HTTP_REFERER"));
		$message = "Ящик удален!";
		showMessage($message,0);
 	}

	$smarty->display('NetworkBox.tpl');
}
?>
