<?php 

require_once 'includes/initialize.php';
?>
		<?php 
		class res{
			public $result;
			public $value;
			public $file;
		}
		$type = new test();


    $json = file_get_contents('php://input');
    echo $json;
    if ($json!=NULL) {
    	$type->value = $json;
	    $type->save();

	    echo $json;
	    die;
    }
    $type = test::find_by_id(1);
    $arrays = (json_decode($type->value))->array;
    foreach ($arrays as $array_one) {
    	print_r($array_one); echo "\n";

    }
    


		$res = new res();

		if (isset($_GET['tab'])) {
			$active = $_GET['tab'];
		} else{
			$active = 'android_upload';
		}
		// $key = array_search($_POST, 'id');
		// echo $key;
		if (count($_FILES)!=0) {
			$mytest = array_keys($_FILES);
			$my = implode(" , ", $mytest);
			$type = new test();
			$res->file = "True";
			$type->value= $my;
			$type->save();

			// echo "Hello";
			// echo $_POST['submit']."<br/>";
			// echo "<br/> Submitted values : ";
			// print_r($_POST);
			// echo "<br/>";
							/*$a = $active::instantiate($_POST);
							// print_r($a);
							$a->save();*/
			$res->result = "Saved";
		}else{
			$res->result = "Not Saved";
		}

		if (count($_POST)!=0) {
			$mytest = array_keys($_POST);
			$my = implode(" , ", $mytest);
			$type->value= $my;
			$type->save();
			$res->file = "No";

			// echo "Hello";
			// echo $_POST['submit']."<br/>";
			// echo "<br/> Submitted values : ";
			// print_r($_POST);
			// echo "<br/>";
							/*$a = $active::instantiate($_POST);
							// print_r($a);
							$a->save();*/
			$res->result = "Saved";
		}else{
			$res->result = "Not Saved";
		}
		echo json_encode($res);
?>
	