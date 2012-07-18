<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>get me to the news on time</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?apikey=AIzaSyB21whNH5gKlg2Ja6uogyWeTWKRtVVwDvw&sensor=false"></script>

<?php
$id = $_GET['id'];
$lat = $_GET['lat'];
$long = $_GET['long'];
$currentloc = $_GET['currentloc'];
$radius = $_GET['radius'];
$transport = $_GET['transport'];

$n0tice_url="http://n0ticeapis.com/2/" . $id;
$string .= file_get_contents($n0tice_url); // get json content
$array = json_decode($string, true); //json decoder

$maps_url="http://maps.googleapis.com/maps/api/directions/json?origin=" . $currentloc . "&destination=" . $array['place']['latitude'] . "," . $array['place']['longitude'] . "&sensor=true&mode=" . $transport;
$maps_string .= file_get_contents($maps_url); // get json content
$maps_array = json_decode($maps_string, true); //json decoder
?>

</head>

<body onload="initialize()">

<div data-role="page" data-theme="b" id="jqm-home">

<div data-role="header" data-position="inline">
   <a href='#' class='ui-btn-left' data-icon='arrow-l' onclick="history.back(); return false">back</a><h1>dispatchorama</h1><a href="index.php" data-icon="home" data-role="button" data-iconpos="notext"></a>
</div>

<div data-role="content" data-fullscreen="true">
	<?php 
	echo "<h2>" . $array['headline'] . "</h2>"; 
	echo "<h3>" . $array['place']['name'] . "</h3>"; 
	echo "<h3>" . $maps_array['routes'][0]['legs'][0]['distance']['text'] . " - " . $maps_array['routes'][0]['legs'][0]['duration']['text'] . "</h3>"; 
	echo "<h4>" . $maps_array['routes'][0]['legs'][0]['steps'][0]['travel_mode'] . " from " . $maps_array['routes'][0]['legs'][0]['start_address']  . ":</h4>";
	echo "<ul data-role=\"listview\">";
	$i = 0; 
	foreach ($maps_array['routes'][0]['legs'][0][steps] as $v) {
		echo "<li>";
		echo $maps_array['routes'][0]['legs'][0][steps][$i]['html_instructions'];
		echo "</li>";
		$i++;
	}
	echo "</ul>";

	echo "<a href=\"https://maps.google.com/maps?q=" . $array['place']['latitude'] . "," . $array['place']['longitude'] . "\"><img src=\"https://maps.googleapis.com/maps/api/staticmap?center=" . $array['place']['latitude'] . "," . $array['place']['longitude'] . "&zoom=16&size=288x200&markers=" . $array['place']['latitude'] . "," . $array['place']['longitude'] . "&sensor=true\" width=\"288\" height=\"200\"></a>";
	#echo "</ul><br><br>http://maps.googleapis.com/maps/api/directions/json?origin=" . $currentloc . "&destination=" . $array['place']['latitude'] . "," . $array['place']['longitude'] . "&sensor=true&mode=" . $transport;
	?>

</div>		
	
</div>
</body>

</body>
</html>
