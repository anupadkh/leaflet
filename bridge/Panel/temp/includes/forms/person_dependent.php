<?php  
class person_dependent{
			protected static $db_fields = array('id', 'fullname', 'type', 'person_id');
			protected static $table_name = "person_dependent";
		public $id;
		public $fullname;
		public $type;
		public $person_id;
			} 
 ?>