<?php

require_once 'includes/initialize.php';
// echo "Hello";

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Bridges Information on Parbat DDC</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="src/leaflet.css" />
	<link rel="stylesheet" type="text/css" href="Panel/php/bootstrap/css/bootstrap.min.css">
	<script src="src/leaflet.js"></script>
	<script src="src/jquery.min.js"></script>
	<script src="Panel/php/bootstrap/js/bootstrap.min.js"></script>
	<script src="src/Label.js"></script>
	<script src="src/BaseMarkerMethods.js"></script>
	<script src="src/Marker.Label.js"></script>
	<script src="src/CircleMarker.Label.js"></script>
	<script src="src/Path.Label.js"></script>
	<script src="src/Map.Label.js"></script>
	<script src="src/FeatureGroup.Label.js"></script>


</head>
<body>
<style>

/* Leaflet.label.css */
.leaflet-label {
	background: rgb(235, 235, 235);
	background: rgba(235, 235, 235, 0.81);
	background-clip: padding-box;
	border-color: #777;
	border-color: rgba(0,0,0,0.25);
	border-radius: 4px;
	border-style: solid;
	border-width: 4px;
	color: #111;
	display: block;
	font: 12px/20px "Helvetica Neue", Arial, Helvetica, sans-serif;
	font-weight: bold;
	padding: 1px 6px;
	position: absolute;
	-webkit-user-select: none;
	   -moz-user-select: none;
	    -ms-user-select: none;
	        user-select: none;
	pointer-events: none;
	white-space: nowrap;
	z-index: 6;
}

.leaflet-label.leaflet-clickable {
	cursor: pointer;
	pointer-events: auto;
}

.leaflet-label:before,
.leaflet-label:after {
	border-top: 6px solid transparent;
	border-bottom: 6px solid transparent;
	content: none;
	position: absolute;
	top: 5px;
}

.leaflet-label:before {
	border-right: 6px solid black;
	border-right-color: inherit;
	left: -10px;
}

.leaflet-label:after {
	border-left: 6px solid black;
	border-left-color: inherit;
	right: -10px;
}

.leaflet-label-right:before,
.leaflet-label-left:after {
	content: "";
}

/* Leaflet.label.css */
		#mymap {
			width: 800px;
			height: 500px;
		}

		.info {
			padding: 6px 8px;
			font: 14px/16px Arial, Helvetica, sans-serif;
			background: white;
			background: rgba(255,255,255,0.8);
			box-shadow: 0 0 15px rgba(0,0,0,0.2);
			border-radius: 5px;
		}
		.info h4 {
			margin: 0 0 5px;
			color: #777;
		}

		.legend {
			text-align: left;
			line-height: 18px;
			color: #555;
		}
		.legend i {
			width: 18px;
			height: 18px;
			float: left;
			margin-right: 8px;
			opacity: 0.7;
		}
	</style>
<script type="text/javascript">
		 function showValue(newValue, target)    {
    		document.getElementById(target).innerHTML=newValue;    
    	}
</script>

<div id="map" style="height:600px; width:1200px;align:center;"></div>


<script type="text/javascript">
 var myItems=[];
 <?php 
if (isset($_POST['submit'])) {
	if ($_POST['submit'] == 'पेश गर्नुहोस्' ) {
		// $_SESSION['ids'] = $_POST['check_item'];
		// redirect_to('admin/create_kml.php');
		$i=0;

		$collected = $_POST['check_item'];
		foreach ($collected as $one_bridge) {
			$bridge = Bridge::find_by_id($one_bridge);
			// print_r($bridge);
			$globe_coordinates = Coordinates::find_by_bridge_id($one_bridge);

			// print_r($globe_coordinates);

			if (count($globe_coordinates) == 0){
				continue;
			}
				$globe = $globe_coordinates[0];	

			
			echo "myItems.push(['{$bridge->BridgeName}', {$globe->latitude}, {$globe->longitude}])";


			
		}
			
	}
}else{ 	// Start of Else
	$bridges = Bridge::find_all();
	foreach ($bridges as $bridge) {
		# code...
		$globe_coordinates = Coordinates::find_by_bridge_id($bridge->id);

			// print_r($globe_coordinates);

			if (count($globe_coordinates) == 0){
				continue;
			}
				$globe = $globe_coordinates[0];	
				// print_r($globe);

			
			echo "myItems.push(['{$bridge->BridgeName}', {$globe->latitude}, {$globe->longitude}]);";

	}

 ?><?php

} 	/// end of Else 

	?></script>
<script type="text/javascript" src="Lmap2.js"></script>

<div id="mapinfo" class="col-lg-8"></div>
</body>
</html>
