<?php  
class person_transfer{
			protected static $db_fields = array('id', 'person_id', 'from_office', 'to_office', 'decision_date');
			protected static $table_name = "person_transfer";
		public $id;
		public $person_id;
		public $from_office;
		public $to_office;
		public $decision_date;
			} 
 ?>