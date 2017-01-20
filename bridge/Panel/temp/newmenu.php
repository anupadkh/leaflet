<?php 
require_once 'includes/initialize.php';
$page_title = "मेनु व्यवस्थापन";
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
          	$_GET['tab']='mymenu';
          	require_once 'myform.php';
          }else{
            if (isset($_POST['table'])) {
              $active = $_POST['table'];
              $a = $active::instantiate($_POST);
              // print_r($a);
              $a->save();

            }
          	$_GET['tab']='mymenu';
          ?>

          	 <iframe src="newlist.php?tab=mymenu&position=<?php echo $_GET['position']; ?>" height="600" width="1100"></iframe> ;
          <?php
      		}
           ?>
           			</div>
           	</div>
          </section>
</section>

<?php require_once 'footer.php'; ?>