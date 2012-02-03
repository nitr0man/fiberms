<?php
require_once("auth.php");
require_once("smarty.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		require "func/NetworkBoxType_func.php";
		require_once("functions.php");
		if ($_POST['mode'] == 1)
			{
				$boxtypeid = $_POST['boxtypeid'];
				if ($boxtypeid == 0)
					{
						$res = NetworkBoxType_SELECT('id LIMIT 1','');  					    $rows = $res['rows'];
           				$boxtypeid = $rows[0]['id'];
					}
				$wr['NetworkBoxType'] = $boxtypeid;
				$res = NetworkBox_SELECT('',$wr);
				$boxtypecount = $res['count'];
				unset($wr);
				$wr['id'] = $boxtypeid;
				$res = NetworkBoxType_SELECT('',$wr);
				$rows = $res['rows'];
				$smarty->assign("id",$rows[0]['id']);
				$smarty->assign("marking",$rows[0]['marking']);
				$smarty->assign("manufacturer",$rows[0]['manufacturer']);
				$smarty->assign("units",$rows[0]['units']);
				$smarty->assign("width",$rows[0]['width']);
				$smarty->assign("height",$rows[0]['height']);
				$smarty->assign("length",$rows[0]['length']);
				$smarty->assign("diameter",$rows[0]['diameter']);
				$res = NetworkBoxType_SELECT('','');
				$typecount = $res['count'];
				$rows = $res['rows'];
				$i = -1;
				while (++$i<$typecount)
				{					$combobox_boxtype_values[] = $rows[$i]['id'];
					$combobox_boxtype_text[] = $rows[$i]['marking'];
				}
				$smarty->assign("count",'<a href="NetworkBox.php?typeid='.$boxtypeid.'" target="_blank">'.$boxtypecount."</a>");
				$smarty->assign("combobox_boxtype_values",$combobox_boxtype_values);
				$smarty->assign("combobox_boxtype_text",$combobox_boxtype_text);
				$smarty->assign("combobox_boxtype_selected",$boxtypeid);
				$smarty->display('NetworkBoxType_content.tpl');
			}
		else
		if ($_POST['mode'] == 2)
			{
				$id = $_POST['id'];				$marking = $_POST['marking'];
		    	$manufacturer = $_POST['manufacturer'];
		    	$units = $_POST['units'];
		    	$width = $_POST['width'];
		    	$height = $_POST['height'];
		    	$length = $_POST['length'];
		    	$diameter = $_POST['diameter'];
		    	if ($_POST['rb'] == 'true')
		    	{
		    		$upd['marking'] = "'$marking'";
		    		$upd['manufacturer'] = "'$manufacturer'";
		    		$upd['units'] = "$units";
		    		$upd['width'] = "$width";
		    		$upd['height'] = "$height";
		    		$upd['length'] = "$length";
		    		$upd['diameter'] = "$diameter";
		    		$wr['id'] = $id;
				   	NetworkBoxType_UPDATE($upd,$wr);
				   	print("Изменено успешно!<br />
					<a href=\"NetworkBoxType.php\">Назад</a>");
				}
				else
				{
					$ins['marking'] = "'$marking'";
		    		$ins['manufacturer'] = "'$manufacturer'";
		    		$ins['units'] = "$units";
		    		$ins['width'] = "$width";
		    		$ins['height'] = "$height";
		    		$ins['length'] = "$length";
		    		$ins['diameter'] = "$diameter";					NetworkBoxType_INSERT($ins);
					print("Тип успешно добавлен!<br />
					<a href=\"NetworkBoxType.php\">Назад</a>");
				}
			}
	}
else
{
	$smarty->display('NetworkBoxType.tpl');
}
?>
