<?php

function PQuery($query)
{
	require "config.php";
	$result = pg_query($connection, $query) or die(pg_last_error($connection));
	return $result;
}


if($_SERVER["REQUEST_METHOD"] == 'POST')
	{		if ($_POST['whichadded'] == 'networkboxtype')
			{		    	$marking = $_POST['marking'];
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
			{    			$res = PQuery('SELECT id, "marking" FROM "NetworkBoxType"');
    			/*print("	<table>
				<tr>
				<td><label class=\"events_anonce\">Тип ящика</label></td><td>");*/
    			print("<select name=\"networkboxtypes\" onChange=\"javascript: gettypeboxinfo(document.boxtypevalue.networkboxtypes.value,2);\">");
			//	print("<select>");
				print("<option selected=\"true\">Выберите нужное</option>");
				while ($mybox = pg_fetch_array($res)) {
				//	print("<option value=\"".$res['id']."\">".$res['marking']."</option>");
				print("<option value=\"".$mybox['id']."\">".$mybox['marking']."</option>");
				}
				print("</select>");
				//print("</select>");
			//	print('SELECT id FROM "NetworkBoxType" ORDER BY id LIMIT 1');
			/*	$res = PQuery('SELECT "id" FROM "NetworkBoxType" ORDER BY "id" LIMIT 1');
				while ($row = pg_fetch_array($res)) {
					$boxtypeid = $row['id'];
				}
				$res = PQuery('SELECT COUNT(*) AS count FROM "NetworkBox" WHERE "NetworkBoxType"='.$boxtypeid);
				while ($row = pg_fetch_array($res)) {
					$boxtypeid = $row['count'];
				}

			/*	print("</select>
				</td>
				<br />
				</tr>
				<tr>
				<td><label class=\"events_anonce\">Количество ящиков:</label></td><td id=\"inventorynumber\"> <a href=\"#\">$boxtypeid</a></td><!--<td><input type=\"text\" name=\"invmun\" size=\"30\" /></td>-->
				<br />
				</tr>
				<tr>
				<td><label class=\"events_anonce\">deprecated</label></td><td><input type=\"hidden\" name=\"whichadded\" value=\"networkbo2x\" size=\"30\" /></td>
				</tr>
				<tr>
				<td><input type=\"submit\" /></td>
				</tr>
				</table>");*/
			}
		else
		if ($_POST['mode'] == 2)
			{				$boxtypeid = $_POST['boxtypeid'];
			//	$res = PQuery('SELECT id, "marking" FROM "NetworkBoxType"');
    			/*print("	<table>
				<tr>
				<td><label class=\"events_anonce\">Тип ящика</label></td><td>");
    			print("<select name=\"networkboxtypes\" onChange=\"javascript: gettypeboxinfo(document.boxtypevalue.networkboxtypes.value,2);\">");
				while ($networkbox = pg_fetch_array($res)) {					if ($boxtypeid == $networkbox['id'])
					{
						print("<option ХУЙ value=\"".$networkbox['id']."\" selected>".$networkbox['marking']."</option>");
					}
					else
					{
						print("<option ХУЙ value=\"".$networkbox['id']."\">".$networkbox['marking']."</option>");
					}
				}*/
				$res = PQuery('SELECT COUNT(*) AS count FROM "NetworkBox" WHERE "NetworkBoxType"='.$boxtypeid);
				while ($row = pg_fetch_array($res)) {
					$boxtypeid = $row['count'];
				}

				print($boxtypeid);
			}
	}
else print("bris!");
?>
