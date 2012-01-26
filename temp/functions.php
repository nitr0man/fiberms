<?php
require_once("config.php");

function PQuery($query)
{	pg_query($connection, $query) or die(pg_last_error($connection));
	$qcount++;
}


if($_SERVER["REQUEST_METHOD"] == 'POST')
	{		function AddNetworkBox;
		{		if ($_POST['whichadded'] == 'networkboxtype')
			{    	    	PQuery("INSERT INTO NetworkBoxType(
        	    marking, manufacturer, units, width, height, length, diameter)
		    	VALUES ('$_POST[marking]', '$_POST[manufacturer]', '$_POST[units]', '$_POST[width]', '$_POST[height]', '$_POST[length]', '$_POST[diameter]');");
			}
		}
	}
else print("Брысь!");
?>