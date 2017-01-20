		<?php 
		require_once 'includes/initialize.php';
		if ($_SESSION['user_id'] == NULL) {
			redirect_to('login.php');
		}
        // print_r($_POST);

        // get arguments = tab, next, id, position
        // globals required $active, $active_id 
		if (isset($_GET['tab'])) {
			$active = $_GET['tab'];
		} else{
			$active = 'person';
		}
		if (isset($_POST['table'])) {
			$a = $active::instantiate($_POST);
			$a->save();
            echo "<h4> Saved </h4>";
			if(isset($_GET['next'])){
				$active = $_GET['next'];
				redirect_to("personform.php?tab={$active}&savedid={$a->id}");
			} else{
				$_GET['id'] = $a->id;
			}
            redirect_to('index.php?status=saved');
			
		}
        // $active_id = 4; // it is used to load current menu position
        $active_id = $_GET['position'];
        require_once 'header.php';
        require_once 'navbar.php';
        require_once 'sidebar.php';

		// print_r($_SERVER);
        // $_SERVER['HTTP_HOST'].
        $active = $_GET['tab'];

		?>

	   <section id="main-content">
          <section class="wrapper">
            <div class="row">
                  
		