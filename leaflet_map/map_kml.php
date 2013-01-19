<html>
<head>
	<title>Leaflet_KML</title>
	<link rel="stylesheet" href="leaflet/leaflet.css" />
	<script src="leaflet/leaflet.js"></script>
	<script src="layer/vector/KML.js"></script>
</head>
<body>
	<div style="width:100%; height:100%" id="map"></div>
<script type='text/javascript'>
	var map = new L.Map('map', {center: new L.LatLng(58.4, 43.0), zoom: 11});
	var osm = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

	var track = new L.KML("physic_element.kml", {async: true});
	track.on("loaded", function(e) { map.fitBounds(e.target.getBounds()); });

	map.addLayer(track);
	map.addLayer(osm);
	map.addControl(new L.Control.Layers({}, {'Track':track}));
</script>
 
</body>
</html>
