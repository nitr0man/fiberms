<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/NetworkBoxType_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
				$id = $_POST['id'];
				$marking = $_POST['marking'];
		    	$manufacturer = $_POST['manufacturer'];
		    	$units = $_POST['units'];
		    	$width = $_POST['width'];
		    	$height = $_POST['height'];
		    	$length = $_POST['length'];
		    	$diameter = $_POST['diameter'];
	    		$upd['marking'] = "'$marking'";
	    		$upd['manufacturer'] = "'$manufacturer'";
	    		$upd['units'] = "$units";
	    		$upd['width'] = "$width";
	    		$upd['height'] = "$height";
	    		$upd['length'] = "$length";
	    		$upd['diameter'] = "$diameter";
	    		$wr['id'] = $id;
			   	NetworkBoxType_UPDATE($upd,$wr);
            	header("Refresh: 2; url=NetworkBoxType.php");
            	print('Тип ящика изменен!');
			}
		else
		if ($_POST['mode'] == 2)
			{
				$marking = $_POST['marking'];
		    	$manufacturer = $_POST['manufacturer'];
		    	$units = $_POST['units'];
		    	$width = $_POST['width'];
		    	$height = $_POST['height'];
		    	$length = $_POST['length'];
		    	$diameter = $_POST['diameter'];
				$ins['marking'] = "'$marking'";
	    		$ins['manufacturer'] = "'$manufacturer'";
	    		$ins['units'] = "$units";
	    		$ins['width'] = "$width";
	    		$ins['height'] = "$height";
	    		$ins['length'] = "$length";
	    		$ins['diameter'] = "$diameter";
	    		NetworkBoxType_INSERT($ins);
				header("Refresh: 2; url=NetworkBoxType.php");
				print("Тип ящика добавлен!");
			}
	}
else
{
    if (!isset($_GET['mode']))
    {
		require_once("functions.php");
		$res = NetworkBoxType_SELECT('','');
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i<$res['count'])
	  	{	  		$boxtype_arr[] = $rows[$i]['id'];
	  		$boxtype_arr[] = '<a href="NetworkBoxType.php?mode=charac&boxtypeid='.$rows[$i]['id'].'">'.$rows[$i]['marking'].'</a>';
			$boxtype_arr[] = $rows[$i]['manufacturer'];
			$boxtype_arr[] = $rows[$i]['units'];
			$boxtype_arr[] = $rows[$i]['width'];
			$boxtype_arr[] = $rows[$i]['height'];
			$boxtype_arr[] = $rows[$i]['length'];
			$boxtype_arr[] = $rows[$i]['diameter'];
			$wr['NetworkBoxType'] = $rows[$i]['id'];
			$res2 = NetworkBox_SELECT('',$wr);
			$boxtype_arr[] = $res2['count'];
			$boxtype_arr[] = '<a href="NetworkBoxType.php?mode=change&boxtypeid='.$rows[$i]['id'].'">Изменить</a>';
			$boxtype_arr[] = '<a href="NetworkBoxType.php?mode=delete&boxtypeid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$boxtype_arr);
	}
	elseif (($_GET['mode'] == 'charac') and (isset($_GET['boxtypeid'])))
	{		$smarty->assign("mode","charac");

		$wr['id'] = $_GET['boxtypeid'];
    	$res = NetworkBoxType_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('Типа с таким ID не существует!<br />
			<a href="NetworkBoxType.php">Назад</a>');
			die();
		}
    	$rows = $res['rows'];

		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("marking",$rows[0]['marking']);
		$smarty->assign("manufacturer",$rows[0]['manufacturer']);
		$smarty->assign("units",$rows[0]['units']);
		$smarty->assign("width",$rows[0]['width']);
		$smarty->assign("height",$rows[0]['height']);
		$smarty->assign("length",$rows[0]['length']);
		$smarty->assign("diameter",$rows[0]['diameter']);
		unset($wr);
		$wr['NetworkBoxType'] = $rows[0]['id'];
		$res = NetworkBox_SELECT('',$wr);
		$smarty->assign("count",$res['count']);
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['boxtypeid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['boxtypeid'];
    	$res = NetworkBoxType_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('Типа с таким ID не существует!<br />
			<a href="NetworkBoxType.php">Назад</a>');
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
		$smarty->assign("units",$rows[0]['units']);
		$smarty->assign("width",$rows[0]['width']);
		$smarty->assign("height",$rows[0]['height']);
		$smarty->assign("length",$rows[0]['length']);
		$smarty->assign("diameter",$rows[0]['diameter']);
	}
	elseif ($_GET['mode'] == 'add')
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
		$smarty->assign("mode","add");
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['boxtypeid'])))
	{
		if ($_SESSION['class'] > 1)
		{			die("!!!");
		}//    	NetworkBox_DELETE('id='.$_GET['boxid']);
		$wr['id'] = $_GET['boxtypeid'];
		NetworkBoxType_DELETE($wr);
    	header("Refresh: 2; url=NetworkBoxType.php");
		print("Тип удален!");
		die();
 	}

	$smarty->display('NetworkBoxType.tpl');
}
?>
