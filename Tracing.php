<?php

require_once("auth.php");
require_once("smarty.php");
require_once("func/FiberSplice.php");
require_once("design_func.php");

$cableLine = $_GET[ 'CableLine' ];
$cableLinePoint = $_GET[ 'clpid' ];
$networkNodeId = $_GET[ 'networknodeid' ];

//$res = getCableLineDirection( $cableLine, $cableLinePoint, $networkNodeId );
//$res = tracing( $cableLine, $cableLinePoint, $networkNodeId );
$res = trace( -1, 66 );
/*
SELECT * FROM "OpticalFiberJoin" AS "ofj"
WHERE "ofj"."OpticalFiber" = 66;

SELECT * FROM "OpticalFiberJoin" AS "ofj"
LEFT JOIN "OpticalFiber" AS "of" ON "of".id = "ofj"."OpticalFiber"
WHERE "ofj"."OpticalFiber" != 66 AND ("ofj"."OpticalFiberSplice" = 1 OR "ofj"."OpticalFiberSplice" = 10);
 */
print_r( $res );
?>
