<?php

require_once 'backend/CableType.php';
print( '<meta charset="UTF-8">' );

if ( isset( $_GET[ 'CableLine' ] ) && ctype_digit( $_GET[ 'CableLine' ] ) )
{
    $CableLine = $_GET[ 'CableLine' ];
    $wr[ 'id' ] = $CableLine;
    $cl = CableLine_SELECT( -1, $wr );
    $CableType = $cl[ 'rows' ][ 0 ][ 'CableType' ];
    $wr[ 'id' ] = $CableType;
    $ct = CableType_SELECT( -1, $wr );
    $fibersCount = $ct[ 'rows' ][ 0 ][ 'tubeQuantity' ] * $ct[ 'rows' ][ 0 ][ 'fiberPerTube' ];
    for ( $i = 1; $i <= $fibersCount; $i++ )
    {
        print "Добавляем волокно #".$i."...<br/>";
        $ins[ 'CableLine' ] = $CableLine;
        $ins[ 'fiber' ] = $i;
        $query = 'INSERT INTO "OpticalFiber"'.genInsert( $ins );
        PQuery( $query );
    }
    print "Добавление волокон завершено!";
}
?>
