<?php require_once('../includes/initialize.php'); 
// require_once('user.php');
require_once ('user.php');
$user = User::find_by_id($session->user_id);
if ($user->user_type != 5){
	echo "Unauthorized access";
	exit;
}
?>
<?php
	include_once("../includes/form_functions.php");
	
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
// array('id','username', 'password', 'first_name', 'last_name', 'bank', 'branch' );
		$username = trim(mysql_prep($_POST['username']));
		$password = trim(mysql_prep($_POST['password']));
		$first_name = trim(mysql_prep($_POST['first_name']));
		$last_name = trim(mysql_prep($_POST['last_name']));
		$bank = $_POST['bank'];
		$branch = $_POST['branch'];
		$hashed_password = sha1($password);

		if ( empty($errors) ) {
			$query = "INSERT INTO user_ss (
							username, password, first_name, last_name, bank, branch
						) VALUES (
							'{$username}', '{$hashed_password}','{$first_name}','{$last_name}', '{$bank}', '{$branch}'
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
<table id="structure">
	<tr>
		<td id="navigation">
			<a href="staff.php">Return to Menu</a><br />
			<br />
		</td>
		<td id="page">
			<h2>Create New User</h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			<form action="new_user.php" method="post">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" /></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" /></td>
				</tr>
				<tr>
					<p>First Name: <input type="text" name="first_name"></p>
					<p>Last Name: <input type="text" name="last_name"></p>
					<p>Bank Name: <input type="text" name="bank"></p>
					<p>Branch: <input type="text" name="branch"></p>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Create user" /></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
