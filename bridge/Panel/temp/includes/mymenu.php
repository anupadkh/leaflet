<?php  
class mymenu{
		protected static $db_fields = array('id', 'nepl_name', 'eng_name', 'parent_id', 'weight', 'icon', 'href','hidden_to_user');
		protected static $table_name = "mymenu";
		public $id;
		public $nepl_name;
		public $eng_name;
		public $parent_id;
		public $weight;
		public $icon;
		public $href;
		public $hidden_to_user;

	  public static function find_children($id)
	  {
	  	// Get all the children under the id
	  	return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE parent_id={$id} "." ORDER BY weight ASC ");
		
	  }
  public static function find_all_parent()
	  {
	  	// Get all the children under the id
	  	return self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE parent_id = 0 "." ORDER BY weight ASC ");
		
	  }

			  public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public static function find_by_sql($sql="") {
    global $database;
    // echo $sql;
    $result_set = $database->query($sql);
    $object_array = array();
    // print_r($object_array);
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }

	public static function instantiate($record) { // here I made it public for Post initialization
    $object = new self;
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
	public function save() {
	  // A new record won't have an id yet.
		// echo "id=".$this->id."find";
	  return isset($this->id) ? (!($this->id == '') ? $this->update() : $this->create()) : $this->create();
	}
	
	public function create() {
		global $database;
		$this->timestamp = time(); // adding timestamp
		$attributes = $this->sanitized_attributes();
		
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		$sql = str_replace("''", "NULL", $sql);
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update() {
	  global $database;
	  $this->modified_timestamp = time();
		$attributes = $this->sanitized_attributes();
		
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
		// echo $sql;
		$sql = str_replace("''", "NULL", $sql);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		global $database;
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
	}} 
 ?>