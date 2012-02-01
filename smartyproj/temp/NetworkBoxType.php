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
						$res = NetworkBoxType_SELECT('id','ORDER BY id LIMIT 1','');
						  FROM "NetworkBoxType" ORDER BY id LIMIT 1');*/
  					    while ($row = pg_fetch_array($res)) {
  					    }
					}
/*				$res = PQuery('SELECT COUNT(*) AS count FROM "NetworkBox" WHERE "NetworkBoxType"='.$boxtypeid);*/
				$res = NetworkBox_SELECT('COUNT(*) AS count','','"NetworkBoxType"='.$boxtypeid);
				while ($row = pg_fetch_array($res)) {
					$boxtypecount = $row['count'];
				}
/*				$res = PQuery('SELECT * FROM "NetworkBoxType" WHERE id='.$boxtypeid);*/
				$res = NetworkBoxType_SELECT('*','','id='.$boxtypeid);
				while ($boxrow = pg_fetch_array($res)) {
					$smarty->assign("marking",$boxrow['marking']);
					$smarty->assign("manufacturer",$boxrow['manufacturer']);
					$smarty->assign("units",$boxrow['units']);
					$smarty->assign("width",$boxrow['width']);
					$smarty->assign("height",$boxrow['height']);
					$smarty->assign("length",$boxrow['length']);
					$smarty->assign("diameter",$boxrow['diameter']);
				}
/*				$res = PQuery('SELECT id, "marking" FROM "NetworkBoxType"');*/
				$res = NetworkBoxType_SELECT('id, "marking"','','');
				while ($boxtype = pg_fetch_array($res)) {
//					print("<option value=\"".$mybox['id']."\">".$mybox['marking']."</option>");
					$combobox_boxtype_values[] = $boxtype['id'];
					$combobox_boxtype_text[] = $boxtype['marking'];
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
				$id = $_POST['id'];
		    	$manufacturer = $_POST['manufacturer'];
		    	$units = $_POST['units'];
		    	$width = $_POST['width'];
		    	$height = $_POST['height'];
		    	$length = $_POST['length'];
		    	$diameter = $_POST['diameter'];
		    	if ($_POST['rb'] == 'true')
		    	{
				   	NetworkBoxType_UPDATE('"marking"=\''.$marking.'\',"manufacturer"=\''.$manufacturer.'\',"units"='.$units.',"width"='.$width.',"height"='.$height.',"length"='.$length.',"diameter"='.$diameter,'id='.$id);
				   	print("Изменено успешно!<br />
					<a href=\"NetworkBoxType.php\">Назад</a>");
				}
				else
				{
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