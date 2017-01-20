<?php //LBPIS/forms/karmachari.php
$page_title = "कर्मचारीको विवरण";
$active_id = 3;
require_once '../includes/initialize.php';
require_once '../header.php';
require_once '../navbar.php';
require_once '../sidebar.php'; ?>      
<section id="main-content">
  <section class="wrapper">

	<div role="tabpanel" class="col-lg-9">
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active">
				<a href="#home" aria-controls="home" role="tab">Profile</a>
			</li>
			<li role="presentation">
				<a href="#messages" aria-controls="messages" role="tab">Messages</a>
			</li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="home">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
			</div>
			<div role="tabpanel" class="tab-pane" id="home">Nothing is here</div>
		</div>
	</div>
  </section>
 </section>
<?php require_once 'footer.php'; ?>

 ?>