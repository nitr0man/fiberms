<?php
require_once("auth.php");
require_once("smarty.php");
require_once("/func/FiberSplice.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
	if ($_POST['mode'] == 1) {
	   	$SpliceId = $_POST['SpliceId'];
	   	$IsA = $_POST['IsA'];
	   	if ($IsA == 0) {	   		$CableLinePointA = $_POST['CableLinePoint'];
	   		$fiberA = $_POST['Fibers'];
	   		$FiberSpliceOrganizer = $_POST['FibersSpliceOrganizer'];
			$CableLinePointB = '';
			$fiberB = '';
	   	} else {
			$CableLinePointB = $_POST['CableLinePoint'];
			$fiberB = $_POST['Fibers'];
			$FiberSpliceOrganizer = $_POST['FibersSpliceOrganizer'];
			$CableLinePointA = '';
			$fiberA = '';
		}
		$res = FiberSplice_Mod($SpliceId,$CableLinePointA,$fiberA,$CableLinePointB,$fiberB,$FiberSpliceOrganizer,$IsA);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=FiberSplice.php");
	        $message = 'Сварка изменена!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 2) {
	    $CableLinePointA = $_POST['CableLinePoint'];
		$fiberA = $_POST['Fibers'];
		$CableLinePointB = $_POST['CableLinePoint'];
		$fiberB = $_POST['Fibers'];
		$FiberSpliceOrganizer = $_POST['FibersSpliceOrganizer'];
		$res = FiberSplice_Add($CableLinePointA,$fiberA,$CableLinePointB,$fiberB,$FiberSpliceOrganizer);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=FiberSplice.php");
	        $message = 'Сварка добавлена!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 3) {
		$CurrFiber = $_POST['CurrFiber'];
		if ((!isset($CurrFiber)) or ($CurrFiber == '')){			$CurrFiber = -1;
		}
		$fibers = GetFibers($_POST['CableLinePoint'],$_POST['NetworkNodeId'],$CurrFiber);
	  	$smarty->assign("ComboBox_Fibers_values",$fibers);
		$smarty->assign("ComboBox_Fibers_text",$fibers);
		$smarty->display("FiberSplice_content_Fibers.tpl");
	}
	ShowMessage($message,$error);
}
else
{   if (($_GET['mode'] == 'change') and (isset($_GET['networknodeid'])) and (isset($_GET['clpid1'])) and (isset($_GET['fiber1']))) {
	    if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			ShowMessage($message,0);
		}

	    $smarty->assign("mode","change");

        $NetworkNodeId = $_GET['networknodeid'];
        $res = GetFiberTable($NetworkNodeId);
		$fibers = GetFibers($_GET['clpid1'],$NetworkNodeId,$_GET['fiber1']);

		$cl_array = $res['cl_array'];
		for ($i = 0; $i<$cl_array['count']; $i++) {			$ComboBox_CableLinePoint_values[] = $cl_array['rows'][$i]['clpid'];
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
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			ShowMessage($message,0);
		}

		$smarty->assign("mode","add");

		$NetworkNodeId = $_GET['networknodeid'];
        $res = GetFiberTable($NetworkNodeId);
		$fibers = GetFibers($_GET['clpid1'],$NetworkNodeId,$_GET['fiber2']);

		$cl_array = $res['cl_array'];
		for ($i = 0; $i < $cl_array['count']; $i++) {
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
	} elseif (isset($_GET['networknodeid'])) {
    	$NetworkNodeId = $_GET['networknodeid'];
		$res = GetFiberTable($NetworkNodeId);
		$cols[] = "Имя";
		for ($i = 0; $i < count($res['CableLinePoints']); $i++) {
			$cols[] = "<u>".$res['cl_array']['rows'][$i]['name']."</u>";
			$tr_arr['marking'][$i] = "<u>".$res['cl_array']['rows'][$i]['marking']."</u>";
			$tr_arr['fiber_count'][$i] = $res['cl_array']['rows'][$i]['fiber'];
			$tr_arr['direction'][$i] = GetDirection($res['cl_array']['rows'][$i]['clpid'],$NetworkNodeId);
			$tr_arr['number'][$i] = "<u>".($i+1)."</u>";
			$tr_attr = array("class=header","class=header","class=header","class=header");
		}
		$table = array_merge(array("Маркировка"),$tr_arr['marking'],array("Количество волокон"),$tr_arr['fiber_count'],array("Направление"),$tr_arr['direction'],array(""),$tr_arr['number']);
		for ($i = 1; $i <= $res['maxfiber']; $i++) {
            $table[] = $i;
            for ($j = 0; $j < count($res['CableLinePoints']); $j++)	{
            	$arr = $res['SpliceArray'][$j][$i];
            	$clpid1 = $res['cl_array']['rows'][$j]['clpid'];
            	$clpid2 = $res['cl_array']['rows'][$arr[1]]['clpid'];
            	$fiber1 = $i;
            	$fiber2 = $arr[2];
            	$is_a = $arr[3];
            	$splice_id = $arr[0];
            	if (isset($arr)) {
					$linksD = ' <a href="FiberSplice.php?mode=delete&spliceid='.$splice_id.'">[x]</a>';
					$table[] = ' <a href="FiberSplice.php?mode=change&clpid1='.$clpid1.'&clpid2='.$clpid2.'&fiber1='.$fiber1.'&fiber2='.$fiber2.'&networknodeid='.$NetworkNodeId.'&spliceid='.$splice_id.'&isa='.$is_a.'">'.(string)($arr[1]+1) . ' - ' . $arr[2].'</a> '.$linksD;
				} else {
					if ($i > $res['cl_array']['rows'][$j]['fiber']) {
						$linksN = ' ';
					}
					else {						$linksN = '<a href="FiberSplice.php?mode=add&clpid1='.$clpid1.'&fiber1='.$fiber1.'&networknodeid='.$NetworkNodeId.'">[+]</a>';
					}
					$table[] = $linksN;
				}
				$tr_attr[] = "";
			}
		}
		$smarty->assign("tr_attr",$tr_attr);
		$smarty->assign("cols",$cols);
		$smarty->assign("data",$table);

	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['spliceid']))) {
		if ($_SESSION['class'] > 1)	{			$message = '!!!';
			ShowMessage($message,0);
		}		$wr['id'] = $_GET['spliceid'];
		FiberSplice_DELETE($wr);
    	header("Refresh: 2; url=FiberSplice.php");
		$message = "Сварка удалена!";
		ShowMessage($message,0);		
 	}

	$smarty->display('FiberSplice.tpl');
}
?>
