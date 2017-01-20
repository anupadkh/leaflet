<?php require_once("includes/initialize.php"); 
// require_once 'includes/form_functions.php'; ?>
<?php
	
	// START FORM PROCESSING
	if (isset($_POST['submit'])) { // Form has been submitted.
		$errors = array();

		// perform validations on the form data
		// $required_fields = array('username', 'password');
		// $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

		// $fields_with_lengths = array('username' => 30, 'password' => 30);
		// $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
		// print_r($_POST);
		// $username = trim(mysql_prep($_POST['username']));
		// $password = trim(mysql_prep($_POST['password']));
		// $hashed_password = $password;
		$username = $_POST['username'];
		$hashed_password = $_POST['password'];
		// print_r($_POST);
		
		if ( empty($errors) ) {
			// Check database to see if username and the hashed password exist there.
			$query = "SELECT id, username ";
			$query .= "FROM user ";
			$query .= "WHERE username = '{$username}' ";
			$query .= "AND pwd = '{$hashed_password}' ";
			$query .= "LIMIT 1";
			// echo $query;
			$logged_user = user::find_by_sql($query)[0];
			if (($logged_user->id) != NULL) {
				// username/password authenticated
				// and only 1 match
				
				$_SESSION['user_id'] = $logged_user->id;
				$_SESSION['username'] = $logged_user->username;
				redirect_to("index.php");
				echo "The user is logged In";
			} else {
				// username/password combo was not found in the database
				$message = "Username/password combination incorrect.<br />
					Please make sure your caps lock key is off and try again.";
				print_r($logged_user);	
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
		
	} else { // Form has not been submitted.
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			$message = "You are now logged out.";
		} 
		$username = "";
		$password = "";
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>जिल्ला विकास समितिको कार्यालयको</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		      <form class="form-login" action="login.php" method="post">
		        <h2 class="form-login-heading">युजरनेम र पासवर्ड राख्नुहोस्</h2>
		        <div class="login-wrap">
		            <input type="text" name="username" class="form-control" placeholder="युजरनेम" autofocus>
		            <br>
		            <input type="password" class="form-control" placeholder="पासवर्ड" name="password">
		            <input name="submit" type="hidden" value="form">
		            <button class="btn btn-theme btn-block" href="login.php" type="submit"><i class="fa fa-lock"></i> साईन ईन</button>
		            <hr>
		            
		            
		        </div>
	
		
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>


  </body>
</html>