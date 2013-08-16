<?php

require_once("auth.php");
require_once("smarty.php");
require_once("func/FiberSplice.php");
require_once("design_func.php");

$cableLine = $_GET[ 'CableLine' ];
$cableLinePoint = $_GET[ 'clpid' ];
$networkNodeId = $_GET[ 'networknodeid' ];

$res = trace( 14 );
//$res = trace( -1, 110 );
print_r( $res );
?>
