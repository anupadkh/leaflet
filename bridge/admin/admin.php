
<?php
// echo "Hello";
require_once('../includes/initialize.php');
require_once('user.php');


?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Bridges Information on Parbat DDC</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
<a href="../logout.php">Log Out</a>
<script type="text/javascript">
		 function showValue(newValue, target)    {
    		document.getElementById(target).innerHTML=newValue;    
    	}
</script>
<h1>Welcome to Parbat DDC Bridge Database</h1>
<p>Please select any items from the query list</p>

<form method="POST" action = "#" accept-charset="character_set">
	<p>Bridge Name<input type="text" name="bridge_name" /></p>
	<p>गाविस अनुसार खोज गर्नुहोस् <select name="vdc_bank">
		<option value = 'all'>ALL</option>
		<?php 
		$bridges = Bridge::find_banks();
		foreach ($bridges as $bridge1) {
			
				echo "<option value={$bridge1->VDC_sifarish}>{$bridge1->VDC_sifarish}";
				echo "</option>";
			
		}
		
		?>
	</select></p>
	<p>Bridge Lengths from 
	<input name="low_length" value="0" min="0" max="400" type="range" step="1" onchange="showValue(this.value,'lrange')" />
	<span id="lrange">0</span> metres (m) 
	
	 Upto <input name="high_length" value="400" min="1" max="400" type="range" step="1" onchange="showValue(this.value,'hrange')" /> 
	<span id="hrange">400</span> metres(m) 
	<p><input type="submit" name="submit" value="submit"/></p>
	
</form>

<p><a href="edit.php?edit_id=new">Add New Bridge Information</a></p>

<form method="POST" action="#" accept-charset="character_set">
<br/>
	<p>NULL values हुन सक्ने column रोज्नुहोस् <select name="null_values"> 
		<?php 
		foreach ($bridge1 as $key => $value) {
			if ($key == 'id' || $key == 'BridgeName'){
				continue;
			}
		 	echo "<option value='{$key}'>{$bridge1->nepali_name($key)}";
				echo "</option>";
		 } ?>
	</select></p>
	<input type="submit" name="form2" value="Submit">
</form>


<div id="container">
<p>Total Records Displayed = <span id="total"></span></p>

<?php 
	unset($bridges);
	$bridges = Bridge::find_all();
	$load_results = true;
	if (isset($_POST['submit'])) {
	 	// print_r($_POST);
		if ($_POST['submit']=='submit'){
			unset($bridges);
			$user_VDC = $_POST['vdc_bank'];
			$user_bridge_name = $_POST['bridge_name'];
			$user_length = $_POST['low_length'];
			$user_high_limit = $_POST['high_length'];
			if ($user_length < $user_high_limit){
						$bridges = Bridge::find_bridges($user_length, $user_high_limit,$user_bridge_name,$user_VDC);

					}else{
						echo "Wrong paramenters. Highest length should be greater than lowest lengths";
						$load_results = false;
					}
					
			// print_r($bridges);
		}
		
	}
	if (isset($_POST['form2'])){
		if ($_POST['form2'] == 'Submit'){
				$bridges = Bridge::find_null_field($_POST['null_values']);
		}
	}
	

	$first_time_run = true;

		if ($load_results==true && !empty($bridges)){
			foreach ($bridges as $bridge) {
					# code...
					echo "<div class=\"row\">";
					// echo $bridge->R_Bank."<br/>";
					// print_r($bridge);
					foreach ($bridge as $key => $value) {
						if ($key=='DCODE' || $key == 'state'){
							continue;
						}
						
						if ($key == 'BridgeName'){
							$value = $value . " झोलुङ्गे पुल";
						}
						
						echo "<span class=\"{$key}\">";
						if ($first_time_run == true) {
							echo "<strong>".Bridge::nepali_name($key)."</strong>". "<br/>" ;
							
						}
						if ($key =='id') {	
							echo "<a href=\"edit.php?edit_id={$value}\">"."Edit"."</a>";

							echo "</span>";
							continue;
						}
						if ($key=='Heralu' && !(is_null($value))) {
							$heralu_obj = Heralu::find_by_id($value);
							if ($heralu_obj != false){
								echo $heralu_obj->full_name() . "</span>";
								continue;
							}
							echo "</span>";
							continue;
						}
						echo $value."</span>";
					}

					if ($first_time_run == true) {
							echo "<span class=\"maintain\">";
							echo "<strong>"."मर्मत सुचना"."</strong><br/>";
							echo "<a href=\"maintenance.php?bridge_id={$bridge->id}\">"."मर्मत Click Here"."</a>";
							echo "</span>";
						} else{
							echo "<span class=\"maintain\">";
							echo "<a href=\"maintenance.php?bridge_id={$bridge->id}\">"."मर्मत Click Here"."</a>";
							echo "</span>";
						}
					$first_time_run = false;
					echo "<br/>";
					echo "</div>";
				}
			}
	
 ?>
 
 <script type="text/javascript">
 document.getElementById("total").innerHTML= <?php 
 echo count($bridges); ?>;
 </script>
 </div>
</body>
</html>