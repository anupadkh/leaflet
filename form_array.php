		<?php 
		require_once 'includes/initialize.php';
        
        if ($active=='') { // takes care of passing $active by default
        	if (isset($_GET['tab'])) {
				$active = $_GET['tab'];
			} else{
				$active = 'person';
			}
        }
		
		if (isset($_POST['table'])) {
			$active = $_POST['table'];
            $all_class_vars = get_class_vars($active);
            foreach ($all_class_vars as $var_one) {
                $var_one[] = $_POST[$var_one];
            }
            for ($post_count=0; $post_count < count($$var_one); $post_count++) { 
                foreach ($all_class_vars as $var_one) {
                        $a = new $active();
                        $a->$var_one = $var_one[$post_count];
                    }
                print_r($a);
                // $a->save();    
                unset($a);
            }
            
			
            echo "<h4> Saved </h4>";
			if(isset($_GET['next'])){
				$active = $_GET['next'];
                $the = mymenu::find_by_id($_GET['next']);
                echo strpos($the, "?"); 
                if (strpos($the->href, "?")>0) {
                    redirect_to($the->href."&position=".$_GET['next']."&status=saved");    
                }
				redirect_to($the->href."?position=".$_GET['next']."&status=saved");
			} else{
				$_GET['id'] = $a->id;
			}
            // redirect_to('index.php?status=saved&position=1');
            // print_r($a); echo "<br/>";echo "<br/>";echo "<br/>";
            // print_r($_POST);
			
		}


		?>

        <div class="form-panel">
                      <h4 class="mb"><i class="fa fa-angle-right"></i> <?php echo $sidebar_active->nepl_name; ?></h4>
        <form class="form-inline" role="form" method="post" action="raw_form.php?tab=<?php echo $active;

        
        if (isset($_GET['position'])){
            echo "&position=".$_GET['position']."&next=".$_GET['position'];
        }

        if (isset($p_id)) { // parent id
        	echo "&p_id=".$p_id;
        } else{
            if (isset($_GET['id'])){
            echo "&id=".$_GET['id'];
        }
        }

        ?>">
            
            <?php 
  
            $all_cols = fields::find_by_sql("SELECT * FROM fields WHERE tablename='{$active}'"); 
            // print_r($all_cols);
            if ($parent == NULL) {
                if(isset($_GET['id'])){
                    $myvalue = $active::find_by_id($_GET['id']);
                }else{
                    $myvalue = new $active();
                }
            } else{ // Else finding the already existed record using parent_id, and constant hidden values are required.

            }  
            
            

            if ($parent != '') { //setting the hidden parent values
            	$properties = mytables::find_table($parent);
            	$hidden_array = array();
            	$subtables = explode(",", $properties->subtables);
            	$i = array_search($active, $subtables);
                if ($multiple_index != NULL) {
                    $i = $multiple_index;
                }
            	$default_values = explode("," , $properties->defaultvalues)[$i];
            	$table_values = explode("+", $default_values);
                                                                    // print_r($default_values);
                                                                    // echo "Defaults and <br/><br/>";
                                                                    // print_r($table_values);
                                                                    // echo "TableVaues";
            	$j = 0;
                // array_push(array, var)
                                                                    // echo $p_id . "I am here";
                                                                    // echo $tablevalues;
            	foreach ($table_values as $valued1) {
            		if ($j==0) {
            			$hidden_array[$valued1] = $p_id ; // Id of the parent Table
            		}else{
            			
            			$anup = explode("=", $valued1);
            			$hidden_array[$anup[0]] = $anup[1] ;
            		}
                    $j++;
            	}
            }
            
            
echo "<!--my arrays";
print_r($hidden_array);
echo "-->";
            
    if (isset($hidden_array)){
        unset($anup);
        foreach ($hidden_array as $key => $value){
        $myvalue->$key = $value;
        $anup ="{$key} = {$value} AND " ; // join keys and values
        }
        // print_r($anup);

            unset($sql);
            $sql = "SELECT * FROM {$active} WHERE ";
            $sql .= $anup . "1";
            echo $sql;
            $myvalue2 = $active::find_by_sql($sql);
            // print_r($myvalue2);

            unset($anup);
            unset($sql);

    }
    
            foreach ($all_cols as $col1) {
             $field = $col1->field;
                if ($col1->type== "hidden"){

                    echo "<input type=\"hidden\" name=\"{$field}\" value=\"{$myvalue->$field}\">";
                    continue;
                    
                }
            ?><div class="form-row">
                <label><?php 
                        if (explode("=",explode(",", $col1->field_extra)[0])[1] =="NO") {
                            $col1->nepl_name .= "*";
                        }
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

                 
            }
           
        //     print_r($myvalue);?>

        <input type="hidden" name="table" value="<?php echo $active; ?>"/>
        <input type="submit" name="<?php echo $active; ?>" value="Submit"/>
        </form>
        <!-- Form Panel Ends here -->
     </div> <?php  
        if ($myvalue->id !== NULL) {
            ?><form id="file-form" action="handler.php" method="POST">
                  <inptu type="file" id="file-select" name="photos[]" multiple/>
                  <button type="submit" id="upload-button">Upload</button>
                </form>
            <?php
        }

        unset($myvalue); // It is necessary to destroy the id; 
        ?>
