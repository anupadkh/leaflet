<?php 
require_once 'includes/initialize.php';
$page_title = "अन्य सेटअप गर्नुहोस्";
$active_id = $_GET['position'];
require_once 'header.php';

require_once 'navbar.php';
require_once 'sidebar.php'; 
$gritter = false;
function myfilter($table_one)
{
  global $t1;
  // print_r($report1);
  if ($t1->tablename == $table_one->id) {
    return $table_one;
  }
}

?>      
<section id="main-content">
          <section class="wrapper">
          	<div class="row">
                  <div class="col-lg-12">
                              <?php 
                      if ($_GET['type']=='new') {
                        if (($_GET['tab'] == '')) {
                          $_GET['tab']=$_GET['item'];
                        };
                        require_once 'myform.php';
                      }else{

                        if (isset($_POST['table'])) {
                          $active = $_POST['table'];

                          $a = $active::instantiate($_POST);
                          // print_r($a);
                          $a->save();

                        } elseif($_GET['item'] != '') { // if sub table is found
                          $_GET['tab']=$_GET['item'];
                          $active = $_GET['item'];
                        
                        
                      ?>

                         <iframe src="newlist.php?tab=<?php echo $_GET['tab']."&position=" .$_GET['position']; ?>" height="600" width="1100"></iframe>  

                      <?php
                        }
                        else{
                          // $_GET['tab']="others";
                        }
                      }
                       ?>

                  <h2>अन्य सेटअपमा यहाँलाई स्वागत छ । </h2>

                  <?php 
                  $setups = setuptables::find_all();
                  $all_tables = mytables::find_all();
                  $other_tables = array();
                  foreach ($setups as $t1) {
                    $selected_table = (array_filter($all_tables, "myfilter")); 
                    // t1 id is passed in the function through global variable
                    $table = array_shift($selected_table);
                    // print_r($table);
                    array_push($other_tables, array($table->header, $table->tablename, $t1->nepl_name, $t1->icon, $t1->panel_class));

                  }
                  // $other_tables = array( array('Religion','religion', 'धर्म', 'fa-sun-o') , array('Caste','caste', 'जाती', 'fa-sun-o'),array('Nationality','nation', 'राष्ट्रियता', 'fa-sun-o') );
                  $i=0;
                  echo "<div class=\"row\">"; // First Panel Row
                  foreach ($other_tables as $table1) {
                    if ((($i+1) % 4) == 0) {
                      echo "<div class=\"row\">";
                    }
                  
                   ?>
                  
                   
                   <!-- WEATHER-3 PANEL -->
                      <div class="col-lg-3 col-md-3 col-sm-3 mb">
                        <div class="weather-3 pn centered">
                          <i class="fa <?php echo $table1[3]; ?>"></i>
                          <h1><?php echo $table1[2]; ?></h1>
                          <div class="info">
                            <div class="row">
                                <h3 class="centered"><?php echo $table1[0]; ?></h3>
                              <div class="col-sm-6 col-xs-6">
                                <p class="goleft"><a href="others.php?position=<?php

                                 echo $_GET['position'] . "&tab=". $table1[1] . "&item=".$table1[1] ;

                                 ?>"><i class="fa fa-tint"></i> सबै हेर्नुहोस्</a></p>
                              </div>
                              <div class="col-sm-6 col-xs-6">
                                <p class="goright"><a href="others.php?position=<?php

                                 echo $_GET['position'] . "&tab=". $_GET['tab'] . "&item=". $table1[1] . "&type=new" ;

                                 ?>"><i class="fa fa-flag"></i> नयाँ थप्नुहोस्</a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><! --/col-md-4 -->

                  <?php
                  if ((($i+1) % 4)==0) {
                      echo "</div>"; // Panel Row Ends
                    } 
                  $i++;
                }
                echo "</div>"; // First Panel Row Ends
                  ?>


           			</div>
           	</div>
          </section>
</section>

<?php require_once 'footer.php'; ?>