<?php 
require_once ('../includes/initialize.php');
require_once ('user.php');

 ?><!DOCTYPE html>
 <html>
 <head>
 	<title>गाविस छान्नुहोस्</title>
 </head>
 <body>
 	<h1>तपाईँको गाविस छान्नुहोस् । </h1>
 	<h4> Welcome <?php $user = User::find_by_id($_SESSION['user_id']); echo $user->full_name(); ?></h4>
 	<p><a href="../logout.php">Log Out</a></p>
 	<p>
 	
 	<ul>
	<?php 
		foreach ($vdc as $vdc_id) {
			$vobj = Vdc::find_by_id($vdc_id);
			echo "<li><a href=\"edit.php?vdc={$vdc_id}\">".$vobj->nepl_name."</a></li>";
		}
	 ?>
	 </ul>
	 <ol>
 		<a href="provide_access.php">प्रयोगकर्ताको गा.वि.स.हरु मिलाउनुहोस् ।</a><br/>
 		<a href="new_user.php">नयाँ प्रयोगकर्ता थपनुहोस् ।</a>
 	</ol>
 	</p>
 </body>
 </html>