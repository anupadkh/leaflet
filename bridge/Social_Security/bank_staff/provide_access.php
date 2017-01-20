<?php 
require_once '../includes/initialize.php';
require_once ('user.php');
$user = User::find_by_id($session->user_id);
if ($user->user_type != 5){
	echo "Unauthorized access";
	exit;
}
if (isset($_POST['access'])) {
	$vdcarray = $_POST['vdc'];
	$authority = $_POST['authority'];
	$all_entries = BankAccessVdc::find_by_user_id($_POST['user']);
	foreach ($all_entries as $one_entry) {
		$one_entry->delete();
	}
	for ($i=0; $i<count($vdcarray); $i++) {
		$user_enter = new BankAccessVdc;
		$user_enter->user_id = $_POST['user'];
		$user_enter->vdc_id = $vdcarray[$i];
		$user_enter->authority = $authority[$i];
		$user_enter->save();
	}
}
 ?><!DOCTYPE html>
 <html>
 <head>
 	<title>Access Domain</title>
 </head>
 <body>
 <h4> Welcome <?php $user = User::find_by_id($_SESSION['user_id']); echo $user->full_name(); ?></h4>
<p><a href="../logout.php">Log Out</a></p>
 <form method="post" action="#">
 	<?php 
 		$vdcs = Vdc::find_current_vdcs();
 		$user = User::find_all();
 		echo "<select name=\"user\">";
 		foreach ($user as $user1) {
 			echo "<option value=\"" . $user1->id ."\">". $user1->full_name() . "</option>";
 		}
 		echo "</select>"."<br/>";
 		?><table>
 			<tr>
	 			<th>Select</th>
	 			<th>VDC</th>
	 			<th>Access</th>
	 		</tr>
 			
 		<?php
 		
 		foreach ($vdcs as $vdc1) {
 			echo "<tr>";
	 			echo "<td>";
	 			echo "<input type=\"checkbox\" name=\"vdc[]\" value=". 
	 				$vdc1->id.">"; 
	 			echo "</td>";
	 			echo "<td>".$vdc1->nepl_name."</td>";
	 			echo "<td><input type=\"number\" name=\"authority[]\" max=2 min=1>"."</td>";
	 			/*echo "<fieldset>";
        			echo "<td><input type=\"radio\" name=\"read[]\"></td>";
        			echo "<td><input type=\"radio\" name=\"write\"></td>";
        		echo "</fieldset>";*/
        	echo "<tr/>";
    	}
 	 ?></table>
 	 <input type="Submit" name="access" value="Submit">
 </form>
 	
 </body>
 </html>