<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/CableType_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require_once("functions.php");
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
	    		$upd['marking'] = "'$marking'";
	    		$upd['manufacturer'] = "'$manufacturer'";
	    		$upd['tubeQuantity'] = "$tubeQuantity";
	    		$upd['fiberPerTube'] = "$fiberPerTube";
	    		$upd['tensileStrength'] = "$tensileStrength";
	    		$upd['diameter'] = "$diameter";
	    		$upd['comment'] = "'$comment'";
	    		$wr['id'] = $id;
			   	CableType_UPDATE($upd,$wr);
            	header("Refresh: 2; url=CableType.php");
            	print('Тип кабеля изменен!');
			}
		else
		if ($_POST['mode'] == 2)
			{
				$marking = $_POST['marking'];
		    	$manufacturer = $_POST['manufacturer'];
		    	$tubeQuantity = $_POST['tubeQuantity'];
		    	$fiberPerTube = $_POST['fiberPerTube'];
		    	$tensileStrength = $_POST['tensileStrength'];
		    	$diameter = $_POST['diameter'];
		    	$comment = $_POST['comment'];
				$ins['marking'] = "'$marking'";
	    		$ins['manufacturer'] = "'$manufacturer'";
	    		$ins['tubeQuantity'] = "$tubeQuantity";
	    		$ins['fiberPerTube'] = "$fiberPerTube";
	    		$ins['tensileStrength'] = "$tensileStrength";
	    		$ins['diameter'] = "$diameter";
	    		$ins['comment'] = "'$comment'";
	    		CableType_INSERT($ins);
				header("Refresh: 2; url=CableType.php");
				print("Тип кабеля добавлен!");
			}
	}
else
{
/*	if (isset($_GET['boxid']))
	{
		$smarty->assign("body",'<body onload="javascript: GetBoxInfo('.$_GET['boxid'].',1);">');
	}
	else
	{		$smarty->assign("body",'<body onload="javascript: GetBoxInfo(0,1);">');
	}  */
    if (!isset($_GET['mode']))
    {
		require_once("functions.php");
		$res = CableType_SELECT('','');
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i<$res['count'])
	  	{	  		$cabletype_arr[] = $rows[$i]['id'];
	  		$cabletype_arr[] = '<a href="CableType.php?mode=change&cabletypeid='.$rows[$i]['id'].'">'.$rows[$i]['marking'].'</a>';
			$cabletype_arr[] = $rows[$i]['manufacturer'];
			$cabletype_arr[] = $rows[$i]['tubeQuantity'];
			$cabletype_arr[] = $rows[$i]['fiberPerTube'];
			$cabletype_arr[] = $rows[$i]['tensileStrength'];
			$cabletype_arr[] = $rows[$i]['diameter'];
			$cabletype_arr[] = $rows[$i]['comment'];
			/*$wr['NetworkBoxType'] = $rows[$i]['id'];
			$res2 = NetworkBox_SELECT('',$wr);*/
			$cabletype_arr[] = /*$res2['count']*/'0';
			$cabletype_arr[] = '<a href="CableType.php?mode=delete&cabletypeid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$cabletype_arr);
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['cabletypeid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['cabletypeid'];
    	$res = CableType_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('Типа с таким ID не существует!<br />
			<a href="CableType.php">Назад</a>');
			die();
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
	}
	elseif ($_GET['mode'] == 'add')
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
		$smarty->assign("mode","add");
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['cabletypeid'])))
	{
		if ($_SESSION['class'] > 1)
		{			die("!!!");
		}//    	NetworkBox_DELETE('id='.$_GET['boxid']);
		$wr['id'] = $_GET['cabletypeid'];
		CableType_DELETE($wr);
    	header("Refresh: 2; url=CableType.php");
		print("Тип удален!");
		die();
 	}

	$smarty->display('CableType.tpl');
}
?>
