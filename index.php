<?php 
if (!isset($_GET['position'])) {
    $_GET['position'] = 1;
}
require_once 'formheader.php';

function myfilter($table_one)
{
  global $report1;
  // print_r($report1);
  if ($report1->tablename == $table_one->id) {
    return $table_one;
  }
}

; ?>      

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
     
              <div class="row">
                  <div class="col-lg-9 main-chart">
                  <script type="text/javascript">
                  </script>
                  <?php 
                  $all_reports = reports::find_all();
                  $all_tables = mytables::find_all();
                  // print_r($all_tables);
                   ?>
                  	<div class="row mtbox">
                    <?php 
                    $r_count = count($all_reports);
                    foreach ($all_reports as $report1) {
                    ?><div class="col-md-2 col-sm-2 col-md-offset-1 box0">
                			<div class="box1">
          			  			<span class="<?php echo $report1->linecons; ?>"></span>
          			  			<h3><?php 
                          $selected_table = array_shift(array_filter($all_tables, "myfilter"));
                          echo ($db->countentries($selected_table->tablename))['entries'];
                          // echo " " . $selected_table->header;
                        ?></h3>
                			</div>
					  			<p><?php echo $report1->description; ?></p>
                  		</div>
                    <?php 
                    }
                     ?></div><!-- /row mt -->	
                  
                      
                      
                      
                  </div>
                   <div class="col-lg-3 ds">
                  <!-- /col-lg-3 -->
                  <!-- CALENDAR-->
                        <div id="calendar" class="mb">
                            <div class="panel green-panel no-margin">
                                <div class="panel-body">
                                    <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                                        <div class="arrow"></div>
                                        <h3 class="popover-title" style="disadding: none;"></h3>
                                        <div id="date-popover-content" class="popover-content"></div>
                                    </div>
                                    <div id="my-calendar"></div>
                                </div>
                            </div>
                        </div><!-- / calendar -->
                      
                  </div><!-- /col-lg-3 -->
              </div><! --/row -->
          </section>
      </section>
    <!--main content end-->
    
<?php require_once 'footer.php'; ?>