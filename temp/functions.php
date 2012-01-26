<?php

function PQuery($query)
{	require_once "config.php";
	$result = pg_query($connection, $query) or die(pg_last_error($connection));
	$qcount++;
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
    			print("	<table>
				<tr>
				<td><label class=\"events_anonce\">Тип ящика</label></td><td>");
    			print("<select name=\"networkboxtypes\">");
				while ($networkbox = pg_fetch_array($res)) {
					print("<option value=\"".$networkbox['id']."\">".$networkbox['marking']."</option>");
				}
				$boxtypeid = "javascript: document.boxtypevalue.networkbox.value";
//				$res = PQuery('SELECT COUNT(*) FROM "NetworkBox" WHERE "NetworkBoxType"=$boxtypeid');

				print("</select>
				</td>
				SELECT COUNT(*) FROM \"NetworkBox\" WHERE \"NetworkBoxType\"=$boxtypeid

				<br />
				</tr>
				<tr>
				<td><label class=\"events_anonce\">Инв. номер</label></td><td id=\"inventorynumber\"> <label onclick=\"initscript('#inventorynumber')\">\получить из базы\</label></td><!--<td><input type=\"text\" name=\"invmun\" size=\"30\" /></td>-->
				<br />
				</tr>
				<tr>
				<td><label class=\"events_anonce\">deprecated</label></td><td><input type=\"hidden\" name=\"whichadded\" value=\"networkbo2x\" size=\"30\" /></td>
				</tr>
				<tr>
				<td><input type=\"submit\" /></td>
				</tr>
				</table>");
				/*print("<br />
				</tr>
				<tr>
				<td><label class=\"events_anonce\">Инв. номер</label></td><td id=\"inventorynumber\"> <label onclick=\"initscript('#inventorynumber')\">\получить из базы\</label></td><!--<td><input type=\"text\" name=\"invmun\" size=\"30\" /></td>-->
				<br />
				</tr>
				<tr>
				<td><label class=\"events_anonce\">deprecated</label></td><td><input type=\"hidden\" name=\"whichadded\" value=\"networkbox\" size=\"30\" /></td>
				</tr><tr><td><input type=\"submit\" />
				</table>
				</td></tr>");*/
			}
	}
else print("bris!");
?>
