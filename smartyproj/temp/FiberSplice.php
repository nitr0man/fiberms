<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/FS_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
				$id = $_POST['id'];
				$marking = $_POST['marking'];
		    	$manufacturer = $_POST['manufacturer'];
		    	$note = $_POST['note'];
				$upd['marking'] = "'$marking'";
	    		$upd['manufacturer'] = "'$manufacturer'";
	    		$upd['note'] = "'$note'";
	    		$wr['id'] = $id;
			   	FSOT_UPDATE($upd,$wr);
            	header("Refresh: 2; url=FSOT.php");
            	print('FSOT изменен!');
			}
		else
		if ($_POST['mode'] == 2)
			{
				$marking = $_POST['marking'];
		    	$manufacturer = $_POST['manufacturer'];
		    	$note = $_POST['note'];
				$ins['marking'] = "'$marking'";
	    		$ins['manufacturer'] = "'$manufacturer'";
	    		$ins['note'] = "'$note'";
	    		FSOT_INSERT($ins);
				header("Refresh: 2; url=FSOT.php");
				print("FSOT добавлен!");
			}
		else
		if ($_POST['mode'] == 3)
		{
			require_once('func/CableLine_func.php');			$clpid = $_POST['clpid'];
			$NetworkNode = $_POST['NetworkNode'];
			$wr['NetworkNode'] = $NetworkNode;
			$res = CableLinePoint_SELECT('',$wr);
			$rows = $res['rows'];
			for ($i = 0; $i<$res['count']; $i++)
			{
				$ComboBox_CableLinePoint_values[] = $rows[$i]['id'];
				$ComboBox_CableLinePoint_text[] = $rows[$i]['note'];			}
			$smarty->assign("ComboBox_CableLinePoint_values",$ComboBox_CableLinePoint_values);
			$smarty->assign("ComboBox_CableLinePoint_text",$ComboBox_CableLinePoint_text);



			$res = GetFiberTable($NetworkNodeId);
			$j = $res['CableLinePoins'][$clpid];
			for ($i = 1; $i<=$res['cl_array']['rows'][$j]['fiber']; $i++)
			{
				$arr = $res['SpliceArray'][$j][$i];
				if (!isset($arr))
				{					$fibers[] = $i;
				}
			}
			$smarty->assign("ComboBox_Fibers_values",$fibers);
			$smarty->assign("ComboBox_Fibers_text",$fibers);
			$smarty->display('Fiber_Splice_content_change.tpl');
		}
	}
