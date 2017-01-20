		<?php 
		require_once 'includes/initialize.php';
        ini_set('upload_max_filesize', '20M');
        
        if ($active=='') { // takes care of passing $active by default
        	if (isset($_GET['tab'])) {
				$active = $_GET['tab'];
			} else{
				$active = 'person';
			}
        }
		
		if (isset($_POST['table'])) {
			$active = $_POST['table'];
            print_r($_POST);
			$a = $active::instantiate($_POST);
			$a->save();
            echo "<h4> Saved </h4>";
			if(isset($_GET['next'])){
				$active = $_GET['next'];
                $the = mymenu::find_by_id($_GET['next']);
                echo strpos($the, "?"); 
                if ($_GET['p_id'] == NULL) {
                    $jump_id = $a->id;
                }else{
                    $jump_id = $_GET['p_id'];
                }
                if (strpos($the->href, "?")>0) {
                    redirect_to($the->href."&position=".$_GET['next']."&status=saved&id={$jump_id}");    
                }
				redirect_to($the->href."?position=".$_GET['next']."&status=saved&id={$jump_id}");
			} else{
				$_GET['id'] = $a->id;
			}
            // redirect_to('index.php?status=saved&position=1');
            // print_r($a); echo "<br/>";echo "<br/>";echo "<br/>";
            // print_r($_POST);
                                    // $multiple_index = $m;
                                    // $active = $mytables[$m];
                                    // $p_id = $_GET['id'];
                                    // $parent = $_GET['tab'];
                                    // $formstyle = $formtype[$m];
			
		}
        if (!isset($scripts)) {
            $scripts = ''; // scripts to run at the end;
        }
        


		?>

        <div class="form-panel">
                      <h4 class="mb"><i class="fa fa-angle-right"></i> <?php echo $sidebar_active->nepl_name; ?></h4>
        <form name="<?php echo $active; ?>" class="form-inline" role="form" method="post" action="raw_form.php?tab=<?php echo $active;

        
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
                        $foreign_key = $valued1;
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
        $anup = "";
        foreach ($hidden_array as $key => $value){
        $myvalue->$key = $value;
        $anup .= "{$key} = {$value} AND " ; // join keys and values
        }
        // print_r($anup);

            unset($sql);
            $sql = "SELECT * FROM {$active} WHERE ";
            $sql .= $anup . "1";

            // echo $sql;
            $myvalue2 = $active::find_by_sql($sql)[0];
            // print_r($myvalue2);

            if($formstyle == 2){
                $rec_insert=1;
                $merosql=$sql;?>
                <iframe src="newlist.php?tab=<?php echo $active."&position=" .$_GET['position']; ?>" height="200" width="500"></iframe>  
                <?php
                $myvalue2 = new $active();
                // unset($anup);
                // unset($sql);
                // break;

            }
            
            unset($anup);
            unset($sql);
        
        if ($myvalue2->$foreign_key == $myvalue->$foreign_key) {
            // Then the things are same
            $myvalue = $myvalue2;
            unset($myvalue2);
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
                                        // print_r($col1);
                    // Operations for Date and Nepali Picker
                    if (explode("=",explode(",", $col1->field_extra)[1])[1] =="date") {
                           
                           $opdisplay = "<input type=\"text\" id=\"{$col1->field}_nep_{$active}\" onchange=\"$('#{$col1->field}_en_{$active}').val(BS2AD($(this).val()))\" >BS";
                           $opdisplay .= "<input type=\"text\" id=\"{$col1->field}_en_{$active}\" name=\"{$col1->field}\" value=\"{$myvalue->$field}\" onchange=\"$('#{$col1->field}_nep_{$active}').val(BS2AD($(this).val()))\" >AD";
                           
                           $scripts .= "$('#{$col1->field}_nep_{$active}').val(AD2BS($('#{$col1->field}_en_{$active}').val())); 
                           $('#{$col1->field}_nep_{$active}').nepaliDatePicker({
                            ndpEnglishInput: '{$col1->field}_en_{$active}',
                            npdMonth: true,
                            npdYear: true,

                           });
                           $('#{$col1->field}_en_{$active}').change(function(){
                                $('#{$col1->field}_nep_{$active}').val(AD2BS($('#{$col1->field}_en_{$active}').val()));
                            });
                           ";
                           echo $opdisplay;
                           

                        } // Nepali Picker Ends Here
                        else{
                    ?>

                    <input size=50 type="<?php echo $col1->type; ?>" name="<?php echo $col1->field; ?>" value="<?php echo $myvalue->$field; ?>">
                    <?php 
                    } //end of else sub
                
                } // end of else main
                    ?>

                </label>

            </div>
            <?php 

                 
            }
           
        //     print_r($myvalue);?>

        <input type="hidden" name="table" value="<?php echo $active; ?>"/>
        <!-- <button type="submit" class="btn btn-primary" form="<?php echo $active; ?>" value="Submit">पेश गर्नुहोस् Submit</button> -->
        <input type="submit" class="btn btn-default" name="<?php echo $active; ?>" value="Submit"/>
        </form>
        <!-- Form Panel Ends here -->
     </div><div class="row"><!-- row of images and files lists already uploaded --> <?php  

        // <div class="row">
                        // <div class="col-lg-4 col-md-4 col-sm-4 mb">
                        //     <div class="product-panel-2 pn">
                        //         <div class="badge badge-hot">HOT</div>
        //                         <img src="assets/img/product.jpg" width="200" alt="">
        //                         <h5 class="mt">Flat Pack Heritage</h5>
        //                         <h6>TOTAL SALES: 1388</h6>
        //                         <button class="btn btn-small btn-theme04">FULL REPORT</button>
        //                     </div>
        //                 </div>

     
        if (($myvalue->id !== NULL) && (mytables::find_table($active)->file == 2)) {
            // echo "SELECT * FROM file WHERE cur_tablename=". $active." AND cur_id=".$myvalue->id;
            $files_all = file::find_by_sql("SELECT * FROM file WHERE cur_tablename='". $active."' AND cur_id=".$myvalue->id);
            
            foreach ($files_all as $file_one) {
                ?><div class="col-lg-4 col-md-4 col-sm-4 mb">
                            <div class="product-panel-2 pn">
                                <div class="badge badge-hot"><?php echo $file_one->id; ?></div>
                                <?php switch ($file_one->file_type) {
                                    case 'pdf':
                                        echo "<img src=\"assets/img/product.jpg\" width=\"200\" >";
                                        $text_display = "View Full Document";
                                        $button_text = "Uploaded Document";
                                        break;
                                    case 'docx':
                                        echo "<img src=\"assets/img/product.jpg\" width=\"200\" >";
                                        $text_display = "View Full Document";
                                        $button_text = "Uploaded Document";
                                        break;
                                    default:
                                        $text_display = "View Full Image";
                                        $button_text = "Uploaded Image";
                                        break;
                                }
                                ?><img src="uploads/<?php echo $file_one->file_name; ?>" class="img-rounded" width="200" alt="">
                                <h5 class="mt"><?php echo $file_one->description; ?></h5>
                                <h6><a href="delete_image.php?id=<?php 

                                    echo $file_one->id . 
                                    "&pid_parent=" . $_GET['id']. 
                                    "&tab=" . $_GET['tab'].
                                    "&position=" . $_GET['position'];

                                 ;?>" onclick="return confirm('Are you sure? के तपाईँ यो फाइल हटाउन चाहनुहुन्छ?')">Delete (हटाउनुहोस् )</a></h6>
                                <a class="btn btn-small btn-theme04" href="uploads/<?php echo $file_one->file_name; ?>" role="button"><?php echo $text_display; ?></a>
                            </div>
                        </div><?php

                 
            }
            
            ?></div>
            <!-- row of images and files lists already uploaded -->
            <form id="file-form<?php echo $active; ?>" action="uploads/upload.php" method="POST" enctype="multipart/form-data">
                  <input type="file" id="file-select<?php echo $active. $myvalue->id; ?>" name="fileToUpload"/>
                  <input type="hidden" name="table" value="<?php echo $active; ?>" />
                  <input type="hidden" name="id" value="<?php echo $myvalue->id; ?>" />

                  <input type="hidden" name="nav_id" value="<?php echo $_GET['id']; ?>" />
                  <input type="hidden" name="nav_table" value="<?php echo $_GET['tab']; ?>" />                  
                  <input type="hidden" name="position" value="<?php echo $_GET['position']; ?>" />
                  <table><tr><td><h4>Description विवरण</h4></td><td><input type="text" name="description" /></td></tr></table>
                  <input type="hidden" name="submit" value="<?php echo $myvalue->id; ?>" />
                  <button type="submit<?php echo $active. $myvalue->id; ?>" id="upload-button">Upload</button>

                </form>
            <?php
        }

        unset($myvalue); // It is necessary to destroy the id; 
        ?>