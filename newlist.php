<?php 
		require_once 'includes/initialize.php';
		if (isset($_GET['tab'])) {
			$active = $_GET['tab'];
		} else{
			$active = 'person';
		}
    if ($rec_insert == 1) {
      $records = $active::find_by_sql($merosql);
    }else{
        $records = $active::find_all();
      }
		?>
<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css">
  <style type="text/css" class="init">
  
  </style>


  <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.3.js">
  </script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.1/js/buttons.flash.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js">
  </script>
  <script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js">
  </script>
  <script type="text/javascript" class="init">
  


$(document).ready(function() {
  $('#example').DataTable( {
    dom: 'Bfrtip',
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ]
  } );
} );



  </script>
</head>
<table id="example" class="display nowrap" cellspacing="0" width="100%">
  <?php 
  $i = 1;
		$output =  "<tr>";
    $output .= "<th>S.No.</th><th></th>";
		$hidden = array();
		$visible = array();
    $external = array();
    $externalkey = array();
    $customkey = array();
    $customoptions = array();
		$all_cols = fields::find_by_sql("SELECT * FROM fields WHERE tablename='{$active}'"); 
  			foreach ($all_cols as $col1){
	  			// Load external Table Data
          if ($col1->descrip != '') {
            $constraints = explode(",",$col1->descrip);
            foreach ($constraints as $const1){
              $m1 = explode("=",$const1);
              $conditions[($m1[0])] = $m1[1];
            }

            $table = $conditions['table'];
            $valuekey = $conditions['nepl'];
            array_push($external, array($table, $valuekey));
            array_push($externalkey, $col1->field);

          }
          elseif ($col1->mykeys != '') {
            $constraints = explode(",",$col1->mykeys);
            $valuesall = explode(",",$col1->myvalues);
            
            array_push($customkey, $col1->field);

            array_push($customoptions,$valuesall,$constraints);            

          }
          // Skip hidden values
	  			if ($col1->type == "hidden") {
	  				array_push($hidden, $col1->field);
	  				continue;
	  			}
	  			array_push($visible, $col1->field);
	  			$output .= "<th>";
	  			$output .= $col1->eng_name;
	  			$output .="</th>";
	  		}
	  		$output .= "</tr>";

	  		echo "<thead>".$output."</thead>";
        // print_r($customkey); echo "<br/>";print_r($customoptions);
        // Check if the Conditions are printed properly
        // echo "<tr>";print_r($conditions);echo "</tr>";
        echo "<tfoot>".$output."</tfoot>";
        echo "<tbody";
        $c = 0;
        foreach ($records as $rec1) {
        	echo "<tr>";
          echo "<td>".(++$c)."</td>";
          echo "<td>"."<a href=\"personform.php";
          ?>?tab=<?php echo $active;
            echo "&id=".$rec1->id."&position=".$_GET['position'];
          echo "\"target=\"_parent\">Edit"."</a>&nbsp;&nbsp;" ;
          echo "<a href=\"delete.php?tab=".$active."&id=".$rec1->id."&next=". $_GET['position']. "\" target=\"_parent\">Delete</a>";

          echo "</td>";
          $i=0;
        	foreach ($rec1 as $key => $value) {
        		if(in_array($key, $hidden)){
        			continue;
        		}
            if ($key == $externalkey[$i] && ($value != NULL )) {
              echo "<td>";
               $table = ($external[$i][0]);
               // print_r($rec1);
              
            $iditem = ($external[$i][1]) ;
            $item = ($table::find_by_id($value));
            // print_r($item);
            $newvalue = $item->$iditem;
            echo $newvalue;
                echo "</td>";
              /*$table = $external[$i][0]::find_by_id($value);
              echo "<td class=\"{$key}\">". $table->($externalkey[$i]) . "</td>";
              $i++;*/
              $i++;
              continue;
            }
           if (in_array($key, $customkey)) {
            $j = array_search($key, $customkey);
            // echo "Key location =" .$j."<br/>";

            $search_index = array_search($value, $customoptions[($j * 2 + 1)]); // for first customkey, the value of key is in Array index 1 and the populated values in array index 0. 2 is multiplier for finding the current key fields.
            echo "<td class=\"{$key}\">". ($customoptions[$j*2][$search_index*2 +1]) ;
                                                                                          /*print_r($customoptions[($j * 2 + 1)]);
                                                                                          echo "Search Index = ". $search_index;
                                                                                          echo "Value =". $value;
                                                                                          print_r($customoptions[$j*2]);*/
            echo "</td>"; // search index * 2+1 is for loading nepali values.
            // customoptions 0 has populated values
            // echo "<td class=\"{$key}\">".$customoptions[$j][1][$search_index] ."index = ".($search_index+1) . "</td>";
            continue;            

          }

        		echo "<td class=\"{$key}\">".$value . "</td>";
        	}
        	echo "</tr>";
        }
       echo "</tbody>";

// print_r($visible);
// echo "<br/>";
// echo join("', '", array_values($visible));
// print_r($hidden);
   ?>
  
    <!-- IMPORTANT, class="list" have to be at tbody -->
  </table>
</html>