<?php
require_once("config.php");

function PQuery($query)
{
	$qcount++;
}


if($_SERVER["REQUEST_METHOD"] == 'POST')
	{
		{
			{
        	    marking, manufacturer, units, width, height, length, diameter)
		    	VALUES ('$_POST[marking]', '$_POST[manufacturer]', '$_POST[units]', '$_POST[width]', '$_POST[height]', '$_POST[length]', '$_POST[diameter]');");
			}
		}
	}
else print("Брысь!");
?>