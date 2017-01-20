<?php 
require_once 'includes/initialize.php';
$page_title = "कर्मचारी विवरण";
$active_id = $_GET['position'];
require_once 'header.php';

require_once 'navbar.php';
require_once 'sidebar.php'; 

?>      
<section id="main-content">
          <section class="wrapper">
          	<div class="row">
                  <div class="col-lg-9">
          <?php 
          if ($_GET['type']=='new') {
          	if (($_GET['tab'] == '')) {
              $_GET['tab']='person';
            };
          	require_once 'myform.php';
          }else{
            if (isset($_POST['table'])) {
              $active = $_POST['table'];
              $a = $active::instantiate($_POST);
              // print_r($a);
              $a->save();
              $_GET['id'] = $a->id;

            }
          	$_GET['tab']='person';
          ?>

          	 <iframe src="newlist.php?tab=<?php echo $_GET['tab']."&position=" .$_GET['position']; ?>" height="600" width="1100"></iframe> 
          <?php
      		}
           ?>
           <?php 
           if ($_GET['id']!='') {
           ?>
           <! -- MODALS -->
              <div class="showback">
                <h4><i class="fa fa-angle-right"></i> थप जानकारी</h4>
            <!-- Button trigger modal -->
            <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#address">
              Address
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                  </div>
                  <div class="modal-body">
                    Hi there, I am a Modal Example for Dashgum Admin Panel.
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
            ?>
           			</div>
           	</div>
          </section>
</section>

<?php require_once 'footer.php'; ?>