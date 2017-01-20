<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

require_once(LIB_PATH.DS.'database.php');

class Number {
	
	protected static $table_name="number";
	public	$id, $eldest_dalit, $eldest_other, $single, $divorced, $janjati, 
          $handicapped_full, $handicapped_partial, $dalit_children, $type, $vdc, 
          $male_female, $user;
  protected static $db_fields = array('id', 'eldest_dalit', 'eldest_other', 'single', 'divorced', 'janjati', 
              'handicapped_full', 'handicapped_partial', 'dalit_children', 'type', 'vdc',
              'male_female', 'user');
  protected static $db_fields_nepali = array('क्र.म. सं.', 'जेष्ठ दलित', 'जेष्ठ अन्य', 'एकल महिला', 'विधवा महिला', 'लोपन्मुख आदिवासी जनजाती', 'पूर्ण अशक्त, अपाङ्गता भएका', 'आंशिक अपाङ्गता भएका', 'दलित बालबालिका','', 'गा.वि.स',
    'पुरुष । महिला', 'प्रयोग कर्ता');
	
  public static function instantiate_post_values($post, $num)
  {
    $object_male = new self;
    $object_female = new self;
    $object_male->type = $num;
    $object_female->type = $num;
    $object_male->male_female = 0;
    $object_female->male_female = 1;
    $findme   = $num . '_';
    foreach($post as $attribute=>$value){
      $mystring = $attribute;
      $pos = strpos($attribute, $findme);

      /*
      $true_false = ($pos === 0) ? "True" : "False" ;
        echo "<br/>True false = ".$true_false. "<br/>";
      */
      if ($pos !== 0){
        // if other then it considered male or female string after 4_1_ in search string of 1_
        // 1st character is the social_security type

        continue;
      }
      
      $string_ = substr($mystring, $pos+1);

      $mf_check = substr($mystring, $pos + 2, 1 );

      $string_reqd = substr($string_, $pos + 3);
      /*
      echo "<h4>Here is one Iteration</h4>";
      echo "string_ = ". $string_ . "<br/>" .
            "pos = ". $pos . "<br/>" .
            "mf_check = " . $mf_check . "<br/>" .
            "string_reqd = " . $string_reqd . "<br/>";
      */
      if ($mf_check == 0){
        if($object_male->has_attribute($string_reqd)) {
          $object_male->$string_reqd = $value;
        }  
      } else{
        if($object_female->has_attribute($string_reqd)) {
          $object_female->$string_reqd = $value;
        }  
      }
      
    }
    $object = array($object_male, $object_female );
    return $object;
  }
  
  public static function find_by_vdc($vdc)
  {
    return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE vdc={$vdc}");
    
  }


  public static function find_by_type_vdc_id($type, $vdc_id, $mf = 0)
  {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE male_female={$mf} AND type={$type} AND vdc={$vdc_id} LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }

	// Common Database Methods
  public static function nepali_name($field){
    return self::$db_fields_nepali[array_search($field, self::$db_fields)];
  }

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

  public static function find_by_sql($sql="") {
    global $database;
    mysql_query ("set character_set_results='utf8'");
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
    return isset($this->id) ? ($this->id != NULL ? $this->update() : $this->create() ) : $this->create();
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
    mysql_query ("set character_set_results='utf8'");
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
    mysql_query ("set character_set_results='utf8'");
    // echo $sql;
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;
  }

  public function delete() {
    global $database;
    mysql_query ("set character_set_results='utf8'");
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