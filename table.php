<?php 
include_once '../includes/initialize.php'; 

$all_tables = mytables::find_all();

		if (isset($_GET['tab'])) {
			$active = $_GET['tab'];
		} else{
			$active = 'person';
		}
		if (isset($_POST['submit'])) {
			
			
			echo $_POST['submit']."<br/>";
			$a = $active::instantiate($_POST);
			print_r($a);
		}
		$selected_table = mytables::find_by_name($active);
		// print_r($selected_table);
		// print_r($selected_table);
		foreach ($all_tables as $table1) {
			echo "<li><a href=\"index.php?tab={$table1->tablename}\" ";
				if ($active == $table1->tablename) {
					echo "class=\"active\"";
				}
			echo ">{$table1->header}</a></li>";
		} ?>
	</ul>
	<div class="main-content">
		<form class="form-basic" method="post" action="index.php?tab=<?php echo $active; ?>">
			<div class="form-title-row">
                <h1><?php echo $selected_table->header; ?></h1>
            </div>
            <?php 
            $all_cols = fields::find_by_sql("SELECT * FROM fields WHERE tablename=\"{$active}\"" ); 
            foreach ($all_cols as $col1) {
            	if ($col1->type== "hidden"){
                	continue;
                }
            ?>

            <div class="form-row">
                <label>
                
                    <span><?php echo $col1->field; ?></span>
                    <input type="<?php echo $col1->type; ?>" name="<?php echo $active.",".$col1->field; ?>">
                </label>

            </div>
            <?php 
            	 
            }?>
           <!--  <input id="form-person-title" type="text" list="mylist">
<datalist id="mylist">
<option label="Mr" value="Mr">
<option label="Ms" value="Ms">
<option label="Prof" value="Mad Professor">
</datalist> -->
		<input type="submit" name="submit" value="<?php echo $active; ?>"/>
		</form>

	</div>
</body>
</html>
