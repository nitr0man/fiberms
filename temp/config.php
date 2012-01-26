<?php
$host = "nitr0.homelinux.net";
$user = "development";
$pass = "devpass12";
$db = "dev";
$connection = pg_connect("host='".$host."' dbname='".$db."' user='".$user."' password='".$pass."'");
if (!$connection)
{
  die("Could not open connection to database server");
}
?>