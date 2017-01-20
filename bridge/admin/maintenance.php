<?php
require_once('../includes/initialize.php');
require_once ('user.php');

if (!isset($_GET['bridge_id'])){
	redirect_to("admin.php");
}
if (isset($_POST['form1'])) {
	 // print_r( $_POST);
	
	$object = Maintenance::instantiate($_POST);
	$object->save();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>पुल सुधारको सुचना राख्ने, सम्पादन गर्नुहोस्</title>
	 <script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="nepali.datepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="nepali.datepicker.css" />
</head>
<body>
<h1>यो पुल मर्मत Page मा तपाईँलाई स्वागत छ ।</h1>
<p>यो पेजमा तपाईँले रोजेको पुलको मर्मत विवरण राख्न सक्नुहुनेछ ।</p>
<h3>हालसम्मको पुल मर्मतको वस्तु स्थिति विवरण </h3>
<?php $maintain_objects = Maintenance::find_by_bridge_id($_GET['bridge_id']); 
		if ($maintain_objects == false){
			echo "राख्ने गरेको छैन ।";
		}
		foreach ($maintain_objects as $maintain_info) {
		
		
?>
<h4 style="margin-left:10px;">मिति: <?php 

echo $maintain_info->m_date; ?></h4>
<p style="margin-left:50px;">मर्मतको विवरण:<?php echo $maintain_info->description; ?></p>
<?php 

		} 

?> <h3> नयाँ मर्मतबारे रिकर्ड थप्नुहोस् </h3>
<form method="post" action="#" accept-charset="character_set">
	<p>पुल सुधार भएको मिति: <input type ="date" name = "m_date" class="nepali-calendar" id="m_date" value="2072-10-18"></p>
	<p>पुल सुधार हुनु बारे छोटो विवरण : <input type ="text" name = "description" style="height:300px; width:300px;"></p>
	<input type="hidden" name="bridge_id" value="<?php echo $_GET['bridge_id']; ?>">
	<p><input type="submit" name="form1" value="Submit"></p>
</form>
</body>
</html>