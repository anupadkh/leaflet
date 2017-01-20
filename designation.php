<?php 
require_once 'includes/initialize.php';
$page_title = "पद सुची";
$active_id = $_GET['position'];
$header = "designation.php?type=new";

require_once 'header.php';

require_once 'navbar.php';
require_once 'sidebar.php'; 

?>      
<section id="main-content">
          <section class="wrapper">
          	<div class="row">
                  <div class="col-lg-9">
          <?php 
           if (isset($_POST['table'])) {
              $active = $_POST['table'];
              $a = $active::instantiate($_POST);
              // print_r($a);
              $a->save();

            }
          if ($_GET['type']=='new') {
          	$_GET['tab']='designation';
          	require_once 'myform.php';
          }else{
           
          	// $_GET['tab']='designation';
          ?>

          	 <iframe src="newlist.php?tab=<?php echo $_GET['tab']."&position=" .$_GET['position']; ?>" height="600" width="1100"></iframe> 
          <?php
      		}
           ?>
           			</div>
           	</div>
          </section>
</section>

<?php require_once 'footer.php'; ?>