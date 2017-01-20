<?php
require_once(LIB_PATH.DS."config.php");

class MySQLDatabase {
	
	private $connection;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string_exists;
	
  function __construct() {

    $this->open_connection();

		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists( "mysqli_real_escape_string" );
  }

	public function open_connection() {
		/*if (function_exists('mysql_connect')) {
    echo "IMAP functions are available.<br />\n";
} else {
    echo "IMAP functions are not available.<br />\n";
    phpinfo();
}*/

		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
		 
		if (!$this->connection) {
			die("Database connection and selection failed: " . mysqli_error($this->connection));
		}


	}

	public function close_connection() {
		if(isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}

	public function query($sql) {
		// echo $sql;
		$this->last_query = $sql;
		// mysqli_query ($this->connection, "set names utf8mb4");
		$result = mysqli_query($this->connection, $sql );
		$this->confirm_query($result);
		return $result;

	}
	
	public function escape_value( $value ) {
		// echo "<br/>Value before mysqli ". $value. "</br>";
		if( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysqli_real_escape_string($this->connection, $value );
			// echo "<br/>Value after mysqli ". $value. "</br>";
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
	// "database-neutral" methods
  public function fetch_array($result_set) {
    return mysqli_fetch_array($result_set);

  }
  
  public function num_rows($result_set) {
   return mysqli_num_rows($result_set);
  }
  
  public function insert_id() {
    // get the last id inserted over the current db connection
    return mysqli_insert_id($this->connection);
  }
  
  public function affected_rows() {
    return mysqli_affected_rows($this->connection);
  }


	private function confirm_query($result) {
		if (!$result) {
	    $output = "Database query failed: " . mysqli_error($this->connection) . "<br /><br />";
	    // $output .= "Last SQL query: " . $this->last_query;
	    die( $output );
		}
	}

  public function countentries($tablename) {
    return self::fetch_array(self::query("SELECT COUNT(*) AS entries FROM {$tablename}"));
  }

	
}

$database = new MySQLDatabase();

$db =& $database;

?>
