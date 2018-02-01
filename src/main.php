
<!DOCTYPE html>
<html>
	<body>
<?php

$opts = array('http' => array('proxy' => 'tcp://127.0.0.1:8080', 'request_fulluri' => true));
$context = stream_context_create($opts);

$data="http://www.freegeoip.net/xml/".$_SERVER['REMOTE_ADDR'];
$content=file_get_contents($data,false,$context);
$xml=simplexml_load_string($content);
	$lat=$xml->Response->Latitude;
	$long=$xml->Response->Longitude;
	var_dump($lat);
	var_dump($long);

	$meteo="http://www.infoclimat.fr/public-api/gfs/xml?_ll=48.85341,2.3488&_auth=UUtXQAV7V3UHKlFmAnQHLlA4UmdcKgUiBHgAY1g9XiMDaFAxB2cGYAdpWyYDLAI0BClQMww3BDRUPwpyAXMHZlE7VzsFblcwB2hRNAItByxQZ1IxXGIFPQRgAHhYKl48A2lQNwd6BmEHaFsnAzICNQQyUC4MMgQ1VDAKcgFzB2VRN1cyBWFXMQdhUToCNgc1UGZSLVx8BTgENgBgWDZePgNkUDAHbQZtBztbPwNgAmUEMlAuDDUEP1Q0CmQBZQdiUTFXOgV5VyoHEVFAAi8Hc1AhUmdcJQUgBDIAOVhh&_c=d79ba7c79ae5fa5cac0c471d1d583b50";
	$content_meteo=file_get_contents($meteo,false,$context);
	$xml_meteo=simplexml_load_string($content_meteo);
	if(!empty($xml_meteo)){
		$xsl=new DOMDocument();
		$xsl->load("meteo.xsl");
		$xslt=new XSLTProcessor();
		$xslt->importStylesheet($xsl);
		print $xslt->transformToXml($xml_meteo);
		$stan="http://www.velostanlib.fr/service/carto/";
		$content_stan= file_get_contents($stan,false,$context);
		$xml_stam=simplexml_load_string($content_stan);
		if(!empty($xml_stan)){
			$details="http://www.velostanlib.fr/service/stationdetails/nancy/";
			echo"<script>
			var mymap = L.map('mapid').setView([$lat,$long], 13);
			var circle= L.circle([$lat,$long],{
				color:'blue',
				radius:40
			}).addTo(mymap);
			circle.bindPopup().openPopup();";

			$station=null;

			foreach($xml_stan->markers->markers as s){
				$content_details= file_get_contents($details.$s->attributes()->number,false,$context);
				$lt=$s.attributes()->lat;
				$lg=$s.attributes()->lng;
				echo "var marker=L.marker([lt,lg]).addTo(mymap)";
				$station_xml=simplexml_load_string($content_details);
				$address=$s->attributes()->fullAddress;

				if(!empty($station_xml)){
					echo "marker.bindPopup(\"<b>$station_adresse </b><br/>Vélos libre: $station_details_xml->available <br/>Places libre: $station_details_xml->free <br/>\");";
          }
				}
			}else{
				echo " API Velo stan inaccessible"
			}

		}else{
			echo "API Meteo inaccessible"
		}
		echo "

		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors, ' +
				'<a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, ' +
				'Imagery © <a href=\"http://mapbox.com\">Mapbox</a>',
			id: 'mapbox.streets'
		}).addTo(mymap);
		</script>";
	}else{
		echo "API météorologique inaccessible";
	}
?>
</body>
</html>
