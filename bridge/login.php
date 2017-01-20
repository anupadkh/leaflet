<?php
require_once 'includes/initialize.php';
if (isset($_POST['submit'])) {
	$_POST['password'] = sha1($_POST['password']);
	$user = User::authenticate($_POST['username'], $_POST['password']);
	// print_r($user);
	if ($user){
		$session->login($user);
		// echo "successfully Logged In";
	}
}

if ($session->is_logged_in()){
	$redirect = (isset($_SESSION['page'])) ? $_SESSION['page'] : 'admin/admin.php';
	// echo $redirect;
	redirect_to($redirect);
	// print_r($_POST);
} else{
	 
}

if (!isset($_SESSION['page'])){
	$messr = 'index.php';
}
// unset($_SESSION['page']);
?>
<html>
<head>
	<title>Login User | Bridge Information Database</title>
</head>
<body>
<form name="login" action='<?php echo (isset($messr)) ? $messr : 'login.php' ; ?>' method="POST">
<table><tr><td>Username:</td><td><input type="text" name="username" cols=40><br/></td></tr>
<tr><td>Password:</td><td><input	type="password" name="password" cols=40></td></tr>
</table>
<input type="submit" name="submit" value="Submit">
</form></body>
</html>