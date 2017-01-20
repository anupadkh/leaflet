<?php 
require_once '../includes/initialize.php';
  global $session;
  if (!$session->is_logged_in()){
    redirect_to('../index.php');
  }
  
  $all_access = BankAccessVdc::find_by_user_id($session->user_id);
  // print_r($all_access);
  $vdc = [];
  foreach ($all_access as $vdc1) {
  	// print_r($vdc1);
  	$vdc[] = $vdc1->vdc_id;
  }
  if (isset($_GET['vdc'])) {
  	// print_r($vdc);
  	if (!in_array($_GET['vdc'], $vdc)) {
  		echo "Unauthorized access";
  		exit;
  	}
  }
 ?>