<?php 
require_once ('includes/initialize.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Forms Creator</title>
</head>
<body>
<?php 
// print_r($_POST);
if (isset($_POST['eng_name'])) {
	//Get the fields of columns to be skipped 
	$all = fields::find_all();
	$skippedtables = array();
	foreach ($all as $one) {
	 	array_push($skippedtables, array($one->field, $one->tablename));
	 } ;
	 // Get of skipped columns ends here

 	$eng_name = ($_POST['eng_name']);
 	$desc = ($_POST['desc']);
 	$order = ($_POST['order']);
 	$tables = ($_POST['table_name']);
 	
 	$type = ($_POST['type']);
 	$fields = $_POST['fields'];
 	for ($i=0; $i < sizeof($desc); $i++) { 
 		// echo "Result of Check:". in_array(array($fields[$i], $tables[$i]) , $skippedtables ) . " of Columns = " . $fields[$i]. " from ". $tables[$i]; 
 		// Skipping the existed Data
 		if ( in_array(array($fields[$i], $tables[$i]) , $skippedtables )) {
 			echo "<br/>Totally Skipped Columns = " . $fields[$i]. " from ". $tables[$i]; 
 			continue;
 		}
 		echo "<br/>Not Skipped Columns = " . $fields[$i]. " from ". $tables[$i]; 
 		$myobj = new fields();
 		$myobj->tablename = $tables[$i];
 		$myobj->field = $fields[$i];
 		$myobj->type = $type[$i];
 		$myobj->eng_name = $eng_name[$i];
 		$myobj->priority = $order[$i];
 		$myobj->descrip = $desc[$i];
 		/*echo "<br/>Record<br/>";
    	print_r($myobj);
    	echo "<br/>Record<br/>";*/
 		
 		$myobj->save();
 		// print_r($myobj);
 		echo "<br/>";
 	}
 } ?>
<form action="create_cols.php" method="post">
<table>
<?php 
	function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = $row[0];
    }
    return $object_array;
  }

$tables = find_by_sql('show tables');
// print_r($myarray);

	$htmltype = array('text' => 'Text' , 'checkbox' => 'Multiple Select', 'radio' => 'Choose from one' ,'hidden' => "Hidden from the field");
	$ijk = 0;
	foreach ($tables as $table_name) {
		if (($ijk % 6) == 5) {
			?>
			<tr><td><input type="Submit" name="submit"/></td></tr></form>		
			<form action="create_cols.php" method="post">
			<?php
		} 
		$ijk++;

		?>

		<tr><th colspan="4"><?php echo $table_name; ?></th></tr>
		
		<?php $cols = (get_class_vars($table_name));
		echo "<tr><td colspan=\"4\">";
		// print_r($tables);
		echo "</td></tr>";

			echo "<tr><th> Fileld Name </th><th> English Name</th> <th>Type</th><th>Description</th><th>Order</th></tr>";
			// echo "<br/><bold> size is".sizeof($cols) . "</bold>";
			foreach ($cols as $col1 => $value) {
				
		/*		if (($col1 == 'id') || ($col1 == 'tablename') ) {
					continue;
				}
		*/		echo "<tr><td>". $col1.
					"</td>". "<td>" . "<input type=\"text\" name=\"eng_name[]\" />" . "</td>".
					"</td>". "<td>" . "<input type=\"hidden\" name=\"fields[]\" value=\"{$col1}\" />" . "</td>".
					"</td>". "<td>" . "<input type=\"hidden\" name=\"table_name[]\" value=\"{$table_name}\" />" . "</td>".
					"<td>" . "<select name=\"type[]\">";
					foreach ($htmltype as $type1 => $display) {
						echo "<option value=\"{$type1}\">{$display}</option>";	
					}
					echo "</select>";

				echo
					"<td>" . "<input type=\"text\" name=\"desc[]\" />" . "</td>".  "</td>".
					"<td>" . "<input type=\"text\" name=\"order[]\" />" . "</td>".
					"</tr>";
			}
		?>
		
		<?php
	}
 ?> <tr><td><input type="Submit" name="submit"/></td></tr>
</table>

</form>
</body>
</html>