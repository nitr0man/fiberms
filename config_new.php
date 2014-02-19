<?php

require_once("backend/functions.php");

$config[ 'host' ] = "localhost";
$config[ 'user' ] = "postgres";
$config[ 'pass' ] = "";
$config[ 'db' ] = "dev";
$config[ 'LinesPerPage' ] = 10;
$config[ 'version' ] = '1.0.0';
$config[ 'maxTraceDepth' ] = 1000; // макс. глубина функции трассировки
$query_count = 0;
$connection = PConnect( $config[ 'host' ], $config[ 'db' ], $config[ 'user' ],
     $config[ 'pass' ] );
if ( !$connection )
{
    die( "Could not open connection to database server" );
}
?>