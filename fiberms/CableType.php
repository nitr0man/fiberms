<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/CableType.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
	$back = $_POST['back'];
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
		$res = CableType_Mod($id,$marking,$manufacturer,$tubeQuantity,$fiberPerTube,$tensileStrength,$diameter,$comment);
		if (isset($res['error'])) {           	
			$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=".$back);
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
		$res = CableType_Add($marking,$manufacturer,$tubeQuantity,$fiberPerTube,$tensileStrength,$diameter,$comment);
		if (isset($res['error'])) {
            $message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=".$back);
	       	$message = 'Тип кабеля добавлен!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	}
	showMessage($message,$error);
} else {
    if (!isset($_GET['mode'])) {
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
		$res = CableType_SELECT($_GET['sort'],'',$config['LinesPerPage'],($page-1)*$config['LinesPerPage']);
		$pages = genPages('CableType.php?sort='.$sort.'&',ceil($res['allPages']/$config['LinesPerPage']),$page);
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i<$res['count']) {	  		$CableType_arr[] = $rows[$i]['id'];
	  		$CableType_arr[] = '<a href="CableType.php?mode=charac&cabletypeid='.$rows[$i]['id'].'">'.$rows[$i]['marking'].'</a>';
			$CableType_arr[] = $rows[$i]['manufacturer'];
			$CableType_arr[] = $rows[$i]['tubeQuantity'];
			$CableType_arr[] = $rows[$i]['fiberPerTube'];
			$CableType_arr[] = $rows[$i]['tensileStrength'];
			$CableType_arr[] = $rows[$i]['diameter'];			
			$wr['CableType'] = $rows[$i]['id'];
			$res2 = CableLine_SELECT('',$wr,'','');
			if ($res2['count'] > 0) {
				$CableType_arr[] = '<a href="CableLine.php?typeid='.$rows[$i]['id'].'">'.$res2['count'].'</a>';
				$CableType_arr[] = '<a href="CableType.php?mode=change&cabletypeid='.$rows[$i]['id'].'">Изменить</a>';
				$CableType_arr[] = '';
			} else {
				$CableType_arr[] = $res2['count'];
				$CableType_arr[] = '<a href="CableType.php?mode=change&cabletypeid='.$rows[$i]['id'].'">Изменить</a>';
				$CableType_arr[] = '<a href="CableType.php?mode=delete&cabletypeid='.$rows[$i]['id'].'">Удалить</a>';
			}						
	  	}
		$smarty->assign("data",$CableType_arr);
		$smarty->assign('pages',$pages);
	} elseif (($_GET['mode'] == 'change') and (isset($_GET['cabletypeid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			showMessage($message,0);
		}    	$smarty->assign("mode","add_change");
		$smarty->assign("mod","1");
		$smarty->assign("back",getenv("HTTP_REFERER"));

    	$wr['id'] = $_GET['cabletypeid'];
    	$res = CableType_SELECT(0,$wr);
    	if ($res['count'] < 1) {
			$message = 'Типа кабеля с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>';
			showMessage($message,0);
		}
    	$rows = $res['rows'];
		
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("marking",$rows[0]['marking']);
		$smarty->assign("manufacturer",$rows[0]['manufacturer']);
		$smarty->assign("tubeQuantity",$rows[0]['tubeQuantity']);
		$smarty->assign("fiberPerTube",$rows[0]['fiberPerTube']);
		$smarty->assign("tensileStrength",$rows[0]['tensileStrength']);
		$smarty->assign("diameter",$rows[0]['diameter']);
		$smarty->assign("comment",$rows[0]['comment']);
	} elseif (($_GET['mode'] == 'charac') and (isset($_GET['cabletypeid']))) {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			showMessage($message,0);
		}
    	$smarty->assign("mode","charac");

    	$wr['id'] = $_GET['cabletypeid'];
    	$res = CableType_SELECT(0,$wr);
    	if ($res['count'] < 1) {
			$message = 'Типа кабеля с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>';
			showMessage($message,0);
		}
    	$rows = $res['rows'];
		$changeDelete = '<a href="CableType.php?mode=change&cabletypeid='.$_GET['cabletypeid'].'">Изменить</a>';
		unset($wr);
		$wr['CableType'] = $_GET['cabletypeid'];
		$res2 = CableLine_SELECT('',$wr,'','');
		if ($res2['count'] == 0) {
			$changeDelete .= '<a href="CableType.php?mode=delete&cabletypeid='.$_GET['cabletypeid'].'">Удалить</a>';
		}
		
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("marking",$rows[0]['marking']);
		$smarty->assign("manufacturer",$rows[0]['manufacturer']);
		$smarty->assign("tubeQuantity",$rows[0]['tubeQuantity']);
		$smarty->assign("fiberPerTube",$rows[0]['fiberPerTube']);
		$smarty->assign("tensileStrength",$rows[0]['tensileStrength']);
		$smarty->assign("diameter",$rows[0]['diameter']);
		$smarty->assign("comment",nl2br($rows[0]['comment']));
		$smarty->assign("ChangeDelete",$changeDelete);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1)
		{
			$message = '!!!';
			showMessage($message,0);
		}
		$smarty->assign("mode","add_change");
		$smarty->assign("mod","2");
		$smarty->assign("back",getenv("HTTP_REFERER"));
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['cabletypeid']))) {
		if ($_SESSION['class'] > 1)	{			$message = '!!!';
			showMessage($message,0);
		}		$wr['id'] = $_GET['cabletypeid'];
		CableType_Delete($wr);
    	header("Refresh: 2; url=".getenv("HTTP_REFERER"));
		$message = 'Тип кабеля удален!';
		showMessage($message,0);		
 	}

	$smarty->display('CableType.tpl');
}
?>
