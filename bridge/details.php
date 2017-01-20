
<?php
// echo "Hello";
require_once('includes/initialize.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>पुलको मर्मत सम्भार भएको विवरण</title>
</head>
<body>
<h1><?php $bridge = Bridge::find_by_id($_GET['bridge_id']);
echo $bridge->BridgeName; ?> झोलुङ्गे पुलको मर्मत विवरण</h1>
<?php $maintain_objects = Maintenance::find_by_bridge_id($_GET['bridge_id']); 
		foreach ($maintain_objects as $maintain_info) {
		
		
?>
<h2>मिति: <?php 

echo $maintain_info->m_date; ?></h2>
<p><?php echo $maintain_info->description; ?></p>
<?php } ?>
</body>
</html>
