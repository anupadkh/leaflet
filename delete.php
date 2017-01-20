<?php 
require_once 'includes/initialize.php';
// print_r($_GET);
// echo count($_GET) + 1;
if (count($_GET) == 0 ) {
	echo "No values";
	exit('');
}
$active = $_GET['tab'];
// print_r($_GET);

$newobj =  $active::find_by_id($_GET['id']);
$newobj->delete();
			
				redirect_to("others.php?tab={$active}&item={$active}&deleted=true&position={$_GET['next']}"); //tab=organization&item=organization




 ?>
 <a href="index.php">Return Home</a>