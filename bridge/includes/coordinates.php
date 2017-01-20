<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

require_once(LIB_PATH.DS.'database.php');

class Coordinates {
	
	protected static $table_name="coordinates";
	public	$id, $bridge_id, $left_right, $latitude, $longitude;
  protected static $db_fields = array('id', 'bridge_id', 'left_right', 'latitude', 'longitude');
  protected static $db_fields_nepali = array( 'id', 'bridge_id', 'left_right', 'Latitude: (देशान्तर)', 'Longitude (दक्षिणान्त्र)');

  public static function instantiate_all_coordinates($record, $bridge_id){
    $object2 = self::instantiate_coordinates($record, '_r_');
    $object2->left_right = 1;
    $object2->bridge_id = $bridge_id;
    $object1 = self::instantiate_coordinates($record, '_l_');
    $object1->left_right = 0;
    $object1->bridge_id = $bridge_id;
    $all = array($object1, $object2);
    return $all;
  }

  public static function instantiate_coordinates($record, $findme) {
    $object = new self;
    foreach($record as $attribute=>$value){
      $mystring = $attribute;
      $pos = strpos($attribute, $findme);
      $string_reqd = substr($mystring, $pos+1+2);
      if (!is_string($string_reqd)) {
        continue;
      }
      if($object->has_attribute($string_reqd)) {
        $object->$string_reqd = $value;
      }
    }
    return $object;
  }

  public static function find_by_bridge_id($id){
    return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE bridge_id='{$id}'");
  }

  public static function nepali_name($field){
    return self::$db_fields_nepali[array_search($field, self::$db_fields)];
  }

	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
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
    return isset($this->id) ? (is_null($this->id) ? $this->create() : $this->update()) : $this->create() ;
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
    $sql .= join("', '", array_values($attributes));
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