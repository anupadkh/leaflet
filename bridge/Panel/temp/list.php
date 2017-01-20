<?php 
		require_once 'includes/initialize.php';
		if (isset($_GET['tab'])) {
			$active = $_GET['tab'];
		} else{
			$active = 'person';
		}
		$records = $active::find_all();
		?>
		<style type="text/css">
			.list {
  font-family:sans-serif;
}
td {
  padding:10px; 
  border:solid 1px #eee;
}

input {
  border:solid 1px #ccc;
  border-radius: 5px;
  padding:7px 14px;
  margin-bottom:10px
}
input:focus {
  outline:none;
  border-color:#aaa;
}
.sort {
  padding:8px 30px;
  border-radius: 6px;
  border:none;
  display:inline-block;
  color:#fff;
  text-decoration: none;
  background-color: #28a8e0;
  height:30px;
}
.sort:hover {
  text-decoration: none;
  background-color:#1b8aba;
}
.sort:focus {
  outline:none;
}
.sort:after {
  display:inline-block;
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-bottom: 5px solid transparent;
  content:"";
  position: relative;
  top:-10px;
  right:-5px;
}
.sort.asc:after {
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-top: 5px solid #fff;
  content:"";
  position: relative;
  top:4px;
  right:-5px;
}
.sort.desc:after {
  width: 0;
  height: 0;
  border-left: 5px solid transparent;
  border-right: 5px solid transparent;
  border-bottom: 5px solid #fff;
  content:"";
  position: relative;
  top:-4px;
  right:-5px;
}
		</style>
<div id="users">
  <input class="search" placeholder="Search" />
  <table>
  <?php 
  $i = 1;
		$output =  "<tr>";
		$hidden = array();
		$visible = array();
		$all_cols = fields::find_by_sql("SELECT * FROM fields WHERE tablename='{$active}'"); 
  			foreach ($all_cols as $col1){
	  			
	  			if ($col1->type == "hidden") {
	  				array_push($hidden, $col1->field);
	  				continue;
	  			}
	  			array_push($visible, $col1->field);
	  			$output .= "<td>";
	  			$output .= "<button class=\"sort\" data-sort=\"{$col1->field}\">". $col1->eng_name ."</button>";
	  			$output .="</td>";
	  		}
	  		$output .= "</tr>";
	  		echo $output;
echo "<tbody class=\"list\">";
  foreach ($records as $rec1) {
  	echo "<tr>";
  	foreach ($rec1 as $key => $value) {
  		if(in_array($key, $hidden)){
  			continue;
  		}
  		echo "<td class=\"{$key}\">".$value . "</td>";
  	}
  	echo "<tr/>";
  }
 echo "</tbody>";

// print_r($visible);
// echo "<br/>";
// echo join("', '", array_values($visible));
// print_r($hidden);
   ?>
  
    <!-- IMPORTANT, class="list" have to be at tbody -->
  </table>

</div>

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.2.0/list.min.js"></script>
<script type="text/javascript">
	var options = {
  valueNames: [ '<?php echo join("', '", array_values($visible)); ?>']
};

var userList = new List('users', options);
</script>