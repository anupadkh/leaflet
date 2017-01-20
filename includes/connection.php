<?php
require("constants.php");

// 1. Create a database connection
$connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if (!$connection) {
	die("Database connection failed: " . mysqli_error());
}
echo "Pass 1";
// 2. Select a database to use 
$db_select = mysqli_select_db(DB_NAME,$connection);
if (!$db_select) {
	die("Database selection failed: " . mysqli_error());
}
?>
