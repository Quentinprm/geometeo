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
var_dump($lol);

// Recupère entetes html
var_dump($http_response_header); 

// Freegeoip
$ip = "77.136.19.179";
$pos = file_get_contents('http://freegeoip.net/xml/'.$ip);
$xmlIP = simplexml_load_string($pos);
var_dump($xmlIP);

echo "Latitude : $xmlIP->Latitude, Longitude : $xmlIP->Longitude";

$html .= "
			<script src = \"app.js\"></src>
		</body>
</html>";

echo $html;
