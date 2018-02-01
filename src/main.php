
<!DOCTYPE html>
<html>
<head>
	
	<title>Quick Start - Leaflet</title>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>


	
</head>
<body>



<div id="mapid" style="width: 600px; height: 400px;"></div>

<?php 

$html = "
<!doctype html>
	<html lang=\"fr\">
	<head>
	  	<meta charset=\"utf-8\">
	  	<title>Titre de la page</title>

	  	<link rel=\"stylesheet\" href=\"https://unpkg.com/leaflet@1.3.1/dist/leaflet.css\"
	   	integrity=\"sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==\"
	   	crossorigin=\"\"/>
	   	<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">

	 	<!-- Make sure you put this AFTER Leaflet's CSS -->
	 	<script src=\"https://unpkg.com/leaflet@1.3.1/dist/leaflet.js\"
	   	integrity=\"sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==\"
	   	crossorigin=\"\"></script>
	</head>

	<body>

		<div id=\"mapid\"></div>";

// charge page 
$apiIp = file_get_contents('http://ip-api.com/xml',false);
var_dump($apiIp);
$lol = simplexml_load_string($apiIp);
//var_dump($lol);

// Recupère entetes html
//var_dump($http_response_header); 

// Freegeoip


$ip = $_SERVER['HTTP_CLIENT_IP'];
$pos = file_get_contents('http://freegeoip.net/xml/'.$ip);
$xmlIP = simplexml_load_string($pos);
//var_dump($xmlIP);

echo "Latitude : $xmlIP->Latitude, Longitude : $xmlIP->Longitude";

$html .= "
			<script src = \"app.js\"></script>
		</body>
</html>";
$script="
<script>

	var mymap = L.map('mapid').setView([$xmlIP->Latitude, $xmlIP->Longitude], 13);

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, ' +
			'<a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, ' +
			'Imagery © <a href=\"http://mapbox.com\">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

	var popup = L.popup();

	function onMapClick(e) {
		popup
			.setLatLng(e.latlng)
			.setContent(\"You clicked the map at \" + e.latlng.toString())
			.openOn(mymap);
	}

	mymap.on('click', onMapClick);

</script>";
echo $script;
?>
</body>
</html>
