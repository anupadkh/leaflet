<?php 
// require_once '../includes/initialize.php';
require_once ('user.php');

if (isset($_POST['number_edit'])) {
	// print_r($_POST);
	for ($i=1; $i < 7; $i++) { 
		$object = Number::instantiate_post_values($_POST, $i);
		foreach ($object as $one_object) {
			if($one_object->vdc == NULL){
				continue;
			}
			$one_object->user = $session->user;
			$one_object->save();

		}
	}
	
	
}
if (!isset($_GET['vdc'])) {
	redirect_to("../index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>पर्वत जिल्लाको भत्ता पाउने लक्षित वर्गको विवरण</title>

</head>
<body>
<h4> Welcome <?php $user = User::find_by_id($_SESSION['user_id']); echo $user->full_name(); ?></h4>
<p><a href="../logout.php">Log Out</a></p>
<form action="edit.php?vdc=<?php echo $_GET['vdc']; ?>" method="post" accept-charset="utf-8">
	<?php
		$objects = Number::find_by_vdc($_GET['vdc']);
		if (!empty($objects)) {
			$output = edit_code('', $_GET['vdc']);
		} else{
				$output = edit_code("new", $_GET['vdc']);
			}
		echo $output;
	 ?>
	 <input type="submit" name="number_edit" value="Submit"/>&nbsp; &nbsp;&nbsp;&nbsp;
	 <input type="Reset" value="Reset"/>
</form>

</body>
</html>