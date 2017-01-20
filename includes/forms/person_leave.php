<?php  
class person_leave{
			protected static $db_fields = array('id', 'person_id', 'from_date', 'to_date', 'type');
			protected static $table_name = "person_leave";
		public $id;
		public $person_id;
		public $from_date;
		public $to_date;
		public $type;
			} 
 ?>