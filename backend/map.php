<?php
	function updCableLinePoints( $coors, $CableLine, $seqStart, $seqEnd )
	{
		$query = 'SELECT * FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' ORDER BY "sequence"';
		$res = PQuery( $query );
		if ( count( $coors ) != $res['count'] )
		{
			error_log( "seqStart=".$seqStart );
			error_log( "seqEnd=".$seqEnd );
			//error_log( print_r($res, true) );			
			if ( $res['rows'][$seqEnd]['meterSign'] != "" )
			{
				error_log("1");
				$seqDiff = count( $coors ) - ( $seqEnd - $seqStart );
				$query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqStart.' AND "sequence" < '.$seqEnd;
				error_log( "delete= ".$query );
				PQuery( $query );
				$query = 'UPDATE "CableLinePoint" SET "sequence" = ("sequence" + '.$seqDiff.')*-1 WHERE "CableLine" = '.$CableLine;
				/*$query = 'DECLARE
				cursUpd CURSOR FOR SELECT * FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqStart.' AND "sequence" < '.$seqEnd.';
				UPDATE "CableLinePoint" SET "sequence" = "sequence" + '.$seqDiff.' WHERE CURRENT OF cursUpd;';*/
				error_log( "update= ".$query );
				PQuery( $query );
				$query = 'UPDATE "CableLinePoint" SET "sequence" = "sequence" * -1 WHERE "CableLine" = '.$CableLine;
				PQuery( $query );
				$seq = $seqStart;
				for ( $i = 0; $i < count( $coors ); $i++ )
				{
					$coor = "(".$coors[$i]->lon.",".$coors[$i]->lat.")";
					$ins['OpenGIS'] = $coor;
					$ins['sequence'] = $seq++;
					$ins['CableLine'] = $CableLine;
					$query = 'INSERT INTO "CableLinePoint"'.genInsert( $ins );
					error_log( "insert= ".$query );
					PQuery( $query );
				}
			}
			else if ( $res['rows'][$seqStart]['meterSign'] != "" )
			{
				error_log("2");
				$seqDiff = count( $coors ) - ( $seqEnd - $seqStart );
				$query = 'UPDATE "CableLinePoint" SET "sequence" = "sequence" + '.$seqDiff.' WHERE "CableLine" = '.$CableLine;
				error_log( "update= ".$query );
				PQuery( $query );
				$query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" > '.$seqStart.' AND "sequence" <= '.$seqEnd;
				error_log( "delete= ".$query );
				PQuery( $query );
				$seq = $seqStart;
				for ( $i = 0; $i < count( $coors ); $i++ )
				{
					$coor = "(".$coors[$i]->lon.",".$coors[$i]->lat.")";
					$ins['OpenGIS'] = $coor;
					$ins['sequence'] = $seq++;
					$ins['CableLine'] = $CableLine;
					$query = 'INSERT INTO "CableLinePoint"'.genInsert( $ins );
					PQuery( $query );
					error_log("insert= ".$query);
				}
			}
		}
		return;
	
		$seqEnd = $seqStart + count( $coors ) - 1;
		//$query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqStart.' AND "sequence" <= '.$seqEnd.' AND "meterSign" IS NULL AND "NetworkNode" IS NULL AND "note" IS NULL';
		$query = 'DELETE FROM "CableLinePoint" WHERE "CableLine" = '.$CableLine.' AND "sequence" >= '.$seqStart.' AND "sequence" <= '.$seqEnd;//.' AND "meterSign" IS NULL AND "NetworkNode" IS NULL AND "note" IS NULL';
		PQuery( $query );
		error_log( "Delete: ".$query );
		$seq = $seqStart;				
		for ( $i = 0; $i < count( $coors ); $i++ )
		{
			$coor = "(".$coors[$i]->lon.",".$coors[$i]->lat.")";
			$ins['OpenGIS'] = $coor;
			$ins['sequence'] = $seq++;
			$ins['CableLine'] = $CableLine;
			//$query = 'INSERT INTO "CableLinePoint" ("OpenGIS", "sequence", "CableLine") VALUES ()';
			//$query = 'INSERT INTO "CableLinePoint"'.genInsert( $ins ).' ON DUPLICATE KEY UPDATE "OpenGIS" = '.$coor;
			$query = 'INSERT INTO "CableLinePoint"'.genInsert( $ins );
			error_log( "Insert: ".$query );
			PQuery( $query );
		}
	}
?>