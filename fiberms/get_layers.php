<?php
	require_once('backend/functions.php');
	require_once('backend/CableType.php');
	require_once('backend/NetworkNode.php');

	if ($_GET['mode'] == 'GetCableLines') {
		if ($_GET['type'] == 1) { // медный кабель
			$res = getCopperCableLines();
		} elseif ($_GET['type'] == 2) { // обычный кабель
			$res = getNormalCableLines();			
		}
		$rows = $res['rows'];
		
		$dom = new DomDocument('1.0', 'UTF-8');
		$osm = $dom->appendChild($dom->createElement('osm'));
		$osm_attr = $dom->createAttribute('version');
		$osm_attr->value = '0.6';
		$osm->appendChild($osm_attr);
	
		$osm_attr = $dom->createAttribute('generator');
		$osm_attr->value = 'plosm';
		$osm->appendChild($osm_attr);
		
		for ($i = 0, $ways_count = 0, $nodeId = 1; $i < $res['count']; $i++) {
			$OpenGIS = $rows[$i]['OpenGIS'];
			if (preg_match_all('/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS, $matches)) {
				for ($j = 0; $j < count($matches[0]); $j++) {
					$node = $osm->appendChild($dom->createElement('node'));	
					$node_attr = $dom->createAttribute('visible');
					$node_attr->value = 'true';
					$node->appendChild($node_attr);
	
					$node_attr = $dom->createAttribute('id');
					$node_attr->value = $nodeId;
					$node->appendChild($node_attr);

					$node_attr = $dom->createAttribute('version');
					$node_attr->value = '8';
					$node->appendChild($node_attr);

					$node_attr = $dom->createAttribute('lat');
					$node_attr->value = $matches['y'][$j];
					$node->appendChild($node_attr);

					$node_attr = $dom->createAttribute('lon');
					$node_attr->value = $matches['x'][$j];
					$node->appendChild($node_attr);
					
					$ways_arr['Nodes'][$ways_count][]['nodeId'] = $nodeId;
					$nodeId++;
				}
			}
			$ways_count++;
		}
		for ($i = 0; $i < count($ways_arr['Nodes']); $i++) {
			$way = $osm->appendChild($dom->createElement('way'));

			$way_attr = $dom->createAttribute('id');
			$way_attr->value = $nodeId+$i+1;
			$way->appendChild($way_attr);

			$way_attr = $dom->createAttribute('visible');
			$way_attr->value = 'true';
			$way->appendChild($way_attr);

			$way_attr = $dom->createAttribute('version');
			$way_attr->value = '8';
			$way->appendChild($way_attr);
			
			for ($j = 0; $j < count($ways_arr['Nodes'][$i]); $j++) {	
				$nd = $way->appendChild(
										$dom->createElement('nd')
										);
				$nd_attr = $dom->createAttribute('ref');
				$nd_attr->value = $ways_arr['Nodes'][$i][$j]['nodeId'];
				$nd->appendChild($nd_attr);
			}
			$tag = $way->appendChild(
							$dom->createElement('tag')
							);
			$tag_attr = $dom->createAttribute('k');
			$tag_attr->value = 'oneway';
			$tag->appendChild($tag_attr);
			$tag_attr = $dom->createAttribute('v');
			$tag_attr->value = 'yes';
			$tag->appendChild($tag_attr);

			$tag = $way->appendChild(
									$dom->createElement('tag')
									);
			$tag_attr = $dom->createAttribute('k');
			$tag_attr->value = 'ported';
			$tag->appendChild($tag_attr);
			$tag_attr = $dom->createAttribute('v');
			$tag_attr->value = '1';
			$tag->appendChild($tag_attr);

			$tag = $way->appendChild(
									$dom->createElement('tag')
									);
			$tag_attr = $dom->createAttribute('k');
			$tag_attr->value = 'highway';
			$tag->appendChild($tag_attr);
			$tag_attr = $dom->createAttribute('v');
			$tag_attr->value = 'primary';
			$tag->appendChild($tag_attr);
		}
		$dom->formatOutput = true;
		$res = $dom->saveXML();
		
		header ("content-type: text/xml");
		print($res);		
	} elseif ($_GET['mode'] == 'GetNodesMarkers') {
		//header('Content-Type: text/html; charset=utf-8', true);
		$res = getNetworkNodeList_NetworkBoxName('', '', '');
		$rows = $res['rows'];
		$pois_text = "lat\tlon\ttitle\tdescription\ticon\ticonSize\ticonOffset\n";		
		for ($i = 0; $i < $res['count']; $i++) {
			$OpenGIS = $rows[$i]['OpenGIS'];
			if (preg_match_all('/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS, $matches)) {
				for ($j = 0; $j < count($matches[0]); $j++) {
					$lat         = $matches['y'][$j];
					$lon         = $matches['x'][$j];
					$title       = $rows[$i]['name'];
					$description = "Ящик: ".$rows[$i]['inventoryNumber']."<br>".
									'Тип ящика: '.$rows[$i]['NBTmarking']."<br>".
									"Примечание: ".nl2br($rows[$i]['note']);
					$icon        = "pic/Ol_icon_blue_example.png";
					$iconSize    = "24,24";
					$iconOffset  = "0,-24";
				
					$pois_text .= $lat."\t".$lon."\t".$title."\t".$description."\t".$icon."\t".$iconSize."\t".$iconOffset."\n";
				}
			}
		}		
		print($pois_text);
	
	} elseif ($_GET['mode'] == 'GetNodesLabels') {
		$res = getNetworkNodeList_NetworkBoxName('', '', '');
		$rows = $res['rows'];
		for ($i = 0; $i < $res['count']; $i++) {
			$OpenGIS = $rows[$i]['OpenGIS'];
			if (preg_match_all('/(?<x>[0-9.]+),(?<y>[0-9.]+)/', $OpenGIS, $matches)) {
				for ($j = 0; $j < count($matches[0]); $j++) {
					$lat         = $matches['y'][$j];
					$lon         = $matches['x'][$j];
					$title       = $rows[$i]['name'];
					print("addPoint(".$lon.",".$lat.",'".$title."','".$i."',map.layers[5]);");
				}
			}
		}

	}

?>