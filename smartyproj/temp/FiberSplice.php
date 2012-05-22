<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/FS_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
			   	$SpliceId = $_POST['SpliceId'];
			   	$IsA = $_POST['IsA'];
			   	if ($IsA == 0) {			   		$upd['CableLinePointA'] = $_POST['CableLinePoint'];
			   		$upd['fiberA'] = $_POST['Fibers'];
			   		$upd['FiberSpliceOrganizer'] = $_POST['FibersSpliceOrganizer'];
			   	}
			   	else {			   		$upd['CableLinePointB'] = $_POST['CableLinePoint'];
			   		$upd['fiberB'] = $_POST['Fibers'];
			   		$upd['FiberSpliceOrganizer'] = $_POST['FibersSpliceOrganizer'];
			   	}
                $wr['id'] = $SpliceId;
                FiberSplice_UPDATE($upd,$wr);

            	header("Refresh: 2; url=FiberSplice.php");
            	print('Сварка изменена!');
			}
		else
		if ($_POST['mode'] == 2)
			{
	    		$ins['CableLinePointA'] = $_POST['clpid1'];
	    		$ins['fiberA'] = $_POST['fiber'];
	    		$ins['CableLinePointB'] = $_POST['CableLinePoint'];
	    		$ins['fiberB'] = $_POST['Fibers'];
	    		$ins['FiberSpliceOrganizer'] = $_POST['FibersSpliceOrganizer'];
	    		FiberSplice_INSERT($ins);

				header("Refresh: 2; url=FiberSplice.php");
				print("Сварка добавлена!");
			}
		else
		if ($_POST['mode'] == 3)
		{
			$CurrFiber = $_POST['CurrFiber'];
//			print($_POST['CableLinePoint']);
//			print_r(GetFiberTable($_POST['NetworkNodeId']));
			if ((!isset($CurrFiber)) or ($CurrFiber == '')){				$CurrFiber = -1;
			}
		    $fibers = GetFibers($_POST['CableLinePoint'],$_POST['NetworkNodeId'],$CurrFiber);
	  		$smarty->assign("ComboBox_Fibers_values",$fibers);
			$smarty->assign("ComboBox_Fibers_text",$fibers);
			$smarty->display("FiberSplice_content_Fibers.tpl");
		}
	}
