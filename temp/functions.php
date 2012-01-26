<?php

function PQuery($query)
{	require_once "config.php";
	pg_query($connection, $query) or die(pg_last_error($connection));
	$qcount++;
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
		    	print("done");
			}
	}
else print("bris!");
?>
