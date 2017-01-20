<?php 
require_once 'includes/initialize.php';
$file1 = fopen("includes/class/myclass.php","w");
$file2 = fopen("includes/class/data.txt", "r");
$code = fread($file2,filesize("includes". DS. "class". DS. "data.txt")) ;
fclose($file2);
// echo getcwd();
// echo filesize("includes". DS. "class". DS. "data.txt");

function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = $row[0];
    }
    return $object_array;
  }

$myarray = find_by_sql('show tables');
print_r($myarray);

foreach ($myarray as $myclass) {
$file1 = fopen("includes/class/".  $myclass . ".php","w");
	$clas = "class ". $myclass ."{";
	// echo $myclass ."<br/>";
	// print_r( find_by_sql("desc ".$myclass));
	// echo "<br/>";
	$var = '';
	$var .= "protected static \$table_name = \"{$myclass}\";" ;
	unset($w1);
	$w1 = find_by_sql("desc ".$myclass);
	echo "<br/>";
	echo $myclass."<br/>";
	// print_r($w1);
	foreach ($w1 as $key => $value) {
		$var .= "
		public $".$value .";";
	}
	// echo $var . "<br/>";
	echo "<br/>";
	print_r($w1);
	$tb = "protected static \$db_fields = array('". join("', '", array_values($w1)) . "');";
	// echo "<br/>";
	$output = "<?php  \n" . //require_once '../database.php';
			$clas . "
			" . $tb . "
			" . $var . "
			".
			$code .
			"} \n" .
			" ?>" ;
fwrite($file1, $output);
fclose($file1);
	
}



 ?>