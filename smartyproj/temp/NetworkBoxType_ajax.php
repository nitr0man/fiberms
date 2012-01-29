<?php
require "functions.php";
require "smarty.php";
if ($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		if ($_POST['whichadded'] == 'networkboxtype')
			{
		    	$marking = $_POST['marking'];
		    	$manufacturer = $_POST['manufacturer'];
		    	$units = $_POST['units'];
		    	$width = $_POST['width'];
		    	$height = $_POST['height'];
		    	$length = $_POST['length'];
		    	$diameter = $_POST['diameter'];
		    	PQuery('INSERT INTO "NetworkBoxType" (marking, manufacturer, units, width, height, length, diameter) VALUES (\''.$marking.'\', \''.$manufacturer.'\', '.$units.', '.$width.', '.$height.', '.$length.', '.$diameter.')');
		    	print("Добавлено!
		    	<br><a href=\"index.php\">Назад</a>");
			}
		else
		if ($_POST['mode'] == 1)
			{
				$boxtypeid = $_POST['boxtypeid'];
    			$res = PQuery('SELECT id, "marking" FROM "NetworkBoxType"');
    			print("<select name=\"networkboxtypes\" onChange=\"javascript: gettypeboxinfo(document.boxtypevalue.networkboxtypes.value,2);\">");
				while ($mybox = pg_fetch_array($res)) {					print("<option value=\"".$mybox['id']."\">".$mybox['marking']."</option>");
				}
				print("</select>");
				//print("<script type=\"text/javascript\">var a=2; var b=3; alert(a+b);</script>");
			}
		else
		if ($_POST['mode'] == 2)
			{
				$boxtypeid = $_POST['boxtypeid'];
				$res = PQuery('SELECT COUNT(*) AS count FROM "NetworkBox" WHERE "NetworkBoxType"='.$boxtypeid);
				while ($row = pg_fetch_array($res)) {
					$boxtypecount = $row['count'];
				}
				$res = PQuery('SELECT * FROM "NetworkBoxType" WHERE id='.$boxtypeid.';');
				while ($boxrow = pg_fetch_array($res)) {
					$smarty->assign("marking",$boxrow['marking']);
					$smarty->assign("manufacturer",$boxrow['manufacturer']);
					$smarty->assign("units",$boxrow['units']);
					$smarty->assign("width",$boxrow['width']);
					$smarty->assign("height",$boxrow['height']);
					$smarty->assign("length",$boxrow['length']);
					$smarty->assign("diameter",$boxrow['diameter']);
				}
				$res = PQuery('SELECT id, "marking" FROM "NetworkBoxType"');
				while ($mybox = pg_fetch_array($res)) {
//					print("<option value=\"".$mybox['id']."\">".$mybox['marking']."</option>");
					$combobox_boxtype_values[] = $mybox['id'];
					$combobox_boxtype_text[] = $mybox['marking'];
				}
				$smarty->assign("count",$boxtypecount);
				$smarty->assign("combobox_boxtype_values",$combobox_boxtype_values);
				$smarty->assign("combobox_boxtype_text",$combobox_boxtype_text);
				$smarty->assign("combobox_boxtype_selected",$boxtypeid);
				$smarty->display('NetworkBoxType_content.tpl');
			}
		if ($_POST['mode'] == 3)
			{
				$boxtypeid = $_POST['boxtypeid'];
				$res = PQuery('SELECT * FROM "NetworkBoxType" WHERE id='.$boxtypeid.';');
				while ($boxrow = pg_fetch_array($res)) {
					print("&nbsp;<script type=\"text/javascript\">
					var marking = \"".$boxrow['marking']."\";
					var manufacturer = \"".$boxrow['manufacturer']."\";
					var units = \"".$boxrow['units']."\";
					var width = \"".$boxrow['width']."\";
					var height = \"".$boxrow['height']."\";
					var length = \"".$boxrow['length']."\";
					var diameter = \"".$boxrow['diameter']."\";
					</script>");
					$smarty->assign("marking","Fred Irving Johnathan Bradley Peppergill",true);
					$smarty->assign("marking","Fred Irving Johnathan Bradley Peppergill",true);
					$smarty->assign("marking","Fred Irving Johnathan Bradley Peppergill",true);
					$smarty->assign("marking","Fred Irving Johnathan Bradley Peppergill",true);
					$smarty->assign("marking","Fred Irving Johnathan Bradley Peppergill",true);
					$smarty->assign("marking","Fred Irving Johnathan Bradley Peppergill",true);
					$smarty->assign("marking","Fred Irving Johnathan Bradley Peppergill",true);
				}
				$smarty->display('networkbox.tpl');
			}
	}
else print("bris!");
/*var marking = \"".$boxrow['marking']."\";
						   var manufacturer = \"".$boxrow['manufacturer']."\";
						   var units = \"".$boxrow['units']."\";
						   var width = \"".$boxrow['width']."\";
						   var height = \"".$boxrow['height']."\";
						   var length = \"".$boxrow['length']."\";
						   var diameter = \"".$boxrow['diameter']."\";
						   setvalues(marking,manufacturer,units,width,height,length,diameter);
						   */
?>