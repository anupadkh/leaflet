<?php
require_once('includes/initialize.php');
$bridges = Bridge::find_all();
// echo "{";
// foreach ($bridges as $bridge1) {
// 	echo "[";
// 	foreach ($bridge1 as $key => $value) {
// 		echo "{". 
// 				"\"{$key}\":".
// 				"\"{$value}\"".
// 				"}".",";
// 	}
// 	echo "]";
// }
// echo "}";
echo "{\"bridges\":";
echo json_encode($bridges);
echo "}";

?>