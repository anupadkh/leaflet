<?php 
$page_title = "ड्यासबोर्ड";
$active_id = 1;

require_once 'includes/initialize.php';
$all_tables = mytables::find_all();
/* 

- $active stores name of table used
- Use of hidden variable table stores name of table used on submit. Table can't be used in database name as variable . So this name is best
- 


*/
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Personal Information System</title>

	<link rel="stylesheet" href="../form/assets/demo.css">
	<link rel="stylesheet" href="../form/assets/form-basic.css">
	<style type="text/css">
		table td{
			width: 143px;
		}
	</style>
</head>
<body>
	<header>
		<h1>Khichadi</h1>
        <a href="#">Bringing PIS to your door</a>
	</header>
	<ul>

		<?php 

		if (isset($_GET['tab'])) {
			$active = $_GET['tab'];
		} else{
			$active = 'person';
		}
		// $key = array_search($_POST, 'id');
		// echo $key;
		if (isset($_POST['table'])) {
			// echo "Hello";
			// echo $_POST['submit']."<br/>";
			// echo "<br/> Submitted values : ";
			// print_r($_POST);
			// echo "<br/>";
			$a = $active::instantiate($_POST);
			// print_r($a);
			$a->save();
			
		}

		$selected_table = mytables::find_by_sql("SELECT * FROM mytables WHERE tablename='{$active}' LIMIT 1")[0];

		foreach ($all_tables as $table1) {
			echo "<li><a href=\"update_columns.php?tab={$table1->tablename}\" ";
				if ($active == $table1->tablename) {
					echo "class=\"active\"";
				}
			echo ">{$table1->header}</a></li>";
		} ?>
	</ul>
	<div class="main-content">
		<form class="form-basic" method="post" action="update_columns.php?tab=<?php echo $active; ?>">
			<div class="form-title-row">
                <h1><?php echo $selected_table->header; ?></h1>
            </div>
            <?php 
  
            $all_cols = fields::find_by_sql("SELECT * FROM fields WHERE tablename='{$active}'"); 
            // print_r($all_cols);
            foreach ($all_cols as $col1) {
            	if ($col1->type== "hidden"){
                	continue;
                }
            ?>

            <div class="form-row">
                <label>
                	<?php 
                		
                		if ($col1->type=='radio') {
                			?> <span><?php echo $col1->eng_name. "(".$col1->nepl_name . ")" ; ?></span>
                			<select name=<?php echo $col1->field; ?>>
                			<?php 
                				$field_array = explode(",", $col1->mykeys);
                				$field_values = explode(",", $col1->myvalues);
                				$i = 0;
                				foreach ($field_array as $myoption) {
                					echo "<option value=".$myoption.">".$field_values[2*$i]."(".$field_values[2*$i + 1]. ")" . "</option>";
                					$i++;
                				}
                			?>
                			</select>
                			<?php 
                			
                		} elseif ($col1->type=='checkbox') {
                			 echo "<span>" . $col1->eng_name. "(".$col1->nepl_name . ")" . "</span>";
		            			$field_array = explode(",", $col1->mykeys);
                				$field_values = explode(",", $col1->myvalues);
                				$i = 0;
                				foreach ($field_array as $myoption) {
                					echo "<input type=\"checkbox\" name=\"{$col1->field}\" value=".$myoption."/><label>".$field_values[$i]."(".$field_values[$i + count($field_array)]. ")" . "</label>";
                					$i++;
                				}
                		} else {

                	?>
                    <span><?php echo $col1->eng_name. "(".$col1->nepl_name . ")" ; ?></span>
                    <input type="<?php echo $col1->type; ?>" name="<?php echo $col1->field; ?>">
                    <?php 
                } // end of else 
                    ?>

                </label>

            </div>
            <?php 
            	 
            }?>

		<input type="hidden" name="table" value="<?php echo $active; ?>"/>
		<input type="submit" name="<?php echo $active; ?>" value="Submit"/>
		</form>

	</div>
</body>
</html>
