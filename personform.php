<?php require_once 'formheader.php'; 
$gritter = false;?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
      <?php $table_is = mytables::find_table($active);
      echo $table_is->header; ?>
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?php echo $table_is->header; ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">


      <div class="col-lg-12">
        <?php include 'raw_form.php'; ?>

        <?php 
        $active = $_GET['tab'];

        if (isset($_GET['id'])) { // Load options for only valid main ids.
        
        $subtables = mytables::find_table($active);
        $op_header = explode(",",$subtables->extra_name);
        $mytables = explode(",", $subtables->subtables);
        $formtype = explode(",", $subtables->form_type);

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
                                    $formstyle = $formtype[$m];
                                    include 'raw_form.php'; 

                                ?>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
      </div>
        </section>
        </div>
        <script type="text/javascript">
          <?php if (isset($_GET['deleted_status'])) {
              if ($_GET['deleted_status'] == 1) {
                echo "alert('The file has been Deleted');";
              }else{
                echo "alert('The file could not been Deleted');";
              }
          } ?>
        </script>

<?php require_once 'footer.php'; ?>