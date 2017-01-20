
<?php
// echo "Hello";
require_once('../includes/initialize.php');
// require_once('user.php');

?><?php
	include_once("../includes/form_functions.php");
	
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		$first_name = trim(mysql_prep($_POST['first_name']));
		$last_name = trim(mysql_prep($_POST['last_name']));
		$vdc = $_POST['vdc'];
		$mobile = $_POST['mobile'];
		$state = $_POST['state'];
		$recruit_date = $_POST['recruit_date'];
		$hashed_password = sha1($password);
		$email = $_POST['email'];

		if ( empty($errors) ) {
			$query = "INSERT INTO users (
							username, password, first_name, last_name, vdc, state, recruit_date, email, mobile
						) VALUES (
							'{$username}', '{$hashed_password}','{$first_name}','{$last_name}', '{$vdc}', '{$state}', '{$recruit_date}', '{$email}', '{$mobile}'
						)";
			$result = mysql_query($query);
			if ($result) {
				$message = "The user was successfully created.";
			} else {
				$message = "The user could not be created.";
				$message .= "<br />" . mysql_error();
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
	} else { // Form has not been submitted.
		$username = "";
		$password = "";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create New User</title>
</head>
<body>
<?php 
if (isset($message)) {
		echo $message;
}  ?>
<form action="#" method="POST" accept-charset="utf-8">
	<table>
		<tr><th>First Name</th><td><input name="first_name" type="text"/></td></tr>
		<tr><th>Last Name</th><td><input name="last_name" type="text"/></td></tr>
		<tr><th>Username</th><td><input name="username" type="text"/></td></tr>
		<tr><th>Password</th><td><input name="password" type="password"/></td></tr>
		<tr><th>Mobile Number:</th><td><input name="mobile" type="text"/></td></tr>
		<tr><th>VDC</th><td><select name="vdc"><?php 
		$vdc_list = Vdc::find_all();
		foreach ($vdc_list as $vdc1) {
			echo "<option value=".$vdc1->id.">". $vdc1->nepl_name."</option>";
		}
		 ?></select></td></tr>
		 <tr><th>State</th><td><select name="state">
		 	<option value="1">Active</option>
		 	<option value="2">Inactive</option>
		 </select></td></tr>
		 <tr><th>काममा भर्ना भएको मिति:<br/>२०६९ साल पौष महिना ११ गते<br/>(2069/10/11)</th><td><input name="recruit_date" type="date"/></td></tr>
		 <tr><th>Email Address:</th><td><input type="text" name="email"/></td></tr>
		 <tr><td><input type="Submit" value="Submit" name="submit"/></td></tr>
	</table>
</form>
</body>
</html>
