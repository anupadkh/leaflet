<?php 

  global $session;
  if (!$session->is_logged_in()){
  	$_SESSION['page'] = 'admin/admin.php';
    redirect_to('../login.php');
  }

define('district_code', $_SESSION['DCODE']);


 ?>