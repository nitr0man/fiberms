<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/CableType.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	if ($_POST['mode'] == 1)
		{
		$id = $_POST['id'];
		$marking = $_POST['marking'];
	    $manufacturer = $_POST['manufacturer'];
	    $tubeQuantity = $_POST['tubeQuantity'];
	    $fiberPerTube = $_POST['fiberPerTube'];
	    $tensileStrength = $_POST['tensileStrength'];
	    $diameter = $_POST['diameter'];
	    $comment = $_POST['comment'];
	   	/*$upd['marking'] = "'$marking'";
	   	$upd['manufacturer'] = "'$manufacturer'";
	   	$upd['tubeQuantity'] = "$tubeQuantity";
	   	$upd['fiberPerTube'] = "$fiberPerTube";
	   	$upd['tensileStrength'] = "$tensileStrength";
	   	$upd['diameter'] = "$diameter";
	   	$upd['comment'] = "'$comment'";
	   	$wr['id'] = $id;
		CableType_UPDATE($upd,$wr); */
		$res = CableType_Mod($id,$marking,$manufacturer,$tubeQuantity,$fiberPerTube,$tensileStrength,$diameter,$comment);
		if (isset($res['error'])) {           	
			$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=CableType.php");
	        $message = 'Тип кабеля изменен!';
			$error = 0;
        } else {    	   	
			$message = 'Неверно заполнены поля!';
			$error = 1;    	}    	        
	}
	elseif ($_POST['mode'] == 2) {
		$marking = $_POST['marking'];
		$manufacturer = $_POST['manufacturer'];
		$tubeQuantity = $_POST['tubeQuantity'];
		$fiberPerTube = $_POST['fiberPerTube'];
		$tensileStrength = $_POST['tensileStrength'];
		$diameter = $_POST['diameter'];
		$comment = $_POST['comment'];
		/*$ins['marking'] = "'$marking'";
	    $ins['manufacturer'] = "'$manufacturer'";
	    $ins['tubeQuantity'] = "$tubeQuantity";
	    $ins['fiberPerTube'] = "$fiberPerTube";
	    $ins['tensileStrength'] = "$tensileStrength";
	    $ins['diameter'] = "$diameter";
	    $ins['comment'] = "'$comment'";
	    CableType_INSERT($ins); */
		$res = CableType_Add($marking,$manufacturer,$tubeQuantity,$fiberPerTube,$tensileStrength,$diameter,$comment);
		if (isset($res['error'])) {
            $message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=CableType.php");
	       	$message = 'Тип кабеля добавлен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	ShowMessage($message,$error);
	/*$smarty->assign("message",$message);
	$smarty->display("message.tpl");*/
} else {
    if (!isset($_GET['mode'])) {
		$res = CableType_SELECT($_GET['sort'],'');
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i<$res['count']) {	  		$CableType_arr[] = $rows[$i]['id'];
	  		$CableType_arr[] = '<a href="CableType.php?mode=change&cabletypeid='.$rows[$i]['id'].'">'.$rows[$i]['marking'].'</a>';
			$CableType_arr[] = $rows[$i]['manufacturer'];
			$CableType_arr[] = $rows[$i]['tubeQuantity'];
			$CableType_arr[] = $rows[$i]['fiberPerTube'];
			$CableType_arr[] = $rows[$i]['tensileStrength'];
			$CableType_arr[] = $rows[$i]['diameter'];
			$CableType_arr[] = $rows[$i]['comment'];
			$wr['CableType'] = $rows[$i]['id'];
			$res2 = CableLine_SELECT('',$wr);
			$CableType_arr[] = $res2['count'];//'0';
			$CableType_arr[] = '<a href="CableType.php?mode=delete&cabletypeid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
//	  	$CableType_arr = CableType_Logic_List();
		$smarty->assign("data",$CableType_arr);
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['cabletypeid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			ShowMessage($message,0);
		}    	$smarty->assign("mode","change");

    	$wr['id'] = $_GET['cabletypeid'];
    	$res = CableType_SELECT(0,$wr);
    	if ($res['count'] < 1) {
			$message = 'Типа с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>';
			ShowMessage($message,0);
		}
    	$rows = $res['rows'];
/*		while ($boxinfo = pg_fetch_array($res))
		{
			$smarty->assign("id",$boxinfo['id']);
			$boxtypeid = $boxinfo['NetworkBoxType'];
			$smarty->assign("invNum",$boxinfo['inventoryNumber']);
		}   */
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("marking",$rows[0]['marking']);
		$smarty->assign("manufacturer",$rows[0]['manufacturer']);
		$smarty->assign("tubeQuantity",$rows[0]['tubeQuantity']);
		$smarty->assign("fiberPerTube",$rows[0]['fiberPerTube']);
		$smarty->assign("tensileStrength",$rows[0]['tensileStrength']);
		$smarty->assign("diameter",$rows[0]['diameter']);
		$smarty->assign("comment",$rows[0]['comment']);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1)
		{
			$message = '!!!';
			ShowMessage($message,0);
		}
		$smarty->assign("mode","add");
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['cabletypeid']))) {
		if ($_SESSION['class'] > 1)	{			$message = '!!!';
			ShowMessage($message,0);
		}//    	NetworkBox_DELETE('id='.$_GET['boxid']);
/*		$wr['id'] = $_GET['cabletypeid'];
		CableType_DELETE($wr);  */
		$wr['id'] = $_GET['cabletypeid'];
		CableType_Delete($wr);
    	header("Refresh: 2; url=CableType.php");
		$message = 'Тип удален!';
		ShowMessage($message,0);		
 	}

	$smarty->display('CableType.tpl');
}
?>
