<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

require_once(LIB_PATH.DS.'database.php');

class Bridge {
	
	protected static $table_name="bridge";
	public	$BridgeName,	$Length,	$Type,	$L_Bank,	$R_Bank,	$Heralu,	$VDC_sifarish,	$id, $state, $DCODE;
  protected static $db_fields = array('id', 'BridgeName', 'Length', 'Type', 'L_Bank', 'R_Bank', 'Heralu', 'VDC_sifarish', 'state', 'DCODE');
  protected static $db_fields_nepali = array('सम्सोधन गर्नुहोस्', 'पुलको नाम', 'लम्बाइ', 'किसिम', 'दायाँ किनारा', 'बायाँ किनारा', 'हेरालु', 'गा. वि. स', 'अवस्था', 'जिल्ला कोड');
	
  public static function nepali_name($field){
    return self::$db_fields_nepali[array_search($field, self::$db_fields)];
    // $nepali = self::$db_fields_nepali;
    // foreach (self::$db_fields as $value) {
    //   # code...
    //   $shifted_nepali = array_shift($nepali);
    //   if ($value ==$field) {
    //     return $shifted_nepali;
    //   }
    // }
  }


	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public static function find_null_field($field){
    $sql_statement_query = "SELECT * FROM ".self::$table_name." WHERE {$field} = \"NULL\" OR {$field} = ''";
    return self::find_by_sql($sql_statement_query);

  }

  public static function find_bridges($user_low_length=0,$user_high_length=1000,$user_bridge_name='',$user_VDC)  {	

  	$sql_statement_query = "SELECT * FROM ".self::$table_name." WHERE ". 
  		" (Length > {$user_low_length} AND Length < {$user_high_length})";
    if ($user_low_length == 0){
      // $sql_statement_query = $sql_statement_query . " OR (Length = 'NULL')";
    }
  	if ($user_bridge_name != '') {
		$custom_sql = "SELECT BridgeName FROM ".self::$table_name." WHERE BridgeName LIKE N'%{$user_bridge_name}%' "; 
		// for unicode "LIKE N 'pattern' "
		// otherwise "LIKE 'pattern' " works

		$sql_statement_query = $sql_statement_query. " AND BridgeName IN (" .$custom_sql. ")";
  		// if ($user_VDC != 'ALL'){
  		// 	$custom_sql = "SELECT VDC_sifarish FROM ".self::$table_name." WHERE VDC_sifarish LIKE N'%{$user_VDC}%' ";
  		// 	$sql_statement_query = $sql_statement_query . " AND VDC_sifarish IN (" .$custom_sql. ")";
  		// }			
  		// $sql_statement_query = $sql_statement_query ." ORDER BY Length DESC";
  						
  						
  		// $result_array =  self::find_by_sql( $sql_statement_query);
  		
  		// return !empty($result_array) ? $result_array : false;

  	} 
  	if ($user_VDC != 'all'){
  			$custom_sql = "SELECT VDC_sifarish FROM ".self::$table_name." WHERE VDC_sifarish LIKE N'%{$user_VDC}%' ";
  			$sql_statement_query = $sql_statement_query . " AND VDC_sifarish IN (" .$custom_sql. ")";
  		}
  	$sql_statement_query = $sql_statement_query . " ORDER BY Length DESC";
  	// echo $sql_statement_query;
  	$result_array = self::find_by_sql($sql_statement_query);
  	// print_r($result_array);
  	return !empty($result_array) ? $result_array : false;
  }

  public static function find_banks(){
  	$result_array = self::find_by_sql("SELECT DISTINCT VDC_sifarish FROM ".self::$table_name." WHERE 1" );
  	return !empty($result_array) ? $result_array : false;
  }
  public static function find_by_sql($sql="") {
    global $database;
    // mysql_query ("set character_set_results='utf8'");
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }

	public static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // get_object_vars returns an associative array with all attributes 
	  // (incl. private ones!) as the keys and their current values as the value
	  $object_vars = get_object_vars($this);
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $object_vars);
	}

    protected function attributes() { 
    // return an array of attribute names and their values
    $attributes = array();
    foreach(self::$db_fields as $field) {
      if(property_exists($this, $field)) {
        $attributes[$field] = $this->$field;
      }
    }
    return $attributes;
  }

  public static function count_all() {
    global $database;
    $sql = "SELECT COUNT(*) FROM ".self::$table_name;
    $result_set = $database->query($sql);
    $row = $database->fetch_array($result_set);
    return array_shift($row);
  }

  protected function sanitized_attributes() {
    global $database;
    $clean_attributes = array();
    // sanitize the values before submitting
    // Note: does not alter the actual value of each attribute
    foreach($this->attributes() as $key => $value){
      $clean_attributes[$key] = $database->escape_value($value);
    }
    return $clean_attributes;
  }
  
  public function save() {
    // A new record won't have an id yet.
    return isset($this->id) ? $this->update() : $this->create() ;
  }
  
  public function create() {
    global $database;
    
    // Don't forget your SQL syntax and good habits:
    // - INSERT INTO table (key, key) VALUES ('value', 'value')
    // - single-quotes around all values
    // - escape all values to prevent SQL injection
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO ".self::$table_name." (";
    $sql .= join(", ", array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', N'", array_values($attributes));
    $sql .= "')";
    // mysql_query ("set character_set_results='utf8'");
    if($database->query($sql)) {
      $this->id = $database->insert_id();
      return true;
    } else {
      return false;
    }
  }

  public function update() {
    global $database;
    
    // Don't forget your SQL syntax and good habits:
    // - UPDATE table SET key='value', key='value' WHERE condition
    // - single-quotes around all values
    // - escape all values to prevent SQL injection
    $attributes = $this->sanitized_attributes();
    $attribute_pairs = array();
    foreach($attributes as $key => $value) {
      if (!is_numeric($value)){
        $attribute_pairs[] = "{$key}=N'{$value}'";     
        continue;   
      }

      $attribute_pairs[] = "{$key}='{$value}'";
    }
    $sql = "UPDATE ".self::$table_name." SET ";
    $sql .= join(", ", $attribute_pairs);
    $sql .= " WHERE id=". $database->escape_value($this->id);
    // mysql_query ("set character_set_results='utf8'");
    // echo $sql;
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

  public function delete() {
    global $database;
    // mysql_query ("set character_set_results='utf8'");
    // Don't forget your SQL syntax and good habits:
    // - DELETE FROM table WHERE condition LIMIT 1
    // - escape all values to prevent SQL injection
    // - use LIMIT 1
    $sql = "DELETE FROM ".self::$table_name;
    $sql .= " WHERE id=". $database->escape_value($this->id);
    $sql .= " LIMIT 1";
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  
    // NB: After deleting, the instance of User still 
    // exists, even though the database entry does not.
    // This can be useful, as in:
    //   echo $user->first_name . " was deleted";
    // but, for example, we can't call $user->update() 
    // after calling $user->delete().
  }
  
  //My own function is here
  //1. Return object to array
  public function arraycreate(){
    foreach ($db_fields as $oneField) {
      $record[$oneField] = $this->$oneField;
    }
    return $record;
  }


}

?>