else
{   if (($_GET['mode'] == 'change') and (isset($_GET['networknodeid'])) and (isset($_GET['clpid1'])) and (isset($_GET['fiber1'])))
	{
	    $smarty->assign("mode","change");
        require_once('func/CableType_func.php');
			$clpid = $_GET['clpid2'];
			$NetworkNodeId = $_GET['networknodeid'];
			$wr['NetworkNode'] = $NetworkNodeId;
			$res = CableLinePoint_SELECT('',$wr);
			$rows = $res['rows'];
			for ($i = 0; $i<$res['count']; $i++)
			{
				$ComboBox_CableLinePoint_values[] = $rows[$i]['id'];
				$ComboBox_CableLinePoint_text[] = $rows[$i]['note'];
			}
			$smarty->assign("ComboBox_CableLinePoint_values",$ComboBox_CableLinePoint_values);
			$smarty->assign("ComboBox_CableLinePoint_text",$ComboBox_CableLinePoint_text);



			$res = GetFiberTable($NetworkNodeId);
			$j = $res['CableLinePoins'][$clpid];
			for ($i = 1; $i<=$res['cl_array']['rows'][$j]['fiber']; $i++)
			{
				$arr = $res['SpliceArray'][$j][$i];
				if (!isset($arr))
				{
					$fibers[] = $i;
				}
			}
			$smarty->assign("ComboBox_Fibers_values",$fibers);
			$smarty->assign("ComboBox_Fibers_text",$fibers);
//			$smarty->display('Fiber_Splice_content_change.tpl');


    	/*require_once('func/CableType_func.php');
    	$wr['id'] = $_GET['clpid2'];
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
		$smarty->assign("data",$cableline_arr);*/
	}
    elseif (isset($_GET['networknodeid']))
    {
    	require_once("func/CableType_func.php");
    	$NetworkNodeId = $_GET['networknodeid'];
		$res = GetFiberTable($NetworkNodeId);
		print_r($res);
		print('ff '.$res['cl_array']['rows'][0]['fiber']);
		if ($NPrint != 1)
		{
			$linksD = ' <a href="#">[x]</a>';
			$linksN = '<a href="#">[+]</a>';
		}
		for ($i = 1; $i<=$res['maxfiber']; $i++)
		{
			$cols[] = $i;        	for ($j = 0; $j < count($res['CableLinePoints']); $j++)
        	{
            	$arr = $res['SpliceArray'][$j][$i];
            	$clpid1 = $res['cl_array']['rows'][1][$j];
            	$clpid2 = $arr[1];
            	$fiber1 = $i;
            	$fiber2 = $arr[2];
            	$is_a = $arr[4];
            	$splice_id = $arr[0];
            	if (isset($arr))
				{
					$table[] = $arr[1]+1 . ' - ' . $arr[2].'</a> <a href="FiberSplice.php?mode=change&clpid1='.$clpid1.'&clpid2='.$clpid2.'&fiber1='.$fiber1.'&fiber2='.$fiber2.'&networknodeid='.$NetworkNodeId.'">[E]</a> '.$linksD;
				}
				else
				{
					$table = $linksN;
				}
			}
		}
		$smarty->assign("cols",$cols);
		$smarty->assign("data",$table);
/*		for ($i = 0; $i<=3; $i++)
		{
			print($table[$i]."<br>");
		}    */



		/*$res = GetFiberNum($NetworkNodeId);
		$fiber_count = $res['fiber'];
		$CableLinePointA = $res['clpid'][0];
        $CableLinePointB = $res['clpid'][1];
        $wr['CableLinePointA'] = $CableLinePointA;
        $wr['CableLinePointB'] = $CableLinePointB;
        $res2 = FiberSplice_SELECT('',$wr,1);
        $rows2 = $res2['rows'];
        $FibResCount = $res2['count'];
//        pg_free_result($res2);
        unset($wr);

		$wr['NetworkNode'] = $NetworkNodeId;
        $res1 = CableLinePoint_SELECT('',$wr);
        $rows1 = $res1['rows'];
        for ($i=0; $i<$res1['count']; $i++)
        {        	$cables[$rows1[$i]['id']] = $i;
//        	$columns[] = $i;
//        	print($cables[$rows1[$i]['id']]." ".$rows1[$i]['id']."<br />")
        }
        $col_count = $i;

        for ($i=0; $i<$FibResCount; $i++)
        {        	$fiber = $rows2[$i]['fiberB'];
        	$CableLinePoint = $CableLinePointB;
        	$col = $CableLinePointA;
        	print($cables[$CableLinePoint].'-'.$fiber.'(колонка '.$cables[$col].')'.'<br />');
        } */

        /*for ($i=1; $i<=$fiber_count; $i++)
        {
        	unset($wr);
        	$wr['fiberA'] = $i;
        	$wr['fiberB'] = $i;
        	$res2 = FiberSplice_SELECT('',$wr,1);
        	if ($res2['rows'][0]['fiberB']==$i)
        	{
		        $fiber = $res2['rows'][0]['fiberA'];
        		$CableLinePoint = $res2['rows'][0]['CableLinePointA'];
        		$col = $res2['rows'][0]['CableLinePointB'];
        	}
        	else
        	{        		$fiber = $res2['rows'][0]['fiberB'];
        		$CableLinePoint = $res2['rows'][0]['CableLinePointB'];
        		$col = $res2['rows'][0]['CableLinePointA'];
        	}
//        	print($CableLinePoint.'<br />');			print($cables[$CableLinePoint].'-'.$fiber.'(колонка '.$cables[$col].')'.'<br />');
			$table[$col][$i] = $cables[$CableLinePoint].'-'.$fiber;
        }
        for ($i=0; $i<$col_count; $i++)
        {
        	$cols .= $i.',';
        	for ($i2=0; $i2<=$fiber; $i2++)
        	{        		if (!isset($table[$i][$i2]))
        		{        			$table[$i][$i2] = '-';
        		}
        	}
        }
        $smarty->assign("cols",$cols);
        $smarty->assign("data",$table);      */

/*  		for ($i=0; $i<=$fiber; $i++)
  		{
  			$res = FiberInfo($i);
  			$fiber_arr[] = $i;
  			if ($res['count']==0)
  			{
  			}  			$res = FiberSplice_SELECT('',$wr);

  		}
		$rows = $res['rows'];
	  	$i = -1;
	  	while (++$i<$res['count'])
	  	{	  		$cableline_arr[] = '<a href="CableLine.php?mode=charac&cablelineid='.$rows[$i]['id'].'">'.$rows[$i]['id'].'</a>';
	  		$cableline_arr[] = $rows[$i]['OpenGIS'];
			$cableline_arr[] = $rows[$i]['CableType'];
			$cableline_arr[] = $rows[$i]['length'];
			$cableline_arr[] = $rows[$i]['comment'];
			$cableline_arr[] = '<a href="CableLine.php?mode=change&cablelineid='.$rows[$i]['id'].'">Изменить</a>';
			$cableline_arr[] = '<a href="CableLine.php?mode=delete&cablelineid='.$rows[$i]['id'].'">Удалить</a>';
	  	}
		$smarty->assign("data",$cableline_arr); */
	}
	elseif (($_GET['mode'] == 'change') and (isset($_GET['fsotid'])))
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
    	$smarty->assign("mode","change");

		$wr['id'] = $_GET['fsotid'];
    	$res = FSOT_SELECT('',$wr);
    	if ($res['count'] < 1)
		{
			print('FSOT с таким ID не существует!<br />
			<a href="FSOT.php">Назад</a>');
			die();
		}
    	$rows = $res['rows'];
		$smarty->assign("id",$rows[0]['id']);
		$smarty->assign("marking",$rows[0]['marking']);
		$smarty->assign("manufacturer",$rows[0]['manufacturer']);
		$smarty->assign("note",$rows[0]['note']);
	}
	elseif ($_GET['mode'] == 'add')
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}
		$smarty->assign("mode","add");
	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['cablelineid'])))
	{
		if ($_SESSION['class'] > 1)
		{			die("!!!");
		}//    	NetworkBox_DELETE('id='.$_GET['boxid']);
		$wr['id'] = $_GET['cablelineid'];
		CableLine_DELETE($wr);
    	header("Refresh: 2; url=CableLine.php");
		print("Тип удален!");
		die();
 	}

	$smarty->display('FiberSplice.tpl');
}
?>
