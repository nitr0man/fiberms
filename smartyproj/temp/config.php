<?php
$host = "localhost";
$user = "postgres";
$pass = "";
$db = "dev";
$connection = pg_connect("host='".$host."' dbname='".$db."' user='".$user."' password='".$pass."'");
if (!$connection)
{
  die("Could not open connection to database server");
}
?>