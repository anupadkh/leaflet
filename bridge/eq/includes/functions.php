<?php

  function mysql_prep( $value ) {
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
    if( $new_enough_php ) { // PHP v4.3.0 or higher
      // undo any magic quote effects so mysql_real_escape_string can do the work
      if( $magic_quotes_active ) { $value = stripslashes( $value ); }
      $value = mysql_real_escape_string( $value );
    } else { // before PHP v4.3.0
      // if magic quotes aren't already on then add slashes manually
      if( !$magic_quotes_active ) { $value = addslashes( $value ); }
      // if magic quotes are active, then the slashes already exist
    }
    return $value;
  }

function strip_zeros_from_date( $marked_string="" ) {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_string);
  // then remove any remaining marks
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function non_admin_redirect(){
    global $session;
    if (!$session->is_logged_in()){
      $_SESSION['page'] = 'admin/admin.php';
      redirect_to(DS.SITE_ROOT.DS.'login.php');
    }
}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function __autoload($class_name) {
	$class_name = strtolower($class_name);
  $path = LIB_PATH.DS."{$class_name}.php";
  if(file_exists($path)) {
    require_once($path);
  } else {
		die("The file {$class_name}.php could not be found.");
	}
}

function include_layout_template($template="") {
	include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}

function log_action($action, $message="") {
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}

function edit_code($edit_id, $selected){
  $output = '';
  // If no Heralu exists
  if (is_numeric($edit_id)) {
    foreach ($selected as $key => $value) {
      if ($key=="id") {
        $output .= "<input name={$key} type=\"hidden\"  value = \"{$value}\"> ";
        continue;
      }
      if ($key == "Heralu"){
        if (($value == NULL) || ($value == 0)) {
                $vars = get_object_vars(new Heralu);
              } else {
                $vars = Heralu::find_by_id($value);
                $output.="<input name={$key} type=\"hidden\"  value = \"{$value}\"> ";
              }
        
        foreach ($vars as $var1 => $value) {
          if ($var1 == 'id') {
            $output .= "<h2> Heralu Information </h2>";
            $output .= "<input type=\"hidden\" name=\"heralu_id\" value=\"{$value}\"";
            continue;
          }
          elseif ($var1 == 'active') {
            $output .= "<p style=\"padding-left:30px;\">". Heralu::nepali_name($var1).": ". 
                        "<select name=\"heralu_{$var1}\">";
                        $option_nepali = array('निस्कृय', 'कार्यरत');
                        for ($i=0; $i < 2; $i++) { 
                          $output .= "<option value={$i}";
                          if ($i==$value){
                            $output .= " selected >".$option_nepali[$i]."</option>";
                          }
                          $output .= ">".$option_nepali[$i]."</option>";
                        }
              $output .= "</select></p>";
                        continue;
          } else{
            $output .= "<p style=\"padding-left:30px;\">". Heralu::nepali_name($var1).": "."<input name=\"heralu_{$var1}\" type=\"text\" value = \"{$value}\" style=\"height:20px; \"> "."</p>";
          }
        }
        continue;
      }
      $output .= "<p>".Bridge::nepali_name($key). ": "."<input name={$key} type=\"text\" value = \"{$value}\" style=\"height:20px;\"> "."</p>";
      
    } 
    $output .= print_coordinates_form($selected->id);
  } else{
    $selected = Bridge::find_by_id(1);
    foreach ($selected as $key => $value) {
      if ($key=="id") {
        $output .= "<input name={$key} type=\"hidden\"  value = \"NULL\"> ";
        continue;

      }
      if ($key=="Heralu"){
        $vars = get_object_vars(new Heralu);
        
        foreach ($vars as $var1 => $value) {
          if ($var1 == 'id') {
            $output .= "<h2> Heralu Information </h2>";
            continue;
          }
          if ($var1 == 'active') {
            $output .= "<p style=\"padding-left:30px;\">". Heralu::nepali_name($var1).": ". 
                        "<select name=\"heralu_{$var1}\">".  
                        "<option value=1>कार्यरत</option><option value=0>निस्कृय</option></p>";
            continue;
          }
          $output .= "<p style=\"padding-left:30px;\">". Heralu::nepali_name($var1).": "."<input name=\"heralu_{$var1}\" type=\"text\" value = \"\" style=\"height:20px; \"> "."</p>";
        }
        continue;
      }
      $output .= "<p>".Bridge::nepali_name($key).": "."<input name={$key} type=\"text\" value = \"\" style=\"height:20px;\"> "."</p>";
    } 
    $output .= print_coordinates_form("new");
  }
// Adding coordinates to the coordinates database
return $output;
  
}

function print_coordinates_form($id)
{
  $output = "<h4> Enter the Left and Right Coordinates </h4>";
  if ($id == "new") {
    $obj1 = new Coordinates;
    $left_right = array(0,1);
    foreach ($left_right as $point) {
      if ($point == 0){ 
        $findme = "coordinates_l_"; // if the point is a left bank coordinate
        $output .= "<h4> (बायाँ किनारा) Left Coordinates: </h4>";
        } else{
          $findme = "coordinates_r_"; // if the point is a right bank coordinate
          $output .= "<h4> (दायाँ किनारा) Right Coordinates: </h4>";
        }

        foreach ($obj1 as $key => $value) {
          if (($key=="id") || ($key=="left_right") || ($key == "bridge_id")){
            continue;
          }
          $output .= "<p>".Coordinates::nepali_name($key)." : <input name=\"{$findme}{$key}\" type=\"text\" value=\"{$value}\"></p>";
        }
    }
  } else{
    $all = Coordinates::find_by_bridge_id($id);
    if ($all == false) {
      return print_coordinates_form("new");
    }
    foreach ($all as $point) {
      if ($point->left_right == 0){ 
        $findme = "coordinates_l_"; // if the point is a left bank coordinate
        $output .= "<h4> (किनारा) Left Coordinates: </h4>";
      } else{
        $findme = "coordinates_r_"; // if the point is a right bank coordinate
        $output .= "<h4> (बायाँ किनारा) Right Coordinates: </h4>";
      }

        foreach ($point as $key => $value) {
          if (($key=="left_right") || ($key == "bridge_id")){
            continue;
          }
          if (($key=="id")) {
            $output .= "<input type=\"hidden\" name=\"{$findme}{$key}\" value={$value}>";
            continue;
          }
          $output .= "<p>".Coordinates::nepali_name($key)." : <input name=\"{$findme}{$key}\" type=\"text\" value=\"{$value}\"></p>";
        }
      
    }
  }
  return $output;
}



?>