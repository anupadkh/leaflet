<?php 
require_once ('includes/initialize.php');
// print_r($_POST);
// $desc_array = array(); contains the description of database table from the database system
if (isset($_POST['id'])) {
 	$eng_name = ($_POST['eng_name']);
 	$nepl_name = ($_POST['nepl_name']);
 	$desc = ($_POST['desc']);
 	$order = ($_POST['order']);
 	$tables = ($_POST['table_name']);
 	$type = ($_POST['type']);
 	$fields = $_POST['fields'];
 	$id = $_POST['id'];
 	$mykeys = $_POST['mykeys'];
 	$myvalues = $_POST['myvalues'];
 	$field_extra = $_POST['field_extra'];

 	for ($i=0; $i < sizeof($desc); $i++) { 
 		$myobj = new fields();
 		$myobj->tablename = $tables[$i];
 		$myobj->field = $fields[$i];
 		$myobj->type = $type[$i];
 		$myobj->eng_name = $eng_name[$i];
 		$myobj->nepl_name = $nepl_name[$i];
 		$myobj->priority = $order[$i];
 		$myobj->descrip = $desc[$i];
 		$myobj->id = $id[$i];
 		$myobj->mykeys = $mykeys[$i];
 		$myobj->myvalues = $myvalues[$i];
 		$myobj->field_extra = $field_extra[$i];
	 	if($table[$i] == "religion"){
	 		print_r($myobj);
	 	}
 		// print_r($myobj);
 		$myobj->save();
 	}
 } 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Personal Information System</title>

	<link rel="stylesheet" href="form/assets/demo.css">
	<link rel="stylesheet" href="form/assets/form-basic.css">
</head>
<body>
	<header>
		<h1>Updating Columns</h1>
        <a href="form/index.php?tab=address">Make your own PIS</a>
	</header>
	<ul>

<?php 
	
	$htmltype = array('text' => 'Text' , 'checkbox' => 'Multiple Select', 'radio' => 'Radio Select' ,'hidden' => "Hidden",'password'=>"Password");
	// foreach ($tables as $table_name) {
		?>
		<?php $all_fieldsnames = fields::find_all();
		$mydivs = array_chunk($all_fieldsnames,50,true);
		foreach($mydivs as $all_cols){ // start processing chunk Division 
		?>
<form action="update_cols.php" method="post" >
<table>
<?php
		
		$tablename = '';

		
			// echo "<br/><bold> size is".sizeof($cols) . "</bold>";
			foreach ($all_cols as $col1) {
				// id, tablename, field, type, eng_name, descrip, priority
				
		/*		if (($col1 == 'id') || ($col1 == 'tablename') ) {
					continue;
				}

		
		*/		if ($tablename != $col1->tablename) {
					echo "<tr><th colspan=\"7\">";
					echo $col1->tablename;
					$mydescription = $db->query("desc ".$col1->tablename);
					$desc_array = array();
					foreach ($mydescription as $desc1) {
					
						array_push($desc_array, array('type'=> $desc1['Type'], 'null'=>$desc1['Null']));
					}
					
					$desc_counter = 0;
					echo "</th></tr>";

					echo "<tr><th> Fileld Name </th><th> English Name</th><th> Nepali Name</th> <th width=\"10\">Type</th><th>Description</th><th>Order</th><th>Keys</th><th>Values</th><th>Extra</th></tr>";
					$tablename = $col1->tablename;
		}
				echo "<tr><td>". $col1->field. "<br/>". 

					// "Type: ".$desc_array[$desc_counter]['type'] . "; Null Qty =". $desc_array[$desc_counter]['null'].

					"<td>" . "<input type=\"text\" name=\"eng_name[]\" value=\"{$col1->eng_name}\" size=\"10\"/>" . "</td>".
					"<td>" . "<input type=\"text\" name=\"nepl_name[]\" value=\"{$col1->nepl_name}\" size=\"10\"/>" . "</td>".
					"<td>" . "<select name=\"type[]\">";
					foreach ($htmltype as $type1 => $display) {
						echo "<option value=\"{$type1}\" ";
							if ($col1->type == $type1) {
								echo " selected";
							}
						echo">{$display}</option>";	
					}
					echo "</select>";
				

				echo
					"<td>" . "<input type=\"text\" name=\"desc[]\"  value=\"{$col1->descrip}\" size=\"10\" />" . "</td>".
					"<td>" . "<input type=\"text\" name=\"order[]\"  value=\"{$col1->priority}\" size=\"3\"/>" . "</td>".
					"<td>" . "<input type=\"text\" name=\"mykeys[]\"  value=\"{$col1->mykeys}\" size=\"3\"/>" . "</td>".
					"<td>" . "<input type=\"text\" name=\"myvalues[]\"  value=\"{$col1->myvalues}\"/>" . "</td>".
					"<td>" . "<input type=\"text\" name=\"field_extra[]\"  value=\"";
					if ($col1->field_extra == NULL) {
						echo "NULL=" . $desc_array[$desc_counter]['null']. ",";
						
						if ((strpos($desc_array[$desc_counter]['type'], 'nt') == 0)) {
							if ($desc_array[$desc_counter]['type'] == 'text') {
								echo "type=longtext";
							} elseif ($desc_array[$desc_counter]['type']=="date") {
								echo "type=date";
							} else {
								echo "type=text";
							}
						}else{
							echo "type=number";
						}
						
					}else{
						echo $col1->field_extra;
					}
					echo "\" size=10/>" . "</td>".
					 "<td>" . "<input type=\"hidden\" name=\"fields[]\" value=\"{$col1->field}\" />" . "</td>".
					 "<td>" . "<input type=\"hidden\" name=\"table_name[]\" value=\"{$col1->tablename}\" />" . "</td>".
					 "<td>" . "<input type=\"hidden\" name=\"id[]\" value=\"{$col1->id}\" />" . "</td>".
					"</tr>";

					$desc_counter++; 
			}
		?>
		
		<?php
	// }
 ?> 
</table>
<div class="form-row"><input type="submit" name="submits" value="SUBMIT" class="form-basic form button" /></div>

</form>
<?php 

}// end of Chunks of form divisions
?>
</body>
</html>
