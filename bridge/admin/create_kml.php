<?php 
require_once '../includes/initialize.php';
function create_kml($ids)
{
	
	$kml = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>
	<kml xmlns=\"http://www.opengis.net/kml/2.2\">
	<Document><Folder><name>Bridges of Parbat DDC</name>";
	// Main Code is Here to populate all the bridges
	foreach ($ids as $id) {
		$bridge = Bridge::find_by_id($id);
		$globe = Coordinates::find_by_bridge_id($id);
		if (count($globe) == 0){
			continue;
		}
		$kml .= "<Placemark>
				<name>".$bridge->BridgeName." झोलुङ्गे पुल</name><description>".
				"झोलुङ्गे पुलको विवरण".
				"</description> 
				<Style>
					<LineStyle>
						<width>4</width>
						<color>ff0000ff</color>
					</LineStyle>
					<PolyStyle>
						<fill>0</fill>
					</PolyStyle>
				</Style>".
				"<MultiGeometry><LineString><coordinates>";
		
		foreach ($globe as $bridge_coordinate) {
			$kml .= $bridge_coordinate->longitude . ",". $bridge_coordinate->latitude.",0 ";
		}
		$kml .= "</coordinates></LineString></MultiGeometry>
				  ";
		$kml .= "<Point><coordinates>".$bridge_coordinate->longitude . ",". $bridge_coordinate->latitude."</coordinates></Point></Placemark>";
	}
	$kml .= "</Folder>";
	// echo $kml;
	/* $kml .= "<Schema name=\"TRACK\" id=\"TRACK\">
		<SimpleField name=\"type\" type=\"string\"></SimpleField>
		<SimpleField name=\"ident\" type=\"string\"></SimpleField>
		<SimpleField name=\"Latitude\" type=\"float\"></SimpleField>
		<SimpleField name=\"Longitude\" type=\"float\"></SimpleField>
		<SimpleField name=\"y_proj\" type=\"float\"></SimpleField>
		<SimpleField name=\"x_proj\" type=\"float\"></SimpleField>
		<SimpleField name=\"new_trk\" type=\"string\"></SimpleField>
		<SimpleField name=\"new_seg\" type=\"string\"></SimpleField>
		<SimpleField name=\"display\" type=\"string\"></SimpleField>
		<SimpleField name=\"color\" type=\"string\"></SimpleField>
		<SimpleField name=\"altitude\" type=\"float\"></SimpleField>
		<SimpleField name=\"depth\" type=\"float\"></SimpleField>
		<SimpleField name=\"temp\" type=\"float\"></SimpleField>
		<SimpleField name=\"time\" type=\"string\"></SimpleField>
		<SimpleField name=\"model\" type=\"string\"></SimpleField>
		<SimpleField name=\"filename\" type=\"string\"></SimpleField>
		<SimpleField name=\"ltime\" type=\"string\"></SimpleField>
		<SimpleField name=\"desc\" type=\"string\"></SimpleField>
		<SimpleField name=\"link\" type=\"string\"></SimpleField>
	</Schema>";*/
	$kml .= "</Document></kml>";
	return $kml;
}
echo ini_set('display_errors', 1);
echo error_reporting(E_ALL);
$kml = create_kml($_SESSION['ids']);
$filename = SITE_ROOT.DS."admin".DS. "kmls".DS."Bridge_reqd.kml";
echo($filename);
if (!file_exists($filename)){
	echo "File Not Found";
} elseif (!($myfile = fopen($filename, "w"))) {
	echo "File can't be opened";
}
$newfile = fopen("heelo.txt", "w");
fwrite($newfile, $kml);
fclose($newfile);
echo $kml;
$myfile = fopen($filename, "w") or die("Unable to open file!");

fwrite($myfile, $kml);
// fwrite($myfile, $txt);
fclose($myfile);
redirect_to($filename);
 ?>