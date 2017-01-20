<?php  
class person_promo{
			protected static $db_fields = array('id', 'person_id', 'type', 'date', 'designation_from', 'designation_to');
			protected static $table_name = "person_promo";
		public $id;
		public $person_id;
		public $type;
		public $date;
		public $designation_from;
		public $designation_to;
			} 
 ?>