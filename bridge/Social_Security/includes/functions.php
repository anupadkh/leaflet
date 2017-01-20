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

function edit_code($edit_id, $vdc_id){
  $type = Social::find_all();
    $output = "";
    foreach ($type as $one_type) {
      if ($edit_id == "new"){
        $person = new Number;
        $female_person = new Number;
      } else{
        $person = Number::find_by_type_vdc_id($one_type->id, $vdc_id, 0);
        $female_person = Number::find_by_type_vdc_id($one_type->id, $vdc_id, 1);
      }
      $output .= "<h1>".$one_type->nepali."</h1>";
      
      $output .= "<table style=\"width:100%\"> ";
      $output .= "<th>विवरण</th><th>पुरुष</th><th>महिला</th>";
      if ($one_type->id == 3) {
        continue;
      }
      foreach ($person as $key => $value) {
        if ($key == 'type' || $key == 'male_female') {
          continue;
        }

        $output .= "<tr class=\"" . $one_type->name . " ". $key."\">";
        if ($key != 'id' && $key != 'vdc' ){
              $output .= "<td>". Number::nepali_name($key) . "</td>";
            }
        for ($i=0; $i < 2; $i++) { // for male or female
          if ($i==1) {
            $value = $female_person->$key;
          }
                if ($key == 'id') {
                    $output .= "<input type=\"hidden\" name = \"". $one_type->id . "_{$i}_{$key}\" value=\"" . $value ."\"/>" ;
                    continue;
                  }
                if ($key == 'vdc') {
                    $output .= "<input type=\"hidden\" name = \"". $one_type->id . "_{$i}_{$key}\" value=\"" . $vdc_id ."\"/>" ;
                    continue;
                  }
                $output .= "<td>"."<input name = \"". $one_type->id . "_{$i}_{$key}\" type=\"number\" value=\"{$value}\"/>" 
                      . "</td>" ;
                
        }
        $output .= "</tr>";
      }
      
      $output .= "</table>";
    }
  return $output;
}



?>