<?php 
require_once 'includes/initialize.php';
if (isset($_GET['id']) && isset($_GET['pid_parent'])) {
	$toDel = file::find_by_id($_GET['id']);
	unlink("uploads".DS.$toDel->file_name);
	if (!(file_exists("uploads".DS.$toDel->file_name))) {
		$toDel->delete();
		$op = "Deleted";
		$del = 1;
	}
}else{
	$op = "Not Deleted";
	$del = 0;
}
redirect_to("personform.php?tab=".$_GET['tab']."&id=".$_GET['pid_parent']."&position=".$_GET['position']."&deleted_status=".$del);
// http://localhost:81/nhrm/LBPIS/delete_image.php?id=11&pid_parent=1&tab=person&position=10
 ?> 
