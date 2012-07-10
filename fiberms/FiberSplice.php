<?php
require_once("auth.php");
require_once("smarty.php");
require_once("func/FiberSplice.php");
require_once("backend/NetworkNode.php");
require_once("design_func.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
	$back = $_POST['back'];
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
		$res = FiberSplice_Mod($SpliceId, $CableLinePointA, $fiberA, $CableLinePointB, $fiberB, $FiberSpliceOrganizer, $IsA);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=".$back);
	        $message = 'Сварка изменена!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 2) {
	    $CableLinePointA = $_POST['clpid1'];
		$fiberA = $_POST['fiber'];
		$CableLinePointB = $_POST['CableLinePoint'];
		$fiberB = $_POST['Fibers'];
		$FiberSpliceOrganizer = $_POST['FibersSpliceOrganizer'];
		$res = FiberSplice_Add($CableLinePointA, $fiberA, $CableLinePointB, $fiberB, $FiberSpliceOrganizer);
		if (isset($res['error'])) {
           	$message = $res['error'];
			$error = 1;
        } elseif ($res == 1) {
			header("Refresh: 3; url=".$back);
	        $message = 'Сварка добавлена!';
			$error = 0;
        } else {
    	   	$message = 'Неверно заполнены поля!';
			$error = 1;
    	}
	} elseif ($_POST['mode'] == 3) {
		$currFiber = $_POST['CurrFiber'];
		if ((!isset($currFiber)) or ($currFiber == '')){			$currFiber = -1;
		}
		$fibers = getFibers($_POST['CableLinePoint'], $_POST['NetworkNodeId'], $currFiber);
	  	$smarty->assign("ComboBox_Fibers_values", $fibers);
		$smarty->assign("ComboBox_Fibers_text", $fibers);
		$smarty->display("FiberSplice_content_Fibers.tpl");
		die();
	}
	showMessage($message, $error);
}
else
{   if (($_GET['mode'] == 'change') and (isset($_GET['networknodeid'])) and (isset($_GET['clpid1'])) and (isset($_GET['fiber1']))) {
	    if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			showMessage($message, 0);
		}

	    $smarty->assign("mode", "add_change");
		$smarty->assign("mod", "1");
		$smarty->assign("back", getenv("HTTP_REFERER"));

        $networkNodeId = $_GET['networknodeid'];
        $res = getFiberTable($networkNodeId);
		$fibers = getFibers($_GET['clpid1'], $networkNodeId, $_GET['fiber1']);

		$cl_array = $res['cl_array'];
		for ($i = 0; $i<$cl_array['count']; $i++) {			$ComboBox_CableLinePoint_Values[] = $cl_array['rows'][$i]['clpid'];
			$ComboBox_CableLinePoint_Text[] = $cl_array['rows'][$i]['name'];
		}
		$cable1 = $cl_array['rows'][$res['CableLinePoints'][$_GET['clpid1']]]['name'];

  		$smarty->assign("cable1", $cable1);
  		$smarty->assign("fiber1", $_GET['fiber1']);
  		$smarty->assign("Combobox_Fibers_selected", $_GET['fiber2']);
  		$smarty->assign("ComboBox_Fibers_values", $fibers);
		$smarty->assign("ComboBox_Fibers_text", $fibers);

		//$res = FSO_Select('', '');
		$res = getFiberSpliceOrganizerInfo(-1, -1, $networkNodeId);
  		for ($i = 0; $i < $res['count']; $i++) {
  			$ComboBox_FibersSpliceOrganizer_Values[] = $res['rows'][$i]['id'];
  			$ComboBox_FibersSpliceOrganizer_Text[] = $res['rows'][$i]['id']." (".$res['rows'][$i]['FiberSpliceOrganizationTypeId'].")";
  		}
  		$smarty->assign("ComboBox_FibersSpliceOrganizer_values", $ComboBox_FibersSpliceOrganizer_Values);
		$smarty->assign("ComboBox_FibersSpliceOrganizer_text", $ComboBox_FibersSpliceOrganizer_Text);
		$smarty->assign("ComboBox_CableLinePoint_values", $ComboBox_CableLinePoint_Values);
		$smarty->assign("ComboBox_CableLinePoint_text", $ComboBox_CableLinePoint_Text);
		$smarty->assign("ComboBox_CableLinePoint_selected", $_GET['clpid2']);
		$smarty->assign("IsA", $_GET['isa']);
		$smarty->assign("SpliceId", $_GET['spliceid']);
		$smarty->assign("NetworkNodeId", $networkNodeId);
		$smarty->assign("curr_fiber", $_GET['fiber1']);
	} elseif ($_GET['mode'] == 'add') {
		if ($_SESSION['class'] > 1)	{
			$message = '!!!';
			showMessage($message, 0);
		}

		$smarty->assign("mode", "add_change");
		$smarty->assign("mod", "2");
		$smarty->assign("back", getenv("HTTP_REFERER"));
		
		$networkNodeId = $_GET['networknodeid'];
        $res = getFiberTable($networkNodeId);
		$fibers = getFibers($_GET['clpid1'], $networkNodeId, $_GET['fiber2']);

		$cl_array = $res['cl_array'];
		for ($i = 0; $i < $cl_array['count']; $i++) {
			$ComboBox_CableLinePoint_Values[] = $cl_array['rows'][$i]['clpid'];
			$ComboBox_CableLinePoint_Text[] = $cl_array['rows'][$i]['name'];
		}
		$cable1 = $cl_array['rows'][$res['CableLinePoints'][$_GET['clpid1']]]['name'];

		//$res = FSO_Select('', '');
		$res = getFiberSpliceOrganizerInfo(-1, -1, $networkNodeId);
  		for ($i = 0; $i < $res['count']; $i++) {
  			$ComboBox_FibersSpliceOrganizer_Values[] = $res['rows'][$i]['id'];
  			$ComboBox_FibersSpliceOrganizer_Text[] = $res['rows'][$i]['id']." (".$res['rows'][$i]['FiberSpliceOrganizationTypeId'].")";
  		}

  		$smarty->assign("cable1", $cable1);
  		$smarty->assign("fiber1", $_GET['fiber1']);
  		$smarty->assign("ComboBox_Fibers_values", $fibers);
		$smarty->assign("ComboBox_Fibers_text", $fibers);
		$smarty->assign("ComboBox_FibersSpliceOrganizer_values", $ComboBox_FibersSpliceOrganizer_Values);
		$smarty->assign("ComboBox_FibersSpliceOrganizer_text", $ComboBox_FibersSpliceOrganizer_Text);
		$smarty->assign("ComboBox_CableLinePoint_values", $ComboBox_CableLinePoint_Values);
		$smarty->assign("ComboBox_CableLinePoint_text", $ComboBox_CableLinePoint_Text);
		$smarty->assign("ComboBox_CableLinePoint_selected", $_GET['clpid1']);
		$smarty->assign("clpid1", $_GET['clpid1']);
		$smarty->assign("NetworkNodeId", $networkNodeId);
		$smarty->assign("curr_fiber", '-1');
	} elseif (isset($_GET['networknodeid'])) {
    	$networkNodeId = $_GET['networknodeid'];
		$wr['id'] = $networkNodeId;
		$res = NetworkNode_SELECT('', '', $wr);
		$networkNodeName = $res['rows'][0]['name'];
		$res = getFiberTable($networkNodeId);
		if ($res['maxfiber'] < 1) {
			$message = 'Узлу должно принадлежать минимум 1 кабель!';
			showMessage($message, 0);
		}
		
		$cols[] = "№";
		for ($i = 0; $i < count($res['CableLinePoints']); $i++) {
			/*if (isset($_GET['print'])) {
				//$cols[] = $res['cl_array']['rows'][$i]['name'];
				$cols[] = ($i+1);
			} else {
				//$cols[] = '<a href="CableLine.php?mode=charac&cablelineid='.$res['cl_array']['rows'][$i]['clid'].'">'.$res['cl_array']['rows'][$i]['name'].'</a>';
			}*/
			$cols[] = ($i+1);
			if (isset($_GET['print'])) {
				$tr_arr['marking'][$i] = $res['cl_array']['rows'][$i]['manufacturer'].'<br>'.$res['cl_array']['rows'][$i]['marking'];
			} else {
				$tr_arr['marking'][$i] = '<a href="CableType.php?mode=charac&cabletypeid='.$res['cl_array']['rows'][$i]['ctid'].'">'.$res['cl_array']['rows'][$i]['manufacturer'].'<br>'.$res['cl_array']['rows'][$i]['marking'].'</a>';
			}
			$tr_arr['fiber_count'][$i] = $res['cl_array']['rows'][$i]['fiber'];
			$direction = getDirection($res['cl_array']['rows'][$i]['clpid'], $networkNodeId);
			if ($direction['name'] == '-') {
				$tr_arr['direction'][$i] = '-';
			} else {
				if (isset($_GET['print'])) {
					$tr_arr['direction'][$i] = $direction['name'];
				} else {
					$tr_arr['direction'][$i] = '<a href="NetworkNodes.php?mode=charac&nodeid='.$direction['NetworkNode'].'">'.$direction['name'].'</a>';
				}
			}
			if (isset($_GET['print'])) {
				$tr_arr['CableLineNames'][$i] = $res['cl_array']['rows'][$i]['name'];
			} else {
				$tr_arr['CableLineNames'][$i] = '<a href="CableLine.php?mode=charac&cablelineid='.$res['cl_array']['rows'][$i]['clid'].'">'.$res['cl_array']['rows'][$i]['name'].'</a>';
			}
			
			//$tr_attr = array("class=header", "class=header", "class=header", 'class=header class="bottomborder"');
			if (isset($_GET['print'])) {
				$tr_attr = array("class=cp", "class=cp", "class=cp", 'class="bottomborder"');
			} else {
				$tr_attr = array("class=header", "class=header", "class=header", 'class=header class="bottomborder"');
			}
		}
		
		$table = array_merge(array("Имя"), $tr_arr['CableLineNames'], array("Направление"), $tr_arr['direction'], array("Маркировка"), $tr_arr['marking'], array("Количество волокон"), $tr_arr['fiber_count']);
		for ($i = 1; $i <= $res['maxfiber']; $i++) {
			if (isset($_GET['print'])) {
				$table[] = '<b>'.$i.'</b>';
			} else {
				$table[] = $i;
			}
            for ($j = 0; $j < count($res['CableLinePoints']); $j++)	{
            	$arr = $res['SpliceArray'][$j][$i];
            	$clpid1 = $res['cl_array']['rows'][$j]['clpid'];
            	$clpid2 = $res['cl_array']['rows'][$arr[1]]['clpid'];
            	$fiber1 = $i;
            	$fiber2 = $arr[2];
            	$is_a = $arr[3];
            	$splice_id = $arr[0];
            	if (isset($arr)) {
					if (isset($_GET['print'])) {
						$linksD = ' ';
					} else {
						$linksD = ' <a href="FiberSplice.php?mode=delete&spliceid='.$splice_id.'"&networknodeid='.$networkNodeId.'>[x]</a>';
					}
					if (isset($_GET['print'])) {
						$table[] = (string)($arr[1]+1) . ' - ' . $arr[2];
					} else {
						$table[] = ' <a href="FiberSplice.php?mode=change&clpid1='.$clpid1.'&clpid2='.$clpid2.'&fiber1='.$fiber1.'&fiber2='.$fiber2.'&networknodeid='.$networkNodeId.'&spliceid='.$splice_id.'&isa='.$is_a.'">'.(string)($arr[1]+1) . ' - ' . $arr[2].'</a> '.$linksD;
					}
				} else {
					if (($i > $res['cl_array']['rows'][$j]['fiber']) or (isset($_GET['print']))) {
						$linksN = ' &nbsp;';
					}
					else {						$linksN = '<a href="FiberSplice.php?mode=add&clpid1='.$clpid1.'&fiber1='.$fiber1.'&networknodeid='.$networkNodeId.'">[+]</a>';
					}
					$table[] = $linksN;
				}
				$tr_attr[] = "";
			}
		}
		if (isset($_GET['print'])) {
			$printLink = '';
		} else {
			$printLink = '[<a href="FiberSplice.php?networknodeid='.$networkNodeId.'&print">Версия для печати</a>]';
		}
		
		$smarty->assign("tr_attr", $tr_attr);
		$smarty->assign("cols", $cols);
		$smarty->assign("data", $table);
		$smarty->assign("nodeName", $networkNodeName);
		$smarty->assign("printLink", $printLink);
	} elseif (($_GET['mode'] == 'delete') and (isset($_GET['spliceid']))) {
		if ($_SESSION['class'] > 1)	{			$message = '!!!';
			showMessage($message, 0);
		}		$wr['id'] = $_GET['spliceid'];
		FiberSplice_DELETE($wr);
    	header("Refresh: 2; url=".getenv("HTTP_REFERER"));
		$message = "Сварка удалена!";
		showMessage($message, 0);
 	}

	$smarty->display('FiberSplice.tpl');
}
?>
