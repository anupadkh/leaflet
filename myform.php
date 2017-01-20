<?php if (!isset($_GET['position'])) {
    $_GET['position'] = 1;
} ?>
<?php require_once 'formheader.php'; ?>
      <div class="col-lg-12">
        <div class="form-panel">
                      <h4 class="mb"><i class="fa fa-angle-right"></i> <?php echo $sidebar_active->nepl_name; ?></h4>
		<form class="form-inline" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?tab=<?php echo $active;

		if (isset($_GET['id'])){
			echo "&id=".$_GET['id'];
		}
        if (isset($_GET['position'])){
            echo "&position=".$_GET['position'];
        }

		?>">
            
            <?php 
  
            $all_cols = fields::find_by_sql("SELECT * FROM fields WHERE tablename='{$active}'"); 
            // print_r($all_cols);
            if(isset($_GET['id'])){
            	$myvalue = $active::find_by_id($_GET['id']);
            }else{
            	$myvalue = new $active();
            }

            


	if (isset($hidden_array)){
		foreach ($hidden_array as $key => $value){
		$myvalue->$key = $value;
		}
	}
	
            foreach ($all_cols as $col1) {
    		 $field = $col1->field;
            	if ($col1->type== "hidden"){

                	echo "<input type=\"hidden\" name=\"{$field}\" value=\"{$myvalue->$field}\">";
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
                			
                			if (!is_null($col1->descrip)){
                				$field_array =  array();
                				$field_values =  array();
	                			$constraints = explode(",",$col1->descrip);
	                			$conditions = array();
	                			foreach ($constraints as $const1){
	                				$m1 = explode("=",$const1);
	                				$conditions[($m1[0])] = $m1[1];
	                			}
	                			$table = $conditions['table'];
	                			$nepl = $conditions['nepl'];
	                			$eng = $conditions['eng'];
	                			
	                			$table_fields = $table::find_all();
	                			foreach ($table_fields as $newoption){
	                				array_push($field_array,$newoption->id);
	                				array_push($field_values,$newoption->$eng,$newoption->$nepl);
	                			}
                			}else{
                				$field_array = explode(",", $col1->mykeys);
                				$field_values = explode(",", $col1->myvalues);
                            }
                				$i = 0;
                				foreach ($field_array as $myoption) {
                					echo "<option value=".$myoption;
                					if($myvalue->$field == $field_array[$i]){
                						echo " selected";
                					}
                					echo">".$field_values[$i*2]."(".$field_values[$i*2+1] . ")" . "</option>";
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
                					echo "<input type=\"checkbox\" name=\"{$col1->field}[]\" value=".$myoption."/><label>".$field_values[$i]."(".$field_values[$i + count($field_array)]. ")" . "</label>";
                					$i++;
                				}
                		} else {

                	?>
                    <span><?php echo $col1->eng_name. "(".$col1->nepl_name . ")" ; ?></span>
                    <?php $field = $col1->field; 
                    
                                        // print_r($col1);?>

                    <input type="<?php echo $col1->type; ?>" name="<?php echo $col1->field; ?>" value="<?php echo $myvalue->$field; ?>">
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
        </div>
        </section>
        </section>

	<?php require_once 'footer.php'; ?>