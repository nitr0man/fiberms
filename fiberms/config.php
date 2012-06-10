<?php
require_once("backend/functions.php");

$host = "nitr0.homelinux.net";
$user = "development";
$pass = "devpass12";
$db = "dev";
$connection = PConnect($host,$db,$user,$pass);
if (!$connection) {
	die("Could not open connection to database server");
}

?>