<?php
require_once("auth.php");
require_once("smarty.php");
require_once("/func/NetworkBoxType.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	if ($_POST['mode'] == 1) {
		$BoxTypeId = $_POST['networkboxtypes'];
        $id = $_POST['boxid'];
        $InvNum = $_POST['invnum'];
		$res = NetworkBox_Mod($id,$BoxTypeId,$InvNum);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=FiberSplice.php");
	        $message = 'Ящик изменен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 2) {
		$BoxTypeId = $_POST['networkboxtypes'];
		$InvNum = $_POST['invnum'];
		$res = NetworkBox_Add($BoxTypeId,$InvNum);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=FiberSplice.php");
	        $message = 'Ящик изменен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	ShowMessage($message,$error);
} else {
    if (!isset($_GET['mode'])) {
		$TypeId = $_GET['boxtypeid'];
		if (!isset($TypeId)) {			$res = NetworkBox_SELECT($_GET['sort'],'');
		} else {			$wr['NetworkBoxType'] = $TypeId;
			$res = NetworkBox_SELECT($_GET['sort'],$wr);
		}
		if ($res['count'] < 1) {			$message = 'Ящиков с таким ID/Типом не существует!<br />
						<a href="NetworkBox.php">Назад</a>';
			ShowMessage($message,0);
		}
		$rows = $res['rows'];
/*		while ($boxrow = pg_fetch_array($res))
  		{
			$box_arr[] = $boxrow['id'];
			$box_arr[] = $boxrow['NetworkBoxType'];
			$box_arr[] = $boxrow['inventoryNumber'];
			$box_arr[] = '<a href="NetworkBox.php?mode=change&boxid='.$boxrow['id'].'">Изменить</a>';
			$box_arr[] = '<a href="NetworkBox.php?mode=delete&boxid='.$boxrow['id'].'">Удалить</a>';
	  	} */
	  	$i = -1;
	  	while (++$i < $res['count']) {	  		$box_arr[] = $rows[$i]['id'];
	  		$box_arr[] = $rows[$i]['NetworkBoxType'];
			$box_arr[] = '<a href="NetworkBox.php?mode=charac&boxid='.$rows[$i]['id'].'">'.$rows[$i]['inventoryNumber'].'</a>';
			$box_arr[] = '<a href="NetworkBox.php?mode=change&boxid='.$rows[$i]['id'].'">Изменить</a>';
			$box_arr[] = '<a href="NetworkBox.php?mode=delete&boxid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$box_arr);
	} elseif (($_GET['mode'] == 'charac') and (isset($_GET['boxid']))) {		$smarty->assign("mode","charac");

		$NetworkBoxId = $_GET['boxid'];
		$res = GetNetworkBoxInfo($NetworkBoxId);
		if ($res['NetworkBox']['count'] < 1) {			$message = 'Ящика с таким ID не существует!<br />
			<a href="NetworkBox.php">Назад</a>';
			ShowMessage($message,0);
		}
		$rows = $res['NetworkBox']['rows'][0];
		$NetworkNodeName = $rows['NetworkNode']['name'];
		if (!isset($NetworkNodeName)) {
			$NetworkNodeName = 'None';
			$ChangeDelete = '<a href="NetworkBox.php?mode=change&boxid='.$rows['id'].'">Изменить</a><br>
							 <a href="NetworkBox.php?mode=delete&boxid='.$rows['id'].'">Удалить</a>';
			$smarty->assign("ChangeDelete",$ChangeDelete);
		}

		$smarty->assign("invNum",$rows['inventoryNumber']);
		$smarty->assign("boxtype",$rows['NetworkBoxType']['marking']);
		$smarty->assign("nodename",$NetworkNodeName);

    	/*$res = NetworkBox_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('Ящика с таким ID не существует!<br />
			<a href="NetworkBox.php">Назад</a>');
			die();
		}
    	$rows = $res['rows'];
//		$smarty->assign("id",$rows[0]['id']);
//		$boxtypeid = $rows[0]['NetworkBoxType'];
		$smarty->assign("invNum",$rows[0]['inventoryNumber']);
		unset($wr);
		$wr['id'] = $rows[0]['NetworkBoxType'];
		$res = NetworkBoxType_SELECT('',$wr);
		$smarty->assign("boxtype",$res['rows'][0]['marking']);
		unset($wr);
		$wr['NetworkBox'] = $_GET['boxid'];
		$res = NetworkNode_SELECT('',$wr);
		$smarty->assign("nodename",$res['rows'][0]['name']);*/

/*		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count'])
		{
			$combobox_boxtype_values[] = $rows[$i]['id'];
			$combobox_boxtype_text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_boxtype_values",$combobox_boxtype_values);
		$smarty->assign("combobox_boxtype_text",$combobox_boxtype_text);
		$smarty->assign("combobox_boxtype_selected",$boxtypeid);*/
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['boxid']))) {
		if ($_SESSION['class'] > 1) {
			$message = '!!!';
			ShowMessage($message,0);
		}
    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['boxid'];
    	$res = NetworkBox_SELECT('',$wr);
    	if ($res['count'] < 1) {
			$message = 'Ящика с таким ID не существует!<br />
						<a href="NetworkBox.php">Назад</a>';
			ShowMessage($message,0);
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$boxtypeid = $rows[0]['NetworkBoxType'];
		$smarty->assign("invNum",$rows[0]['inventoryNumber']);
		$res = NetworkBoxType_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_boxtype_values[] = $rows[$i]['id'];
			$combobox_boxtype_text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_boxtype_values",$combobox_boxtype_values);
		$smarty->assign("combobox_boxtype_text",$combobox_boxtype_text);
		$smarty->assign("combobox_boxtype_selected",$boxtypeid);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			ShowMessage($message,0);
		}
		$smarty->assign("mode","add");

		$res = NetworkBoxType_SELECT('','');
		$rows = $res['rows'];
		$i = -1;
		while (++$i<$res['count']) {
			$combobox_boxtype_values[] = $rows[$i]['id'];
			$combobox_boxtype_text[] = $rows[$i]['marking'];
		}
		$smarty->assign("combobox_boxtype_values",$combobox_boxtype_values);
		$smarty->assign("combobox_boxtype_text",$combobox_boxtype_text);
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['boxid']))) {
		if ($_SESSION['class'] > 1)	{			$message = '!!!';
			ShowMessage($message,0);
		}//    	NetworkBox_DELETE('id='.$_GET['boxid']);
		$wr['id'] = $_GET['boxid'];
		NetworkBox_DELETE($wr);
    	header("Refresh: 2; url=NetworkBox.php");
		$message = "Ящик удален!";
		ShowMessage($message,0);
 	}

	$smarty->display('NetworkBox.tpl');
}
?>
