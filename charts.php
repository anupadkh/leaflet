<?php require_once 'formheader.php'; 
$gritter = false;?>
      <div class="col-lg-12">
        <?php include 'raw_form.php'; ?>

        <?php 
        $active = $_GET['tab'];

        if (isset($_GET['id'])) { // Load options for only valid main ids.
        
        $subtables = mytables::find_table($active);
        $op_header = explode(",",$subtables->extra_name);
        $mytables = explode(",", $subtables->subtables);
        // echo count($mytables);
        $mybuttons = '';
        for ($m=0; $m < count($mytables); $m++) { 
          if ($mytables[$m]=='') {
            break;
          }
            $mybuttons .= "<button class=\"btn btn-success btn-default\" data-toggle=\"modal\" data-target=\"#mytab{$m}\">
                          {$op_header[$m]}
                        </button>&nbsp;&nbsp;&nbsp;&nbsp;";
            
        
            ?>
            <div class="modal fade" id="mytab<?php echo $m; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $m; ?>" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel<?php echo $m; ?>"><?php echo $op_header[$m]; ?></h4>
                              </div>
                              <div class="modal-body">
                                <?php 
                                    $multiple_index = $m;
                                    $active = $mytables[$m];
                                    $p_id = $_GET['id'];
                                    $parent = $_GET['tab'];
                                    include 'raw_form.php'; 

                                ?>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                              </div>
                            </div>
                          </div>
                        </div>                      
                    </div><!-- /showback -->
            <?php
        }

        
        echo $mybuttons;
        
        
} // Valid Ids check True ends
        ?>
      </div>
        </section>
        </section>

    <?php require_once 'footer.php'; ?>