else
{   if (($_GET['mode'] == 'change') and (isset($_GET['networknodeid'])) and (isset($_GET['clpid1'])) and (isset($_GET['fiber1'])))
	{
	    if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}

	    $smarty->assign("mode","change");
        //require_once('func/CableType_func.php');

        $NetworkNodeId = $_GET['networknodeid'];
        $res = GetFiberTable($NetworkNodeId);
        /*$j = (int)$res['CableLinePoins'][$_GET['clpid1']];
        for ($i = 1; $i<=$res['cl_array']['rows'][$j]['fiber']; $i++)
		{
			$arr = $res['SpliceArray'][$j][$i];
			if ((!isset($arr)) or ($i == $_GET['fiber2']))
			{
				$fibers[] = $i;
			}
		}  */
		$fibers = GetFibers($_GET['clpid1'],$NetworkNodeId,$_GET['fiber1']);

		$cl_array = $res['cl_array'];
		for ($i = 0; $i<$cl_array['count']; $i++){			$ComboBox_CableLinePoint_values[] = $cl_array['rows'][$i]['clpid'];
			$ComboBox_CableLinePoint_text[] = $cl_array['rows'][$i]['name'];
		}
		$cable1 = $cl_array['rows'][$res['CableLinePoints'][$_GET['clpid1']]]['name'];

  		$smarty->assign("cable1",$cable1);
  		$smarty->assign("fiber1",$_GET['fiber1']);
  		$smarty->assign("Combobox_Fibers_selected",$_GET['fiber1']);
  		$smarty->assign("ComboBox_Fibers_values",$fibers);
		$smarty->assign("ComboBox_Fibers_text",$fibers);

		$res = FSO_Select('','');
  		for ($i = 0; $i < $res['count']; $i++) {
  			$ComboBox_FibersSpliceOrganizer_values[] = $res['rows'][$i]['id'];
  			$ComboBox_FibersSpliceOrganizer_text[] = $res['rows'][$i]['id']." (".$res['rows'][$i]['FiberSpliceOrganizationType'].")";
  		}
  		$smarty->assign("ComboBox_FibersSpliceOrganizer_values",$ComboBox_FibersSpliceOrganizer_values);
		$smarty->assign("ComboBox_FibersSpliceOrganizer_text",$ComboBox_FibersSpliceOrganizer_text);
		$smarty->assign("ComboBox_CableLinePoint_values",$ComboBox_CableLinePoint_values);
		$smarty->assign("ComboBox_CableLinePoint_text",$ComboBox_CableLinePoint_text);
		$smarty->assign("ComboBox_CableLinePoint_selected",$_GET['clpid1']);
		$smarty->assign("IsA",$_GET['isa']);
		$smarty->assign("SpliceId",$_GET['spliceid']);
		$smarty->assign("NetworkNodeId",$NetworkNodeId);
		$smarty->assign("curr_fiber",$_GET['fiber1']);
	}
	elseif ($_GET['mode'] == 'add')
	{
		if ($_SESSION['class'] > 1)
		{
			die("!!!");
		}

		$smarty->assign("mode","add");

		$NetworkNodeId = $_GET['networknodeid'];
        $res = GetFiberTable($NetworkNodeId);
        /*$j = (int)$res['CableLinePoins'][$_GET['clpid1']];
        for ($i = 1; $i<=$res['cl_array']['rows'][$j]['fiber']; $i++)
		{
			$arr = $res['SpliceArray'][$j][$i];
			if ((!isset($arr)) or ($i == $_GET['fiber2']))
			{
				$fibers[] = $i;
			}
		} */
		$fibers = GetFibers($_GET['clpid1'],$NetworkNodeId,$_GET['fiber2']);

		$cl_array = $res['cl_array'];
		for ($i = 0; $i < $cl_array['count']; $i++){
			$ComboBox_CableLinePoint_values[] = $cl_array['rows'][$i]['clpid'];
			$ComboBox_CableLinePoint_text[] = $cl_array['rows'][$i]['name'];
		}
		$cable1 = $cl_array['rows'][$res['CableLinePoints'][$_GET['clpid1']]]['name'];

		$res = FSO_Select('','');
  		for ($i = 0; $i < $res['count']; $i++) {
  			$ComboBox_FibersSpliceOrganizer_values[] = $res['rows'][$i]['id'];
  			$ComboBox_FibersSpliceOrganizer_text[] = $res['rows'][$i]['id']." (".$res['rows'][$i]['FiberSpliceOrganizationType'].")";
  		}

  		$smarty->assign("cable1",$cable1);
  		$smarty->assign("fiber1",$_GET['fiber1']);
  		$smarty->assign("ComboBox_Fibers_values",$fibers);
		$smarty->assign("ComboBox_Fibers_text",$fibers);
		$smarty->assign("ComboBox_FibersSpliceOrganizer_values",$ComboBox_FibersSpliceOrganizer_values);
		$smarty->assign("ComboBox_FibersSpliceOrganizer_text",$ComboBox_FibersSpliceOrganizer_text);
		$smarty->assign("ComboBox_CableLinePoint_values",$ComboBox_CableLinePoint_values);
		$smarty->assign("ComboBox_CableLinePoint_text",$ComboBox_CableLinePoint_text);
		$smarty->assign("ComboBox_CableLinePoint_selected",$_GET['clpid1']);
		$smarty->assign("clpid1",$_GET['clpid1']);
		$smarty->assign("NetworkNodeId",$NetworkNodeId);
	}
    elseif (isset($_GET['networknodeid']))
    {
    	require_once("func/CableType_func.php");
    	$NetworkNodeId = $_GET['networknodeid'];
		$res = GetFiberTable($NetworkNodeId);
//		print_r($res);
//		print('ff '.$res['cl_array']['rows'][0]['fiber']);
/*		if ($NPrint != 1)
		{
			$linksD = ' <a href="#">[x]</a>';
			$linksN = '<a href="#">[+]</a>';
		} */
/*		$cols[] = "Кабель";
		$cols[] = "Маркировка";
		$cols[] = "Имя";*/

		$cols[] = "Волокна";
		for ($i = 0; $i < count($res['CableLinePoints']); $i++) {
			$cols[] = "Кабель:&nbsp;<u>".($i+1)."</u><br>Маркировка:&nbsp;<u>".$res['cl_array']['rows'][$i]['marking']."</u><br>Имя:&nbsp;<u>".$res['cl_array']['rows'][$i]['name']."</u>";
/*			$table[] = "<u>".($i+1)."</u>";
			$table[] = "<u>".$res['cl_array']['rows'][$i]['marking']."</u>";
			$table[] = "<u>".$res['cl_array']['rows'][$i]['name']."</u>"; */
		}

		for ($i = 1; $i <= $res['maxfiber']; $i++) {
            $table[] = $i;        	for ($j = 0; $j < count($res['CableLinePoints']); $j++)
        	{
            	$arr = $res['SpliceArray'][$j][$i];
            	$clpid1 = $res['cl_array']['rows'][$j][1];
            	$clpid2 = $res['cl_array']['rows'][$arr[1]][1];
            	$fiber1 = $i;
            	$fiber2 = $arr[2];
            	$is_a = $arr[3];
            	$splice_id = $arr[0];
            	if (isset($arr))
				{
					$linksD = '<a href="FiberSplice.php?mode=delete&spliceid='.$splice_id.'">[x]</a>';
					$table[] = $arr[1]+1 . ' - ' . $arr[2].' <a href="FiberSplice.php?mode=change&clpid1='.$clpid1.'&clpid2='.$clpid2.'&fiber1='.$fiber1.'&fiber2='.$fiber2.'&networknodeid='.$NetworkNodeId.'&spliceid='.$splice_id.'&isa='.$is_a.'">[E]</a> '.$linksD;
				}
				else
				{
					$linksN = '<a href="FiberSplice.php?mode=add&clpid1='.$clpid1.'&fiber1='.$fiber1.'&networknodeid='.$NetworkNodeId.'">[+]</a>';
					$table[] = $linksN;
				}
			}
		}
		$smarty->assign("cols",$cols);
		$smarty->assign("data",$table);

	}
	elseif (($_GET['mode'] == 'delete') and (isset($_GET['spliceid'])))
	{
		if ($_SESSION['class'] > 1)
		{			die("!!!");
		}		$wr['id'] = $_GET['spliceid'];
		FiberSplice_DELETE($wr);
    	header("Refresh: 2; url=FiberSplice.php");
		print("Сварка удалена!");
		die();
 	}

	$smarty->display('FiberSplice.tpl');
}
?>
