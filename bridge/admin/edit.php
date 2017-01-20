<?php
require_once('../includes/initialize.php');
require_once('user.php');
if (!isset($_POST['submit'])){
	if (!isset($_GET['edit_id'])){
		redirect_to("admin.php");
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Edit the Bridges Information</title>
</head>
<body>

<?php 
if (isset($_POST['form'])) {
	echo "Submit Successful"; 
	?>
	<a href="admin.php">Click here to be directed to main page</a>
	<?php
			// Array to object
	$object = Bridge::instantiate($_POST); // it is normally private. I wanted it here to call. So made it public
	$heralu = Heralu::instantiate_heralu($_POST);
	
	$heralu->save();
	$object->Heralu = $heralu->id;
	$object->save();
	

	$all_coordinates = Coordinates::instantiate_all_coordinates($_POST, $object->id);

	foreach ($all_coordinates as $point) {
		$point->save();
	}
}
 ?>
<?php 
	if (is_numeric($_GET['edit_id'])) {
		# code...
		$selected = Bridge::find_by_id($_GET['edit_id']);
	} elseif (is_string($_GET['edit_id'])) {
		$selected = NULL;
	} else {
		$selected = Bridge::find_by_id($object->id);
	}
	

 ?>
 <form action="edit.php?edit_id=<?php echo $_GET['edit_id']; ?>" method ="post" accept-charset="character_set">
 	<?php 

 	echo edit_code($_GET['edit_id'], $selected);
 	
 	 ?>
 	 <input type="submit" value="Submit" id="submit" name="form"/>
 </form>
</body>
</html>