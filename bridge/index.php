<?php

require_once'includes/initialize.php';
redirect_to("Panel/php/login.php");
// echo "Hello";

?>
<?php 
if (isset($_POST['submit'])) {
	if ($_POST['submit'] == 'पेश गर्नुहोस्' ) {
		$_SESSION['ids'] = $_POST['check_item'];
		redirect_to('admin/create_kml.php');
	}
}
 ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Bridges Information on Parbat DDC</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<script type="text/javascript">
		 function showValue(newValue, target)    {
    		document.getElementById(target).innerHTML=newValue;    
    	}
</script>
<h1>Welcome to Parbat DDC Bridge Database</h1>
<p>Please select any items from the query list</p>

<form method="POST" action = "index.php" accept-charset="character_set">
	<p>Bridge Name<input type="text" name="bridge_name" /></p>
	<p>गाविस अनुसार खोज गर्नुहोस् <select name="vdc_bank">
		<option value = 'all'>ALL</option>
		<?php 
		$bridges = Bridge::find_banks();
		if (isset($_POST['vdc_bank'])) {
			$sel_vdc = $_POST['vdc_bank'];
		}else{
			$sel_vdc = '';
		}
		foreach ($bridges as $bridge1) {
			
				echo "<option value={$bridge1->VDC_sifarish} ";
				if ($sel_vdc == $bridge1->VDC_sifarish) {
					echo "selected";
				}
				echo ">{$bridge1->VDC_sifarish}";
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
<p>Total Records Displayed = <span id="total"></span></p>

<div id="container">
<form action="#" method="post" accept-charset="utf-8">
<?php 
	unset($bridges);
	$bridges = Bridge::find_all();
	$load_results = true;
	if (isset($_POST['submit'])) {
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
	$first_time_run = true;
	$states = array('राम्रो', 'ठिकै', 'मर्मत हुनुपर्ने अवस्था');
		if ($load_results==true && !empty($bridges)){
			foreach ($bridges as $bridge) {
					# code...
					echo "<div class=\"row\">";
					// echo $bridge->R_Bank."<br/>";
					// print_r($bridge);
					foreach ($bridge as $key => $value) {
						# code...
					
						if ($key=='Heralu' || $key == 'DCODE' || $key == 'state') {	
							continue;
						}
						if ($key == 'id'){
							echo "<span class=\"Heralu\"><input type=\"checkbox\" value={$value} class=\"myselect\" name=\"check_item[]\" /></span>";
							continue;
						}
						
						if ($key == 'BridgeName'){
							$value = $value . " झोलुङ्गे पुल";
						}

						echo "<span class=\"{$key}\">";
						if ($first_time_run == true) {
							echo "<strong>".Bridge::nepali_name($key)."</strong>". "<br/>" ;
							
						}
				
						echo $value."</span>";
					}
					echo "<span class=\"maintain\">";
						$maintain_info = Maintenance::find_by_bridge_id($bridge->id);
						if ($first_time_run== true){
							echo "<strong>मर्मत भएको मिति</strong>";
						}
							if (!is_null($maintain_info)) {
								
									foreach ($maintain_info as $maintain_info1) {
										echo "<a href=\"details.php?id=". $maintain_info1->id."&bridge_id=".$bridge->id."\" >". $maintain_info1->m_date. "</a>" . "<br/>";
									}		
								
								
							}
						
					echo "</span>";
					
					$first_time_run = false;
					echo "<br/>";
					echo "</div>";
				}
			}
	
 ?>
 <input type="submit" value="पेश गर्नुहोस्" name="submit">
 </form>
 <script type="text/javascript">
 document.getElementById("total").innerHTML= <?php 
 echo count($bridges); ?>;
 </script>
 </div>
 <div>
 
 	<script type="text/javascript">
		function toggle_me(source) {
		  checkboxes = document.getElementsByClassName('myselect');
		  for (index =0; index<checkboxes.length; index++)
		    checkboxes[index].checked = source.checked;
		}
	</script>
	<input type="checkbox" onClick="toggle_me(this)"/>Select All
 </div>
</body>
</html>
